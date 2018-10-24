<div class="page-title">
    <div class="title_left">
        <h3><?php echo lang_check('Template files list')?></h3>
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
                <h2><?php echo lang_check('Template files list')?></h2>
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
                    <?php if($this->session->flashdata('message')):?>
                    <?php echo $this->session->flashdata('message')?>
                    <?php endif;?>
                    <?php if($this->session->flashdata('error')):?>
                    <p class="label label-important validation"><?php echo $this->session->flashdata('error')?></p>
                    <?php endif;?>
                    <?php if($writing_permissions != ''):?>
                    <p class="label label-important validation"><?php echo $writing_permissions;?></p>
                    <?php endif; ?>
                </div>
                <?php echo form_open('admin/estate/delete_multiple', array('class' => '', 'style'=> 'padding:0px;margin:0px;', 'role'=>'form'))?> 
                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th><?php echo lang_check('Folder');?></th>
                            <th><?php echo lang_check('Filename');?></th>
                            <th class=""><?php echo lang('Edit');?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(count($listings)):
                              $label_index = -1;
                              $label_classes = array('default', 'primary', 'success', 'info', 'warning', 'danger');
                              foreach($listings as $folder_name=>$listings_folder):
                        ?>
                        <?php if(count($listings_folder)): 
                              $label_index++;
                              if($label_index>=count($label_classes))$label_index = 0;
                              foreach($listings_folder as $key=>$listing_item):
                              if($folder_name == 'language')continue;
                              if(is_array($listing_item)):
                              foreach($listing_item as $key1=>$listing_item1):
                              if(substr_count($listing_item1, 'min') > 0)continue;
                        ?>
                            <tr>
                                <td><?php echo '<span class="label label-'.$label_classes[$label_index].'">'.$folder_name.'</span>'; ?></td>
                                <td><?php echo '<a href="'.site_url('admin/templatefiles/edit/'.$listing_item1.'/'.$folder_name.'/'.$key).'" />'.$listing_item1.'</a>'; ?></td>
                                <td><?php echo btn_edit_udora('admin/templatefiles/edit/'.$listing_item1.'/'.$folder_name.'/'.$key)?></td>
                            </tr>
                        <?php endforeach;else: ?>
                            <tr>
                                <td><?php echo '<span class="label label-'.$label_classes[$label_index].'">'.$folder_name.'</span>'; ?></td>
                                <td><?php echo '<a href="'.site_url('admin/templatefiles/edit/'.$listing_item.'/'.$folder_name).'" />'.$listing_item.'</a>'; ?></td>
                                <td><?php echo btn_edit_udora('admin/templatefiles/edit/'.$listing_item.'/'.$folder_name)?></td>
                            </tr>
                        <?php endif;endforeach;endif;?>
                        <?php endforeach;?>
                        <?php else:?>
                            <tr>
                                <td colspan="20"><?php echo lang('We could not find any');?></td>
                            </tr>
                        <?php endif;?>                                
                    </tbody>
                </table>
                <?php echo form_close()?>
            </div>
        </div>
    </div>
</div>

