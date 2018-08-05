<?php
/*
Widget-title: Contact links
Widget-preview-image: /assets/img/widgets_preview/footer_connect.jpg
*/
?>

<div class="col-xs-6 col-xs-offset-0 col-md-2 col-md-offset-1 footer-column">
    <h4>Connect with us</h4>
    <ul>
        <li><a href="<?php echo site_url('/'.$lang_code.'/4/contact');?>"><?php echo lang_check('Contact Us'); ?></a></li>
        <li><a href="https://www.facebook.com/share.php?u={homepage_url}&title={settings_websitetitle}"  onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">Facebook</a></li>
        <li><a href="https://twitter.com/home?status={settings_websitetitle}%20{homepage_url}"  onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">Twitter</a></li>
        <li><a href="https://plus.google.com/share?url={homepage_url}" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">Google+</a></li>
    </ul>
</div>