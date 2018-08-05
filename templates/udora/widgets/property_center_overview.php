<div class="row">
<div class="marg20">
    <h4>{lang_Overview}</h4>
    <hr>
    <div class="property-detail-overview">
        <div class="property-detail-overview-inner clearfix">
        {category_options_1}
        {is_text}
        <div class="property-detail-overview-item col-sm-6 col-md-4">
            <strong>{option_name}:</strong>
        <span>{option_prefix} {option_value} {option_suffix}</span>
        </div><!-- /.property-detail-overview-item -->
        {/is_text}
        {is_dropdown}
        <div class="property-detail-overview-item col-sm-6 col-md-4">
            <strong>{option_name}:</strong>
            <span class="label label-success">{option_value}</span>
        </div><!-- /.property-detail-overview-item -->
        {/is_dropdown}
        {is_checkbox}
        <div class="property-detail-overview-item col-sm-6 col-md-4">
            <strong>{option_name}:</strong>
            <span><img src="assets/img/checkbox_{option_value}.png" alt="{option_value}" /></span>
        </div><!-- /.property-detail-overview-item -->
        {/is_checkbox}
        {/category_options_1}
        <?php if(!empty($estate_data_option_64) && isset($this->treefield_m)): ?>
            <div class="property-detail-overview-item col-sm-6 col-md-4">
                <strong><?php echo $options_name_64; ?>:</strong>
                <span>
                <?php
                    $nice_path = $estate_data_option_64;
                    $link_defined = false;
                    // Get treefield with language data
                    $treefield_id = $this->treefield_m->id_by_path(64, $lang_id, $nice_path);
                    if(is_numeric($treefield_id))
                    {
                        $treefield_data = $this->treefield_m->get_lang($treefield_id, TRUE, $lang_id);

                        // If no content defined then no link, just span
                        if(!empty($treefield_data->{"body_$lang_id"}))
                        {
                            // If slug then define slug link
                            $href = slug_url('treefield/'.$lang_code.'/'.$treefield_id.'/'.url_title_cro($treefield_data->{"value_$lang_id"}), 'treefield_m');
                            echo '<a href="'.$href.'">'.$nice_path.'</a>';
                            $link_defined=true;
                        }
                    }
                    if(!$link_defined) echo $nice_path;
                ?>
               </span>
            </div>
            <?php endif;?>
        </div><!-- /.property-detail-overview-inner -->
    </div>
</div>
</div>
