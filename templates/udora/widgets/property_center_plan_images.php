
<?php
//Fetch repository
$file_rep = array();

if(!empty($estate_data_option_65) && is_numeric($estate_data_option_65)){
    $rep_id = $estate_data_option_65;
    $file_rep = $this->file_m->get_by(array('repository_id'=>$rep_id));
}

// If not defined in this language
if(count($file_rep) == 0)
{
    //Fetch option for default language
    $def_lang_id = $this->language_m->get_default_id();
    if(!empty($def_lang_id))
    {
        $def_lang_rep_id = $this->option_m->get_property_value($def_lang_id, $estate_data_id, 65);

        if(!empty($def_lang_rep_id))
        $file_rep = $this->file_m->get_by(array('repository_id'=>$def_lang_rep_id));
    }
}

$rep_value = '';

if(count($file_rep))
{
    echo '<div class="marg20">';
    
    echo '<h4>'.$options_name_65.'</h4>';
    echo '<hr>';
    
    $rep_value.= '<ul data-target="#modal-gallery" data-toggle="modal-gallery" class="images-gallery clearfix"> ';
    foreach($file_rep as $file_r)
    {
        if(file_exists(FCPATH.'/files/thumbnail/'.$file_r->filename))
        {
            $rep_value.=
            '<li class="col-sm-4">'.
            '    <a data-gallery="gallery" href="'.base_url('files/'.$file_r->filename).'" title="'.$file_r->filename.'" download="'.base_url('files/'.$file_r->filename).'" class="preview show-icon">'.
            '        <img src="assets/img/preview-icon.png" class="" />'.
            '    </a>'.
            '    <div class="preview-img"><img src="'.base_url('files/thumbnail/'.$file_r->filename).'" data-src="'.base_url('files/'.$file_r->filename).'" alt="'.$file_r->filename.'" class="" /></div>'.
            '</li>';
        }
        else if(file_exists(FCPATH.'/templates/'.$settings_template.'/assets/img/icons/filetype/'.get_file_extension($file_r->filename).'.png'))
        {
            $rep_value.=
            '<li class="col-sm-4">'.
            '    <a target="_blank" href="'.base_url('files/'.$file_r->filename).'" title="'.$file_r->filename.'" download="'.base_url('files/'.$file_r->filename).'" class="preview skip show-icon direct-download">'.
            '        <img src="assets/img/preview-icon.png" class="" />'.
            '    </a>'.
            '    <div class="preview-img type-file"><img src="assets/img/icons/filetype/'.get_file_extension($file_r->filename).'.png" data-src="'.base_url('files/'.$file_r->filename).'" alt="'.$file_r->filename.'" class="" /></div>'.
            '</li>';
        }
    }
    $rep_value.= '</ul>';

    echo $rep_value;
    echo '</div><!-- /. widget-gallery -->';
}
?>