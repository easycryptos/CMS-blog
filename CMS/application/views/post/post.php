<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- Section: main -->
<section id="main">
    <div class="container">
        <div class="row">
            <!-- breadcrumb -->
            <div class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo lang_base_url(); ?>"> <?php echo html_escape(trans("home")); ?></a></li>
                    <?php $category_array = get_category_array($post->category_id);
                    if (!empty($category_array['parent_category'])):?>
                        <li class="breadcrumb-item">
                            <a href="<?php echo generate_category_url(null, $category_array['parent_category']->slug); ?>"><?php echo html_escape($category_array['parent_category']->name); ?></a>
                        </li>
                    <?php endif; ?>
                    <?php if (!empty($category_array['subcategory'])): ?>
                        <li class="breadcrumb-item">
                            <a href="<?php echo generate_category_url($category_array['parent_category']->slug, $category_array['subcategory']->slug); ?>"><?php echo html_escape($category_array['subcategory']->name); ?></a>
                        </li>
                    <?php endif; ?>
                    <li class="breadcrumb-item active"><?php echo html_escape($post->title); ?></li>
                </ol>
            </div>

            <div class="col-sm-12 col-md-8">
                <div class="content">

                    <div class="post-content">
                        <div class="post-title">
                            <h1 class="title"><?php echo html_escape($post->title); ?></h1>
                        </div>
                        <?php if (!empty($post->summary)): ?>
                            <div class="post-summary">
                                <h2>
                                    <?php echo $post->summary; ?>
                                </h2>
                            </div>
                        <?php endif; ?>

                        <div class="post-meta">
                            <?php if (!empty($category) && !empty($category->parent_id)):
                                $parent = helper_get_category($category->parent_id);
                                if (!empty($parent)):?>
                                    <a href="<?php echo generate_category_url($parent->slug, $category->slug); ?>" class="font-weight-normal">
                                        <i class="icon-folder"></i>&nbsp;&nbsp;<?php echo html_escape($category->name); ?>
                                    </a>
                                <?php endif; ?>
                            <?php else: ?>
                                <a href="<?php echo generate_category_url(null, $category->slug); ?>" class="font-weight-normal">
                                    <i class="icon-folder"></i>&nbsp;&nbsp;<?php echo html_escape($category->name); ?>
                                </a>
                            <?php endif; ?>
                            <span><i class="icon-clock"></i>&nbsp;&nbsp;<?php echo helper_date_format($post->created_at); ?></span>

                            <?php if ($general_settings->comment_system == 1) : ?>
                                <span><i class="icon-comment"></i>&nbsp;&nbsp;<?php echo helper_get_comment_count($post->id); ?> </span>
                            <?php endif; ?>

                            <!--Show if enabled-->
                            <?php if ($general_settings->show_pageviews == 1) : ?>
                                <span><i class="icon-eye"></i>&nbsp;&nbsp;<?php echo $post->hit; ?></span>
                            <?php endif; ?>


                            <!--Add to Reading List-->
                            <?php if ($this->auth_check) : ?>
                                <?php echo form_open(base_url() . 'add-remove-reading-list'); ?>
                                <input type="hidden" name="post_id" value="<?php echo $post->id; ?>">
                                <?php if ($is_reading_list == false) : ?>
                                    <button type="submit" class="add-to-reading-list pull-right">
                                        <i class="icon-plus-circle"></i>&nbsp;
                                        <?php echo html_escape(trans("add_reading_list")); ?>
                                    </button>
                                <?php else: ?>
                                    <button type="submit" class="delete-from-reading-list  pull-right">
                                        <i class="icon-negative-circle"></i>&nbsp;
                                        <?php echo html_escape(trans("delete_reading_list")); ?>
                                    </button>
                                <?php endif; ?>
                                <?php echo form_close(); ?>

                            <?php else: ?>

                                <a href="<?php echo lang_base_url(); ?>login" class="add-to-reading-list pull-right">
                                    <i class="icon-plus-circle"></i>&nbsp;<?php echo html_escape(trans("add_reading_list")); ?>
                                </a>

                            <?php endif; ?>
                        </div>

                        <?php if (!empty($post->video_embed_code)): ?>
                            <div class="post-video">
                                <div class="embed-responsive embed-responsive-16by9">
                                    <iframe class="embed-responsive-item" src="<?php echo $post->video_embed_code; ?>" allowfullscreen></iframe>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="post-image">
                                <?php if (!empty($additional_images)) :
                                    $this->load->view("post/_post_details_slider", ["ad_space" => "post_top"]);
                                else:
                                    if (!empty($post->image_url)):?>
                                        <img src="<?php echo $post->image_url; ?>" class="img-responsive center-image" alt="<?php echo html_escape($post->title); ?>"/>
                                    <?php else:
                                        if (!empty($post->image_big)): ?>
                                            <img src="<?php echo get_post_image($post, 'big'); ?>" class="img-responsive center-image" alt="<?php echo html_escape($post->title); ?>"/>
                                        <?php endif;
                                    endif; ?>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>


                        <?php $this->load->view("partials/_ad_spaces", ["ad_space" => "post_top"]); ?>

                        <div class="post-text text-style">

                            <?php echo $post->content; ?>

                            <?php if (!empty($post->optional_url)) : ?>
                                <br>
                                <a href="<?php echo html_escape($post->optional_url); ?>"
                                   class="btn btn-md btn-custom margin-bottom15 btn-optional-link"
                                   target="_blank"><?php echo html_escape($settings->optional_url_button_name); ?></a>
                            <?php endif; ?>

                            <!--Optional Url Button -->
                            <?php if (!empty($post->post_url) && !empty($post->show_post_url)) : ?>
                                <div class="optional-url-cnt">
                                    <a href="<?php echo $post->post_url; ?>" class="btn btn-md btn-custom" target="_blank" rel="nofollow">
                                        <?php echo (!empty($feed->read_more_button_text)) ? html_escape($feed->read_more_button_text) : html_escape($settings->optional_url_button_name); ?>&nbsp;&nbsp;&nbsp;<i class="icon-long-arrow-right" aria-hidden="true"></i>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <?php $files = get_post_files($post->id);
                            if (!empty($files)):?>
                                <div class="post-files">
                                    <h2 class="title"><?php echo trans("files"); ?></h2>
                                    <?php foreach ($files as $file): ?>
                                        <?php echo form_open('download-file'); ?>
                                        <input type="hidden" name="id" value="<?php echo $file->id; ?>">
                                        <div class="file">
                                            <button type="submit"><i class="icon-file"></i><?php echo $file->file_name; ?></button>
                                        </div>
                                        </form>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>


                        <div class="post-tags">
                            <?php if (!empty($post_tags)): ?>
                                <h3 class="tags-title"><?php echo html_escape(trans("tags")); ?></h3>
                                <ul class="tag-list">
                                    <?php foreach ($post_tags as $tag) : ?>
                                        <li>
                                            <a href="<?php echo lang_base_url() . 'tag/' . html_escape($tag->tag_slug); ?>">
                                                <?php echo html_escape($tag->tag); ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>


                        <div class="post-share">
                            <a href="javascript:void(0)"
                               onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=<?php echo lang_base_url() . html_escape($post->title_slug); ?>', 'Share This Post', 'width=640,height=450');return false"
                               class="btn-share share facebook">
                                <i class="icon-facebook"></i>
                                <span class="hidden-sm">Facebook</span>
                            </a>

                            <a href="javascript:void(0)"
                               onclick="window.open('https://twitter.com/share?url=<?php echo lang_base_url() . html_escape($post->title_slug); ?>&amp;text=<?php echo urlencode($post->title); ?>', 'Share This Post', 'width=640,height=450');return false"
                               class="btn-share share twitter">
                                <i class="icon-twitter"></i>
                                <span class="hidden-sm">Twitter</span>
                            </a>

                            <a href="https://api.whatsapp.com/send?text=<?php echo html_escape($post->title); ?> - <?php echo lang_base_url() . html_escape($post->title_slug); ?>" target="_blank"
                               class="btn-share share whatsapp">
                                <i class="icon-whatsapp"></i>
                                <span class="hidden-sm">Whatsapp</span>
                            </a>

                            <a href="javascript:void(0)"
                               onclick="window.open('http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo lang_base_url() . html_escape($post->title_slug); ?>', 'Share This Post', 'width=640,height=450');return false"
                               class="btn-share share linkedin">
                                <i class="icon-linkedin"></i>
                                <span class="hidden-sm">Linkedin</span>
                            </a>

                            <a href="javascript:void(0)"
                               onclick="window.open('http://pinterest.com/pin/create/button/?url=<?php echo lang_base_url() . html_escape($post->title_slug); ?>&amp;media=<?php echo base_url() . html_escape($post->image_big); ?>', 'Share This Post', 'width=640,height=450');return false"
                               class="btn-share share pinterest">
                                <i class="icon-pinterest"></i>
                                <span class="hidden-sm">Pinterest</span>
                            </a>

                        </div>

                        <?php if ($this->general_settings->emoji_reactions == 1): ?>
                            <div class="col-sm-12 col-xs-12">
                                <div class="row">
                                    <div class="reactions noselect">
                                        <h4 class="title-reactions"><?php echo trans("whats_your_reaction"); ?></h4>
                                        <div id="reactions_result">
                                            <?php $this->load->view('partials/_emoji_reactions'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="bn-bottom-post">
                                    <?php $this->load->view("partials/_ad_spaces", ["ad_space" => "post_bottom"]); ?>
                                </div>
                            </div>
                        </div>

                    </div><!--/post-content-->

                    <!--include about author -->
                    <?php $this->load->view('post/_post_about_author', ['post_user' => $post_user]); ?>

                    <div class="related-posts">
                        <div class="related-post-title">
                            <h4 class="title"><?php echo html_escape(trans("related_posts")); ?></h4>
                        </div>
                        <div class="row related-posts-row">
                            <ul class="post-list">
                                <?php foreach ($related_posts as $item): ?>

                                    <li class="col-sm-4 col-xs-12 related-posts-col">
                                        <a href="<?php echo lang_base_url() . html_escape($item->title_slug); ?>">
                                            <?php $this->load->view("post/_post_image", ['post_item' => $item, 'type' => 'image_slider']); ?>
                                        </a>
                                        <h3 class="title">
                                            <a href="<?php echo lang_base_url() . html_escape($item->title_slug); ?>">
                                                <?php echo html_escape(character_limiter($item->title, 70, '...')); ?>
                                            </a>
                                        </h3>
                                    </li>

                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>

                    <div class="col-sm-12 col-xs-12">
                        <div class="row">
                            <div class="comment-section">
                                <?php if ($general_settings->comment_system == 1 || $general_settings->facebook_comment == 1): ?>
                                    <ul class="nav nav-tabs">
                                        <?php if ($general_settings->comment_system == 1): ?>
                                            <li class="active"><a data-toggle="tab" href="#comments"><?php echo trans("comments"); ?></a></li>
                                        <?php endif; ?>
                                        <?php if ($general_settings->comment_system == 1): ?>
                                            <li><a data-toggle="tab" href="#facebook_comments"><?php echo trans("facebook_comments"); ?></a></li>
                                        <?php endif; ?>
                                    </ul>

                                    <div class="tab-content">
                                        <?php if ($general_settings->comment_system == 1): ?>
                                            <div id="comments" class="tab-pane fade in active">
                                                <!-- include comments -->
                                                <?php $this->load->view('post/_make_comment'); ?>
                                                <div id="comment-result">
                                                    <?php $this->load->view('post/_comments'); ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <?php if ($general_settings->facebook_comment == 1): ?>
                                            <div class="tab-pane container " id="facebook_comments">

                                            </div>
                                        <?php endif; ?>
                                        <?php if ($general_settings->comment_system == 1): ?>
                                            <div id="facebook_comments" class="tab-pane <?php echo ($general_settings->comment_system != 1) ? 'active' : 'fade'; ?>">
                                                <div class="fb-comments" data-href="<?php echo current_url(); ?>" data-width="100%" data-numposts="5"
                                                     data-colorscheme="<?php echo $this->dark_mode == 1 ? 'dark' : 'light'; ?>"></div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-sm-12 col-md-4">
                <!--Sidebar-->
                <?php $this->load->view('partials/_sidebar'); ?>
            </div><!--/col-->
        </div>
    </div>
</section>
<!-- /.Section: main -->
<script>
    $(function () {
        $('.post-text table').wrap('<div style="overflow-x:auto;"></div>');
    });
</script>
<?php if ($general_settings->facebook_comment == 1): ?>
    <script>
        $(".fb-comments").attr("data-href", window.location.href);
    </script>
    <?php echo $general_settings->facebook_comment;
endif; ?>


<?php if (!empty($post->feed_id)): ?>
    <style>
        .post-text img {
            display: none !important;
        }

        .post-content .post-summary {
            display: none !important;
        }
    </style>
<?php endif; ?>
