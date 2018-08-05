<?php
/*
Widget-title: Contact info
Widget-preview-image: /assets/img/widgets_preview/right_contactinfo.jpg
*/
?>

<h4><?php echo lang_check('Our office');?></h4>
<hr>
<p>
    <span style="font-weight: bold;">
        {settings_address_footer}
    </span>
    <br><br>
    <span style="font-weight: bold;">
        <span><?php echo _l('Tel');?>:</span>
    </span> <?php echo $settings_phone; ?><br>

    <span style="font-weight: bold;">
        <span><?php echo _l('Fax');?>:</span>
    </span> <?php echo $settings_fax; ?> <br>

    <span style="font-weight: bold;">
        <span><?php echo _l('Mail');?>:</span>
    </span> <?php echo $settings_email; ?>
</p>