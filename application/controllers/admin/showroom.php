<?php

class Showroom extends Admin_Controller
{

	public function __construct(){
		parent::__construct();
        $this->load->model('showroom_m');
        $this->load->model('file_m');
        $this->load->model('repository_m');

        // Get language for content id to show in administration
        $this->data['content_language_id'] = $this->language_m->get_content_lang();
        
        $this->data['template_css'] = base_url('templates/'.$this->data['settings']['template']).'/'.config_item('default_template_css');
	}
    
    public function index($category_id = 0, $pagination_offset=0)
	{
	    $this->load->library('pagination');
        
        $category_selected = array();
        if($category_id != 0)
        {
            $category_selected = array('parent_id'=>$category_id);
        }
        
        // Fetch all pages
        $this->data['page_languages'] = $this->language_m->get_form_dropdown('language');
        $this->data['categories'] = $this->showroom_m->get_no_parents_showrooms_category($this->data['content_language_id']);
        $this->data['showrooms'] = $this->showroom_m->get_lang(NULL, FALSE, $this->data['content_language_id'], 
                                                      array_merge(array('type'=>'COMPANY'), $category_selected));

        $config['base_url'] = site_url('admin/showroom/index/'.$category_id.'/');
        $config['uri_segment'] = 5;
        $config['total_rows'] = count($this->data['showrooms']);
        $config['per_page'] = 20;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        
        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();
                if(config_item('admin_template') == 'udora_admin') {
            $pagination_offset = NULL;
            $config['per_page'] = NULL;
        }
        
        $this->data['showrooms'] = $this->showroom_m->get_lang(NULL, FALSE, $this->data['content_language_id'], 
                                                          array_merge(array('type'=>'COMPANY'), $category_selected), 
                                                          $config['per_page'], $pagination_offset);
        
        // Load view
		$this->data['subview'] = 'admin/showroom/index';
        $this->load->view('admin/_layout_main', $this->data);
	}
    
    public function edit($id = NULL)
	{
	    // Fetch a page or set a new one
	    if($id)
        {
            $this->data['showroom'] = $this->showroom_m->get_lang($id, FALSE, $this->data['content_language_id']);
            count($this->data['showroom']) || $this->data['errors'][] = 'User could not be found';
            
            // Fetch file repository
            $repository_id_t = $this->data['showroom']->repository_id;

            if(empty($repository_id_t))
            {
                // Create repository
                $repository_id_new = $this->repository_m->save(array('name'=>'showroom_m'));
                // exit();
                // Update page with new repository_id
                $this->showroom_m->save(array('repository_id'=>$repository_id_new), $this->data['showroom']->id);
            }
        }
        else
        {
            $this->data['showroom'] = $this->showroom_m->get_new();
        }
        
		// Pages for dropdown
        $this->data['showrooms_no_parents'] = $this->showroom_m->get_no_parents_showroom($this->data['content_language_id'], lang_check('No category'));
        $this->data['page_languages'] = $this->language_m->get_form_dropdown('language');
        $this->data['templates_showroom'] = $this->showroom_m->get_templates('showroom_');
        
        // Fetch all files by repository_id
        $files = $this->file_m->get();
        foreach($files as $key=>$file)
        {
            $file->thumbnail_url = base_url('adminudora-assets/img/icons/filetype/_blank.png');
            $file->zoom_enabled = false;
            $file->download_url = base_url('files/'.$file->filename);
            $file->delete_url = site_url_q('files/upload/rep_'.$file->repository_id, '_method=DELETE&amp;file='.rawurlencode($file->filename));

            if(file_exists(FCPATH.'/files/thumbnail/'.$file->filename))
            {
                $file->thumbnail_url = base_url('files/thumbnail/'.$file->filename);
                $file->zoom_enabled = true;
            }
            else if(file_exists(FCPATH.'adminudora-assets/img/icons/filetype/'.get_file_extension($file->filename).'.png'))
            {
                $file->thumbnail_url = base_url('adminudora-assets/img/icons/filetype/'.get_file_extension($file->filename).'.png');
            }
            
            $this->data['files'][$file->repository_id][] = $file;
        }
        
        // Set up the form
        $rules = $this->showroom_m->get_all_rules();
        $rules['date_publish'] = array('field'=>'date_publish', 'label'=>'lang:Date publish', 'rules'=>'trim|required|xss_clean');
        $this->form_validation->set_rules($rules);

        // Process the form
        if($this->form_validation->run() == TRUE)
        {
            if($this->config->item('app_type') == 'demo')
            {
                $this->session->set_flashdata('error', 
                        lang('Data editing disabled in demo'));
                redirect('admin/showroom/edit/'.$id);
                exit();
            }
            
            $data = $this->showroom_m->array_from_post(array('date_publish', 'template', 'parent_id', 'address', 'gps', 'contact_email'));
            
            if($id == NULL)
            {
                //get max order in parent id and set
                $parent_id = $this->input->post('parent_id');
                $data['order'] = $this->showroom_m->max_order($parent_id);
            }

            $data_lang = $this->showroom_m->array_from_post($this->showroom_m->get_lang_post_fields());
            if($id == NULL)
            {
                $data['date'] = date('Y-m-d H:i:s');
            }
            
            $data['type'] = 'COMPANY';
            
            $id = $this->showroom_m->save_with_lang($data, $data_lang, $id);
            
            $this->session->set_flashdata('message', 
                    '<p class="label label-success validation">'.lang_check('Changes saved').'</p>');
            
            redirect('admin/showroom/edit/'.$id);
        }
        
        // Load the view
		$this->data['subview'] = 'admin/showroom/edit';
        $this->load->view('admin/_layout_main', $this->data);
	}
    
	public function gps_check($str)
	{
        $gps_coor = explode(', ', $str);
        
        if(count($gps_coor) != 2)
        {
        	$this->form_validation->set_message('gps_check', lang_check('Please check GPS coordinates'));
        	return FALSE;
        }
        
        if(!is_numeric($gps_coor[0]) || !is_numeric($gps_coor[1]))
        {
        	$this->form_validation->set_message('gps_check', lang_check('Please check GPS coordinates'));
        	return FALSE;
        }
        
        if($gps_coor[0] < -90 || $gps_coor[0] > 90 || $gps_coor[1] < -180 || $gps_coor[1] > 180)
        {
        	$this->form_validation->set_message('gps_check', lang_check('Please check GPS coordinates'));
        	return FALSE;
        }
        
        return TRUE;
	}
    
    public function categories()
	{
	    // Fetch all pages
        $this->data['page_languages'] = $this->language_m->get_form_dropdown('language');
        $this->data['showroom_nested'] = $this->showroom_m->get_nested_tree($this->data['content_language_id']);
        
        // Load view
		$this->data['subview'] = 'admin/showroom/categories';
        $this->load->view('admin/_layout_main', $this->data);
	}
    
    public function update_ajax($filename = NULL)
    {
        // Save order from ajax call
        if(isset($_POST['sortable']) && $this->config->item('app_type') != 'demo')
        {
            $this->showroom_m->save_order($_POST['sortable']);
        }
        
        $data = array();
        $length = strlen(json_encode($data));
        header('Content-Type: application/json; charset=utf8');
        header('Content-Length: '.$length);
        echo json_encode($data);
        
        exit();
    }
    
    public function edit_category($id = NULL)
	{

	    // Fetch a page or set a new one
	    if($id)
        {
            $this->data['showroom'] = $this->showroom_m->get_lang($id, FALSE, $this->data['content_language_id']);
            count($this->data['showroom']) || $this->data['errors'][] = 'User could not be found';
        }
        else
        {
            $this->data['showroom'] = $this->showroom_m->get_new();
        }
        
		// Pages for dropdown
        $this->data['showrooms_no_parents'] = $this->showroom_m->get_no_parents($this->data['content_language_id']);
        $this->data['page_languages'] = $this->language_m->get_form_dropdown('language');
        
        if($id)
        {
            // Fetch all files by repository_id
            $files = $this->file_m->get_where_in(array($this->data['showroom']->repository_id));
            foreach($files as $key=>$file)
            {
                $file->thumbnail_url = base_url('adminudora-assets/img/icons/filetype/_blank.png');
                $file->zoom_enabled = false;
                $file->download_url = base_url('files/'.$file->filename);
                $file->delete_url = site_url_q('files/upload/rep_'.$file->repository_id, '_method=DELETE&amp;file='.rawurlencode($file->filename));
    
                if(file_exists(FCPATH.'/files/thumbnail/'.$file->filename))
                {
                    $file->thumbnail_url = base_url('files/thumbnail/'.$file->filename);
                    $file->zoom_enabled = true;
                }
                else if(file_exists(FCPATH.'adminudora-assets/img/icons/filetype/'.get_file_extension($file->filename).'.png'))
                {
                    $file->thumbnail_url = base_url('adminudora-assets/img/icons/filetype/'.get_file_extension($file->filename).'.png');
                }
                
                $this->data['files'][$file->repository_id][] = $file;
            }
        }
        
        // Set up the form
        $rules = array_merge($this->showroom_m->rules_category, $this->showroom_m->rules_lang_categories);
        $this->form_validation->set_rules($rules);

        // Process the form
        if($this->form_validation->run() == TRUE)
        {
            if($this->config->item('app_type') == 'demo')
            {
                $this->session->set_flashdata('error', 
                        lang('Data editing disabled in demo'));
                redirect('admin/showroom/edit_category/'.$id);
                exit();
            }
            
            $data = $this->showroom_m->array_from_post(array('parent_id'));
            if($id == NULL)$data['order'] = $this->showroom_m->max_order()+1;
            $data_lang = $this->showroom_m->array_from_post($this->showroom_m->get_lang_post_fields('rules_lang_categories'));
            if($id == NULL)
                $data['date'] = date('Y-m-d H:i:s');
                
            $data['type'] = 'CATEGORY';
            
            $id = $this->showroom_m->save_with_lang($data, $data_lang, $id);
            
            $this->session->set_flashdata('message', 
                    '<p class="label label-success validation">'.lang_check('Changes saved').'</p>');
            
            redirect('admin/showroom/edit_category/'.$id);
        }
        
        // Load the view
		$this->data['subview'] = 'admin/showroom/edit_category';
        $this->load->view('admin/_layout_main', $this->data);
	}
    
    public function delete($id)
	{
        if($this->config->item('app_type') == 'demo')
        {
            $this->session->set_flashdata('error', 
                    lang('Data editing disabled in demo'));
            redirect('admin/showroom');
            exit();
        }
       
		$this->showroom_m->delete($id);
        redirect('admin/showroom/categories');
	}
    
    public function _unique_slug($str)
    {
        // Do NOT validate if slug alredy exists
        // UNLESS it's the slug for the current page
        
        $id = $this->uri->segment(4);
        $this->db->where('slug', $this->input->post('slug'));
        !$id || $this->db->where('id !=', $id);
        
        $page = $this->showroom_m->get();
        
        if(count($page))
        {
            $this->form_validation->set_message('_unique_slug', '%s should be unique');
            return FALSE;
        }
        
        return TRUE;
    }
    
}