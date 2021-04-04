<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Section: main -->
<section id="main">
    <div class="container">
        <div class="row">
            <!-- breadcrumb -->
            <?php if ($page->breadcrumb_active == 1): ?>
                <div class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?php echo lang_base_url(); ?>"><?php echo html_escape(trans("home")); ?></a>
                        </li>
                        <li class="breadcrumb-item active"><?php echo html_escape($page->title); ?></li>
                    </ol>
                </div>
            <?php else: ?>
                <div class="page-breadcrumb m-t-45">
                </div>
            <?php endif; ?>


            <div class="page-content">
                <!--If right column active-->
                <?php if ($page->right_column_active == 0): ?>

                    <div class="col-sm-12">
                        <div class="content page-about page-res">

                            <?php if ($page->title_active == 1): ?>
                                <h1 class="page-title"><?php echo html_escape($page->title); ?></h1>
                            <?php endif; ?>

                            <!--  page content -->
                            <div class="text-style">
                                <?php echo $page->page_content; ?>
                            </div>

                        </div>
                    </div>


                <?php else: ?>

                    <div class="col-sm-12 col-md-8">
                        <div class="content page-about page-res">

                            <?php if ($page->title_active == 1): ?>
                                <h1 class="page-title"><?php echo html_escape($page->title); ?></h1>
                            <?php endif; ?>


                            <!-- page content -->
                            <div class="text-style">
                                <?php echo $page->page_content; ?>
                            </div>

                        </div>

                    </div>

                    <div class="col-sm-12 col-md-4">
                        <!--Sidebar-->
                        <?php $this->load->view('partials/_sidebar'); ?>
                    </div><!--/col-->

                <?php endif; ?>


            </div>
        </div>
    </div>
</section>
<!-- /.Section: main -->
