<div class="page-title">
    <div class="title_left">
        <h3><?php echo lang_check('Payment')?></h3>
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
                <h2><?php echo lang_check('Payment').' #'.$payment->id; ?></h2>
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
                            <th><?php echo lang_check('Payer email');?></th>
                            <th data-hide="phone,tablet"><?php echo lang_check('Date paid');?></th>
                            <th><?php echo lang_check('Paid');?></th>
                            <th data-hide="phone,tablet"><?php echo lang_check('Reservation id');?></th>
                            <th data-hide="phone,tablet"><?php echo lang_check('Transaction id');?></th>
                            <th><?php echo lang_check('Invoice num');?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo $payment->id?></td>
                            <td>
                            <?php echo $payment->payer_email?>
                            </td>
                            <td>
                            <?php echo $payment->date_paid?>
                            </td>
                            <td>
                            <?php echo $payment->paid.' '.$payment->currency_code; ?>
                            </td>
                            <td>
                            <?php 
                                $inv_ex = explode('_', $payment->invoice_num);
                                $reservation_id = $inv_ex[0];
                                if(!empty($reservation_id))
                                echo '<a href="'.site_url('admin/booking/edit/'.$reservation_id).'" class="label label-info">#'.$reservation_id.'</a>';
                            ?>
                            </td>
                            <td>
                            <?php echo $payment->txn_id; ?>
                            </td>
                            <td><?php echo $payment->invoice_num; ?></td>
                        </tr>         
                    </tbody>
                </table>
                <?php echo form_close()?>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><?php echo lang_check('Details'); ?></h2>
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
                <?php echo form_open('admin/estate/delete_multiple', array('class' => '', 'style'=> 'padding:0px;margin:0px;', 'role'=>'form'))?> 
                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><?php echo lang_check('Value');?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        $values = unserialize($payment->data_post);
                        if(count($values) > 0 && is_array($values))
                        foreach($values as $key=>$val):
                      ?>
                            <tr>
                            	<td><?php echo $key; ?></td>
                                <td><?php echo $val; ?></td>
                            </tr>    
                      <?php endforeach; ?>
                    </tbody>
                </table>
                <?php echo form_close()?>
            </div>
        </div>
    </div>
</div>

