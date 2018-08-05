<div class="page-title">
    <div class="title_left">
        <h3><?php echo lang_check('Invoices')?></h3>
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
                <h2><?php echo lang_check('View all invoices')?></h2>
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
                            <th><?php echo lang_check('Item type');?></th>
                            <th data-hide="phone,tablet"><?php echo lang_check('Payer email');?></th>
                            <th data-hide="phone,tablet"><?php echo lang_check('Date paid');?></th>
                            <th><?php echo lang_check('Price');?></th>
                            <th><?php echo lang_check('Paid');?></th>
                            <th data-hide="phone,tablet"><?php echo lang_check('Activated');?></th>
                            <th data-hide="phone,tablet"><?php echo lang_check('Mark as paid');?></th>
                            <th><?php echo lang_check('Edit');?></th>
                            <th data-hide="phone,tablet"><?php echo lang_check('Delete');?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(count($invoices)): foreach($invoices as $item):?>
                        <tr>
                            <td><?php echo $item->id_invoice?></td>
                            <td>
                            <?php 
                                $inv_ex = explode('_', $item->invoice_num);
                                $pay_type = $inv_ex[1];
                                if(!empty($pay_type))
                                echo '<a href="'.site_url('admin/monetize/invoices/'.$pay_type).'" class="label label-danger">#'.$pay_type.$item->reference_id.'</a>';
                            ?>
                            </td>
                            <td>
                            <?php 
                                $data_json = json_decode($item->data_json);

                                if(!empty($data_json->user->mail))
                                echo '<a href="'.site_url('admin/user/edit/'.$item->user_id).'" class="label label-warning">'.$data_json->user->mail.'</a>';
                            ?>
                            </td>
                            <td>
                            <?php echo $item->date_created?>
                            </td>
                            <td>
                            <?php echo $item->price.' '.$item->currency_code; ?>
                            </td>
                            <td>
                            <?php
                                if($item->is_paid)
                                {
                                    echo '<i class="icon-ok"></i>';
                                }
                                else
                                {
                                    echo '<i class="icon-remove"></i>';
                                }
                            ?>
                            </td>
                            <td>
                            <?php
                                if($item->is_activated)
                                {
                                    echo '<i class="icon-ok"></i>';
                                }
                                else
                                {
                                    echo '<i class="icon-remove"></i>';
                                }
                            ?>
                            </td>
                            <td>
                                <?php if(!$item->is_paid): ?>
                                <a class="btn btn-success" href="<?php echo site_url('admin/monetize/mark_as_paid/'.$item->id_invoice); ?>"><i class="icon-usd"></i></a>
                                <?php endif; ?>
                            </td>
                            <td><?php echo btn_edit_udora('admin/monetize/edit_invoice/'.$item->id_invoice)?></td>
                            <td>
                                <?php if(!$item->is_paid): ?>
                                <?php echo btn_delete_udora('admin/monetize/delete_invoice/'.$item->id_invoice)?>
                                <?php endif; ?>
                            </td>
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

