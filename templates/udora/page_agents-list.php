<!DOCTYPE html>
<html>
<head>
    <?php _widget('head');?>
</head>
<body>
    <?php _widget('header_menu');?>
    <div class="container marg50">
        <div class="row">
            <div class="col-lg-9 marg-b-4">
                <div class="row properties-items">
                    <?php foreach($paginated_agents as $item):?>
                    <div class="col-md-4 col-sm-6 col-xs-12 listing_wrapper listing_wrapper_agents">
                        <div class="agent_unit">
                            <div class="agent-unit-img-wrapper">
                                <a href="<?php  _che($item['agent_url']);?>">
                                    <div class="prop_new_details_back"></div>
                                    <img width="525" height="328" src="<?php echo _simg($item['image_url'], '600x400'); ?>" class="img-responsive wp-post-image" alt=""> 
                                </a>
                            </div>
                            <div class="">
                                <h4> 
                                    <a href="<?php  _che($item['agent_url']);?>"><?php  _che($item['name_surname']);?></a>
                                </h4>
                                <div class="agent_position"><?php  _che($item['address']);?></div>
                                <div class="agent_detail"><i class="fa fa-phone"></i><?php  _che($item['phone']);?></div>
                                <div class="agent_detail"><i class="fa fa-mobile"></i>(305) 555-4555</div>
                                <div class="agent_detail"><i class="fa fa-envelope-o"></i><a href="mailto:<?php  _che($item['mail']);?>?subject={lang_Estateinqueryfor}:{page_title}"><?php  _che($item['mail']);?></a></div>
                                <div class="agent_detail"><i class="ion-ios-location"></i><?php  _che($item['address']);?></div> 
                            </div>
                            <div class="agent_unit_social agent_list">
                                <div class="social-wrapper">
                                    <?php if(!empty($item['agent_profile']['facebook_link'])): ?>
                                    <a href="<?php echo $item['agent_profile']['facebook_link']; ?>"><i class="fa fa-facebook"></i></a>
                                    <?php endif; ?>
                                    <?php if(!empty($item['agent_profile']['youtube_link'])): ?>
                                        <a href="<?php echo $item['agent_profile']['youtube_link']; ?>"><i class="fa fa-youtube"></i></a>
                                    <?php endif; ?>
                                    <?php if(!empty($item['agent_profile']['gplus_link'])): ?>
                                        <a href="<?php echo $item['agent_profile']['gplus_link']; ?>"><i class="fa fa-google-plus"></i></a>
                                    <?php endif; ?>
                                    <?php if(!empty($item['agent_profile']['twitter_link'])): ?>
                                        <a href="<?php echo $item['agent_profile']['twitter_link']; ?>"><i class="fa fa-twitter"></i></a>
                                    <?php endif; ?>
                                    <?php if(!empty($item['agent_profile']['linkedin_link'])): ?>
                                        <a href="<?php echo $item['agent_profile']['linkedin_link']; ?>"><i class="fa fa-linkedin"></i></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach;?>
                </div>
                <div class="text-center">
                    <div class="pagination pagination-centered">
                        <?php echo $agents_pagination; ?>
                    </div>
                </div>
            </div>
            <!-- Features Section Sidebar -->
            <div class="col-lg-3">
                <form  class="form-search agents" action="<?php echo current_url().'#gent-search'; ?>" method="get">
                    <div class="promo-text-blog"><?php _l('Search');?></div>
                    <input class="blog-search" type="text" name="search-agent" value="<?php echo $this->input->get('search-agent'); ?>" placeholder="<?php echo lang_check('Type your search');?>">
                </form>
                <?php echo _widget('right_recentevents');?>
                <?php echo _widget('right_ads');?>
            </div>
        </div>
    </div>
    <?php _widget('custom_footer');?>
    <?php _widget('custom_javascript');?>
</body>
</html>
