<!DOCTYPE html>
<html>
    <head>
        <?php _widget('head'); ?>
    </head>
    <body class="body-login-register" id="main">
        <?php _widget('header_menu'); ?>
        <!-- Business hero  -->
        <div class="container register-login">
            <div class="raw">
                <div class="col-xs-12">
                    <div class="col-xs-12 col-md-12 box-white section section-d12">
                        <div class="section-title">
                            <h3><?php echo lang_check('My rates and availability'); ?></h3>
                        </div>
                        <div class="widget-content widget-controls"> 
                            <?php echo anchor('rates/rate_edit/'.$lang_code.'#content', '<i class="icon-plus"></i>&nbsp;&nbsp;'.lang_check('Add rate'), 'class="btn btn-info"')?>
                        </div>
                        <div class="widget-content widget-controls"> 
                            <?php if($this->session->flashdata('message')):?>
                            <?php echo $this->session->flashdata('message')?>
                            <?php endif;?>
                            <?php if($this->session->flashdata('error')):?>
                            <p class="alert alert-error"><?php echo $this->session->flashdata('error')?></p>
                            <?php endif;?>
                        </div>
                       <div class="widget-content">
                                <table class="table table-striped footable" data-sorting="true">
                                <thead>
                                    <th>#</th>
                                    <th data-breakpoints="xs sm" data-type="html"><?php echo lang_check('From date');?></th>
                                    <th data-breakpoints="xs sm" data-type="html"><?php echo lang_check('To date');?></th>
                                    <th data-type="html"><?php echo lang_check('Property');?></th>
                                    <th class="control" data-type="html"><?php echo lang_check('Edit');?></th>
                                    <th class="control" data-type="html"><?php echo lang_check('Delete');?></th>
                                </thead>
                               <?php if(count($listings)): foreach($listings as $listing_item):?>
                                    <tr>
                                        <td><?php echo $listing_item->id; ?></td>
                                        <td><?php echo $listing_item->date_from; ?></td>
                                        <td><?php echo $listing_item->date_to; ?></td>
                                        <td><?php echo $properties[$listing_item->property_id]; ?></td>
                                        <td><?php echo btn_edit('rates/rate_edit/'.$lang_code.'/'.$listing_item->id)?></td>
                                        <td><?php echo btn_delete('rates/rate_delete/'.$lang_code.'/'.$listing_item->id)?></td>
                                    
                                    </tr>
                                <?php endforeach;?>
                                <?php else:?>
                                    <tr>
                                    	<td colspan="20"><?php echo lang_check('We could not find any');?></td>
                                    </tr>
                                <?php endif;?>       
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<div class="d-block d-md-none">
    <?php _widget('custom_footer_menu');?>
</div>

<a href="#" class="js-toogle-footermenu">
    <i class="material-icons">
    playlist_add
    </i>
    <i class="close-icon"></i>
</a>
        <div class="d-none d-sm-block">
            <?php _widget('custom_footer'); ?>
        </div>
        <?php _widget('custom_javascript'); ?>
        <script>
            /*
             * http://fooplugins.github.io/FooTable/docs/getting-started.html
             */

            $('document').ready(function () {
                $('.footable').footable({
                    "filtering": {
                        "enabled": false
                    },
                });
            })

        </script>
    </body>
</html>
