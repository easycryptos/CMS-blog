<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_controller extends Home_Core_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->library('bcrypt');
	}

	/**
	 * Login
	 */
	public function login()
	{
		//check if logged in
		if ($this->auth_model->is_logged_in() == true) {
			redirect(lang_base_url());
		}

		$data['title'] = trans("login");
		$data['description'] = trans("login") . " - " . $this->settings->application_name;
		$data['keywords'] = trans("login") . "," . $this->settings->application_name;

		$this->load->view('partials/_header', $data);
		$this->load->view('auth/login');
		$this->load->view('partials/_footer');
	}

	/**
	 * Login Post
	 */
	public function login_post()
	{
        post_method();

		//check if logged in
		if ($this->auth_model->is_logged_in() == true) {
			redirect(lang_base_url());
		}

		//validate inputs
		$this->form_validation->set_rules('username', trans("username"), 'required|xss_clean|max_length[150]');
		$this->form_validation->set_rules('password', trans("password"), 'required|xss_clean|max_length[128]');

		if ($this->form_validation->run() == false) {
			$this->session->set_flashdata('errors', validation_errors());
			$this->session->set_flashdata('form_data', $this->auth_model->input_values());
			redirect($this->agent->referrer());
		} else {

			$result = $this->auth_model->login();

			if ($result == "banned") {
				//user banned
				$this->session->set_flashdata('form_data', $this->auth_model->input_values());
				$this->session->set_flashdata('error', trans("message_ban_error"));
				redirect($this->agent->referrer());

			} elseif ($result == "success") {
				$redirect = $this->input->post('redirect_url', true);
				redirect($redirect);
			} else {
				//error
				$this->session->set_flashdata('form_data', $this->auth_model->input_values());
				$this->session->set_flashdata('error', trans("login_error"));
				redirect($this->agent->referrer());
			}

		}
	}

	/**
	 * Connect with Facebook
	 */
	public function connect_with_facebook()
	{
		//include facebook login
		require_once APPPATH . "third_party/facebook/vendor/autoload.php";

		$fb_url = "https://www.facebook.com/v3.3/dialog/oauth?client_id=" . $this->general_settings->facebook_app_id . "&redirect_uri=" . base_url() . "facebook-callback&scope=email&state=" . generate_unique_id();

		$this->session->set_userdata('fb_login_referrer', $this->agent->referrer());
		redirect($fb_url);
		exit();
	}

	/**
	 * Facebook Callback
	 */
	public function facebook_callback()
	{
		//include facebook login
		require_once APPPATH . "third_party/facebook/vendor/autoload.php";

		$fb = new \Facebook\Facebook([
			'app_id' => $this->general_settings->facebook_app_id,
			'app_secret' => $this->general_settings->facebook_app_secret,
			'default_graph_version' => 'v2.10',
		]);
		try {
			$helper = $fb->getRedirectLoginHelper();
			$permissions = ['email'];
			if (isset($_GET['state'])) {
				$helper->getPersistentDataHandler()->set('state', $_GET['state']);
			}
			$accessToken = $helper->getAccessToken();
            if (empty($accessToken)) {
                redirect(lang_base_url());
            }
			$response = $fb->get('/me?fields=name,email', $accessToken);
		} catch (\Facebook\Exceptions\FacebookResponseException $e) {
			// When Graph returns an error
			echo 'Graph returned an error: ' . $e->getMessage();
			exit;
		} catch (\Facebook\Exceptions\FacebookSDKException $e) {
			// When validation fails or other local issues
			echo 'Facebook SDK returned an error: ' . $e->getMessage();
			exit;
		}

		$user = $response->getGraphUser();
		$fb_user = new stdClass();
		$fb_user->id = $user->getId();
		$fb_user->email = $user->getEmail();
		$fb_user->name = $user->getName();

		$this->auth_model->login_with_facebook($fb_user);

		if (!empty($this->session->userdata('fb_login_referrer'))) {
			redirect($this->session->userdata('fb_login_referrer'));
		} else {
			redirect(base_url());
		}
	}

	/**
	 * Connect with Google
	 */
	public function connect_with_google()
	{
		require_once APPPATH . "third_party/google/vendor/autoload.php";

		$provider = new League\OAuth2\Client\Provider\Google([
			'clientId' => $this->general_settings->google_client_id,
			'clientSecret' => $this->general_settings->google_client_secret,
			'redirectUri' => base_url() . 'connect-with-google',
		]);

		if (!empty($_GET['error'])) {
			// Got an error, probably user denied access
			exit('Got error: ' . htmlspecialchars($_GET['error'], ENT_QUOTES, 'UTF-8'));
		} elseif (empty($_GET['code'])) {

			// If we don't have an authorization code then get one
			$authUrl = $provider->getAuthorizationUrl();
			$_SESSION['oauth2state'] = $provider->getState();
			$this->session->set_userdata('g_login_referrer', $this->agent->referrer());
			header('Location: ' . $authUrl);
			exit();

		} elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
			// State is invalid, possible CSRF attack in progress
			unset($_SESSION['oauth2state']);
			exit('Invalid state');
		} else {
			// Try to get an access token (using the authorization code grant)
			$token = $provider->getAccessToken('authorization_code', [
				'code' => $_GET['code']
			]);
			// Optional: Now you have a token you can look up a users profile data
			try {
				// We got an access token, let's now get the owner details
				$user = $provider->getResourceOwner($token);

				$g_user = new stdClass();
				$g_user->id = $user->getId();
				$g_user->email = $user->getEmail();
				$g_user->name = $user->getName();
				$g_user->avatar = $user->getAvatar();

				$this->auth_model->login_with_google($g_user);

				if (!empty($this->session->userdata('g_login_referrer'))) {
					redirect($this->session->userdata('g_login_referrer'));
				} else {
					redirect(base_url());
				}

			} catch (Exception $e) {
				// Failed to get user details
				exit('Something went wrong: ' . $e->getMessage());
			}
		}
	}

	/**
	 * Register
	 */
	public function register()
	{
		//check if logged in
		if ($this->auth_model->is_logged_in() == true) {
			redirect(lang_base_url());
		}
		$this->is_registration_active();
		$data['title'] = trans("register");
		$data['description'] = trans("register") . " - " . $this->settings->application_name;
		$data['keywords'] = trans("register") . "," . $this->settings->application_name;

		$this->load->view('partials/_header', $data);
		$this->load->view('auth/register');
		$this->load->view('partials/_footer');
	}

	/**
	 * Register Post
	 */
	public function register_post()
	{
		//check if logged in
		if ($this->auth_model->is_logged_in() == true) {
			redirect(lang_base_url());
		}

		//remove @ from username
		if (strpos($this->input->post('username'), '@') !== false) {
			$this->session->set_flashdata('form_data', $this->auth_model->input_values());
			$this->session->set_flashdata('error', trans("msg_register_character_error"));
			redirect(lang_base_url() . "register");
			exit();
		}

		//validate inputs
		$this->form_validation->set_rules('username', trans("username"), 'required|xss_clean|min_length[4]|max_length[100]|is_unique[users.username]');
		$this->form_validation->set_rules('email', trans("email"), 'required|xss_clean|max_length[200]|is_unique[users.email]');
		$this->form_validation->set_rules('password', trans("password"), 'required|xss_clean|min_length[4]|max_length[128]');
		$this->form_validation->set_rules('confirm_password', trans("confirm_password"), 'required|xss_clean|matches[password]');

		if ($this->form_validation->run() === false) {
			$this->session->set_flashdata('errors', validation_errors());
			$this->session->set_flashdata('form_data', $this->auth_model->input_values());
			redirect($this->agent->referrer());
		} else {
			if (!$this->recaptcha_verify_request()) {
				$this->session->set_flashdata('form_data', $this->auth_model->input_values());
				$this->session->set_flashdata('error', trans("msg_recaptcha"));
				redirect($this->agent->referrer());
			} else {
				//register
				if ($this->auth_model->register()) {
					$this->session->set_flashdata('success', trans("msg_register_success"));
					redirect(lang_base_url() . "settings");
				} else {
					//error
					$this->session->set_flashdata('form_data', $this->auth_model->input_values());
					$this->session->set_flashdata('error', trans("msg_error"));
					redirect($this->agent->referrer());
				}
			}
		}
	}

	/**
	 * Reset Password
	 */
	public function forgot_password()
	{
		//check if logged in
		if ($this->auth_model->is_logged_in() == true) {
			redirect(lang_base_url());
		}

		$this->is_registration_active();

		$data['title'] = trans("forgot_password");
		$data['description'] = trans("forgot_password") . " - " . $this->settings->application_name;
		$data['keywords'] = trans("forgot_password") . "," . $this->settings->application_name;

		$this->load->view('partials/_header', $data);
		$this->load->view('auth/forgot_password');
		$this->load->view('partials/_footer');
	}


	/**
	 * Forgot Password Post
	 */
	public function forgot_password_post()
	{
		//check auth
		if ($this->auth_check) {
			redirect(lang_base_url());
		}

		$email = $this->input->post('email', true);
		//get user
		$user = $this->auth_model->get_user_by_email($email);

		//if user not exists
		if (empty($user)) {
			$this->session->set_flashdata('error', html_escape(trans("reset_password_error")));
			redirect($this->agent->referrer());
		} else {
			$this->load->model("email_model");
			$this->email_model->send_email_reset_password($user->id);
			$this->session->set_flashdata('success', trans("msg_reset_password_success"));
			redirect($this->agent->referrer());
		}
	}

	/**
	 * Reset Password
	 */
	public function reset_password()
	{
		//check if logged in
		if ($this->auth_check) {
			redirect(lang_base_url());
		}

		$data['title'] = trans("reset_password");
		$data['description'] = trans("reset_password") . " - " . $this->settings->application_name;
		$data['keywords'] = trans("reset_password") . "," . $this->settings->application_name;

		$token = $this->input->get('token', true);
		//get user
		$data["user"] = $this->auth_model->get_user_by_token($token);
		$data["success"] = $this->session->flashdata('success');

		if (empty($data["user"]) && empty($data["success"])) {
			redirect(lang_base_url());
		}

		$this->load->view('partials/_header', $data);
		$this->load->view('auth/reset_password');
		$this->load->view('partials/_footer');
	}


	/**
	 * Reset Password Post
	 */
	public function reset_password_post()
	{
		$success = $this->input->post('success', true);
		if ($success == 1) {
			redirect(lang_base_url());
		}

		$this->form_validation->set_rules('password', trans("new_password"), 'required|xss_clean|min_length[4]|max_length[50]');
		$this->form_validation->set_rules('password_confirm', trans("confirm_password"), 'required|xss_clean|matches[password]');

		if ($this->form_validation->run() == false) {
			$this->session->set_flashdata('errors', validation_errors());
			$this->session->set_flashdata('form_data', $this->profile_model->change_password_input_values());
			redirect($this->agent->referrer());
		} else {
			$token = $this->input->post('token', true);
			if ($this->auth_model->reset_password($token)) {
				$this->session->set_flashdata('success', trans("message_change_password"));
				redirect($this->agent->referrer());
			} else {
				$this->session->set_flashdata('error', trans("change_password_error"));
				redirect($this->agent->referrer());
			}
		}
	}


	public function is_registration_active()
	{
		if ($this->general_settings->registration_system != 1) {
			redirect(lang_base_url());
		}
	}

	/**
	 * Unsubscribe
	 */
	public function unsubscribe()
	{
		get_method();
		$data['title'] = trans("unsubscribe");
		$data['description'] = trans("unsubscribe");
		$data['keywords'] = trans("unsubscribe");

		$token = $this->input->get("token");
		$subscriber = $this->newsletter_model->get_subscriber_by_token($token);

		if (empty($subscriber)) {
			redirect(lang_base_url());
		}
		$this->newsletter_model->unsubscribe_email($subscriber->email);

		$this->load->view('partials/_header', $data);
		$this->load->view('auth/unsubscribe');
		$this->load->view('partials/_footer');
	}
}
