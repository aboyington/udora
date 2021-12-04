<div class="page-title">
    <div class="title_left">
        <h3>Gamification Management</h3>
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
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><?php echo lang('Manage')?></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                 <div ng-app="gamifyapp">
                  <div ng-view>loading...</div>
                </div>
            </div>
        </div>
    </div>
    
   
</div>