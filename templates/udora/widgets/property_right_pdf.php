<?php if(file_exists(APPPATH.'libraries/Pdf.php')) : ?>
<a href="<?php echo site_url('api/pdf_export/'.$property_id.'/'.$lang_code) ;?>" class="btn button-standart add-event-btn col-xs-12 col-sm-6 col-lg-12" style="margin-top:30px;"><i class="fa fa-file" aria-hidden="true"></i><?php _l(' Export to PDF');?></a>
<?php endif;?>