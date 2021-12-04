<?php if(file_exists(APPPATH.'controllers/admin/reviews.php') && $settings_reviews_enabled): ?>
<div class="review" id="main">
                <h4 id="form_review" class="page-header"><?php echo lang_check('YourReview'); ?></h4>
                <?php if(count($not_logged) && config_item('reviews_without_login') === FALSE): ?>
                <p class="alert alert-success">
                    <?php echo lang_check('LoginToReview'); ?>
                </p>
                <?php else: ?>
                
                <?php if($reviews_submitted == 0): ?>
                
                <?php _che($reviews_validation_errors); ?>
                
                <?php
                
                
                if(config_db_item('events_qr_confirmation') === TRUE && $this->userattend_m->check_notattend($estate_data_id, 
                                                                                    $this->session->userdata('id'))): ?>
                
                <p class="alert alert-info">
                    <?php echo lang_check('You can review after attending the event'); ?>
                </p>
                
                <?php else: ?>
                
                <form class="form-horizontal" method="post" action="{page_current_url}#form_review">
                
                <?php if(count($not_logged) && config_item('reviews_without_login') === TRUE): ?>
                <div class="control-group">
                    <label class="control-label" for="inputMailR"><?php echo lang_check('Email'); ?></label>
                    <div class="controls">
                        <input id="inputMailR" type="text" name="mail" placeholder="{lang_Email}" />
                    </div>
                </div>
                <?php endif; ?>
                
                <div class="control-group">
                <label class="control-label" for="inputRating"><?php echo lang_check('Rating'); ?></label>
                <div class="controls">
                    <input type="number" data-max="5" data-min="1" name="stars" id="stars" class="rating" data-empty-value="5" value="5" data-active-icon="icon-star" data-inactive-icon="icon-star-empty" />
                </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="inputMessageR"><?php echo lang_check('Message'); ?></label>
                    <div class="controls">
                        <textarea id="inputMessageR" rows="3" name="message" rows="3" placeholder="{lang_Message}"></textarea>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <button type="submit" class="btn"><?php echo lang_check('Send'); ?></button>
                    </div>
                </div>
                </form>
                <?php endif; ?>
                <?php else: ?>
                <p class="alert alert-info">
                    <?php echo lang_check('ThanksOnReview'); ?>
                </p>
                <?php endif; ?>
                
                <?php endif; ?>
                
                
                <?php if($settings_reviews_public_visible_enabled): ?>
                <h4 id="form_review" class="page-header"><?php echo lang_check('Reviews'); ?></h2>
                <?php if(count($not_logged) && !$settings_reviews_public_visible_enabled): ?>
                <p class="alert alert-info">
                    <?php echo lang_check('LoginToReadReviews'); ?>
                </p>
                <?php else: ?>
                <?php if(count($reviews_all) > 0): ?>
                <div class="box">
                <ul class="media-list">
                <?php foreach($reviews_all as $review_data): ?>
                <?php //print_r($review_data); ?>
                <li class="media">
                <div class="pull-left">
                <?php if(isset($review_data['image_user_filename'])): ?>
                <img class="media-object" data-src="holder.js/64x64" style="width: 64px; height: 64px;" src="<?php echo base_url('files/thumbnail/'.$review_data['image_user_filename']); ?>" />
                <?php else: ?>
                <img class="media-object" data-src="holder.js/64x64" style="width: 64px; height: 64px;" src="assets/img/user-agent.png" />
                <?php endif; ?>
                </div>
                <div class="media-body">
                <h4 class="media-heading"><div class="review_stars_<?php echo $review_data['stars']; ?>"> </div> <?php if(!empty($review_data['user_mail']))echo ' <span style="font-size:12px;">'.$review_data['user_mail'].'</span>';?></h4>
                <?php if($review_data['is_visible']): ?>
                <?php echo $review_data['message']; ?>
                <?php else: ?>
                <?php echo lang_check('HiddenByAdmin'); ?>
                <?php endif; ?>
                </div>
                </li>
                <?php endforeach; ?>
                </ul>
                </div>
                <?php else: ?>
                <p class="alert alert-info">
                    <?php echo lang_check('SubmitFirstReview'); ?>
                </p>
                <?php endif; ?>
                <?php endif; ?>
                <?php endif; ?>
                <?php endif; ?>
</div>