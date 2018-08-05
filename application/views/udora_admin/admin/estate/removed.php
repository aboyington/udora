<div class="page-title">
    <div class="title_left">
        <h3><?php echo lang('Removed')?></h3>
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
                <h2><?php echo lang('Estates')?></h2>
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
                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                        	<th>#</th>
                            <th><?php echo lang('Address');?></th>
                            <th data-hide="phone"><?php _l('Gps');?></th>
                            <th data-hide="phone"><?php _l('Removed');?></th>
                            <th data-hide="phone,tablet"><?php _l('Submission');?></th>
                            <th data-hide="phone,tablet"><?php _l('Expire');?></th>
                            <th data-hide="phone,tablet"><?php _l('Price');?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(count($listings)): foreach($listings as $item):?>
                        <tr>
                            <td><?php echo $item->id?></td>
                            <td><?php echo $item->address?></td>
                            <td><?php echo $item->lat.', '.$item->lng?></td>
                            <td><?php echo $item->date_removed?></td>
                            <td><?php echo $item->submission_date?></td>
                            <td><?php echo $item->expire_date?></td>
                            <td><?php echo $item->price_0?></td>
                        </tr>
                        <?php endforeach;?>
                        <?php else:?>
                        <tr>
                            <td colspan="20"><?php echo lang('We could not find any');?></td>
                        </tr>
                        <?php endif;?>                   
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

