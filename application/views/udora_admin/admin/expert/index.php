<div class="page-title">
    <div class="title_left">
        <h3><?php echo lang('Q&A')?></h3>
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
 <?php echo anchor('admin/expert/edit', '<i class="icon-plus"></i>&nbsp;&nbsp;'.lang_check('Add question'), 'class="btn btn-primary-blue"')?>
    </div>
</div>
<!-- /Add page / events button -->


<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><?php echo lang_check('Questions')?></h2>
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
                <?php echo form_open('admin/estate/delete_multiple', array('class' => '', 'style'=> 'padding:0px;margin:0px;', 'role'=>'form'))?> 
                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th data-hide="phone,tablet"><?php echo lang('Question');?></th>
                            <th data-hide="phone,tablet"><?php echo lang_check('Date');?></th>
                            <th data-hide="phone,tablet"><?php echo lang_check('Category');?></th>
                            <th data-hide="phone,tablet"><?php echo lang_check('Expert');?></th>
                            <th class=""><?php echo lang('Edit');?></th>
                            <?php if(check_acl('expert/delete')):?><th class=""><?php echo lang('Delete');?></th><?php endif;?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(count($questions)): foreach($questions as $question):?>
                            <tr>
                                <td><?php echo $question->id?></td>
                                <td>
                                <?php echo anchor('admin/expert/edit/'.$question->id, $question->question)?>&nbsp;&nbsp;<?php echo $question->is_readed == 0? '<span class="label label-warning">'.lang('Not readed').'</span>':''?>
                                </td>
                                <td>
                                <?php echo $question->date_publish?>
                                </td>
                                <td>
                                <a href="<?php echo site_url('admin/expert/index/'.$question->parent_id); ?>" class="label label-danger"><?php echo $categories[$question->parent_id]?></a>
                                </td>
                                <td>
                                <?php if(isset($experts_user[$question->answer_user_id])) echo $experts_user[$question->answer_user_id]?>
                                </td>
                                <td><?php echo btn_edit_udora('admin/expert/edit/'.$question->id)?></td>
                                <?php if(check_acl('expert/delete')):?><td><?php echo btn_delete_udora('admin/expert/delete/'.$question->id)?></td><?php endif;?>
                            </tr>
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

