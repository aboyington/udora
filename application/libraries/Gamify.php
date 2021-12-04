<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* core logic for processing all gamification */
class Gamify {

    public function __construct($params = array())
    {
        $this->CI = &get_instance();
        
    }
    
    public function trigger_item($userid, $itemid)
    {
            $addNotification = false;
    	    /*'******************************************************************'
            ' Check whether user exist in ga_user_levels
            '******************************************************************'*/
            $user_level_query = new \stdClass;
            $user_level_query->userid = $userid;
            if(!$this->CI->gamifyuserlevels_m->check($user_level_query))
            {
                 // user record exist
                 // add user record in gamify user list
    			$user_level = array();
                $user_level["userid"] = $userid;
                $user_level["levels"] = 0; 
                $user_level["points"] = 0;
                $user_level["credits"] = 0;
    			$user_level["init_points"] = 0; 
                $user_level["max_points"] = 0;
                $user_level["level_id"] = 0;
    			$this->CI->gamifyuserlevels_m->insert($user_level);
            }
            
          	/*'******************************************************************'
            ' LOAD BADGE INFORMATION'
            '******************************************************************'*/
            $badge_query = new \stdClass;
            $badge_query->id = $itemid;
		    $badge_info = $this->CI->gamifybadges_m->fetch_records($badge_query);
		   
		    /*'******************************************************************'
            ' PROCESS USER LEVELS, CREDITS,
            '******************************************************************' */
    		$user_query = new \stdClass;
            $user_query->userid = $userid;
            $user_info = $this->CI->gamifyuserlevels_m->fetch_records($user_query);;
		    
		    // reference usage
		    // $points = $user_info[0]['points'];
		    if($badge_info['type'] == '3') {
		        /*'******************************************************************'
                ' LEVEL UP'
                '*******************************************************************/
                $level_info = array();
                $level_info["levels"] = $badge_info['ilevel'];
                $level_info["init_points"] = 0; //'reset to zero for new level calculation'
                $level_info["max_points"] = $badge_info['xp']; // 'maximum points required to cross this level'
                $level_info["level_id"] = $badge_info['id'];  // ' assign allocated id for future processing'
    
    			$this->CI->gamifyuserlevels_m->update($level_info,  array("userid" => $userid));
             	$addNotification = true;
    			/*'******************************************************************'
                ' Check whether there is any reward associated with this level
                '*******************************************************************/
    			// $level_associate_entity = new ga_level_associate_query();
    			$level_associate_entity = new \stdClass;
    			$level_associate_entity->levelid = $level_info["level_id"];
    			// $level_associate_obj = new ga_level_associate_bll();
                $level_associate_output = $this->CI->gamifylevelassociates_m->fetch_records($level_associate_entity);
    			if(count($level_associate_output) > 0)
    			{
    				foreach($level_associate_output as $item)
    				{					
    					// recursive call this function to award this reward
    					$this->trigger_item($userid, $item['rewardid']);
    				}
    			}
                
		    } 
	    	else if($badge_info['type'] == '4') 
	    	{
	    	        print_r('points');
	    	    	/******************************************************************'
                    ' POINTS'
                    '******************************************************************' */
        			$currentpoints = $user_info[0]['points'];
        			$initpoints = $user_info[0]['init_points'];
        			
                    if($badge_info['isdeduct'] == 1)
        			{
        				// 'Deduct Points'
        				$currentpoints = $currentpoints - $badge_info['xp'];
        				$initpoints = $initpoints - $badge_info['xp'];
        				if($currentpoints < 0)
        				  $currentpoints =0;
        				if($initpoints < 0)
        				  $initpoints = 0; 
        			}
        			else
        			{
        				// increment points
        				$currentpoints = $currentpoints + $badge_info['xp'];
        				$initpoints = $initpoints + $badge_info['xp'];
        			}
        			
        			$points_info = array();
                    $points_info["points"] = $currentpoints;
        			$points_info["init_points"] = $initpoints;
        			
                    $this->CI->gamifyuserlevels_m->update($points_info,  array("userid" => $userid));
        			$addNotification = true;
        			if($initpoints >= $user_info[0]['max_points']) 
        			{
        				// Level Up
        				$currentlevel = $user_info[0]['levels'];
        				$nextlevel = $currentlevel+1;
        				$next_badges_query = new \stdClass;
        				$next_badges_query->ilevel = $nextlevel;
        				$next_badge_info = $this->CI->gamifybadges_m->fetch_records($next_badges_query);
                        if(count($next_badge_info) > 0)
        				{
        					//Level Exist'
        					$level_info = array();
        					$level_info["levels"] = $nextlevel;
        					$level_info["init_points"] = 0; //'reset to zero for new level calculation'
        					$level_info["max_points"] = $next_badge_info[0]['xp']; // 'maximum points required to cross this level'
        					$level_info["level_id"] = $next_badge_info[0]['id'];  // ' assign allocated id for future processing'
        					$this->CI->gamifyuserlevels_m->update($level_info,  array("userid" => $userid));
        					
        					/*'******************************************************************'
        					' Check whether there is any reward associated with new level
        					'******************************************************************/
        					$level_associate_entity = new \stdClass;
        					$level_associate_entity->levelid = $next_badge_info[0]['id'];

        			    	$level_associate_output = $this->CI->gamifylevelassociates_m->fetch_records($level_associate_entity);
        					if(count($level_associate_output) > 0)
        					{
        						foreach($level_associate_output as $item)
        						{					
        							// recursive call this function to award this reward
        							$this->trigger_item($userid, $item['rewardid']);
        						}
        					}
        				}
        			}
	    	}
	    	else if($badge_info['type'] == '5')
    		{
    			/******************************************************************'
                ' CREDITS '
                '*******************************************************************/
               
    			$currentcredits = $user_info[0]['credits'];
    			if($badge_info['isdeduct'] == 1)
    			{
    				$currentcredits = $currentcredits - $badge_info['credits'];
    				if($currentcredits < 0)
    				  $currentcredits = 0;
    			}
    			else
    			{
    				$currentcredits = $currentcredits + $badge_info['credits'];
    			}
    			
               	$this->CI->gamifyuserlevels_m->update(array("credits" => $currentcredits),  array("userid" => $userid));
    			$addNotification = true;
    		}
	    	else
    		{
    			/*******************************************************************'
                ' BADGE, REWARD, PACKAGE '
                '******************************************************************'
    
                '******************************************************************'
                ' Associate Badge or Reward or Package with User
                '******************************************************************'*/
               
    			$badge_data = array();
                $badge_data["userid"] = $userid;
    			$badge_data["badge_id"] = $badge_info['id'];
    			
                switch($badge_info['type'])
    			{
    				case 1:
    				    // type : badge
                       $badge_data["type"] = 1;
    				break;
    				case 2:
    				   // type : reward
                       $badge_data["type"] = 2;
    				break;
    				case 6:
    				   // type : package
                       $badge_data["type"] = 3;
    				break;
    			}
    			$badge_data["added_date"] = date("Y-m-d H:i:s");
 	
    			// check whether user already award badge, if not marketd as multiple (award multiple times)
    			if($badge_info['ismultiple'] == 1)
    			{
    				$addNotification = true;
    			    // award multiple times
    			   	$check_user_badge_query = new \stdClass;
    				$check_user_badge_query->userid = $userid;
    				$check_user_badge_query->badge_id = $badge_info['id'];
    			
    				if(!$this->CI->gamifyuserbadges_m->check($check_user_badge_query))
    				{
    					$this->CI->gamifyuserbadges_m->insert($badge_data);
    				}
    				else
    				{   
    					// update occurences of existing awarded badge if exist
    					$current_badge_query = new \stdClass;
     					$current_badge_query->badge_id = $badge_info['id'];
    					$current_badge_query->userid = $userid;
    					$current_badge_info = $this->CI->gamifyuserbadges_m->fetch_records($current_badge_query);
    					if(count($current_badge_info) > 0)
    					{
    						$repeated_badge = $current_badge_info[0]['repeated'];
    						$repeated_badge = $repeated_badge + 1;
    						$this->CI->gamifyuserbadges_m->update(array("repeated" => $repeated_badge), array('userid' => $userid, 'badge_id' => $badge_info['id']));
    						
    					}
      			    }
    				// process physical code related to selected reward.
    				// $this->call_phycical_function($badge_info['type'], $badge_info['id'], $userid);
    			} 
    			else
    			{
    			   
    			  
    				// award single time
    				$check_user_badge_query = new \stdClass;
    				$check_user_badge_query->userid = $userid;
    				$check_user_badge_query->badge_id = $badge_info['id'];
    			 
    				if(!$this->CI->gamifyuserbadges_m->count_records($check_user_badge_query) > 0)
    				{ 
    				    print_r($check_user_badge_query);
       					$this->CI->gamifyuserbadges_m->insert($badge_data);
    					// process physical code related to selected reward.
    					//$this->call_phycical_function($badge_info['type'], $badge_info['id'], $userid);
    					$addNotification = true;
    				} 
    				
    			}
    			
    			if($badge_info['type'] == '6')
    			{
    				// package, credit package allocated credits to user
    				$currentcredits = $user_info[0]['credits'];
    				$currentcredits = $currentcredits + $badge_info['credits'];
    			    $this->CI->gamifyuserlevels_m->update(array("credits" => $currentcredits), array("userid" => $userid));
    				$addNotification = true;
    			}
    		}
    		
    		/*******************************************************************'
            ' Update User Achievements / History
            '******************************************************************'*/
    		if($addNotification)
    		{
    			if($badge_info['notification'] != "") 
    			{
    				$user_history_data = array();
    				$value = "";
    				switch($badge_info['type'])
    				{
    					 case '1':
    					 // type: badge
    					 $value = $badge_info['title']; // ' badge name as value'
    					 break;
    					 case '2':
    					 // type: reward
    					 $value = $badge_info['title']; // ' reward name as value'
    					 break;
    					 case '3':
    					 // type level
    					 $value = $badge_info['ilevel']; // ' level ilevel as value'
    					 break;
    					 case '4':
    					 // type points
    					 $value = $badge_info['xp']; // ' xp as point value'
    					 break;
    					 case '5':
    					 // type credits
    					  $value = $badge_info['credits']; // ' credits as value'
    					 break;
    					 case '6':
    					 // type package
    			    	 $value = $badge_info['title']; // ' packages as title'
    					 break;
    				}
    				
    				$user_history_data["userid"] = $userid;
    				$user_history_data["description"] = preg_replace("/\[value\]/", $value, $badge_info['notification']);
    				$user_history_data["added_date"] = date("Y-m-d H:i:s");
    				$user_history_data["type"] = $badge_info['type'];

    				$this->CI->gamifyuserachievements_m->insert($user_history_data);
    			}
    		}
    		
    		
            /*'******************************************************************'
            ' Process Completed
            '******************************************************************'*/
            return true;
		    
		    //return $badge_info['type'];

     }
     
      private function call_phycical_function($type, $rewardid, $userid)
      {
    	  if($type == 2)
    	  {
    			// unlocked reward
    			// call physical feature to process user own code for selected reward.
    			//$physical_features = new process_reward_features();
    			//$physical_features->process($rewardid, $userid);
    	  }
      }
    
}