
<?php


class GamifyUserBadges_m extends MY_Model {
 
    /*
      * Insert post
    */
    public function insert($fields = array()) {
        $insert = $this->db->insert('ga_user_badges', $fields);
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
         $update = $this->db->update('ga_user_badges', $fields, $filters);
         return $update?true:false;
    }
   
    
    /*
     * Delete post
     */
    public function delete($id){
        $delete = $this->db->delete('ga_user_badges',array('id'=>$id));
        return $delete?true:false;
    }
    
    /*
     * Get posts
     */
    function count_records($entity) {
     
        $this->db->from('ga_user_badges');
        $this->db->join('ga_badges', 'ga_badges.id = ga_user_badges.badge_id');

     	
     	if($entity->id > 0)
     	    $this->db->where('ga_badges.id', $entity->id);
		  
	    if($entity->userid > 0)
     	    $this->db->where('ga_user_badges.userid', $entity->userid);
     	    
        if($entity->type > 0)
     	    $this->db->where('ga_user_badges.type', $entity->type);
     	    
     	if($entity->badge_id > 0)
     	    $this->db->where('ga_user_badges.badge_id', $entity->badge_id);
     	    
     	return $this->db->count_all_results();
	    
    }
   
    
    function fetch_records($entity) {
        
        
          $this->db->from('ga_user_badges');
          $this->db->join('ga_badges', 'ga_badges.id = ga_user_badges.badge_id');
          
          if($entity->id > 0) {
           	    $query = $this->db->where('id', $entity->id);
                return $query->row_array();
           	} else {
           	    print_r($entity);
        	    if($entity->userid > 0) {
        	        print_r('userid');
        	        $this->db->where('userid', $entity->userid);
        	    }
             	    
             	    
                if($entity->type > 0) {
                    print_r('type');
                    $this->db->where('ga_user_badges.type', $entity->type);
                }
             	  
             	
             	if($entity->badge_id > 0) {
             	     print_r('badge_id');
             	     $this->db->where('badge_id', $entity->badge_id);
             	}
     	           
                return $this->db->get()->result();
           	    
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
