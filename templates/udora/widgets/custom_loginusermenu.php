<ul class="dashboard-menu">
    <li class="<?php echo (strpos($this->uri->uri_string(),'frontend/myproperties')!==FALSE)?' current-position':'';?>"><a href="{myproperties_url}#content"><span><i class="ion-ios-speedometer"></i></span>Dashboard</a></li>
    <li class="<?php echo (strpos($this->uri->uri_string(),'frontend/myprofile')!==FALSE)?' current-position':'';?>"><a href="{myprofile_url}#content"><span><i class="ion-ios-body"></i></span>My Profile</a></li>
    <li class="<?php echo (strpos($this->uri->uri_string(),'frontend/editproperty')!==FALSE)?' current-position':'';?>"><a href="<?php echo site_url('frontend/editproperty/'.$lang_code.'#content');?>"><span><i class="ion-ios-compose-outline"></i></span>Add Event</a></li>
    <li class="<?php echo (strpos($this->uri->uri_string(),'ffavorites/myfavorites')!==FALSE)?' current-position':'';?>"><a href="{myfavorites_url}#content"><span><i class="ion-ios-star"></i></span>My Favorites</a></li>
<!--     <li><a href="#content"><span><i class="ion-ios-locked"></i></span>Change Password</a></li> -->
<!--     <li><a href="#content"><span><i class="ion-ios-mic"></i></span>Change Security Question</a></li> -->
    <li class="<?php echo (strpos($this->uri->uri_string(),'frontend/notificationsettings')!==FALSE)?' current-position':'';?>"><a href="<?php echo site_url('frontend/notificationsettings/'.$lang_code.'#content');?>"><span><i class="ion-ios-loop"></i></span><?php echo lang_check('Notifications');?></a></li>
<!--     <li><a href="#content"><span><i class="ion-ios-people"></i></span>Social Networks</a></li> -->
<!--     <li><a href="{logout_url}"><span><i class="ion-ios-close"></i></span>Close Account</a></li> -->
</ul>
