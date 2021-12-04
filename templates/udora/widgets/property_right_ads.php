<div class="promo-text-blog pr_sponsored col-xs-12"><?php echo lang_check('Sponsored ads');?></div>
<div class="text-center">
    <?php if(file_exists(APPPATH.'controllers/admin/ads.php')):?>
    {has_ads_180x150px}
    <a href="{random_ads_180x150px_link}" target="_blank"><img src="{random_ads_180x150px_image}" alt="ads" /></a>
    {/has_ads_180x150px}
    <?php elseif(!empty($settings_adsense160_600)): ?>
        <?php echo $settings_adsense160_600; ?>
    <?php endif; ?>
</div>