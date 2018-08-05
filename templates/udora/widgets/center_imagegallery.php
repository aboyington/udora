<?php
/*
Widget-title: Image gallery
Widget-preview-image: /assets/img/widgets_preview/center_imagegallery.jpg
*/
?>

<?php
/*  The Gallery as lightbox dialog, should be a child element of the document body 
*    use css/blueimp-gallery.min.css
*    use js/blueimp-gallery.min.js
*    use config assets/js/winter-flat.js
*   site https://github.com/blueimp/Gallery/blob/master/README.md#setup
*/
?>

<?php if(!empty($page_images)):?>

<div class="marg20">
    <h4><?php echo lang_check('Image gallery');?></h4>
    <hr>
    <div class="row">
        <ul data-target="#modal-gallery" data-toggle="modal-gallery" class="images-gallery clearfix">  
            <?php foreach ($page_images as $val):?>
            <li class="col-lg-4 col-md-4 col-sm-6">
                <a data-gallery="gallery" href="<?php _che($val->url);?>" title="<?php _che($val->filename);?>" alt="<?php echo $val->alt;?>" download="<?php _che($val->url);?>" class="preview show-icon">
                    <img src="assets/img/preview-icon.png" class="" alt="">
                </a>
                <div class="preview-img image-cover-div"><img src="<?php echo _simg($val->thumbnail_url, '370x200');?>" data-src="<?php _che($val->url);?>" alt="<?php echo $val->alt;?>" class=""></div>
            </li>
            <?php endforeach;?>
        </ul>
    </div>
</div>

<?php endif;?>