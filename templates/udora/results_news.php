<?php foreach ($news_module_all as $key => $row): ?>
<div class="classic-blog">
    <div class="cl-blog-img">
        <?php if (file_exists(FCPATH . 'files/thumbnail/' . $row->image_filename)): ?>
            <img src="<?php echo _simg('files/' . $row->image_filename, '900x500'); ?>" alt="<?php _che($row->title); ?>" />
        <?php else: ?>
            <img src="assets/img/no_image.jpg" alt="<?php _che($row->title); ?>">
        <?php endif; ?>
    </div>
    <div class="cl-blog-naz">
        <div class="cl-blog-type"><i class="ion-ios-briefcase-outline"></i></div>
        <div class="cl-blog-name"><a href="<?php echo site_url($lang_code . '/' . $row->id . '/' . url_title_cro($row->title)); ?>"><?php _che($row->title); ?></a></div>
        <div class="cl-blog-detail">                                                            <i class="fa fa-calendar"></i>
            <?php
            $timestamp = strtotime($row->date_publish);
            $m = strtolower(date("F", $timestamp));
            echo lang_check('cal_' . $m) . ' ' . date("j, Y", $timestamp);
            ?>
        </div>
        <div class="cl-blog-text"><?php echo $row->description; ?></div>
    </div>
    <div class="cl-blog-read"><a href="<?php echo site_url($lang_code . '/' . $row->id . '/' . url_title_cro($row->title)); ?>">Read More</a></div>
    <div class="cl-blog-line"></div>
</div>
<?php endforeach; ?>
<nav class="text-center">
    <div class="pagination news">
        <?php echo $news_pagination; ?>
    </div>
</nav>