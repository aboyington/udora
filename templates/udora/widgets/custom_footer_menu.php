<div class="footer style-1 d-md-none js-hide-when-navbar-open js-hide-when-login-open">
    <div class="footer-links">
        {is_logged_user}
        <a href="<?php echo site_url('frontend/editproperty/' . $lang_code . '#content'); ?>"
           class="footer-links__link">
            <i class="fa fa-plus"></i>
            <span class="footer-links__link__title">{lang_Add Event}</span>
        </a>
        {/is_logged_user}
        {is_logged_other}
        <a href="<?php echo site_url('frontend/editproperty/' . $lang_code . '#content'); ?>"
           class="footer-links__link">
            <i class="fis_logged_usera fa-plus"></i>
            <span class="footer-links__link__title">{lang_Add Event}</span>
        </a>
        {/is_logged_other}
        {not_logged}
        <a href="#" class="footer-links__link" data-toggle="modal" data-target="#addEventsModal">
            <i class="fa fa-plus"></i>
            <span class="footer-links__link__title">{lang_Add Event}</span>
        </a>
        {/not_logged}
        <div class="footer-links__link">
            <form action="#" class="footer-links__link-upload">
                <input type="file">
            </form>
            <i class="fa fa-qrcode"></i>
            <span class="footer-links__link__title">Scan</span>
        </div>
        <a href="<?php echo site_url('' . $lang_code . '#content'); ?>"
           class="footer-links__link js-footer-nav-discover">
            <i class="fa fa-search"></i>
            <span class="footer-links__link__title">{lang_Discover}</span>
        </a>
        <a href="<?php echo site_url('ffavorites/myfavorites/' . $lang_code . '#content'); ?>"
           class="footer-links__link">
            <i class="fa fa-star"></i>
            <span class="footer-links__link__title">{lang_Favorites}</span>
        </a>
        {is_logged_user}
        <a href="<?php echo site_url('frontend/myproperties/' . $lang_code . '#content'); ?>"
           class="footer-links__link">
            <i class="fa fa-user"></i>
            <span class="footer-links__link__title">{lang_Profile}</span>
        </a>
        {/is_logged_user}
        {is_logged_other}
        <a href="<?php echo site_url('frontend/myproperties/' . $lang_code . '#content'); ?>"
           class="footer-links__link">
            <i class="fa fa-user"></i>
            <span class="footer-links__link__title">{lang_Profile}</span>
        </a>
        {/is_logged_other}
        {not_logged}
        <a href="<?php echo site_url('frontend/myproperties/' . $lang_code . '#content'); ?>"
           class="footer-links__link js-toggle-login-popup js-close-mobile-navbar">
            <i class="fa fa-user"></i>
            <span class="footer-links__link__title">{lang_Profile}</span>
        </a>
        {/not_logged}
    </div>
</div>


<script>
    $(function () {
        $('.home .js-footer-nav-discover').on('click', function (e) {
            e.preventDefault();
            $("#search_option_location_second").focus();
        })
    })
</script>