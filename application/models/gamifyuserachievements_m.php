
<?php

class GamifyUserAchievements_m extends MY_Model {
 
    /*
      * Insert post
    */
    public function insert($fields = array()) {
        $insert = $this->db->insert('ga_user_achievements', $fields);
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
         $update = $this->db->update('ga_user_achievements', $fields, $filters);
         return $update?true:false;
    }
   
    /*
     * Delete post
     */
    public function delete($id){
        $delete = $this->db->delete('ga_user_achievements',array('id'=>$id));
        return $delete?true:false;
    }
    
    /*
     * Get posts
     */
    function count_records($entity) {
        $startindex = ($entity->pagenumber - 1) * $entity->pagesize;
        $filter = array();
       
	
     	$this->db->from('ga_user_achievements');
     	
     	if($entity->id > 0)
     	    $this->db->where('id', $entity->id);
		  
	    if($entity->userid > 0)
     	    $this->db->where('userid', $entity->userid);
     	    
     	return $this->db->count_all_results();
	    
    }
   
    
    function fetch_records($entity) {
        
        if($entity->id > 0) {
       	    $query = $this->db->get_where('ga_user_achievements', array('id' => $entity->id));
            return $query->row_array();
       	} else {
       	    
       	    if($entity->userid > 0)
         	    $this->db->where('userid', $entity->userid);
         	
       	    $query = $this->db->get('ga_user_achievements');
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