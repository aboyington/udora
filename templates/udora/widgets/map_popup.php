<!--

Widget-preview-title: <?php _che($option_10, ''); ?>



Widget-preview-idlisting: <?php _che($id, ''); ?>



-->

<?php if( !empty($thumbnail_url)):?>

    <!--

    Widget-preview-image: <?php echo $thumbnail_url; ?>

    

    -->

<?php else :?>

    <!--

    Widget-preview-image: /assets/img/items/default.png

    

    -->

<?php endif;?>

    

<?php if(!empty($option_6) && trim($option_6)==lang_check('Featured Events')):?>

    <!--

    Widget-preview-featured: <div class="tag"><i class="ion-ios-star"></i></div>



    -->

<?php elseif(!empty($option_6) && trim($option_6)==lang_check('Events that offer points')):?>

    <!--

    Widget-preview-featured: <div class="tag points"><i class="ion-ios-star"></i></div>



    -->

<?php else:?>

    <?php endif;?>

<?php

$marker_id ='';

if(!empty($gps)) {

    $gps = explode(', ', $gps);

    $lat = floatval($gps[0]);

    $lng = floatval($gps[1]);

    $marker_id = $lat.$lng;

}

?>

<div class="item infobox" data-id="<?php echo $marker_id;?>">

    <a href="<?php _che($url, ''); ?>">

        <div class="description">

            <?php if( !empty($option_4)):?>

                <div class="label label-default"><?php _che($option_4, ''); ?></div>

            <?php endif;?>

            <h3><?php _che($option_10, ''); ?></h3>



            <?php if( !empty($address)):?>

                <h4><?php _che($address, ''); ?></h4>

            <?php endif;?>

       </div>

        <?php if( !empty($thumbnail_url)):?>

            <div class="image" style="background-image: url(<?php echo $thumbnail_url; ?>)"></div>

        <?php else :?>

            <div class="image" style="background-image: url(assets/img/items/default.png)"></div>

        <?php endif;?>

    </a>

    <?php if( !empty($option_56)):?>

    <div class="rating-passive">

        <?php

            for($i=0; $i < 5; $i++){

                if( $i < $option_56 ){

                    echo '<span class="stars"><figure class="active ion-ios-star"></figure></span>';

                }

                else {

                    echo '<span class="stars"><figure class="inactive ion-ios-star"></figure></span>';

                }

            }

        ?>

        <span class="reviews"><?php _che($option_56, '0'); ?></span>

    </div>

    <?php endif;?>

    <div class="controls-more">

        <ul>

            <li><a href="#" data-id="<?php echo _ch($id); ?>" class="add-favorites-action" ><?php echo lang_check('Add to favorites');?></a></li>

            <li><a href="https://www.facebook.com/share.php?u=<?php echo _ch($option_10); ?>&title=<?php _che($url, ''); ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><?php echo lang_check('Share to friends');?></a></li>

        </ul>

    </div>

</div>