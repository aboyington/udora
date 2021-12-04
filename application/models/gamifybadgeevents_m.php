
<?php

class GamifyBadgesEvents_m extends MY_Model {
 
    /*
      * Insert post
    */
    public function insert($fields = array()) {
        $insert = $this->db->insert('ga_badge_events', $fields);
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
         $update = $this->db->update('ga_badge_events', $fields, $filters);
         return $update?true:false;
    }
  
    /*
     * Delete post
     */
    public function delete($id){
        $delete = $this->db->delete('ga_badge_events',array('id'=>$id));
        return $delete?true:false;
    }
    
    /*
     * Get posts
     */
    function count_records($entity) {
        $startindex = ($entity->pagenumber - 1) * $entity->pagesize;
        $filter = array();
       
	
     	$this->db->from('ga_badge_events');
     	
     	if($entity->id > 0)
     	    $this->db->where('id', $entity->id);
		  
	    if($entity->category_id > 0)
     	    $this->db->where('category_id', $entity->category_id);
     	    
     	return $this->db->count_all_results();
	    
    }
   
    
    function fetch_records($entity) {
        
        if($entity->id > 0) {
       	    $query = $this->db->get_where('ga_badge_events', array('id' => $entity->id));
            return $query->row_array();
       	} else {
       	    
       	    if($entity->category_id > 0)
         	    $this->db->where('category_id', $entity->category_id);
         	
       	    $query = $this->db->get('ga_badge_events');
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