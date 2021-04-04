<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

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
					<li class="breadcrumb-item active">
						<?php echo html_escape($user->username); ?></li>
					</li>
				</ol>
			</div>
			<div class="col-sm-12">
				<div class="row">
					<div class="col-sm-12">
						<div class="profile-page-top">
							<!-- load profile details -->
							<?php $this->load->view("profile/_profile_user_info"); ?>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-12">
				<div class="row">
					<div class="col-sm-12">
						<div class="profile-page">
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-3">
									<div class="widget-followers">
										<div class="widget-head">
											<h3 class="title"><?php echo trans("following"); ?>&nbsp;(<?php echo count($following); ?>)</h3>
										</div>
										<div class="widget-body">
											<div class="widget-content custom-scrollbar">
												<div class="row">
													<div class="col-sm-12">
														<?php if (!empty($following)):
															foreach ($following as $item):?>
																<div class="img-follower">
																	<a href="<?php echo lang_base_url() . "profile/" . html_escape($item->slug); ?>">
																		<img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACwAAAAAAQABAAACAkQBADs=" data-src="<?php echo get_user_avatar($item); ?>" alt="<?php echo html_escape($item->username); ?>" class="img-responsive lazyload">
																	</a>
																</div>
															<?php endforeach;
														endif; ?>
													</div>
												</div>
											</div>
										</div>
									</div>

									<div class="widget-followers">
										<div class="widget-head">
											<h3 class="title"><?php echo trans("followers"); ?>&nbsp;(<?php echo count($followers); ?>)</h3>
										</div>
										<div class="widget-body">
											<div class="widget-content custom-scrollbar-followers">
												<div class="row">
													<div class="col-sm-12">
														<?php if (!empty($followers)):
															foreach ($followers as $item):?>
																<div class="img-follower">
																	<a href="<?php echo lang_base_url() . "profile/" . html_escape($item->slug); ?>">
																		<img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACwAAAAAAQABAAACAkQBADs=" data-src="<?php echo get_user_avatar($item); ?>" alt="<?php echo html_escape($item->username); ?>" class="img-responsive lazyload">
																	</a>
																</div>
															<?php endforeach;
														endif; ?>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>

								<div class="col-xs-12 col-sm-12 col-md-9">
									<!-- posts -->
									<div class="col-xs-12 col-sm-12 posts p-0 posts-boxed">
										<div class="row">
											<?php $count = 0; ?>
											<?php foreach ($posts as $item): ?>
												<?php if ($count != 0 && $count % 2 == 0): ?>
													<div class="col-sm-12 col-xs-12"></div>
												<?php endif; ?>

												<!-- post item -->
												<div class="col-sm-6 col-xs-12 item-boxed-cnt">
													<!--Post list item-->
													<div class="col-xs-12 post-item-boxed p0">
														<div class="item-image">
															<a href="<?php echo generate_category_url($item->parent_category_slug, $item->category_slug); ?>">
                                                            <span class="label-post-category">
                                                                <?php echo html_escape($item->category_name); ?>
                                                            </span>
															</a>
															<a href="<?php echo generate_post_url($item); ?>">
																<?php $this->load->view("post/_post_image", ['post_item' => $item, 'type' => 'image_slider']); ?>
															</a>
														</div>
														<div class="item-content">
															<h3 class="title">
																<a href="<?php echo generate_post_url($item); ?>">
																	<?php echo html_escape(character_limiter($item->title, 40, '...')); ?>
																</a>
															</h3>
															<?php $this->load->view("post/_post_meta", ['item' => $item]); ?>
															<p class="summary">
																<?php echo html_escape(character_limiter($item->summary, 130, '...')); ?>
															</p>
															<div class="post-buttons">
																<a href="<?php echo generate_post_url($item); ?>"
																   class="pull-right read-more">
																	<?php echo html_escape(trans("readmore")); ?>
																	<i class="icon-angle-right read-more-i" aria-hidden="true"></i>
																</a>
															</div>
														</div>
													</div>
												</div>
												<!-- /.post item -->

												<?php if ($count == 1): ?>

													<?php $this->load->view("partials/_ad_spaces", ["ad_space" => "profile_top"]); ?>

												<?php endif; ?>

												<?php $count++; ?>

											<?php endforeach; ?>


										</div><!-- /.posts -->
									</div>

									<div class="col-xs-12 col-sm-12 col-xs-12">
										<div class="row">
											<?php $this->load->view("partials/_ad_spaces", ["ad_space" => "profile_bottom"]); ?>
										</div>
									</div>

									<!-- Pagination -->
									<div class="col-xs-12 col-sm-12 col-xs-12">
										<div class="row">
											<?php echo $this->pagination->create_links(); ?>
										</div>
									</div>
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


