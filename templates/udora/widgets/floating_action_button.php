  {is_logged_user}
  <a class="floating__add__event d-none d-md-flex / js-hide-when-navbar-open js-hide-when-login-open" href="https://udora.io/production/index.php/frontend/editproperty/en#content">
    <i class="ion-plus-round"></i>
  </a>
  {/is_logged_user}

   {is_logged_other}
  <a class="floating__add__event d-none d-md-flex / js-hide-when-navbar-open js-hide-when-login-open" href="https://udora.io/production/index.php/frontend/editproperty/en#content">
    <i class="ion-plus-round"></i>
  </a>
  {/is_logged_other}

  {not_logged}
  <div class="floating__add__event d-none d-md-flex / js-hide-when-navbar-open js-hide-when-login-open" data-toggle="modal" data-target="#addEventsModal">
    <i class="icon ion-plus-round"></i>
  </div>
  {/not_logged}


 <!--Start of Tawk.to Script-->
<!-- <script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/596ffecb1dc79b329518f3ec/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script> -->
<!--End of Tawk.to Script-->
