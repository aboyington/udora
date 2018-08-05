<div class="panel panel-default dashboard__profile">
<!--     <div class="panel-heading"><?php echo lang_check('Profile');?></div> -->
    <div class="panel-body">
        <div class="dashboard__profile--img">
            <?php if($this->session->userdata('profile_image') != ''):?>
            <img src="<?php echo base_url($this->session->userdata('profile_image'));?>" alt="">
            <?php else:?>
            <img src="assets/img/user-agent.png" alt="">
            <?php endif;?>
        </div>
        <span><?php echo $this->session->userdata('name_surname');?></span>

        <ul class="list-unstyled">
            <li>
                <span class="pull-left">
                    <?php echo lang_check('Points');?>
                </span>
                <span class="pull-right">
                    <a href="#">7203</a>
                </span>
            </li>
            <li>
                <span class="pull-left">
                    <?php echo lang_check('Friends');?>
                </span>
                <span class="pull-right">
                    <a href="#">12</a>
                </span>
            </li>
        </ul>

    </div>
</div>