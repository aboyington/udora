<?php foreach($expert_module_all as $key=>$row):?>
<div class="panel panel-default">
    <div class="panel-heading">
        <i class="qmark">?</i>
        <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordionThree" href="#collapse<?php echo $key;?>" aria-expanded="false" class="collapsed">
                <?php echo $row->question; ?>                                        
            </a>
        </h4>
    </div>
    <div id="collapse<?php echo $key;?>" class="panel-collapse collapse <?php echo ($key==0) ? 'in' : '' ;?>" aria-expanded="<?php echo ($key==0) ? 'true' : '' ;?>" style="<?php echo ($key==0) ? 'in' : 'height: 0px' ;?>;">
        <div class="panel-body clearfix">
            <?php if(!empty($row->answer_user_id) && isset($all_experts[$row->answer_user_id])): ?>
            <a class="image_expert" href="<?php echo site_url('expert/'.$row->answer_user_id.'/'.$lang_code); ?>#content-position">
                <img src="<?php echo $all_experts[$row->answer_user_id]['image_url']?>" alt="" />
            </a>
            <?php endif;?>
            <?php echo $row->answer; ?>                                    
        </div>
    </div>
</div>
<?php endforeach; ?>