<?php

class testgamify extends CI_Controller
{
    
    function __construct() {
        parent::__construct();
        
        // gamify library reference models
        $this->load->model('gamifybadges_m');
        $this->load->model('gamifyuserlevels_m');
        $this->load->model('gamifyuserbadges_m');
        $this->load->model('gamifyuserachievements_m');
        $this->load->model('gamifylevelassociates_m');
        // gamification library (to award badge, reward, points,credits, levels etc);
        $this->load->library('gamify'); 
    }
    
    public function index()
    {
         // load awarded badges for selected user
         /* $query = new \stdClass;
          $query->userid = 1; // adjust with profile user id or currently logged in userid;
          $query->type = 1; // 1: badge, 2: rewards, 3: packages
          $result = $this->gamifyuserbadges_m->fetch_records($query);
          
          return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array(
                    'status' => 'success',
                    'query' => $result
            ))); */
            
        
        // load awarded rewards
        /* $query = new \stdClass;
          $query->userid = 1; // adjust with profile user id or currently logged in userid;
          $query->type = 2; // 1: badge, 2: rewards, 3: packages
          $result = $this->gamifyuserbadges_m->fetch_records($query);
          
          return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array(
                    'status' => 'success',
                    'query' => $result
            )));*/
            
        /* load level / available credits and points information */
         /* $query = new \stdClass;
          $query->userid = 1; // adjust with profile user id or currently logged in userid;
          $result = $this->gamifyuserlevels_m->fetch_records($query);
          
          return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array(
                    'status' => 'success',
                    'query' => $result
            ))); */
            
        /* load user achievements */
        $query = new \stdClass;
        $query->userid = 1; // adjust with profile user id or currently logged in userid;
        $result = $this->gamifyuserachievements_m->fetch_records($query);
      
        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array(
                    'status' => 'success',
                    'query' => $result
            )));
       
       
            
         
         /*$data = array();
         $query = new \stdClass;
         $query->id = 0;
         $query->category_id = 0;
         $query->type = 0;
         $query->isdeduct = 2;
         $query->ilevel = 0;
         $query->ishide = 0;
         
         $query->uerid = 1;
         // print_r($query);
         //$posts = $this->gamifybadges_m->fetch_records($query);
         //print_r($posts);
         
         // userid to award (badge, reward, point, credit or level)
         $userid = 1;
         // item id (id of badge or reward or point or credit or level)
         $itemid = 8;
         
         $result = $this->gamify->trigger_item($userid, $itemid);
         //print_r($result);
         //$count_posts = $this->gamifyuserlevels_m->check($query);
         //print_r($count_posts);
         return $this->output
            ->set_content_type('application/json')
            // ->set_status_header(500)
            ->set_output(json_encode(array(
                    'status' => 'success',
                    'query' => $result
            )));*/
    }

}

?>