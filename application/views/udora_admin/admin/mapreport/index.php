<div class="page-title">
    <div class="title_left">
        <h3><?php echo lang('Map report')?></h3>
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
                <h2><?php echo lang('View Map report')?></h2>
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
                    <div class="form-group" style="position: relative;">
                      <?php
                          echo form_dropdown('date_removed', $this->mapreport_m->years, set_value_GET('date_removed', '', true), 'class="form-control" style="float:left;display:inline-block;width:100px;margin-right:5px;"');
                          echo form_dropdown('purpose', $this->mapreport_m->purposes, set_value_GET('purpose', '', true), 'class="form-control" style="float:left;display:inline-block;width:100px;margin-right:5px;"');
                          echo form_dropdown('type', $this->mapreport_m->types, set_value_GET('type', '', true), 'class="form-control" style="float:left;display:inline-block;width:100px;margin-right:5px;"');
                          echo form_dropdown('outcome', $this->mapreport_m->outcomes, set_value_GET('outcome', '', true), 'class="form-control" style="float:left;display:inline-block;width:100px;margin-right:5px;"');
                          echo form_input('area_from', set_value_GET('area_from', '', true), 'class="form-control" style="float:left;display:inline-block;width:100px;margin-right:5px;" placeholder="'.lang_check('Area from').'"');
                          echo form_input('area_to', set_value_GET('area_to', '', true), 'class="form-control" style="float:left;display:inline-block;width:100px;margin-right:5px;" placeholder="'.lang_check('Area to').'"');
                      ?>
                    </div>
                    <button type="submit" class="btn btn-default"><i class="icon icon-search"></i>&nbsp;&nbsp;<?php echo lang_check('Load'); ?></button>
                    <a href="<?php echo site_url('admin/mapreport'); ?>" class="btn btn-default"><i class="icon icon-repeat"></i>&nbsp;&nbsp;<?php echo lang_check('Reset'); ?></a>  
                </form>
                <div class="clearfix"></div>
                <div class="ln_solid"></div>
                <?php echo form_open('admin/estate/delete_multiple', array('class' => '', 'style'=> 'padding:0px;margin:0px;', 'role'=>'form'))?> 
                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><?php _l('Purpose');?></th>
                            <th data-hide="phone"><?php _l('Type');?></th>
                            <th data-hide="phone,tablet"><?php _l('Area');?></th>
                            <th><?php _l('Price');?></th>
                            <th><?php _l('MQ2');?></th>
                            <th><?php _l('Reason');?></th>
                            <th data-hide="phone,tablet"><?php _l('Date submited');?></th>
                            <th><?php _l('Date removed');?></th>
                            <th data-hide="phone,tablet"><?php _l('Address');?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(count($listings)): foreach($listings as $item):?>
                        <tr>
                            <td><?php echo $item->id_mapreport; ?></td>
                            <td><?php echo $item->purpose; ?></td>
                            <td><?php echo $item->type; ?></td>
                            <td><?php echo $item->area; ?></td>
                            <td><?php echo $item->price; ?></td>
                            <td><?php echo number_format($item->price / $item->area, 1); ?></td>
                            <td><?php echo $item->outcome; ?></td>
                            <td><?php echo $item->date_submited; ?></td>
                            <td><?php echo $item->date_removed; ?></td>
                            <td><?php echo $item->address; ?></td>
                        </tr>
                        <?php endforeach;?>
                        <?php else:?>
                        <tr>
                            <td colspan="13"><?php _l('We could not find any item'); ?></td>
                        </tr>
                        <?php endif;?>                 
                    </tbody>
                </table>
                <?php echo form_close()?>
            </div>
        </div>
    </div>
</div>

<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><?php _l('Map report')?></h2>
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
              <div class="gmap_mapsReport" id="mapsReport">
                        
                        </div>
<script language="javascript">
        $(function () {
            $("#mapsReport").gmap3({
             map:{
                options:{
                 center: [<?php echo calculateCenter($estates)?>],
                 zoom: 8,
                 scrollwheel: false
                }
             },
             marker:{
                values:[
                <?php if(count($estates)): foreach($estates as $estate):
                
                    $icon_url = base_url('adminudora-assets/img/markers/marker_blue.png');
                    $days_between = ceil(abs(strtotime($estate->date_removed) - strtotime($estate->date_submited)) / 86400);
                    $json = json_decode($estate->property_json);
                    
                    if(isset($json->{'option6_1'}))
                    {
                        if($json->{'option6_1'} != '' && $json->{'option6_1'} != 'empty')
                        {
                            if(file_exists(FCPATH.'adminudora-assets/img/markers/'.$json->{'option6_1'}.'.png'))
                            $icon_url = base_url('adminudora-assets/img/markers/'.$json->{'option6_1'}.'.png');
                        }
                    }
                
                    echo '{latLng:['.$estate->lat.', '.$estate->lng.'], options:{ icon: "'.$icon_url.'"}, data:"'.lang_check('Address').': '.strip_tags($estate->address);
                    echo '<br />'.lang_check('Purpose').': '.$estate->purpose;
                    echo '<br />'.lang_check('Type').': '.$estate->type;
                    echo '<br />'.lang_check('Reason').': '.$estate->outcome;
                    echo '<br />'.lang_check('Price').': '.$estate->price.' EUR';
                    echo '<br />'.lang_check('Area').': '.$estate->area.' m2';
                    echo '<br />'.lang_check('Days on portal').': '.$days_between;
                    echo '<br />'.lang_check('Year of remove').': '.date('Y', strtotime($estate->date_removed));
                    echo '"},';
                endforeach;
                endif;?> 
                ],
                
            options:{
              draggable: false
            },
            events:{
              mouseover: function(marker, event, context){
                var map = $(this).gmap3("get"),
                  infowindow = $(this).gmap3({get:{name:"infowindow"}});
                if (infowindow){
                  infowindow.open(map, marker);
                  infowindow.setContent(context.data);
                } else {
                  $(this).gmap3({
                    infowindow:{
                      anchor:marker,
                      options:{content: context.data}
                    }
                  });
                }
              },
              mouseout: function(){
                var infowindow = $(this).gmap3({get:{name:"infowindow"}});
                if (infowindow){
                  //infowindow.close();
                }
              }
            }
             }
            });
        });
</script>

            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><?php _l('Totals')?></h2>
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
                            <th><?php _l('Description');?></th>
                            <th><?php _l('Total');?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php _l('The number of properties Total Sold or Rented');?></td>
                            <td><?php echo $total_sold;?></td>
                        </tr>
                        <?php foreach($total_sold_type as $key=>$val): ?>
                        <tr>
                            <td><?php _l('The number of properties Total Sold or Rented'); echo ': '; _l($key);?></td>
                            <td><?php echo $val;?></td>
                        </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td><?php _l('Average days of sale or rent');?></td>
                            <td><?php echo $total_sold>0?intval($total_days_to_sold / $total_sold):'-';?></td>
                        </tr>
                        <?php foreach($total_days_to_sold_type as $key=>$val): ?>
                        <tr>
                            <td><?php _l('Average days of sale or rent'); echo ': '; _l($key);?></td>
                            <td><?php echo intval($val / $total_sold_type[$key]);?></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php foreach($avarage_size_type as $key=>$val): ?>
                        <tr>
                            <td><?php _l('Average size'); echo ': '; _l($key);?></td>
                            <td><?php echo intval($val / $total_sold_type[$key]);?></td>
                        </tr>
                        <?php endforeach; ?>  
                    </tbody>
                </table>
                <?php echo form_close()?>
            </div>
        </div>
    </div>
</div>

