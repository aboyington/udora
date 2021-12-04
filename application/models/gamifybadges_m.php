
<?php
//' Type
//' 1: Badges
//' 2: Rewards'
//' 3: Levels'
//' 4: Credits'
//' 5: Points'
class GamifyBadges_m extends MY_Model {
 
    /*
      Get Max ID
    */
    public function get_max_id() {
        $maxid = 0;
        $row = $this->db->query('SELECT MAX(ilevel) AS `level` FROM `ga_badges`')->row();
        if ($row) {
            $maxid = $row->level; 
        }
        return $maxid;
    }
    /*
      * Insert post
    */
    public function insert($fields = array()) {
        $insert = $this->db->insert('ga_badges', $fields);
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
         $update = $this->db->update('ga_badges', $fields, $filters);
         return $update?true:false;
    }
  
    
    /*
     * Delete post
     */
    public function delete($id){
        $delete = $this->db->delete('ga_badges',array('id'=>$id));
        return $delete?true:false;
    }
    
    /*
     * Get posts
     */
    function count_records($entity) {
        
     	$this->db->from('ga_badges');
     	
     	if($entity->id > 0)
     	    $this->db->where('id', $entity->id);
		  
	    if($entity->category_id > 0)
     	    $this->db->where('category_id', $entity->category_id);
     	    
     	if($entity->type > 0)
     	    $this->db->where('type', $entity->type);
     	    
     	if(isset($entity->isdeduct) && $entity->isdeduct != 2)
     	    $this->db->where('isdeduct', $entity->isdeduct);
     	   
		if($entity->ilevel > 0)
     	    $this->db->where('ilevel', $entity->ilevel);
     	    
		if(isset($entity->ishide) && $entity->ishide != 2)
     	    $this->db->where('ishide', $entity->ishide);
     	    
     	return $this->db->count_all_results();
	    
    }
   
    function fetch_records($entity) {

    
       	if($entity->id > 0) {
       	    $query = $this->db->get_where('ga_badges', array('id' => $entity->id));
            return $query->row_array();
       	} else {
       	     
       	    if($entity->category_id > 0) {
       	        $this->db->where('category_id', $entity->category_id);
       	    }
         	    
         	
         	if($entity->type > 0) {
         	    $this->db->where('type', $entity->type);
         	}
         
         	if(isset($entity->isdeduct) && $entity->isdeduct != 2) {
         	    $this->db->where('isdeduct', $entity->isdeduct);
         	}
         	    
         	if($entity->ilevel > 0) {
         	     $this->db->where('ilevel', $entity->ilevel);
         	}

    		if(isset($entity->ishide) && $entity->ishide != 2) {
         	    $this->db->where('ishide', $entity->ishide);
    		}
         	    
       	    $query = $this->db->get('ga_badges');
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