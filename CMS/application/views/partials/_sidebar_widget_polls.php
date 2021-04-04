<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php if (!empty($polls)): ?>
    <!--Partial: Voting Poll-->
    <div class="widget-title widget-popular-posts-title">
        <h4 class="title"><?php echo html_escape(trans("voting_poll")); ?></h4>
    </div>

    <div class="col-sm-12 widget-body">
        <div class="row">
            <?php foreach ($polls as $poll): ?>
                <?php if ($poll->status == 1): ?>

                    <div id="poll_<?php echo $poll->id; ?>" class="poll">

                        <div class="question">
                            <form data-form-id="<?php echo $poll->id; ?>" class="poll-form" method="post">
                                <input type="hidden" name="poll_id" value="<?php echo $poll->id; ?>">
                                <h5 class="title"><?php echo html_escape($poll->question); ?></h5>
                                <?php
                                for ($i = 1; $i <= 10; $i++):
                                    $option = "option" . $i;
                                    if (!empty($poll->$option)): ?>
										<p class="option">
											<label class="custom-checkbox custom-radio">
												<input type="radio" name="option"  id="option<?php echo $poll->id; ?>-<?php echo $i; ?>" value="<?php echo $option; ?>">
												<span class="checkbox-icon"><i class="icon-check"></i></span>
												<span class="label-poll-option"><?php echo html_escape($poll->$option); ?></span>
											</label>
										</p>
                                    <?php
                                    endif;
                                endfor; ?>

                                <p class="button-cnt">
                                    <button type="submit" class="btn btn-sm btn-custom"><?php echo trans("vote"); ?></button>
                                    <a onclick="view_poll_results('<?php echo $poll->id; ?>');" class="a-view-results"><?php echo trans("view_results"); ?></a>
                                </p>

								<div id="poll-required-message-<?php echo $poll->id; ?>" class="poll-error-message">
									<?php echo trans("please_select_option"); ?>
								</div>
								<div id="poll-error-message-<?php echo $poll->id; ?>" class="poll-error-message">
									<?php echo trans("voted_message"); ?>
								</div>
                            </form>
                        </div>

                        <div class="result" id="poll-results-<?php echo $poll->id; ?>">
                            <h5 class="title"><?php echo html_escape($poll->question); ?></h5>

                            <?php $total_vote = get_total_vote_count($poll->id); ?>

                            <p class="total-vote">Total Vote: <?php echo $total_vote; ?></p>

                            <?php for ($i = 1; $i <= 10; $i++):
                                $option = "option" . $i;

                                $percent = 0;

                                if (!empty($poll->$option)):
                                    $option_vote = get_option_vote_count($poll->id, $option);

                                    if ($total_vote > 0) {
                                        $percent = round(($option_vote * 100) / $total_vote, 1);
                                    }

                                    ?>

                                    <span><?php echo html_escape($poll->$option); ?></span>

                                    <?php if ($percent == 0): ?>
                                    <div class="progress">
                                        <span><?php echo $percent; ?>&nbsp;%</span>
                                        <div class="progress-bar progress-bar-0" role="progressbar" aria-valuenow="<?php echo $total_vote; ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $percent; ?>%"></div>
                                    </div>
                                <?php else: ?>
                                    <div class="progress">
                                        <span><?php echo $percent; ?>&nbsp;%</span>
                                        <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $total_vote; ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $percent; ?>%"></div>
                                    </div>
                                <?php endif; ?>

                                <?php
                                endif;
                            endfor; ?>

                            <p>
                                <a onclick="view_poll_options('<?php echo $poll->id; ?>');" class="a-view-results m-0"><?php echo trans("view_options"); ?></a>
                            </p>
                        </div>

                    </div>

                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>
