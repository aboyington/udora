<?php

class GamifyEvents_m extends MY_Model {
    
    protected $_table_name = 'ga_events';
    protected $_order_by = 'id';
    
    public $rules = array(
        'title' => array('field'=>'title', 'label'=>'lang:Title', 'rules'=>'trim|required|'),
        'listing_id' => array('field'=>'listing_id', 'label'=>'lang:Event', 'rules'=>'trim|required|callback__unique_ga_events_listing_id'),
        'description' => array('field'=>'description', 'label'=>'lang:Description', 'rules'=>'trim'),
        'event_key' => array('field'=>'event_key', 'label'=>'lang:Event key', 'rules'=>'trim|max_length[4]|min_length[4]|callback__unique_ga_events_key|xss_clean'),
    );
    
    
        
    public function get_new()
	{
        $item = new stdClass();
        $item->title = '';
        $item->listing_id = '';
        $item->description = '';
        $item->event_key = '';
        return $item;
    }
    
    /*
      * Insert post
    */
    public function insert($fields = array()) {
        $insert = $this->db->insert('ga_events', $fields);
        if($insert){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }
    
    /*
     * Update post
    */
    public function update($fields, $filters) {
         $update = $this->db->update('ga_events', $fields, $filters);
         return $update?true:false;
    }
   
    /*
     * Delete post
     */
    public function delete($id){
        $delete = $this->db->delete('ga_events',array('id'=>$id));
        return $delete?true:false;
    }
    
    /*
     * Get posts
     */
    function count_records($entity) {
        $startindex = ($entity->pagenumber - 1) * $entity->pagesize;
        $filter = array();
       
	
     	$this->db->from('ga_events');
     	
     	if($entity->id > 0)
     	    $this->db->where($entity->id, $entity->id);
		  
	    if($entity->category_id > 0)
     	    $this->db->where($entity->category_id, $entity->category_id);
     	    
     	return $this->db->count_all_results();
	    
    }
  
    function fetch_records($entity) {
        
        if($entity->id > 0) {
       	    $query = $this->db->get_where('ga_events', array('id' => $entity->id));
            return $query->row_array();
       	} else {
       	    
       	    if($entity->category_id > 0)
         	    $this->db->where('category_id', $entity->category_id);
         	
         	
       	    $query = $this->db->get('ga_events');
                return $query->result_array();
       	    
       	}
        

    }
    
    function check($entity) {
         if ($this->count_records($entity) > 0)
            return true;
         else 
            return false;
    }

}

?>