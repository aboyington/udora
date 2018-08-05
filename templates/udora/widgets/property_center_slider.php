<div class="row">
    <ul id="imageGallery">
        <?php if(count($slideshow_property_images)>0):?>
            <?php foreach($slideshow_property_images as $file): ?>
                <li data-thumb="<?php echo _simg($file['url'], '800x400');?>" data-src="<?php echo $file['url'];?>">
                    <img src="<?php echo _simg($file['url'], '800x400');?>" class="img-responsive" />
                </li>
            <?php endforeach; ?>
        <?php endif;?>
    </ul>
</div>