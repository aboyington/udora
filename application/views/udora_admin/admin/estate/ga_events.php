<div class="page-title">
    <div class="title_left">
        <h3><?php echo lang('Ga Events')?></h3>
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

<!-- Add page / events button -->
<div class="x_panel">
    <div class="x_title">
        <h2><?php echo lang_check('Quick Add');?></h2>
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
        <?php echo anchor('admin/estate/edit_ga_events', '<i class="icon-plus"></i>&nbsp;&nbsp;'.lang_check('Add a Ga Codes'), 'class="btn btn-primary-blue"')?>
    </div>
</div>
<!-- /Add page / events button -->


<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><?php echo lang_check('View all Events codes')?></h2>
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
                <form class="search-admin form-inline" action="<?php echo site_url($this->uri->uri_string()); ?>" method="GET" autocomplete="off">
                    <div class="form-group">
                        <input class="form-control" name="smart_search" id="smart_search" value="<?php echo set_value_GET('smart_search', '', true); ?>" placeholder="<?php echo lang_check('Id, key'); ?>" type="text" />
                    </div>
                    <div class="form-group">
                        <input class="form-control" name="message" id="message" value="<?php echo set_value_GET('listing_id', '', true); ?>" placeholder="<?php echo lang_check('Lisitng id'); ?>" type="text" />
                    </div>
                    <button type="submit" class="btn btn-default"><i class="icon icon-search"></i>&nbsp;&nbsp;<?php echo lang_check('Search'); ?></button>
                </form>
                <div class="clearfix"></div>
                <div class="ln_solid"></div>
                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th><?php echo lang_check('id');?></th>
                            <th data-hide="phone,tablet"><?php echo lang_check('Title');?></th>
                            <th data-hide="phone,tablet"><?php echo lang_check('Event key');?></th>
                            <th data-hide="phone,tablet"><?php echo lang_check('Lisitng');?></th>
                            <th><?php echo lang('Edit');?></th>
                            <th><?php echo lang_check('Delete');?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(count($all_ga_events)): foreach($all_ga_events as $ga_event):?>
                        <tr>
                            <td><?php echo anchor('admin/estate/edit_ga_events/'.$ga_event->id, $ga_event->id)?></td>
                            <td><?php echo anchor('admin/estate/edit_ga_events/'.$ga_event->id, $ga_event->title)?></td>
                            <td><?php _che($ga_event->event_key)?></td>
                            <td><?php _che($all_estates[$ga_event->listing_id])?></td>

                            <td><?php _che(btn_edit_udora('admin/estate/edit_ga_events/'.$ga_event->id))?></td>
                            <td><?php _che(btn_delete_udora('admin/estate/delete_ga_events/'.$ga_event->id))?></td>
                        </tr>
                        <?php endforeach;?>
                        <?php else:?>
                        <tr>
                            <td colspan="20"><?php echo lang('We could not find any ga events')?></td>
                        </tr>
                        <?php endif;?>          
                    </tbody>
                </table>
                <?php echo form_close()?>
            </div>
        </div>
    </div>
</div>