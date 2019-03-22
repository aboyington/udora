<div class="footer style-1 d-md-none js-hide-when-navbar-open js-hide-when-login-open">
    <div class="footer-links">
        
      
        <a href="<?php echo site_url('' . $lang_code . '#content'); ?>"
           class="footer-links__link js-footer-nav-discover">
            <i class="material-icons">search</i>
            <span class="footer-links__link__title">{lang_Explore}</span>
        </a>       
        <a href="<?php echo site_url('ffavorites/myfavorites/' . $lang_code . '#content'); ?>"
               class="footer-links__link">
               <i class="material-icons">favorite_border</i>
                <span class="footer-links__link__title">{lang_Saved}</span>
        </a>

        <div class="footer-links__link">
            <form action="#" class="footer-links__link-upload">
                <input type="file">
            </form>
              <svg xmlns="http://www.w3.org/2000/svg" width="25px" viewBox="0 0 29.07 28.54"><defs><style>.cls-1{fill:#f15a24;}</style></defs><g id="Layer_2" data-name="Layer 2" transform="matrix(1,0,0,1,0,2)"><g id="Foreground_Layer" data-name="Foreground Layer"><path class="cls-1" d="M7.37,22.54A7.34,7.34,0,0,1,0,15.18V0H2.6V15.18a4.77,4.77,0,0,0,9.54,0V4.27h2.6V15.18A7.34,7.34,0,0,1,7.37,22.54Z"/><path class="cls-1" d="M17.34,22.54V19.85c4.34,0,9-3.69,9-8.64s-4.2-8.64-9.23-8.64H4.34V0H17.12c6.53,0,12,4.83,12,11.27S23.41,22.54,17.34,22.54Z"/></g></g></svg>
            <span class="footer-links__link__title">{lang_Check in}</span>
        </div>

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
        <a href="<?php echo site_url('frontend/login/' . $lang_code . '#content'); ?>" class="footer-links__link" >
            <i class="fa fa-plus"></i>
            <span class="footer-links__link__title">{lang_Add Event}</span>
        </a>
        {/not_logged}
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