<div class="page-title">
    <div class="title_left">
        <h3><?php echo lang('View estate statuses')?></h3>
    </div>

    <div class="title_right">
        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
            <?php echo form_open('admin/dashboard/search');?>
            <div class="input-group">
              	<input type="text" class="form-control col-md-7 col-xs-12" name="search" placeholder="<?php echo lang_check('Search')?>" />
                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit">Go!</button>
                </span>
            </div>
            <?php echo form_close();?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><?php echo lang('Dependent fields')?></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Settings 1</a>
                            </li>
                            <li><a href="#">Settings 2</a>
                            </li>
                        </ul>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br/>
                    <table class="table table-bordered table-statuses footable">
                      <thead>
                        <tr>
                            <th><?php _l('Properties Pending Review'); ?></th>
                            <th><?php _l('Properties on Hold'); ?></th>
                            <th><?php _l('Properties contracted'); ?></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                                <td>
                            <?php if(count($estates_pending)): foreach($estates_pending as $estate):?>
                            <div class="status_d">
                            <span style="color: #2E367E;"><?php echo $estate->address; ?></span> 
                            <span style="color: black;"><?php echo lang_check('Submitted').' '.format_d($estate->date); ?></span>
                            <br />
                            <span style="color: black;"><?php echo lang_check('You have').' '; ?></span>
                            <span style="color: red;"><?php

                            $hours_left = (time()-strtotime($estate->date_modified))/3600;

                            if($estate->status == 'REDUCED_PRICE')
                            {
                                echo intval(24-$hours_left);
                            }
                            else
                            {
                                echo intval(48-$hours_left);
                            }

                             ?></span>
                            <span style="color: black;"><?php echo lang_check('hours left to review').' '; ?></span>

                            <?php if($estate->status == 'RESUBMIT'): ?>
                            <a class="btn btn-success" href="<?php echo site_url('admin/estate/status/'.$estate->id.'/APPROVE_RESUBMIT/statuses'); ?>">
                            <i class="icon-ok"></i> <?php echo lang_check('Approve'); ?></a>
                            <?php else: ?>
                            <a class="btn btn-success" href="<?php echo site_url('admin/estate/status/'.$estate->id.'/APPROVE/statuses'); ?>">
                            <i class="icon-ok"></i> <?php echo lang_check('Approve'); ?></a>
                            <?php endif; ?>


                            <?php if($estate->status == 'REDUCED_PRICE'): ?>
                            <a class="btn btn btn-warning" href="<?php echo site_url('admin/estate/status/'.$estate->id.'/HOLD_REDUCED/statuses'); ?>">
                            <i class="icon-pause"></i> <?php echo lang_check('On hold'); ?></a>
                            <?php elseif($estate->status == 'RESUBMIT'): ?>
                            <a class="btn btn btn-warning" href="<?php echo site_url('admin/estate/status/'.$estate->id.'/HOLD_RESUBMIT/statuses'); ?>">
                            <i class="icon-pause"></i> <?php echo lang_check('On hold'); ?></a>
                            <?php else: ?>
                            <a class="btn btn btn-warning" href="<?php echo site_url('admin/estate/status/'.$estate->id.'/HOLD/statuses'); ?>">
                            <i class="icon-pause"></i> <?php echo lang_check('On hold'); ?></a>
                            <?php endif; ?>
                            <a class="btn btn btn-danger" href="<?php echo site_url('admin/estate/status/'.$estate->id.'/DECLINE/statuses'); ?>">
                            <i class="icon-remove-sign"></i> <?php echo lang_check('Decline'); ?></a>
                            </div>
                            <?php endforeach;?>
                            <?php else:?>
                            <div class="status_d">
                            <?php echo lang('We could not find any');?>
                            </div>
                            <?php endif;?>    
                            </td>
                            <td>
                            <?php if(count($estates_hold)): foreach($estates_hold as $estate):?>
                            <div class="status_d">
                            <span style="color: #2E367E;"><?php echo $estate->address; ?></span> 
                            <span style="color: black;"><?php echo lang_check('Placed on hold').' '.format_d($estate->date_status); ?></span><br />
                            <span style="color: black;"><?php echo lang_check('You have').' '; ?></span>
                            <span style="color: red;"><?php

                            $hours_left = (time()-strtotime($estate->date_status))/3600;

                            if($estate->status == 'HOLD_REDUCED')
                            {
                                echo intval(24-$hours_left);
                            }
                            else
                            {
                                echo intval(48-$hours_left);
                            }


                             ?></span>
                            <span style="color: black;"><?php echo lang_check('hours left to take final action').' '; ?></span>
                            <?php if($estate->status == 'HOLD_REDUCED'): ?>
                            <a class="btn btn-success" href="<?php echo site_url('admin/estate/status/'.$estate->id.'/APPROVE_REDUCED/statuses'); ?>">
                            <i class="icon-ok"></i> <?php echo lang_check('Approve'); ?></a>
                            <?php elseif($estate->status == 'HOLD_RESUBMIT'): ?>
                            <a class="btn btn-success" href="<?php echo site_url('admin/estate/status/'.$estate->id.'/APPROVE_RESUBMIT/statuses'); ?>">
                            <i class="icon-ok"></i> <?php echo lang_check('Approve'); ?></a>
                            <?php else: ?>
                            <a class="btn btn-success" href="<?php echo site_url('admin/estate/status/'.$estate->id.'/APPROVE/statuses'); ?>">
                            <i class="icon-ok"></i> <?php echo lang_check('Approve'); ?></a>
                            <?php endif;?> 

                            <a class="btn btn-info" href="<?php echo site_url('admin/estate/status/'.$estate->id.'/CONTRACT/statuses'); ?>">
                            <i class="icon-briefcase"></i> <?php echo lang_check('Contract property'); ?></a>


                            </div>
                            <?php endforeach;?>
                            <?php else:?>
                            <div class="status_d">
                            <?php echo lang('We could not find any');?>
                            </div>
                            <?php endif;?>  
                            </td>
                            <td>
                            <?php if(count($estates_contracted)): foreach($estates_contracted as $estate):?>
                            <div class="status_d">
                            <span style="color: #2E367E;"><?php echo $estate->address; ?></span> 
                            <span style="color: black;"><?php echo lang_check('Contracted on').' '.format_d($estate->date_status); ?></span>


                            </div>
                            <?php endforeach;?>
                            <?php else:?>
                            <div class="status_d">
                            <?php echo lang('We could not find any');?>
                            </div>
                            <?php endif;?>  
                            </td>
                        </tr>       
                      </tbody>
                    </table>


            </div>
        </div>
    </div>
</div>

