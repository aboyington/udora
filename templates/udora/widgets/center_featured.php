<?php
/*
Widget-title: Feature results
Widget-preview-image: /assets/img/widgets_preview/center_recentproperties.jpg
*/
?>

<div class="row properties-items">
    <!-- PROPERTY LISTING -->
    <?php foreach($featured_properties as $key=>$item): ?>
    <?php
        //if($key==0)echo '<div class="row">';
    ?>
        <?php _generate_results_item(array('key'=>$key, 'item'=>$item, 'custom_class'=>'col-sm-6 col-lg-4 thumbnail-g')); ?>
    <?php
        if( ($key+1)%3==0 )
        {
           // echo '</div><div class="row">';
        }
        //if( ($key+1)==count($featured_properties) ) echo '</div>';
        endforeach;
    ?>
</div>