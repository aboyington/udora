<!DOCTYPE html>
<html>
    <head>
        <?php _widget('head'); ?>
    </head>
    <body class="body-login-register">
        <?php _widget('header_menu'); ?>
        <!-- Business hero  -->
        <div class="container register-login">
            <div class="raw">
                <div class="col-xs-12">
                    <?php if(file_exists(APPPATH.'controllers/admin/packages.php')): ?>
                    <div class="col-xs-12 col-md-12 box-white section section-d12">
                        <div class="section-title">
                            <h3>{lang_Myresearch}</h3>
                        </div>
                        <div class=""> 
                            <?php if($this->session->flashdata('message')):?>
                            <?php echo $this->session->flashdata('message')?>
                            <?php endif;?>
                            <?php if($this->session->flashdata('error')):?>
                            <p class="alert alert-error"><?php echo $this->session->flashdata('error')?></p>
                            <?php endif;?>
                        </div>
                        <div class="widget-content">
                            <table class="table table-striped">
                                <thead>
                                    <th>#</th>
                                    <th data-breakpoints="xs sm md" data-type="html"><?php echo lang_check('Parameters');?></th>
                                    <th data-breakpoints="xs sm md" data-type="html"><?php echo lang_check('Lang code');?></th>
                                    <th data-breakpoints="xs sm md" data-type="html"><?php echo lang_check('Activated');?></th>
                                    <?php if(false): ?><th data-breakpoints="xs sm md" class="control" data-type="html"><?php echo lang_check('Load');?></th><?php endif;?>
                                    <th data-breakpoints="xs sm md" class="control" data-type="html"><?php echo lang_check('Edit');?></th>
                                    <th data-breakpoints="xs sm md" class="control" data-type="html"><?php echo lang_check('Delete');?></th>
                                </thead>
                                    <?php if(count($listings)): foreach($listings as $listing_item):?>
                                        <tr>
                                            <td><?php echo $listing_item->id; ?></td>
                                            <td>
                                            <?php

                                            $parameters = json_decode($listing_item->parameters);

                                            foreach($parameters as $key=>$value){
                                                if(!empty($value) && $key != 'view' && $key != 'order')
                                                echo '<span><span class="par_key">'.$key.'</span>: <b class="par_value">'.$value.'</b></span><br />';
                                            }

                                            ?>
                                            </td>
                                            <td><?php echo '['.strtoupper($listing_item->lang_code).']'; ?></td>
                                            <td>
                                                <?php echo $listing_item->activated?'<i class="icon-ok"></i>':'<i class="icon-remove"></i>'; ?>
                                            </td>
                                            <?php if(false): ?>
                                            <td>
                                            <?php if($lang_code == $listing_item->lang_code): ?>
                                            <button class="load_search btn"><i class="icon-search"></i></button>
                                            <?php else: ?>
                                            <?php echo '->'.strtoupper($listing_item->lang_code).'<-'; ?>
                                            <?php endif; ?>
                                            </td>
                                            <?php endif;?>
                                            <td><?php echo btn_edit('fresearch/myresearch_edit/'.$lang_code.'/'.$listing_item->id.'#content')?></td>
                                            <td><?php echo btn_delete('fresearch/myresearch_delete/'.$lang_code.'/'.$listing_item->id)?></td>
                                        </tr>
                                    <?php endforeach;?>
                                    <?php else:?>
                                        <tr>
                                            <td colspan="20"><?php echo lang('We could not find any');?></td>
                                        </tr>
                                    <?php endif;?>   
                            </table>
                            </div>
                        </div>
                    <?php endif; ?>
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
