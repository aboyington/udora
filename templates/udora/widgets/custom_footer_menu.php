<div class="footer style-1 d-md-none js-hide-when-navbar-open js-hide-when-login-open">
    <div class="footer-links">
        <a href="https://udora.io/production/" class="footer-links__link js-footer-nav-discover">
            <i class="fa fa-search"></i>
            <span class="footer-links__link__title">Discover</span>
        </a>
        {is_logged_user}
            <a href="<?php echo site_url('frontend/editproperty/'.$lang_code.'#content');?>" class="footer-links__link">
                <i class="fa fa-plus"></i>
                <span class="footer-links__link__title">Add Event</span>
            </a>
        {/is_logged_user}
        {is_logged_other}
            <a href="<?php echo site_url('frontend/editproperty/'.$lang_code.'#content');?>" class="footer-links__link">
                <i class="fa fa-plus"></i>
                <span class="footer-links__link__title">Add Event</span>
            </a>
        {/is_logged_other}
        {not_logged}
            <a href="#" class="footer-links__link" data-toggle="modal" data-target="#addEventsModal">
                <i class="fa fa-plus"></i>
                <span class="footer-links__link__title">Add Event</span>
            </a>
        {/not_logged}
        <a href="https://udora.io/production/index.php/ffavorites/myfavorites/en#content" class="footer-links__link">
            <i class="fa fa-star"></i>
            <span class="footer-links__link__title">Favorites</span>
        </a>
        {is_logged_user}
            <a href="https://udora.io/production/index.php/frontend/myproperties/en" class="footer-links__link">
                <i class="fa fa-user"></i>
                <span class="footer-links__link__title">Account</span>
            </a>
        {/is_logged_user}
        {is_logged_other}
        <a href="https://udora.io/production/index.php/frontend/myproperties/en" class="footer-links__link">
                <i class="fa fa-user"></i>
                <span class="footer-links__link__title">Account</span>
            </a>
        {/is_logged_other}
        {not_logged}
            <a href="https://udora.io/production/index.php/frontend/myproperties/en" class="footer-links__link js-toggle-login-popup js-close-mobile-navbar">
                <i class="fa fa-user"></i>
                <span class="footer-links__link__title">Account</span>
            </a>
        {/not_logged}
    </div>
</div>


<script>
    $(function() {
        $('.home .js-footer-nav-discover').on('click', function(e) {
            e.preventDefault();
            $("#search_option_location_second").focus();
        })
    })
</script>