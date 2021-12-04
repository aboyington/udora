<!DOCTYPE html>
<html>
<head>
    <?php _widget('head');?>
</head>
<body>
    <?php _widget('header_menu');?>
    <div class="container marg50">
        <div class="row">
            <div class="col-xs-12">
                <div class="list-result">
                    <?php foreach($news_articles as  $key=>$row): ?>
                    <div class="article-list-result box box-fill">
                        <div class="media">
                            <div class="media-left image-preview">
                                <a href="<?php echo site_url($lang_code.'/'.$row->id.'/'.url_title_cro($row->title)); ?>" class="image-hoveffect-zoomlong">
                                    <?php if(file_exists(FCPATH.'files/thumbnail/'.$row->image_filename)):?>
                                    <img src="<?php echo _simg('files/'.$row->image_filename, '285x165'); ?>" alt="<?php _che($row->title);?>" />
                                    <?php else:?>
                                        <img src="assets/img/no_image.jpg" alt="new-image">
                                    <?php endif;?>
                                </a>
                            </div>
                            <div class="media-body">
                                <h2 class="title"><a href="<?php echo site_url($lang_code.'/'.$row->id.'/'.url_title_cro($row->title)); ?>"><?php echo $row->title; ?></a></h2>
                                <div class="description">
                                    <?php echo $row->description; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach;?>
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
        <div class="d-none d-sm-block">
            <?php _widget('custom_footer'); ?>
        </div>
    <?php _widget('custom_javascript');?>
</body>
</html>
