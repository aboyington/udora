<!DOCTYPE html>
<html>
<head>
    <?php _widget('head');?>
</head>
<body>
    <?php _widget('header_menu');?>
    <!-- News/Blog -->
    <div class="container marg50">
      <div class="row">
        <div class="col-lg-9">
<!--        <h3 class="help-header">{page_title}</h3> -->
            <div class="">
                {page_body}
                {has_page_documents}
                <h2>{lang_Filerepository}</h2>
                <ul>
                {page_documents}
                <li>
                    <a href="{url}">{filename}</a>
                </li>
                {/page_documents}
                </ul>
                {/has_page_documents}
            </div>
            <?php echo _widget('bottom_imagegallery');?>
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
      
      <div class="row">
        <div class="marg20">
            <h4><?php echo lang_check('Disqus comments');?></h4>
            <hr>
            <div class="">
                <div id="disqus_thread"></div>
                <script>

                /**
                *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
                *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/

                var disqus_config = function () {
                this.page.url = '<?php echo $page_current_url; ?>';  // Replace PAGE_URL with your page's canonical URL variable
                this.page.identifier = <?php echo $page_id; ?>; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
                };

                (function() { // DON'T EDIT BELOW THIS LINE
                var d = document, s = d.createElement('script');
                s.src = 'https://http-udora-io.disqus.com/embed.js';
                s.setAttribute('data-timestamp', +new Date());
                (d.head || d.body).appendChild(s);
                })();
                </script>
                <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
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
