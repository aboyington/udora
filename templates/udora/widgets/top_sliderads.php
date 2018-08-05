<?php
/*
Widget-title: Slider ads from events field_83
Widget-preview-image: /assets/img/widgets_preview/right_recentevents.jpg
*/

$CI =& get_instance();
$CI->load->model('option_m');
$CI->load->model('file_m');
$CI->load->model('estate_m');

$ads = array();
$options = $CI->option_m->get_property_value_by(array('option_id'=>'83', 'value != ' => ''));


$this->db->select('property_value.*, property.is_activated');
$this->db->join('property',  'property.id = property_value.property_id');
$this->db->where('option_id', '83');
$this->db->where('value != ', '');
$this->db->where('is_activated', 1);
$query= $this->db->get('property_value');
$result_count = array();

if($query)
foreach ($query->result() as $key => $value) {
    $ad = array();
    $files = $CI->file_m->get_where_in(array($value->value));
    
    $ad['property_id'] = $value->property_id;
    $ad['url'] = slug_url($CI->data['listing_uri'].'/'.$value->property_id.'/'.$lang_code);
    
    $image = '';
    $ad['image_url'] = '';
    if(!empty($files)){
        $file = $files[rand(0, count($files)-1)];
        $image = $file->filename;
        if(!empty($image) && file_exists(FCPATH.'files/'.$image))
        {
             $ad['image_url'] = base_url('files/'.$image);
             $ad['image_alt'] = $file->alt;
        }
    }
    
    if(!empty($ad['image_url'])){
        $ads[]= $ad;
    }
}
?>

<?php if(!empty($ads)):?>
<!-- Carousel -->
<div id="mycarousel" class="carousel slide sliderads" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <?php foreach ($ads as $key => $value):?>
            <li data-target="#mycarousel" data-slide-to="<?php echo $key;?>" class="<?php echo ($key == 0) ? 'active' : '';?>"></li>
        <?php endforeach;?>
    </ol>
    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
        <?php foreach ($ads as $key => $value):?>
        <a href="<?php echo $value['url'];?>" title="_blank" class="item <?php echo ($key == 0) ? 'active' : '';?>">
            <img src="<?php echo _simg($value['image_url'], '1800x600', true);?>" alt="<?php _che($value['image_alt']) ;?>">
            <div class="carousel-caption">
                <!--<a href="<?php echo $value['url'];?>" class="btn btn-action-unaccept"><?php echo lang_check('Get more')?></a>--> 
            </div>
        </a>
        <?php endforeach;?>
    </div>

    <!-- Controls -->
    <a class="left carousel-control" href="#mycarousel" role="button" data-slide="prev">
        <span class="ion-ios-arrow-thin-left" style="position: absolute; top: 50%;transform: translate3d(0, -50%, 0); font-size: 40px" aria-hidden="true"></span>
        <span class="sr-only"><?php echo lang_check('Previous');?></span>
    </a>
    <a class="right carousel-control" href="#mycarousel" role="button" data-slide="next">
        <span class="ion-ios-arrow-thin-right" style="position: absolute; top: 50%;transform: translate3d(0, -50%, 0); font-size: 40px" aria-hidden="true"></span>
        <span class="sr-only"<?php echo lang_check('Next')?></span>
    </a>
</div>
<!-- Features Section Events -->
<?php endif;?>

