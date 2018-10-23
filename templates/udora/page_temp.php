<!DOCTYPE html>
<html>
<head>
    <?php _widget('head');?>
<style>
    #codeigniter_profiler {
        display: none;
    }
</style>
</head>
<body class="no-padding footer-nav-black home">
    <?php _widget('header_search');?>

<!--     <div class="d-lg-none">
        <?php // _widget('custom_footer_menu');?>
    </div> -->
    
    <div class="d-none d-md-block">

        <section class="text-center pt-14 pb-14">
        <div class="container">
            <div class="row mb-5">
            <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 text-center">
                <div class="promo-block m-auto">
                <h2 class="weight-400 mb-2">Explore with Udora</h2>
                <div class="promo-paragraph">Do more, spend less. Experiences on a budget</div>
                <div class="center-line"></div>
            </div>
            </div>
            </div>
            <div class="row properties-items">
                <!-- PROPERTY LISTING -->
                    </div>
            <div class="text-center">
            <a class="btn btn-udora" href="<?php echo site_url('frontend/login');?>" type="button">Start now for free!</a>
            </div>
        </div>
        <!--end of container-->
        </section>


        <section class="bg-grey pt-10 pb-10">
        <div class="container">
            <div class="row">
            <div class="col-md-12">
            <div class="row d-md-flex align-items-md-center">
            <div class="col-md-5">
            <h3 class="weight-300">Travel the world with <span class="color-accent weight-600">Udora</span></h3>

<p class="mb-0">Never miss another event. On Udora you can connect with event organizers, locals and explorers like yourself, get recommendations share photos or even meet up.</p>

<p>Udora is your travel companion and will help you discover events near and far.</p>
            </div>

            <div class="col-md-7"><img alt="" class="img-responsive" src="assets/img/how-it-works/how-it-works-1.png"></div>
            </div>
            </div>
            </div>
            </div>
        </section>


        <section class="pt-10 pb-10">
        <div class="container">
<div class="row d-md-flex align-items-md-center">
<div class="col-md-7"><img alt="" class="img-responsive mb-5 mb-md-0" src="assets/img/how-it-works/how-it-works-2.png"></div>

<div class="col-md-5">
<h3 class="weight-300">Travel the world with <span class="color-accent weight-600">Udora</span></h3>

<p class="mb-0">Never miss another event. On Udora you can connect with event organizers, locals and explorers like yourself, get recommendations share photos or even meet up.</p>

<p>Udora is your travel companion and will help you discover events near and far.</p>

</div>
</div>
</div>
        </section>

    <?php _widget('bottom_featured');?>

    <!-- <section class="pt-14 pb-14">
    <div class="container">
        <div class="row">
        <div class="col-sm-6">
            <div class="other-serv marg0 bg-grey">
            <div class="serv-icon"><i class="ion-chatbubbles"></i></div>
            <div class="serv-block-list">
                <h2 class="serv-name">Join the conversation</h2>
                <p class="serv-desc weight-400">Make your voice heard, comment on events you are interested in. Share your opinion with others and give feedback. Your comments and feedback are important so post and be proud.</p>
            </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="other-serv marg0 bg-grey">
            <div class="serv-icon"><i class="ion-ios-location"></i></div>
            <div class="serv-block-list">
                <h2 class="serv-name">Never miss another event</h2>
                <p class="serv-desc weight-400">Is your favourite shop or brand giving away free samples? these are hidden gems you don't want to miss, that's why I created Udora, a social events discovery app for explorers like you.</p>
            </div>
            </div>
        </div>
        </div>
    </div>
    </section> -->


    <section class="cover height-80 imagebg text-center" data-overlay="6">
    <div class="background-image-holder" style="background: url(assets/img/home/inner-1.jpg); opacity: 1;">
        <img alt="background" src="assets/img/home/inner-1.jpg">
    </div>
    <div class="container pos-vertical-center">
        <div class="row">
        <div class="col-sm-6">
            <h3 class="mb-4">Want to know why we love Udora?</h3>
            <p class="lead mb-3">
            Check out this short video to see what Udora is all about and follow Udora to get updates on the app launch.
            </p>
            <div class="modal-instance">
            <div class="video-play-icon video-play-icon--sm modal-trigger" data-fancybox="" href="https://www.youtube.com/watch?v=vlDzYIIOYmM"></div>
            <!--end of modal-container-->
            </div>
            <!--end of modal instance-->
        </div>
        </div>
        <!--end of row-->
    </div>
    <!--end of container-->
    </section>
    <?php _widget('custom_footer');?>

    </div>


<?php _widget('custom_footer_menu');?>


<?php _widget('custom_javascript');?>
 
 <?php //_widget('mautic_tracker_javascript');?>

</body>
</html>
