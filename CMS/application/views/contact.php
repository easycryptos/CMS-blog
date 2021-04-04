<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Section: main -->
<section id="main">
    <div class="container">
        <div class="row">

            <!--Check breadcrumb active-->
            <?php if ($page->breadcrumb_active == 1): ?>
                <div class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?php echo lang_base_url(); ?>"><?php echo trans("home"); ?></a>
                        </li>

                        <li class="breadcrumb-item active"><?php echo html_escape($page->title); ?></li>
                    </ol>
                </div>
            <?php else: ?>
                <div class="col-sm-12 page-breadcrumb"></div>
            <?php endif; ?>

            <div id="content" class="col-sm-12">

                <div class="row">
                    <!--Check page title active-->
                    <?php if ($page->title_active == 1): ?>
                        <div class="col-sm-12">
                            <h1 class="page-title"><?php echo html_escape($page->title); ?></h1>
                        </div>
                    <?php endif; ?>

                    <div class="col-sm-12">
                        <div class="page-contact">

                            <div class="row row-contact-text">
                                <div class="col-sm-12 font-text">
                                    <?php echo $settings->contact_text; ?>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 font-text">
                                    <h2 class="contact-leave-message"><?php echo trans("leave_message"); ?></h2>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6 col-xs-12 contact-left">
                                    <!-- include message block -->
                                    <?php $this->load->view('partials/_messages'); ?>

                                    <!-- form start -->
                                    <?php echo form_open('home_controller/contact_post', ['id' => 'form_validate', 'class' => 'validate_terms']); ?>
                                    <div class="form-group">
                                        <input type="text" class="form-control form-input" name="name"
                                               placeholder="<?php echo trans("name"); ?>" maxlength="199" minlength="1"
                                               pattern=".*\S+.*" value="<?php echo old('name'); ?>" required <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                                    </div>
                                    <div class="form-group">
                                        <input type="email" class="form-control form-input" name="email" maxlength="199"
                                               placeholder="<?php echo trans("email"); ?>"
                                               value="<?php echo old('email'); ?>" required <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                                    </div>
                                    <div class="form-group">
                                    <textarea class="form-control form-input form-textarea" name="message"
                                              placeholder="<?php echo trans("message"); ?>" maxlength="4970"
                                              minlength="5"
                                              required <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>><?php echo old('message'); ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="custom-checkbox">
                                            <input type="checkbox" class="checkbox_terms_conditions" required>
                                            <span class="checkbox-icon"><i class="icon-check"></i></span>
                                            <?php echo trans("terms_conditions_exp"); ?>&nbsp;<a href="<?php echo lang_base_url(); ?>terms-conditions" class="link-terms" target="_blank"><strong><?php echo trans("terms_conditions"); ?></strong></a>
                                        </label>
                                    </div>
                                    <?php generate_recaptcha(); ?>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-md btn-custom">
                                            <?php echo html_escape(trans("submit")); ?>
                                        </button>
                                    </div>

                                    </form><!-- form end -->


                                </div>

                                <div class="col-sm-6 col-xs-12 contact-right">

                                    <?php if ($settings->contact_phone): ?>
                                        <div class="contact-item">
                                            <div class="col-sm-2 col-xs-2 contact-icon">
                                                <i class="icon-phone" aria-hidden="true"></i>
                                            </div>
                                            <div class="col-sm-10 col-xs-10 contact-info">
                                                <?php echo html_escape($settings->contact_phone); ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($settings->contact_email): ?>
                                        <div class="contact-item">
                                            <div class="col-sm-2 col-xs-2 contact-icon">
                                                <i class="icon-envelope" aria-hidden="true"></i>
                                            </div>
                                            <div class="col-sm-10 col-xs-10 contact-info">
                                                <?php echo html_escape($settings->contact_email); ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($settings->contact_address): ?>
                                        <div class="contact-item">
                                            <div class="col-sm-2 col-xs-2 contact-icon">
                                                <i class="icon-map-marker" aria-hidden="true"></i>
                                            </div>
                                            <div class="col-sm-10 col-xs-10 contact-info">
                                                <?php echo html_escape($settings->contact_address); ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>


                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</section>
<!-- /.Section: main -->

<?php if (!empty($settings->contact_address)): ?>
    <div class="container-fluid">
        <div class="row">
            <div class="contact-map-container">
                <iframe id="contact_iframe" src="https://maps.google.com/maps?width=100%&height=600&hl=en&q=<?php echo $settings->contact_address; ?>&ie=UTF8&t=&z=8&iwloc=B&output=embed&disableDefaultUI=true" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
            </div>
        </div>
    </div>
<?php endif; ?>
<script>
    var iframe = document.getElementById("contact_iframe");
    iframe.src = iframe.src;
</script>
<style>
    #footer {
        margin-top: 0;
    }
</style>
