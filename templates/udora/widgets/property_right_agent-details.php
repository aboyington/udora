{has_agent}
<div class="promo-text-blog center-align col-xs-12">{lang_Organizer}</div>
<div class="profile-settings profile-settings-widget">
    <div class="col-sm-12 profile-wrapper">
        <div class="col-sm-12">
            <img src="{agent_image_url}" alt="" class="profile-img">
        </div>
        <div class="col-sm-12">
            <div class="profile-statistics">
                <h4 id="member-name" class="member-name"><a href="{agent_url}"><?php  _che($agent_name_surname);?></a></h4>
               <!-- <p id="member-number"><?php  _che($agent_phone);?></p>
                <p id="member-points"><a href="mailto:<?php  _che($agent_mail);?>?subject={lang_Estateinqueryfor}: {estate_data_id}, {page_title}" title="<?php  _che($agent_mail);?>"><?php  _che($agent_mail);?></a></p>
                 Example to print all custom fields in list -->
                <?php //profile_cf_li(); ?>
                <!-- Example to print specific custom field with label -->
                <?php //profile_cf_single(1, TRUE); ?>
            </div>
        </div>
    </div>
</div>
{/has_agent}