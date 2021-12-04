<!DOCTYPE html>
<html>
<head>
    <?php _widget('head');?>
</head>
<body>
<!-- Custom HTML -->
<?php _widget('header_menu');?>
<!-- Carousel -->
<!-- Features Section Events -->
<div class="container marg50">
    <div class="row">
        <div class="col-lg-9 event-text" id="expert">
            <h4>{page_title}</h4>
            <hr>
            <div class="box-content">
                {page_body}
                {has_page_documents}
                <h4>{lang_Filerepository}</h4>
                <ul>
                {page_documents}
                <li>
                    <a href="{url}">{filename}</a>
                </li>
                {/page_documents}
                </ul>
                {/has_page_documents}
            </div>
            <div class="">
                <div class="panel-group panel-content property_content_position" id="accordionThree">
                    <?php foreach($expert_module_all as $key=>$row):?>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="qmark">?</i>
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordionThree" href="#collapse<?php echo $key;?>" aria-expanded="false" class="collapsed">
                                    <?php echo $row->question; ?>                                        
                                </a>
                            </h4>
                        </div>
                        <div id="collapse<?php echo $key;?>" class="panel-collapse collapse <?php echo ($key==0) ? 'in' : '' ;?>" aria-expanded="<?php echo ($key==0) ? 'true' : '' ;?>" style="<?php echo ($key==0) ? 'in' : 'height: 0px' ;?>;">
                            <div class="panel-body clearfix">
                                <?php if(!empty($row->answer_user_id) && isset($all_experts[$row->answer_user_id])): ?>
                                <a class="image_expert" href="<?php echo site_url('expert/'.$row->answer_user_id.'/'.$lang_code); ?>#content-position">
                                    <img src="<?php echo $all_experts[$row->answer_user_id]['image_url']?>" alt="" />
                                </a>
                                <?php endif;?>
                                <?php echo $row->answer; ?>                                    
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php _widget('center_imagegallery');?>
        </div>
        <div class="col-lg-3">
            <form action="{page_current_url}#ask">
                <div class="promo-text-blog"><?php echo lang_check('Search');?></div>
                <input class="blog-search" id="search_expert" type="text" placeholder="<?php echo lang_check('Type your search');?>">
                <button type="submit" style="display: none;" id="btn-search_expert" class="input-group-addon"><i class="fa fa-search icon-white"></i></button>
            </form>
            <ul class="nav nav-tabs nav-stacked news-cat">
            <?php foreach($categories_expert as $id=>$category_name):?>
            <?php if($id != 0): ?>
                <li><a href="{page_current_url}?cat=<?php echo $id; ?>#expert"><?php echo $category_name; ?></a></li>
            <?php endif;?>
            <?php endforeach;?>
            </ul>
            
            <div class="promo-text-blog center-align col-xs-12" id="form">{lang_Enquireform}</div>
            <!-- Contact form -->
            <form id='ajax-contact-form' class="sidebar-form col-xs-12" action="{page_current_url}#form" name='contact-form' method='POST'>
                {validation_errors} {form_sent_message}
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-lg-12">
                        <div class="form-group {form_error_firstname}">
                            <label for="firstname">{lang_FirstLast}</label>
                           <input type="text" id="firstname" name='firstname' class="form form-control" value="{form_value_firstname}">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-lg-12">
                        <div class="form-group {form_error_email}">
                            <label for="email">{lang_Email}</label>
                             <input type="text" name="email" id="email" class="form form-control" value="{form_value_email}">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-lg-12">
                        <div class="form-group {form_error_phone}">
                            <label for="phone">{lang_Phone}</label>
                            <input type="text" name="phone" id="phone" class="form form-control" value="{form_value_phone}" >
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-lg-12">
                        <div class="form-group {form_error_question}">
                            <label for="question">{lang_Question}</label>
                            <textarea id="question" name="question" class="form textarea form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <?php if(config_item( 'captcha_disabled')===FALSE): ?>
                        <div class="form-group {form_error_captcha}">
                            <div class="row-fluid clearfix">
                                <div class="col-lg-6" style="padding-top:2px;">
                                    <?php echo $captcha[ 'image']; ?>
                                </div>
                                <div class="col-lg-6">
                                    <input class="captcha form-control {form_error_captcha}" name="captcha" type="text" placeholder="{lang_Captcha}" value="" />
                                    <input class="hidden" name="captcha_hash" type="text" value="<?php echo $captcha_hash; ?>" />
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>   
                    <?php if(config_item('recaptcha_site_key') !== FALSE): ?>
                    <div class="col-xs-12 col-sm-12 col-lg-12" >
                        <label class="control-label captcha"></label>
                        <div class="controls">
                            <?php _recaptcha(false); ?>
                        </div>
                    </div>
                    <?php endif; ?>    
                </div>
                <button type="submit" id="valid-form" class="btn sidebar-button accent-button">{lang_Send}</button>
            </form>
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
 <div class="d-none d-sm-block">
        <?php _widget('custom_footer'); ?>
  </div>
<?php _widget('custom_javascript');?>
<script language="javascript">
    $(document).ready(function(){
        $("#btn-search_expert").click( function() {
            if($('#search_expert').val().length > 2 || $('#search_expert').val().length == 0)
            {
                $.post('<?php echo $ajax_expert_load_url; ?>', {search: $('#search_expert').val()}, function(data){
                    $('.property_content_position').html(data.print);
                    
                    reloadElements();
                }, "json");
            }
        });

    });    
</script>
</body>
</html>
