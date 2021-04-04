<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- Start Footer Section -->
<footer id="footer">
    <div class="container">
        <div class="row footer-widgets">
            <!-- footer widget about-->
            <div class="col-sm-4 col-xs-12">
                <div class="footer-widget f-widget-about">
                    <div class="col-sm-12">
                        <div class="row">
                            <h4 class="title"><?php echo html_escape(trans("about")); ?></h4>
                            <div class="title-line"></div>
                            <p>
                                <?php echo html_escape($settings->about_footer); ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div><!-- /.col-sm-4 -->

            <!-- footer widget random posts-->
            <div class="col-sm-4 col-xs-12">
                <!--Include footer random posts partial-->
                <?php $this->load->view('partials/_footer_random_posts'); ?>
            </div><!-- /.col-sm-4 -->

            <!-- footer widget follow us-->
            <div class="col-sm-4 col-xs-12">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="footer-widget f-widget-follow">
                            <div class="col-sm-12">
                                <div class="row">
                                    <h4 class="title"><?php echo html_escape(trans("social_media")); ?></h4>
                                    <div class="title-line"></div>
                                    <ul>
                                        <?php $this->load->view("partials/_social_links"); ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- newsletter -->
                <div class="col-sm-12">
                    <div class="row">
                        <p><?php echo html_escape(trans("newsletter_exp")); ?></p>
                        <?php echo form_open('home_controller/add_to_newsletter'); ?>
                        <div class="newsletter">
                            <div class="left">
                                <input type="email" name="email" id="newsletter_email" maxlength="199" placeholder="<?php echo html_escape(trans("email")); ?>" required <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                            </div>
                            <div class="right">
                                <button type="submit" class="newsletter-button"><?php echo trans("subscribe"); ?></button>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                    <div class="row">
                        <p id="newsletter">
                            <?php
                            if ($this->session->flashdata('news_error')):
                                echo '<span class="text-danger">' . $this->session->flashdata('news_error') . '</span>';
                            endif;

                            if ($this->session->flashdata('news_success')):
                                echo '<span class="text-success">' . $this->session->flashdata('news_success') . '</span>';
                            endif;
                            ?>
                        </p>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="row">
                        <div class="languages-dropdown">
                            <?php if ($general_settings->multilingual_system == 1 && count($languages) > 1): ?>
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle" type="button" data-toggle="dropdown">
                                        <i class="icon-language"></i><?php echo html_escape($selected_lang->name); ?>&nbsp;<span class="icon-arrow-down"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <?php foreach ($languages as $language):
                                            $lang_url = base_url() . $language->short_form . "/";
                                            if ($language->id == $this->general_settings->site_lang) {
                                                $lang_url = base_url();
                                            } ?>
                                            <li><a href="<?php echo $lang_url; ?>" class="<?php echo ($language->id == $selected_lang->id) ? 'selected' : ''; ?>"><?php echo $language->name; ?></a></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- .col-md-3 -->
        </div>
        <!-- .row -->

        <!-- Copyright -->
        <div class="footer-bottom">
            <div class="row">
                <div class="col-md-12">
                    <div class="footer-bottom-left">
                        <p><?php echo $settings->copyright; ?></p>
                    </div>
                    <div class="footer-bottom-right">
                        <ul class="nav-footer">
                            <?php if (!empty($this->menu_links)):
                                foreach ($this->menu_links as $item):
                                    if ($item->item_location == "footer"):?>
                                        <li>
                                            <a href="<?php echo generate_menu_item_url($item); ?>"><?php echo html_escape($item->item_name); ?> </a>
                                        </li>
                                    <?php endif;
                                endforeach;
                            endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- .row -->
        </div>
    </div>
</footer>
<!-- End Footer Section -->
<?php if (!isset($_COOKIE["inf_cookies_warning"]) && $settings->cookies_warning): ?>
    <div class="cookies-warning">
        <div class="text"><?php echo $this->settings->cookies_warning_text; ?></div>
        <a href="javascript:void(0)" onclick="hide_cookies_warning();" class="icon-cl"> <i class="icon-close"></i></a>
    </div>
<?php endif; ?>
<!-- Scroll Up Link -->
<a href="#" class="scrollup"><i class="icon-arrow-up"></i></a>

<script>var sys_lang_id = '<?php echo $this->selected_lang->id; ?>';$('<input>').attr({type: 'hidden', name: 'sys_lang_id', value: sys_lang_id}).appendTo('form');var csfr_token_name = '<?php echo $this->security->get_csrf_token_name(); ?>';var csfr_cookie_name = '<?php echo $this->config->item('csrf_cookie_name'); ?>';var base_url = '<?php echo base_url(); ?>';var is_recaptcha_enabled = false;<?php if ($recaptcha_status == true): ?>is_recaptcha_enabled = true;<?php endif; ?></script>
<script src="<?php echo base_url(); ?>assets/vendor/slick/slick.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins.js"></script>

<script>
  $(document).ready(function () {
    $("#home-slider").slick({
      autoplay: true,
      autoplaySpeed: 4900,
      slidesToShow: 4,
      slidesToScroll: 1,
      infinite: true,
      speed: 200,
      rtl: rtl,
      swipeToSlide: true,
      lazyLoad: "progressive",
      prevArrow: $("#home-slider-nav .prev"),
      nextArrow: $("#home-slider-nav .next"),
      responsive: [
        { breakpoint: 2000, settings: { slidesToShow: 3, slidesToScroll: 1 } },
        { breakpoint: 1200, settings: { slidesToShow: 2, slidesToScroll: 1 } },
        { breakpoint: 768, settings: { slidesToShow: 1, slidesToScroll: 1 } },
      ],
    });
    $("#home-slider-boxed").slick({
      autoplay: true,
      autoplaySpeed: 4900,
      slidesToShow: 1,
      slidesToScroll: 1,
      infinite: true,
      speed: 200,
      rtl: rtl,
      swipeToSlide: true,
      lazyLoad: "progressive",
      prevArrow: $("#home-slider-boxed-nav .prev"),
      nextArrow: $("#home-slider-boxed-nav .next"),
    });
    $("#random-slider").slick({
      autoplay: true,
      autoplaySpeed: 4900,
      slidesToShow: 1,
      slidesToScroll: 1,
      infinite: true,
      speed: 200,
      rtl: rtl,
      lazyLoad: "progressive",
      prevArrow: $("#random-slider-nav .prev"),
      nextArrow: $("#random-slider-nav .next"),
    });
    $("#post-details-slider").slick({
      autoplay: false,
      autoplaySpeed: 4900,
      slidesToShow: 1,
      slidesToScroll: 1,
      infinite: false,
      speed: 200,
      rtl: rtl,
      adaptiveHeight: true,
      lazyLoad: "progressive",
      prevArrow: $("#post-details-slider-nav .prev"),
      nextArrow: $("#post-details-slider-nav .next"),
    });
  });
  $(window).load(function () {
    $("#post-details-slider").css("opacity", "1");
  });
  $(document).on("click", ".redirect-onclik", function () {
    var a = $(this).attr("data-url");
    window.location.href = a;
  });
  $("form").submit(function () {
    $("input[name='" + csfr_token_name + "']").val($.cookie(csfr_cookie_name));
  });
  $(document).on("click", ".btn-open-mobile-nav", function () {
    document.getElementById("navMobile").style.width = "280px";
    $("#overlay_bg").show();
  });
  $(document).on("click", ".btn-close-mobile-nav", function () {
    document.getElementById("navMobile").style.width = "0";
    $("#overlay_bg").hide();
  });
  $(document).on("click", "#overlay_bg", function () {
    document.getElementById("navMobile").style.width = "0";
    $("#overlay_bg").hide();
  });
  $(window).scroll(function () {
    if ($(this).scrollTop() > 100) {
      $(".scrollup").fadeIn();
    } else {
      $(".scrollup").fadeOut();
    }
  });
  $(".scrollup").click(function () {
    $("html, body").animate({ scrollTop: 0 }, 700);
    return false;
  });
  $("[data-toggle='modal-search']").click(function () {
    $("body").toggleClass("search-open");
    return false;
  });
  $(".modal-search .s-close").click(function () {
    $("body").removeClass("search-open");
    return false;
  });
  $(document).on("click", "#search_button", function () {
    $("body").toggleClass("search-open");
  });
  $(document).on("click", "#mobile_search_button", function () {
    $("body").toggleClass("search-open");
  });
  $(document).on("click", ".modal-search .s-close", function () {
    $("body").removeClass("search-open");
  });
  $(document).ready(function () {
    $("#home-slider").hover(
      function () {
        $("#home-slider .owl-nav").css({ display: "block" });
      },
      function () {
        $("#home-slider .owl-nav").css({ display: "none" });
      }
    );
    $("#first-tmp-home-slider").hover(
      function () {
        $("#first-tmp-home-slider .owl-nav").css({ display: "block" });
      },
      function () {
        $("#first-tmp-home-slider .owl-nav").css({ display: "none" });
      }
    );
  });
  $(document).ready(function () {
    $("iframe").attr("allowfullscreen", "");
  });
  function add_reaction(b, c) {
    var a = { post_id: b, reaction: c, sys_lang_id: sys_lang_id };
    a[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
      method: "POST",
      url: base_url + "home_controller/save_reaction",
      data: a,
    }).done(function (d) {
      document.getElementById("reactions_result").innerHTML = d;
    });
  }
  function view_poll_results(b) {
    $("#poll_" + b + " .question").hide();
    $("#poll_" + b + " .result").show();
  }
  function view_poll_options(b) {
    $("#poll_" + b + " .result").hide();
    $("#poll_" + b + " .question").show();
  }
  $(document).ready(function () {
    var b;
    $(".poll-form").submit(function (h) {
      h.preventDefault();
      if (b) {
        b.abort();
      }
      var a = $(this);
      var g = a.find("input, select, button, textarea");
      var j = a.serializeArray();
      j.push({ name: csfr_token_name, value: $.cookie(csfr_cookie_name) });
      var i = $(this).attr("data-form-id");
      b = $.ajax({
        url: base_url + "home_controller/add_vote",
        type: "post",
        data: j,
      });
      b.done(function (c) {
        g.prop("disabled", false);
        if (c == "required") {
          $("#poll-required-message-" + i).show();
          $("#poll-error-message-" + i).hide();
        } else {
          if (c == "voted") {
            $("#poll-error-message-" + i).show();
            $("#poll-required-message-" + i).hide();
          } else {
            document.getElementById("poll-results-" + i).innerHTML = c;
            $("#poll_" + i + " .result").show();
            $("#poll_" + i + " .question").hide();
          }
        }
      });
    });
  });
  $(document).ready(function () {
    $("#make_comment_registered").submit(function (b) {
      b.preventDefault();
      var c = $(this).serializeArray();
      var a = {};
      var d = true;
      $(c).each(function (f, e) {
        if ($.trim(e.value).length < 1) {
          $("#make_comment_registered [name='" + e.name + "']").addClass(
            "is-invalid"
          );
          d = false;
        } else {
          $("#make_comment_registered [name='" + e.name + "']").removeClass(
            "is-invalid"
          );
          a[e.name] = e.value;
        }
      });
      a.limit = $("#post_comment_limit").val();
      a.sys_lang_id = sys_lang_id;
      a[csfr_token_name] = $.cookie(csfr_cookie_name);
      if (d == true) {
        $.ajax({
          type: "POST",
          url: base_url + "home_controller/add_comment_post",
          data: a,
          success: function (f) {
            var e = JSON.parse(f);
            if (e.type == "message") {
              document.getElementById("message-comment-result").innerHTML =
                e.message;
            } else {
              document.getElementById("comment-result").innerHTML = e.message;
            }
            $("#make_comment_registered")[0].reset();
          },
        });
      }
    });
    $("#make_comment").submit(function (b) {
      b.preventDefault();
      var c = $(this).serializeArray();
      var a = {};
      var d = true;
      $(c).each(function (f, e) {
        if ($.trim(e.value).length < 1) {
          $("#make_comment [name='" + e.name + "']").addClass("is-invalid");
          d = false;
        } else {
          $("#make_comment [name='" + e.name + "']").removeClass("is-invalid");
          a[e.name] = e.value;
        }
      });
      a.limit = $("#post_comment_limit").val();
      a.sys_lang_id = sys_lang_id;
      a[csfr_token_name] = $.cookie(csfr_cookie_name);
      if (is_recaptcha_enabled == true) {
        if (typeof a["g-recaptcha-response"] === "undefined") {
          $(".g-recaptcha").addClass("is-recaptcha-invalid");
          d = false;
        } else {
          $(".g-recaptcha").removeClass("is-recaptcha-invalid");
        }
      }
      if (d == true) {
        $(".g-recaptcha").removeClass("is-recaptcha-invalid");
        $.ajax({
          type: "POST",
          url: base_url + "home_controller/add_comment_post",
          data: a,
          success: function (f) {
            var e = JSON.parse(f);
            if (e.type == "message") {
              document.getElementById("message-comment-result").innerHTML =
                e.message;
            } else {
              document.getElementById("comment-result").innerHTML = e.message;
            }
            if (is_recaptcha_enabled == true) {
              grecaptcha.reset();
            }
            $("#make_comment")[0].reset();
          },
        });
      }
    });
  });
  $(document).on("click", ".btn-subcomment-registered", function () {
    var a = $(this).attr("data-comment-id");
    var b = { sys_lang_id: sys_lang_id };
    b[csfr_token_name] = $.cookie(csfr_cookie_name);
    $("#make_subcomment_registered_" + a).ajaxSubmit({
      beforeSubmit: function () {
        var d = $("#make_subcomment_registered_" + a).serializeArray();
        var c = $.trim(d[0].value);
        if (c.length < 1) {
          $(".form-comment-text").addClass("is-invalid");
          return false;
        } else {
          $(".form-comment-text").removeClass("is-invalid");
        }
      },
      type: "POST",
      url: base_url + "home_controller/add_comment_post",
      data: b,
      success: function (d) {
        var c = JSON.parse(d);
        if (c.type == "message") {
          document.getElementById("message-subcomment-result-" + a).innerHTML =
            c.message;
        } else {
          document.getElementById("comment-result").innerHTML = c.message;
        }
        $(".visible-sub-comment form").empty();
      },
    });
  });
  $(document).on("click", ".btn-subcomment", function () {
    var a = $(this).attr("data-comment-id");
    var b = { sys_lang_id: sys_lang_id };
    b[csfr_token_name] = $.cookie(csfr_cookie_name);
    b.limit = $("#post_comment_limit").val();
    var c = "#make_subcomment_" + a;
    $(c).ajaxSubmit({
      beforeSubmit: function () {
        var d = $("#make_subcomment_" + a).serializeArray();
        var e = true;
        $(d).each(function (g, f) {
          if ($.trim(f.value).length < 1) {
            $(c + " [name='" + f.name + "']").addClass("is-invalid");
            e = false;
          } else {
            $(c + " [name='" + f.name + "']").removeClass("is-invalid");
            b[f.name] = f.value;
          }
        });
        if (is_recaptcha_enabled == true) {
          if (typeof b["g-recaptcha-response"] === "undefined") {
            $(c + " .g-recaptcha").addClass("is-recaptcha-invalid");
            e = false;
          } else {
            $(c + " .g-recaptcha").removeClass("is-recaptcha-invalid");
          }
        }
        if (e == false) {
          return false;
        }
      },
      type: "POST",
      url: base_url + "home_controller/add_comment_post",
      data: b,
      success: function (e) {
        if (is_recaptcha_enabled == true) {
          grecaptcha.reset();
        }
        var d = JSON.parse(e);
        if (d.type == "message") {
          document.getElementById("message-subcomment-result-" + a).innerHTML =
            d.message;
        } else {
          document.getElementById("comment-result").innerHTML = d.message;
        }
        $(".visible-sub-comment form").empty();
      },
    });
  });
  function load_more_comment(c) {
    var b = parseInt($("#post_comment_limit").val());
    var a = { post_id: c, limit: b, sys_lang_id: sys_lang_id };
    a[csfr_token_name] = $.cookie(csfr_cookie_name);
    $("#load_comment_spinner").show();
    $.ajax({
      type: "POST",
      url: base_url + "home_controller/load_more_comment",
      data: a,
      success: function (d) {
        setTimeout(function () {
          $("#load_comment_spinner").hide();
          document.getElementById("comment-result").innerHTML = d;
        }, 1000);
      },
    });
  }
  function delete_comment(a, c, b) {
    swal({ text: b, icon: "warning", buttons: true, dangerMode: true }).then(
      function (f) {
        if (f) {
          var e = parseInt($("#post_comment_limit").val());
          var d = { id: a, post_id: c, limit: e, sys_lang_id: sys_lang_id };
          d[csfr_token_name] = $.cookie(csfr_cookie_name);
          $.ajax({
            type: "POST",
            url: base_url + "home_controller/delete_comment_post",
            data: d,
            success: function (g) {
              document.getElementById("comment-result").innerHTML = g;
            },
          });
        }
      }
    );
  }
  function show_comment_box(a) {
    $(".visible-sub-comment").empty();
    var c = parseInt($("#post_comment_limit").val());
    var b = { comment_id: a, limit: c, sys_lang_id: sys_lang_id };
    b[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
      type: "POST",
      url: base_url + "home_controller/load_subcomment_box",
      data: b,
      success: function (d) {
        $("#sub_comment_form_" + a).append(d);
      },
    });
  }
  function hide_cookies_warning() {
    $(".cookies-warning").hide();
    var a = {};
    a[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
      type: "POST",
      url: base_url + "home_controller/cookies_warning",
      data: a,
      success: function (b) {},
    });
  }
  $(document).on("click", ".visual-color-box", function () {
    var a = $(this).attr("data-color");
    $(".visual-color-box").empty();
    $(this).html('<i class="icon-check"></i>');
    $("#input_user_site_color").val(a);
  });
  $(document).on("change", "#Multifileupload", function () {
    var d = document.getElementById("Multifileupload");
    if (typeof FileReader != "undefined") {
      var c = document.getElementById("MultidvPreview");
      c.innerHTML = "";
      var f = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.gif|.png|.bmp)$/;
      for (var b = 0; b < d.files.length; b++) {
        var a = d.files[b];
        var e = new FileReader();
        e.onload = function (g) {
          var h = document.createElement("IMG");
          h.height = "100";
          h.width = "100";
          h.src = g.target.result;
          h.id = "Multifileupload_image";
          c.appendChild(h);
          $("#Multifileupload_button").show();
        };
        e.readAsDataURL(a);
      }
    } else {
      alert("This browser does not support HTML5 FileReader.");
    }
  });
  $(document).ready(function () {
    $(".validate_terms").submit(function (a) {
      if (!$(".checkbox_terms_conditions").is(":checked")) {
        a.preventDefault();
        $(".custom-checkbox .checkbox-icon").addClass("is-invalid");
      } else {
        $(".custom-checkbox .checkbox-icon").removeClass("is-invalid");
      }
    });
  });
  $("#form_validate").validate();
</script>

<?php echo $general_settings->google_analytics; ?>
<?php echo $general_settings->custom_javascript_codes; ?>
<?php $hours = date_difference_in_hours(date('Y-m-d H:i:s'), $this->general_settings->last_cron_update);
if (empty($this->general_settings->last_cron_update) || $hours >= 24):?>
    <script>
        var data_cron = {};
        data_cron[csfr_token_name] = $.cookie(csfr_cookie_name);
        $.ajax({type: "POST", url: base_url + "run-internal-cron", data: data_cron});
    </script>
<?php endif; ?>
</body>
</html>