<?php
/*
Widget-title: Most Events
Widget-preview-image: /assets/img/widgets_preview/right_recentevents.jpg
*/

$CI =& get_instance();
$CI->load->model('favorites_m');


$most_events = array();

/* Get most events Example SQL
 * SELECT `favorites`.*, `property_lang`.`json_object`, COUNT(favorites.property_id) as count 
 * FROM (`favorites`) 
 * JOIN `property_lang` ON `property_lang`.`property_id` = `favorites`.`property_id` 
 * WHERE `property_lang`.`language_id` = '1' 
 * GROUP BY `property_id` 
 * ORDER BY `count` desc 
 * LIMIT 5
 */

$CI->db->select($CI->favorites_m->get_table_name().'.*, property_lang.json_object, COUNT('.$CI->favorites_m->get_table_name().'.property_id) as count');
$CI->db->from($CI->favorites_m->get_table_name());
$CI->db->join('property_lang', 'property_lang.property_id = '.$CI->favorites_m->get_table_name().'.property_id');
$CI->db->group_by('property_id');
$CI->db->where('property_lang.language_id', '1');
$CI->db->order_by('count', 'desc');
$CI->db->limit('5');
$query = $CI->db->get();
if($query==1 && $query->num_rows()>0);
    $most_events = $query->result();
    
    
?>

<div class="promo-text-blog"><?php echo lang_check('Most Viewed');?></div>
<ul class="blog-category">
    <?php foreach($most_events as $item): ?>
    <?php
        $json_obj = json_decode($item->json_object);
        $url = slug_url($CI->data['listing_uri'].'/'.$item->property_id.'/'.$lang_code.'/'.url_title_cro($json_obj->field_10));
    ?>
    <li><i class="ion-ios-arrow-right"></i> <a href="<?php echo $url; ?>"><?php echo _ch($json_obj->field_10,''); ?></a></li>
    <?php endforeach;?>
</ul>