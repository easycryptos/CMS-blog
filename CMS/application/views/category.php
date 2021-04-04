<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- Section: main -->
<section id="main">
    <div class="container">
        <div class="row">
            <!-- breadcrumb -->
            <div class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?php echo lang_base_url(); ?>"><?php echo html_escape(trans("home")); ?></a>
                    </li>
                    <?php $category_array = get_category_array($category->id);
                    if (!empty($category_array['subcategory']) && !empty($category_array['parent_category'])):?>
                        <li class="breadcrumb-item">
                            <a href="<?php echo generate_category_url(null, $category_array['parent_category']->slug); ?>"><?php echo html_escape($category_array['parent_category']->name); ?></a>
                        </li>
                        <li class="breadcrumb-item active">
                            <?php echo html_escape($category_array['subcategory']->name); ?>
                        </li>
                    <?php else:
                        if (!empty($category_array['parent_category'])):?>
                            <li class="breadcrumb-item active">
                                <?php echo html_escape($category_array['parent_category']->name); ?>
                            </li>
                        <?php endif;
                    endif; ?>
                </ol>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-8">
                <div class="content">
                    <h1 class="page-title"> <?php echo html_escape(trans("category")); ?>
                        : <?php echo html_escape($category->name); ?></h1>

                    <!-- posts -->
                    <div class="col-xs-12 col-sm-12 posts <?php echo ($layout == "layout_3" || $layout == "layout_6") ? 'p-0 posts-boxed' : ''; ?>">
                        <div class="row">
                            <?php $count = 0; ?>

                            <?php foreach ($posts as $item): ?>

                                <?php if ($count != 0 && $count % 2 == 0): ?>
                                    <div class="col-sm-12 col-xs-12"></div>
                                <?php endif; ?>

                                <!-- post item -->
                                <?php $this->load->view('post/_post_item', ['item' => $item]); ?>
                                <!-- /.post item -->

                                <?php if ($count == 1): ?>

                                    <?php $this->load->view("partials/_ad_spaces", ["ad_space" => "category_top"]); ?>

                                    <!-- increment count -->
                                <?php endif; ?>

                                <?php $count++; ?>
                            <?php endforeach; ?>
                        </div>
                    </div><!-- /.posts -->

                    <div class="col-xs-12 col-sm-12">
                        <div class="row">
                            <?php $this->load->view("partials/_ad_spaces", ["ad_space" => "category_bottom"]); ?>
                        </div>
                    </div>
                    <!-- Pagination -->
                    <div class="col-xs-12 col-sm-12">
                        <div class="row">
                            <?php echo $this->pagination->create_links(); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-4">
                <!--Sidebar-->
                <?php $this->load->view('partials/_sidebar'); ?>
            </div><!--/col-->
        </div>
    </div>
</section>
<!-- /.Section: main -->


