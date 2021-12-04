
<?php

class GamifyCategories_m extends MY_Model {
 
    /*
      * Insert post
    */
    public function insert($fields = array()) {
        $insert = $this->db->insert('ga_categories', $fields);
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
         $update = $this->db->update('ga_categories', $fields, $filters);
         return $update?true:false;
    }
   
    /*
     * Delete post
     */
    public function delete($id){
        $delete = $this->db->delete('ga_categories',array('id'=>$id));
        return $delete?true:false;
    }
    
    /*
     * Get posts
     */
    function count_records($entity) {
        $startindex = ($entity->pagenumber - 1) * $entity->pagesize;
        $filter = array();
       
	
     	$this->db->from('ga_categories');
     	if($entity->id > 0)
     	    $this->db->where('id', $entity->id);
		  
	    if($entity->type > 0)
     	    $this->db->where('type', $entity->type);
     	    
	    return $this->db->count_all_results();
    }
    
    
    function fetch_records($entity) {
        
        if($entity->id > 0) {
       	    $query = $this->db->get_where('ga_categories', array('id' => $entity->id));
            return $query->row_array();
       	} else {
       	    
         	if($entity->type > 0)
         	    $this->db->where('type', $entity->type);
         
       	    $query = $this->db->get('ga_categories');
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