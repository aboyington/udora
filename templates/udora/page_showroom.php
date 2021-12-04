<!DOCTYPE html>
<html>
<head>
    <?php _widget('head');?>
</head>
<body>
    <?php _widget('header_menu');?>


<!-- Hero section -->
<div class="page-in">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-in-name">{page_title}</div>
            </div>
        </div>
    </div>
</div>
<div class="container marg50">
    <div class="row">
        <div class="col-lg-9 list-result">
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
            <?php foreach ($showroom_module_all as $key => $row): ?>
            <div class="classic-blog classic-article">
                <div class="cl-blog-img">
                    <?php if (file_exists(FCPATH . 'files/thumbnail/' . $row->image_filename)): ?>
                        <img src="<?php echo _simg('files/' . $row->image_filename, '900x550'); ?>" alt="<?php _che($row->title); ?>" />
                    <?php else: ?>
                        <img src="assets/img/no_image.jpg" alt="<?php _che($row->title); ?>">
                    <?php endif; ?>
                </div>
                <div class="cl-blog-naz">
                    <div class="cl-blog-name"><a href="<?php echo site_url('showroom/'.$row->id.'/'.$lang_code); ?>">Rank tall boy man them over post now rapturous unreserved</a></div>
                    <div class="cl-blog-text"><?php echo $row->description; ?></div>
                <div class="cl-blog-read"><a href="<?php echo site_url('showroom/'.$row->id.'/'.$lang_code); ?>">Read More</a></div>
                </div>
                <div class="cl-blog-line"></div>
            </div>
            <?php endforeach; ?>
            <nav class="text-center">
                <div class="pagination news">
                    <?php echo $showroom_pagination; ?>
                </div>
            </nav>
        </div>
        <div class="col-lg-3 sidebar-mobile-margin">
            <form action="{page_current_url}#showroom">
                <div class="promo-text-blog"><?php echo lang_check('Search');?></div>
                <input class="blog-search" id="search_showroom" type="text" placeholder="<?php echo lang_check('Type your search');?>">
                <button type="submit" style="display: none;" id="btn-search_showroom" class="input-group-addon"><i class="fa fa-search icon-white"></i></button>
            </form>
            <ul class="nav nav-tabs nav-stacked news-cat">
            <?php foreach($categories_showroom as $id=>$category_name):?>
            <?php if($id != 0): ?>
                <li><a href="{page_current_url}?cat=<?php echo $id; ?>#showroom"><?php echo $category_name; ?></a></li>
            <?php endif;?>
            <?php endforeach;?>
            </ul>
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
<script>
    $(document).ready(function(){
        $("#btn-search_showroom").click( function(e) { 
            e.preventDefault();
            if($('#search_showroom').val().length > 2 || $('#search_showroom').val().length == 0)
            {
                $.post('<?php echo $ajax_showroom_load_url; ?>', {search: $('#search_showroom').val()}, function(data){
                    $('.list-result').html(data.print);

                    reloadElements();
                }, "json");
            }
        });
    });  
</script>
</body>
</html>
