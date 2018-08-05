<div class="page-title">
    <div class="title_left">
        <h3><?php echo lang('Benchmark tools')?></h3>
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
                <h2><?php echo lang('Benchmark tools')?></h2>
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
 <?php if($this->session->flashdata('error')):?>
                    <p class="label label-important validation"><?php echo $this->session->flashdata('error')?></p>
                    <?php endif;?>

                    <table class="table table-bordered footable">
                      <thead>
                        <tr>
                            <th><?php echo lang_check('Tool description');?></th>
                            <th><?php echo lang_check('Run tool');?></th>
                        </tr>
                      </thead>
                      <tbody>
                            <tr>
                            	<td><?php _l('Generate fake properties'); ?> x100</td>
                                <td><a href="<?php echo site_url('admin/benchmarktool/fake_listings/100')?>" class="btn btn-info btn-sm"><?php _l('Run tool'); ?></a></td>
                            </tr>
                            <tr>
                            	<td><?php _l('Generate fake properties'); ?> x1000</td>
                                <td><a href="<?php echo site_url('admin/benchmarktool/fake_listings/1000')?>" class="btn btn-info btn-sm"><?php _l('Run tool'); ?></a></td>
                            </tr>
                            <tr>
                            	<td><?php _l('Generate sitemap'); ?></td>
                                <td><a href="<?php echo site_url('admin/benchmarktool/generate_sitemap')?>" class="btn btn-info btn-sm"><?php _l('Run tool'); ?></a></td>
                            </tr>
                            <tr>
                            	<td><?php _l('Generate script archive');echo ' BASIC '.$settings['template']; ?></td>
                                <td><a href="<?php echo site_url('admin/benchmarktool/generate_script_basic/'.$settings['template'])?>" class="btn btn-info btn-sm"><?php _l('Run tool'); ?></a></td>
                            </tr>
                            <tr>
                            	<td><?php _l('Generate script archive');echo ' FULL '.$settings['template']; ?></td>
                                <td><a href="<?php echo site_url('admin/benchmarktool/generate_script_full/'.$settings['template'])?>" class="btn btn-info btn-sm"><?php _l('Run tool'); ?></a></td>
                            </tr>
                            <tr>
                            	<td><?php _l('Generate script archive');echo ' CLASSIFIEDS '.$settings['template']; ?></td>
                                <td><a href="<?php echo site_url('admin/benchmarktool/generate_script_classifieds/'.$settings['template'])?>" class="btn btn-info btn-sm"><?php _l('Run tool'); ?></a></td>
                            </tr>
                      </tbody>
                    </table>
                  
            </div>
        </div>
    </div>
</div>