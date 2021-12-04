
<?php

class GamifyLevelAssociates_m extends MY_Model {
 
    /*
      * Insert post
    */
    public function insert($fields = array()) {
        $insert = $this->db->insert('ga_level_associate', $fields);
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
         $update = $this->db->update('ga_level_associate', $fields, $filters);
         return $update?true:false;
    }
  
    /*
     * Delete post
     */
    public function delete($id){
        $delete = $this->db->delete('ga_level_associate',array('id'=>$id));
        return $delete?true:false;
    }
    
    /*
     * Get posts
     */
    function count_records($entity) {
        $startindex = ($entity->pagenumber - 1) * $entity->pagesize;
        $filter = array();
       
	
     	$this->db->from('ga_level_associate');
     	
     	if($entity->id > 0)
     	    $this->db->where('id', $entity->id);
		  
	    if($entity->levelid > 0)
     	    $this->db->where('levelid', $entity->levelid);
     	    
     	return $this->db->count_all_results();
	    
    }
   
    function fetch_records($entity) {
        
       if($entity->id > 0) {
       	    $query = $this->db->get_where('ga_level_associate', array('id' => $entity->id));
            return $query->row_array();
       	} else {
       	    
         	if($entity->ilevel > 0)
         	    $this->db->where('ilevel', $entity->ilevel);
         	  
    		
       	    $query = $this->db->get('ga_level_associate');
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