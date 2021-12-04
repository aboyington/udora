<div class="marg20">
    <h4>{lang_Agentestates}</h4>
    <hr>
    <div class="properties-items" id="ajax_results">
            <?php foreach($agent_estates as $key=>$item): ?>
            <?php
                //if($key==0)echo '<div class="row">';
            ?>
                <?php _generate_results_item(array('key'=>$key, 'item'=>$item, 'custom_class'=>'col-lg-4 col-md-6 thumbnail-g')); ?>
            <?php
                if( ($key+1)%3==0 )
                {
                    //echo '</div><div class="row">';
                }
                //if( ($key+1)==count($agent_estates) ) echo '</div>';
                endforeach;
            ?>
        <nav class="text-center">
            <div class="pagination-ajax-results pagination properties" rel="ajax_results">
                <?php echo $pagination_links_agent; ?>
            </div>
        </nav>
    </div> <!-- /. recent properties -->
</div>