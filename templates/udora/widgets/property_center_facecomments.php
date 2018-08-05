<div class="marg20">
    <h4><?php echo lang_check('Facebook comments');?></h4>
    <hr>
    <div class="">
        <?php if(!empty($settings_facebook_comments)): ?>
            <?php echo str_replace('http://example.com/comments', $page_current_url, $settings_facebook_comments); ?>
        <?php endif;?>
    </div>
</div>

<script>
(function (d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id))
        return;
    js = d.createElement(s);
    js.id = id;
    js.src = "//connect.facebook.net/en_EN/sdk.js#xfbml=1&version=v2.5";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>