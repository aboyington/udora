<?php
/*
Widget-title: Feature results
Widget-preview-image: /assets/img/widgets_preview/center_recentproperties.jpg
*/
?>

<section class="bg-grey pt-12 pb-12">
  <div class="container">
      <div class="row mb-5">
      <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 text-center">
        <div class="promo-block m-auto">
        <div class="promo-text"><?php echo lang_check('Featured events');?></div>
        <div class="promo-paragraph"><?php echo lang_check('This months handpicked and popular events');?></div>
        <div class="center-line"></div>
      </div>
      </div>
    </div>
      <div class="row properties-items">
        <!-- PROPERTY LISTING -->
        <?php foreach($featured_properties as $key=>$item): ?>
        <?php
            if($key>2) break;
        ?>
            <?php _generate_results_item(array('key'=>$key, 'item'=>$item, 'custom_class'=>'col-sm-6 col-md-4 thumbnail-g')); ?>
        <?php
            endforeach;
        ?>
    </div>
      <div class="text-center">
      <a class="btn btn-udora" type="button">View More</a>
    </div>
  </div>
  <!--end of container-->
</section>


