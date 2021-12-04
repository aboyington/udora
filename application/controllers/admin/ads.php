<?php

class Ads extends Admin_Controller
{
    var $modules_acl_config = array('ADMIN'=>array('news'));

	public function __construct(){
		parent::__construct();
        $this->load->model('ads_m');
        $this->load->model('file_m');
        $this->load->model('repository_m');

        // Get language for content id to show in administration
        $this->data['content_language_id'] = $this->language_m->get_content_lang();
        
        $this->data['template_css'] = base_url('templates/'.$this->data['settings']['template']).'/'.config_item('default_template_css');
	}
    
    public function index()
	{
        // Fetch all pages
        $this->data['ads'] = $this->ads_m->get();
        
        // Load view
		$this->data['subview'] = 'admin/ads/index';
        $this->load->view('admin/_layout_main', $this->data);
	}
    
    public function edit($id = NULL)
	{
	    // Fetch a ad or set a new one
	    if($id)
        {
            $this->data['ad'] = $this->ads_m->get($id);
            
            if(count($this->data['ad']) == 0)
            {
                $this->data['errors'][] = lang_check('Ad could not be found');
                redirect('admin/ads');
            }
            
            // Fetch file repository
            $repository_id = $this->data['ad']->repository_id;
            if(empty($repository_id))
            {
                // Create repository
                $repository_id = $this->repository_m->save(array('name'=>'ads_m'));
                
                // Update page with new repository_id
                $this->ads_m->save(array('repository_id'=>$repository_id), $this->data['ad']->id);
            }
        }
        else
        {
            $this->data['ad'] = $this->ads_m->get_new();
        }
       
		$id == NULL || $this->data['ad'] = $this->ads_m->get($id);
        
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
        $rules = $this->ads_m->rules_admin;
        $this->form_validation->set_rules($rules);

        // Process the form
        if($this->form_validation->run() == TRUE)
        {
            if($this->config->item('app_type') == 'demo')
            {
                $this->session->set_flashdata('error', 
                        lang('Data editing disabled in demo'));
                redirect('admin/ads/edit/'.$id);
                exit();
            }
            
            $data = $this->ads_m->array_from_post(array('title', 'description', 'link', 'type', 'is_activated', 'is_random'));

            $id = $this->ads_m->save($data, $id);

            $this->session->set_flashdata('message', 
                    '<p class="label label-success validation">'.lang_check('Changes saved').'</p>');

            redirect('admin/ads/edit/'.$id);
        }
        
        // Load the view
		$this->data['subview'] = 'admin/ads/edit';
        $this->load->view('admin/_layout_main', $this->data);
	}
  
    public function delete($id)
	{
        if($this->config->item('app_type') == 'demo')
        {
            $this->session->set_flashdata('error', 
                    lang('Data editing disabled in demo'));
            redirect('admin/ads');
            exit();
        }
       
		$this->ads_m->delete($id);
        redirect('admin/ads');
	}
    
    public function _unique_code($str)
    {
        // Do NOT validate if slug alredy exists
        // UNLESS it's the slug for the current page
        
        $id = $this->uri->segment(4);
        $this->db->where('code', $this->input->post('code'));
        !$id || $this->db->where('id !=', $id);
        
        $ad = $this->ads_m->get();
        
        if(count($ad))
        {
            $this->form_validation->set_message('_unique_code', '%s should be unique');
            return FALSE;
        }
        
        return TRUE;
    }
    
    public function _unique_title($str)
    {
        // Do NOT validate if slug alredy exists
        // UNLESS it's the slug for the current page
        
        $id = $this->uri->segment(4);
        $this->db->where('title', $this->input->post('title'));
        !$id || $this->db->where('id !=', $id);
        
        $ad = $this->ads_m->get();
        
        if(count($ad))
        {
            $this->form_validation->set_message('_unique_title', '%s should be unique');
            return FALSE;
        }
        
        return TRUE;
    }
    
}