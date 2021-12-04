<!DOCTYPE html>
<html>
<head>
    <?php _widget('head');?>
</head>
<body>
    <?php _widget('header_menu');?>
<!-- Hero section -->
<!-- <div class="page-in">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-in-name">{page_title}</div>
            </div>
        </div>
    </div>
</div> -->
<div class="container marg50">
    <div class="row">
        <div class="col-lg-9">
<!--             <div class="box-content">
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
            </div> -->
            <div class="list-result property_content_position" id="showroom">
                <?php foreach ($news_module_all as $key => $row): ?>
                <div class="classic-blog modern-blog">
                    <a href="<?php echo site_url($lang_code . '/' . $row->id . '/' . url_title_cro($row->title)); ?>">
                    <div class="cl-blog-img">
                        <?php if (file_exists(FCPATH . 'files/thumbnail/' . $row->image_filename)): ?>
                            <img src="<?php echo _simg('files/' . $row->image_filename, '900x500', true); ?>" alt="<?php _che($row->title); ?>" />
                        <?php else: ?>
                            <img src="assets/img/no_image.jpg" alt="<?php _che($row->title); ?>">
                        <?php endif; ?>
                    </div>
                    </a>
                    <div class="cl-blog-naz">
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
                    <a href="<?php echo site_url($lang_code . '/' . $row->id . '/' . url_title_cro($row->title)); ?>" class="btn btn-udora">Read More</a>
                    <div class="cl-blog-line"></div>
                </div>
                <?php endforeach; ?>
                <nav class="text-center">
                    <div class="pagination news">
                        <?php echo $news_pagination; ?>
                    </div>
                </nav>
            </div>
        </div>
        <div class="col-lg-3 sidebar-mobile-margin">
            <form action="{page_current_url}#showroom">
                <div class="promo-text-blog"><?php echo lang_check('Search');?></div>
                <input class="blog-search" id="search_news" type="text" placeholder="<?php echo lang_check('Type your search');?>">
                <button type="submit" style="display: none;" id="btn-search_news" class="input-group-addon"><i class="fa fa-search icon-white"></i></button>
            </form>
            <?php echo _widget('right_recentevents');?>
            <?php echo _widget('right_ads');?>
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
<script >
    $(document).ready(function () {
        $("#btn-search_news").click(function (e) {
            e.preventDefault();
            if ($('#search_news').val().length > 2 || $('#search_news').val().length == 0)
            {
                $.post('<?php echo $ajax_news_load_url; ?>', {search: $('#search_news').val()}, function (data) {
                    $('.list-result').html(data.print);
                    console.log('list-result')
                    reloadElements();
                }, "json");
            }
        });
    });
</script>
</body>
</html>
