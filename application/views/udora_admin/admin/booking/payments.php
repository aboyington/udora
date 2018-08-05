<div class="page-title">
    <div class="title_left">
        <h3><?php echo lang_check('Payments')?></h3>
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
                <h2><?php echo lang('Payments')?></h2>
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
                            <th data-hide="phone,tablet"><?php echo lang_check('Payer email');?></th>
                            <th data-hide="phone,tablet"><?php echo lang_check('Date paid');?></th>
                            <th data-hide="phone,tablet"><?php echo lang_check('Paid');?></th>
                            <th data-hide="phone,tablet"><?php echo lang_check('Reservation id');?></th>
                            <th data-hide="phone,tablet"><?php echo lang_check('Transaction id');?></th>
                            <th class=""><?php echo lang_check('Details');?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(count($payments)): foreach($payments as $item):?>
                        <tr>
                            <td><?php echo $item->id?></td>
                            <td>
                            <?php echo $item->payer_email?>
                            </td>
                            <td>
                            <?php echo $item->date_paid?>
                            </td>
                            <td>
                            <?php echo $item->paid.' '.$item->currency_code; ?>
                            </td>
                            <td>
                            <?php 
                                $inv_ex = explode('_', $item->invoice_num);
                                $reservation_id = $inv_ex[0];
                                if(!empty($reservation_id))
                                echo '<a href="'.site_url('admin/booking/payments/'.$reservation_id).'" class="label label-danger">#'.$reservation_id.'</a>';
                            ?>
                            </td>
                            <td>
                            <?php echo $item->txn_id; ?>
                            </td>
                            <td><?php echo btn_view('admin/booking/view_payment/'.$item->id)?></td>
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

