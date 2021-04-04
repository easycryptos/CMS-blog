<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php if (!empty($ad_space)): ?>

    <?php $ad_codes = helper_get_ad_codes($ad_space); ?>

    <?php if (!empty($ad_codes)): ?>

        <?php if ($ad_space == "sidebar_top" || $ad_space == "sidebar_bottom"): ?>

            <?php if (trim($ad_codes->ad_code_300) != ''): ?>
                <div class="col-sm-12 col-xs-12 bn-lg-sidebar">
                    <div class="row">
                        <?php echo $ad_codes->ad_code_300; ?>
                    </div>
                </div>
            <?php endif; ?>

        <?php else: ?>

            <?php if (trim($ad_codes->ad_code_728) != '') : ?>
                <section class="col-sm-12 bn-lg bn-list p-t-0">
                    <div class="row">
                        <?php echo $ad_codes->ad_code_728; ?>
                    </div>
                </section>
            <?php endif; ?>

            <?php if (trim($ad_codes->ad_code_468) != ''): ?>
                <section class="col-sm-12 bn-md bn-list p-t-0">
                    <div class="row">
                        <?php echo $ad_codes->ad_code_468; ?>
                    </div>
                </section>
            <?php endif; ?>

        <?php endif; ?>


        <?php if (trim($ad_codes->ad_code_234) != ''): ?>
            <section class="col-sm-12 bn-sm bn-list p-t-0">
                <div class="row">
                    <?php echo $ad_codes->ad_code_234; ?>
                </div>
            </section>
        <?php endif; ?>

    <?php endif; ?>
<?php endif; ?>


<!--Sidebar ad space
<?php /* if (!empty($ad) && $ad == "sidebar"): ?>

    <?php if (trim($ads->sidebar_300) != '') : ?>
        <section class="col-sm-12 bn-lg-sidebar">
            <div class="row">
                <?php echo $ads->sidebar_300; ?>
            </div>
        </section>
    <?php endif; ?>

    <?php if (trim($ads->sidebar_234) != ''): ?>
        <section class="col-sm-12 bn-sm-sidebar">
            <div class="row">
                <?php echo $ads->sidebar_234; ?>
            </div>
        </section>
    <?php endif; ?>

<?php endif; */ ?>

-->
