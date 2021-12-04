
<?php

class GamifyUserLevels_m extends MY_Model {
 
    /*
      * Insert post
    */
    public function insert($fields = array()) {
        $insert = $this->db->insert('ga_user_levels', $fields);
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
         $update = $this->db->update('ga_user_levels', $fields, $filters);
         return $update?true:false;
    }
   
    
    /*
     * Delete post
     */
    public function delete($id){
        $delete = $this->db->delete('ga_user_levels',array('id'=>$id));
        return $delete?true:false;
    }
    
    /*
     * Get posts
     */
    function count_records($entity) {
     	$this->db->from('ga_user_levels');
     	
	    if($entity->userid > 0)
     	    $this->db->where('userid', $entity->userid);
     	    
     	return $this->db->count_all_results();
	    
    }
   
    
    function fetch_records($entity) {
        
         if($entity->userid > 0)
         	 $this->db->where('userid', $entity->userid);
         
       	 $query = $this->db->get('ga_user_levels');
            return $query->result_array();
    }
    
    function check($entity) {
         if ($this->count_records($entity) > 0)
            return true;
         else 
            return false;
    }

}

?>