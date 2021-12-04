<div class="page-title">
    <div class="title_left">
        <h3><?php echo lang('Ads')?></h3>
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
        <?php echo anchor('admin/ads/edit', '<i class="icon-plus"></i>&nbsp;&nbsp;'.lang_check('Add ads'), 'class="btn btn-primary-blue"')?>
    </div>
</div>
<!-- /Add page / events button -->


<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><?php echo lang('Ads')?></h2>
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
                <div class="padd-alert">
                    <?php echo validation_errors() ?>
                    <?php if ($this->session->flashdata('message')): ?>
                        <?php echo $this->session->flashdata('message') ?>
                    <?php endif; ?>
                    <?php if ($this->session->flashdata('error')): ?>
                        <p class="label label-important validation"><?php echo $this->session->flashdata('error') ?></p>
                    <?php endif; ?>     
                </div>
                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th data-hide="phone,tablet"><?php echo lang('Code');?></th>
                            <th data-hide="phone,tablet"><?php echo lang_check('Type');?></th>
                            <th data-hide="phone,tablet"><?php echo lang_check('Activated');?></th>
                            <th class=""><?php echo lang('Edit');?></th>
                            <?php if(check_acl('ads/delete')):?><th class=""><?php echo lang('Delete');?></th><?php endif;?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(count($ads)): foreach($ads as $ad):?>
                        <tr>
                            <td><?php echo $ad->id?></td>
                            <td>
                            <?php echo anchor('admin/ads/edit/'.$ad->id, $ad->title)?>
                            <?php echo ($ad->is_hardlocked == 1)?'&nbsp;&nbsp;<i class="icon-lock" style="color:red;"></i>':''?>
                            </td>
                            <td>
                            <span class="label label-danger"><?php if(isset($this->ads_m->ads_types[$ad->type]))echo $this->ads_m->ads_types[$ad->type]; ?></span>
                            </td>
                            <td><?php echo ($ad->is_activated == 1)?'<i class="icon-ok"></i>':''?></td>
                            <td><?php echo btn_edit_udora('admin/ads/edit/'.$ad->id)?></td>
                            <?php if(check_acl('ads/delete')):?><td><?php echo btn_delete_udora('admin/ads/delete/'.$ad->id)?></td><?php endif;?>
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