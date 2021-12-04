<div class="properties-filter-box clearfix">
    <h4 class="properties-filter properties-result-title pull-left"><?php echo _l('Results');?> <span class='h-side-additional'> ( <?php echo $total_rows; ?>  )</span></h4> 
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
            <a href="#" class="view-type grid <?php _che($view_grid_selected); ?>" data-ref="grid"><i class="fa fa-th"></i></a>
            <a href="#" class="view-type list <?php _che($view_list_selected); ?>" data-ref="list"><i class="fa fa-list"></i></a>
        </div>
    </div>
</div> <!-- /. filters -->
{has_no_results}
<div class="result-answer">
    <div class="alert alert-success">
        {lang_Noestates}
    </div>
</div>
{/has_no_results}
{has_view_grid}
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
{/has_view_grid}

{has_view_list}
<?php _widget('results_list');?>
{/has_view_list}
<!-- PAGINATION & FILTERS -->
<nav class="text-center" aria-label="Page navigation">
    <div class="pagination properties">
        {pagination_links}
    </div>
</nav>
<div class="result_preload_indic"></div>
<script>
$('.result_preload_indic').hide();
if( $('#mapplaces_search_results').length) {
    
    var _result_map='';
    $('#mapplaces_search_results results-ts-scr .prebox').hide()  
    
    $('#mapplaces_search_results .prebox-pagin').html('');
    $('#mapplaces_search_results .results-content').html('')
    
    <?php foreach($results as $key=>$item): ?>
    <?php
    $marker_id ='';
    if(!empty($item['gps'])) {
        $gps = explode(', ', $item['gps']);
        $lat = floatval($gps[0]);
        $lng = floatval($gps[1]);
        $marker_id = $lat.$lng;
    }
    ?>
        
    <?php
    $date_start='';
    
    if(isset($item['option_81']) && !empty($item['option_81'])){
        $_strtotime = strtotime($item['option_81']);
        $day = date('l',$_strtotime);
        $day = strtolower($day);
        $month = date('M',$_strtotime);
        $month = strtolower($month);
        $date_start =  lang_check('cal_'.$day).', '.lang_check('cal_'.$month).' '. date('d, g:i a', $_strtotime);
    }
    ?>
        
    _result_map+='<div class="result-item"  data-property_id="<?php echo _ch($item['id']); ?>" data-id="<?php echo $marker_id; ?>" href="<?php echo _jse($item['url']); ?>">\n\
                                <a href="<?php echo _jse($item['url']); ?>"  class="result-item-pop" data-property_id="<?php echo _ch($item['id']); ?>">\n\
                                    <div class="result-item-detail">\n\
                                        <div class="image" style="background-image: url(<?php echo _simg($item['thumbnail_url'], '100x115', true); ?>)">\n\
                                            <figure><?php echo _ch($item['option_79']); ?></figure>\n\
                                        </div>\n\
                                        <div class="description">\n\
                                            <h3 title="<?php echo _jse($item['option_10']); ?>"><?php echo _jse($item['option_10']); ?></h3>\n\
                                            <div class="description__item">\n\
                                                <div class="description__item__icon">\n\
                                                <i class="ion-android-time"></i>\n\
                                                </div>\n\
                                                <h5 title="<?php echo $date_start;?>">\n\
                                                <?php echo $date_start;?>\n\
                                                </h5>\n\
                                            </div>\n\
                                            <div class="description__item">\n\
                                                <div class="description__item__icon">\n\
                                                    <i class="ion-ios-location"></i>\n\
                                                </div>\n\
                                                <h5 title="<?php _jse($item['address']);?>"><?php _jse($item['address']);?></h5>\n\
                                            </div>\n\
                                          <p class=""><?php echo _jse($item['option_chlimit_8']); ?></p>\n\
                                        </div>\n\
                                </div>\n\
                                </a>\n\
                    <div class="controls-more">\n\
                        <ul>\n\
                            <li>\n\
                                <a href="#" data-id="<?php echo _jse($item['id']); ?>" class="add-to-favorites add-favorites-action" style="<?php echo ($item['is_favorite'])?'display:none;':''; ?>"><?php echo lang_check('Add to favorites');?></a>\n\
                                <a href="#" data-id="<?php echo _jse($item['id']); ?>" class="remove-from-favorites remove-favorites-action"" style="<?php echo (!$item['is_favorite'])?'display:none;':''; ?>"><?php echo lang_check('Remove from favorites');?></a>\n\
                                \n\
                                </li>\n\
                            <li><a href="https://www.facebook.com/share.php?u=<?php echo _jse($item['url']); ?>&title=<?php echo _jse($item['option_10']); ?>" onclick="javascript:window.open(this.href, "", "menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600");return false;" class="add-to-watchlist"><?php echo lang_check('Share to friends');?></a></li>\n\
                        </ul>\n\
                    </div>\n\
                </div>';
    <?php endforeach;?>
    $('.popup_request_to_event').addClass('hidden');
    $('.custom_noevents_form').addClass('hidden');
        
    {has_no_results}
    _result_map +='<div class="result-answer">\n\
                    <div class="alert alert-success">\n\
                        {lang_Noestates}\n\
                    </div>\n\
                </div>';
    
    $('.popup_request_to_event').removeClass('hidden');
    $('.custom_noevents_form').removeClass('hidden');
    {/has_no_results}

    $('#mapplaces_search_results .results-content').html(_result_map)
    
    var _pagin = '';
    <?php
    $_pagination_links = str_replace('content', 'top_mapplacesSearchvisual', $pagination_links);
    ?>
    _pagin = '<?php echo $_pagination_links;?>';
    
    $('#mapplaces_search_results .prebox-pagin').html('<div class="pagination properties wp-block default product-list-filters light-gray">'+_pagin+'</div>');
}
    
</script>


                  