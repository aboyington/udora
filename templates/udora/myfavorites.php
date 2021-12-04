<!DOCTYPE html>
<html>
<head>
    <?php _widget('head'); ?>
    <script src='assets/js/gmap3/gmap3.min.js'></script>
</head>
<body class="dashboard-body">
<?php _widget('header_menu'); ?>
<!-- Add Event -->
<?php 

$CI =& get_instance();
$CI->load->model('reviews_m');
$CI->load->model('userattend_m');

?>
<div class="container dashboard-layout" id="main">
    <div class="raw">
        <div class="col-xs-12" style="padding-bottom: 30px;">
            <div class="col-md-3 hidden-xs hidden-sm pad0">
                <?php _widget('custom_login_profile'); ?>
                <?php _widget('custom_loginusermenu');?>
            </div>
            <div class="col-xs-12 col-md-9 pad0">
                <div class="col-xs-12 col-md-12 mobile-pad0 mobile-marg-b-20">
                    <div class="panel panel-default">
                        <div class="panel-heading"><?php echo lang_check('Favorites / Saved Events');?></div>
                        <div class="panel-body left-align">
                            <div class="">
                                     <table class="table table-striped footable">
                                     <thead>
                                         <th data-breakpoints="xs sm md" data-type="html">#</th>
                                         <th data-breakpoints="md" data-type="html"><?php echo lang_check('Event');?></th>
                                         <?php if(file_exists(APPPATH.'controllers/admin/reviews.php') && $settings_reviews_enabled): ?>
                                         <th data-breakpoints="xs sm md" data-type="html" ><?php echo lang_check('Review');?></th>
                                         <?php endif;?>   
                                         <th data-breakpoints="xs sm md" data-type="html" class="control"><?php echo lang_check('Open');?></th>
                                         <th data-breakpoints="xs sm md" data-type="html" class="control"><?php echo lang_check('Delete');?></th>
                                     </thead>
                                     <?php if(count($listings)): foreach($listings as $listing_item):?>
                                         <tr>
                                             <td><?php echo $listing_item->id; ?></td>
                                             <td><?php echo $option_10[$listing_item->property_id]; ?></td>
                                             <?php if(file_exists(APPPATH.'controllers/admin/reviews.php') && $settings_reviews_enabled): ?>
                                             <td>
                                                <?php
                                                    $class= '';
                                                    $data= 'data-toggle="modal" data-target="#leaveReview"';
                                                    $message = '';
                                                    if($CI->reviews_m->check_if_exists($this->session->userdata('id'), $listing_item->property_id) !== 0 ) {
                                                        $class= ' disabled';
                                                        $message = lang_check('You have already reviewed this event');
                                                        $data = '';
                                                    }
                                                                    
                                                    if(config_db_item('events_qr_confirmation') === TRUE && $CI->userattend_m->check_notattend($listing_item->property_id, 
                                                                            $this->session->userdata('id'))) {
                                                        $class= ' disabled';
                                                        $data = '';
                                                        $message = lang_check('Review not active at this time');
                                                    }
                                                ?>
                                                <div type="button" <?php echo $data;?> data-message="<?php _jse($message);?>"  data-listing_id="<?php echo $listing_item->property_id; ?>" class="open-leave-review <?php echo $class;?>"><?php echo lang_check('Leave a Review');?>
                                                </div>
                                             </td>
                                             <?php endif;?>   
                                             <td>
                                             <a href="<?php echo site_url($listing_uri.'/'.$listing_item->property_id.'/'.$listing_item->lang_code); ?>" class="btn btn-primary no-margin"><i class="fa fa-external-link" aria-hidden="true"></i></a>
                                             </td>
                                             <td><?php echo btn_delete('ffavorites/myfavorites_delete/'.$lang_code.'/'.$listing_item->id)?></td>
                                         </tr>
                                         <?php endforeach;?>
                                     <?php else:?>
                                         <tr>
                                             <td colspan="20"><?php echo lang_check('We could not find any');?></td>
                                         </tr>
                                     <?php endif;?>   
                                 </table>
                             </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="d-block d-md-none">
    <?php _widget('custom_footer_menu');?>
</div>

<a href="#" class="js-toogle-footermenu">
    <i class="material-icons">
    playlist_add
    </i>
    <i class="close-icon"></i>
</a>


<?php if(file_exists(APPPATH.'controllers/admin/reviews.php') && $settings_reviews_enabled): ?>
<!-- Modal Review -->
<div class="modal fade" id="leaveReview" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <p class="modal-title center-align marg0"><?php echo lang_check('Give a Review');?></p>
            </div>
            <div class="modal-body">
                <p class="center-align small-font"><?php echo lang_check('Please rate your overall Experience*');?></p>
                <form action="#" id='ajax-review-form' data-listing_id="" name='review-form' method='POST' data-name='Review Form' style="margin-top: -1.4em;">
                    <div class="raw">
                        <div class="col-xs-12">
                            <fieldset class="rating marg20" required>
                                <input type="radio" id="star1" name="stars" value="5" />
                                <label class="full" for="star1" title="Sucks big time - 1 star"></label>
                                <input type="radio" id="star2" name="stars" value="4" />
                                <label class="full" for="star2" title="Kinda bad - 2 stars"></label>
                                <input type="radio" id="star3" name="stars" value="3" />
                                <label class="full" for="star3" title="Meh - 3 stars"></label>
                                <input type="radio" id="star4" name="stars" value="2" />
                                <label class="full" for="star4" title="Pretty good - 4 stars"></label>
                                <input type="radio" id="star5" name="stars" value="1" />
                                <label class="full" for="star5" title="Awesome - 5 stars"></label>
                            </fieldset>
                        </div>
                    </div>
                    <input type='hidden' name='form-name' value='review-form' />
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2">
                            <div class="form-group">
                                <label class="center-align" for="review"><?php echo lang_check('Review');?></label>
                                <textarea name="message" rows="5" id="review" class="form textarea form-control" placeholder="<?php echo lang_check('Enter you review');?>" onfocus="this.placeholder = '<?php echo lang_check('Enter you review');?>'" onblur="this.placeholder = '<?php echo lang_check('Enter you review');?>'" data-name="Review"></textarea>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="raw">
                        <div class="col-md-8 center-align col-md-offset-2">
                            <div class="col-md-12 marg20">
                                <button type="submit" id="valid-form" class="btn btn-default btn-udora"><?php echo lang_check('SEND');?></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-udora-dark btn-sm" data-dismiss="modal"><?php echo lang_check('Close');?></button>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php _widget('custom_javascript'); ?>

<script type="text/javascript">
$(document).ready(function() {
    // [START] Add to reviews //  
    
    $('.open-leave-review').click(function (e) {
       $('#leaveReview form').attr('data-listing_id', $(this).attr('data-listing_id'));
    })
    
    $('.open-leave-review.disabled').click(function (e) {
        e.preventDefault();
        ShowStatus.show($(this).attr('data-message'));
    })
    
    $('#leaveReview').on('hidden.bs.modal', function (e) {
        $('[name="message"]').val('');
    })
      
    $("#ajax-review-form").submit(function(e){
        e.preventDefault();
        var data = $('#ajax-review-form').serializeArray();
        
        $.post("{api_private_url}/send_review/"+$('#leaveReview form').attr('data-listing_id'), data, 
            function(data){
                ShowStatus.show(data.message);
                if(data.success)
                {
                    $('.open-leave-review[data-listing_id="'+$('#leaveReview form').attr('data-listing_id')+'"]')
                                            .addClass('disabled')
                                            .removeAttr('data-toggle')
                                            .click(function (e) {
                                                ShowStatus.show("<?php echo lang_check('You already have review on this event');?>");
                                            });
                    $('#leaveReview').modal('hide');
                }
            }
        );

        return false;
    });
});
// [/END] Add to reviews //  
</script>

<script>
    /*
     * http://fooplugins.github.io/FooTable/docs/getting-started.html
     */

    $('document').ready(function () {
        $('.footable').footable({
            "filtering": {
                "enabled": false
            },
        });
    })

</script>
</body>
</html>
