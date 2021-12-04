<?php
/*
Widget-title: Results grid
Widget-preview-image: /assets/img/widgets_preview/center_recentproperties.jpg
*/
?>

<div class="" id="results_conteiner">
    <div class="properties-filter-box clearfix">
        <h4 class="properties-filter properties-result-title pull-left"><?php echo _l('Results');?> <span class='h-side-additional'>( <?php echo $total_rows; ?>  )</span></h4> 
        <div class="properties-filter pull-right">
            <div class="form-group properties-filter">
                <span><?php echo lang_check('Order By');?>: </span>
                <select class="form-control text-color-primary" name="filter" id="search">
                    <option value="id ASC" {order_dateASC_selected}>{lang_DateASC}</option>
                    <option value="id DESC" {order_dateDESC_selected}>{lang_DateDESC}</option>
                    <option value="price ASC" {order_priceASC_selected}>{lang_PriceASC}</option>
                    <option value="price DESC" {order_priceDESC_selected}>{lang_PriceDESC}</option>
                </select>
            </div>
            <div class="grid-type">
                <a href="#" class="view-type grid active" data-ref="grid"><i class="fa fa-th"></i></a>
                <a href="#" class="view-type list" data-ref="list"><i class="fa fa-list"></i></a>
            </div>
        </div>
    </div> <!-- /. filters -->
    <div class="row widget-content properties-items">
        <!-- PROPERTY LISTING -->
        <?php foreach($results as $key=>$item): ?>
        <?php
            /*if($key==0)echo '<div class="row">';*/
        ?>
            <?php _generate_results_item(array('key'=>$key, 'item'=>$item, 'custom_class'=>'col-lg-4 col-md-6 thumbnail-g')); ?>
        <?php
            /*if( ($key+1)%3==0 )
            {
                echo '</div><div class="row">';
            }
            if( ($key+1)==count($results) ) echo '</div>';*/
            endforeach;
        ?>
    </div> <!-- /. recent properties -->
    <nav class="text-center" aria-label="Page navigation">
        <div class="pagination properties">
            {pagination_links}
        </div>
    </nav>
    <div class="result_preload_indic"></div>
</div>