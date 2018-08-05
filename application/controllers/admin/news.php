<?php

class News extends Admin_Controller
{
    var $modules_acl_config = array('ADMIN'=>array('news'));

	public function __construct(){
		parent::__construct();
        $this->load->model('page_m');
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
        $this->data['categories'] = $this->page_m->get_no_parents_news_category($this->data['content_language_id']);
        $this->data['news'] = $this->page_m->get_lang(NULL, FALSE, $this->data['content_language_id'], 
                                                      array_merge(array('type'=>'MODULE_NEWS_POST'), $category_selected));

        $config['base_url'] = site_url('admin/news/index/'.$category_id.'/');
        $config['uri_segment'] = 5;
        $config['total_rows'] = count($this->data['news']);
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
        
        $this->data['news'] = $this->page_m->get_lang(NULL, FALSE, $this->data['content_language_id'], 
                                                          array_merge(array('type'=>'MODULE_NEWS_POST'), $category_selected), 
                                                          $config['per_page'], $pagination_offset);
        
        // Load view
		$this->data['subview'] = 'admin/news/index';
        $this->load->view('admin/_layout_main', $this->data);
	}
    
    public function edit($id = NULL)
	{
	    // Fetch a page or set a new one
	    if($id)
        {
            $this->data['page'] = $this->page_m->get_lang($id, FALSE, $this->data['content_language_id']);
            count($this->data['page']) || $this->data['errors'][] = 'User could not be found';
            
            // Fetch file repository
            $repository_id_t = $this->data['page']->repository_id;

            if(empty($repository_id_t))
            {
                // Create repository
                $repository_id_new = $this->repository_m->save(array('name'=>'page_m'));
                // exit();
                // Update page with new repository_id
                $this->page_m->save(array('repository_id'=>$repository_id_new), $this->data['page']->id);
            }
        }
        else
        {
            $this->data['page'] = $this->page_m->get_new();
        }
        
		// Pages for dropdown
        $this->data['pages_no_parents'] = $this->page_m->get_no_parents_news_category($this->data['content_language_id']);
        $this->data['page_languages'] = $this->language_m->get_form_dropdown('language');
        $this->data['templates_page'] = $this->page_m->get_templates('page_');
        
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
        $rules = $this->page_m->get_all_rules();
        $rules['date_publish'] = array('field'=>'date_publish', 'label'=>'lang:Date publish', 'rules'=>'trim|required|xss_clean');
        $this->form_validation->set_rules($rules);

        // Process the form
        if($this->form_validation->run() == TRUE)
        {
            if($this->config->item('app_type') == 'demo')
            {
                $this->session->set_flashdata('error', 
                        lang('Data editing disabled in demo'));
                redirect('admin/news/edit/'.$id);
                exit();
            }
            
            $data = $this->page_m->array_from_post(array('date_publish', 'template', 'parent_id'));
            
            if($id == NULL)
            {
                //get max order in parent id and set
                $parent_id = $this->input->post('parent_id');
                $data['order'] = $this->page_m->max_order($parent_id);
            }

            $data_lang = $this->page_m->array_from_post($this->page_m->get_lang_post_fields());
            if($id == NULL)
            {
                $data['date'] = date('Y-m-d H:i:s');
            }
            
            $data['type'] = 'MODULE_NEWS_POST';
            
            $id = $this->page_m->save_with_lang($data, $data_lang, $id);
            
            $this->session->set_flashdata('message', 
                    '<p class="label label-success validation">'.lang_check('Changes saved').'</p>');
            
            redirect('admin/news/edit/'.$id);
        }
        
        // Load the view
		$this->data['subview'] = 'admin/news/edit';
        $this->load->view('admin/_layout_main', $this->data);
	}
    
    public function categories()
	{
	    // Fetch all pages
        $this->data['page_languages'] = $this->language_m->get_form_dropdown('language');
        $this->data['pages_nested'] = $this->page_m->get_nested_news_categories($this->data['content_language_id']);
        
        // Load view
		$this->data['subview'] = 'admin/news/categories';
        $this->load->view('admin/_layout_main', $this->data);
	}
    
    public function edit_category($id = NULL)
	{
	    // Fetch a page or set a new one
	    if($id)
        {
            $this->data['page'] = $this->page_m->get_lang($id, FALSE, $this->data['content_language_id']);
            count($this->data['page']) || $this->data['errors'][] = 'User could not be found';
        }
        else
        {
            $this->data['page'] = $this->page_m->get_new();
        }
        
		// Pages for dropdown
        $this->data['pages_no_parents'] = $this->page_m->get_no_parents_news($this->data['content_language_id']);
        $this->data['page_languages'] = $this->language_m->get_form_dropdown('language');
        
        // Set up the form
        $rules = array_merge($this->page_m->rules_news, $this->page_m->rules_lang_news);
        $this->form_validation->set_rules($rules);

        // Process the form
        if($this->form_validation->run() == TRUE)
        {
            if($this->config->item('app_type') == 'demo')
            {
                $this->session->set_flashdata('error', 
                        lang('Data editing disabled in demo'));
                redirect('admin/news/edit_category/'.$id);
                exit();
            }
            
            $data = $this->page_m->array_from_post(array('parent_id'));
            if($id == NULL)$data['order'] = $this->page_m->max_order()+1;
            $data_lang = $this->page_m->array_from_post($this->page_m->get_lang_post_fields('rules_lang_news'));
            if($id == NULL)
                $data['date'] = date('Y-m-d H:i:s');
                
            $data['type'] = 'MODULE_NEWS_CATEGORY';
            
            $id = $this->page_m->save_with_lang($data, $data_lang, $id);
            
            $this->session->set_flashdata('message', 
                    '<p class="label label-success validation">'.lang_check('Changes saved').'</p>');
            
            redirect('admin/news/edit_category/'.$id);
        }
        
        // Load the view
		$this->data['subview'] = 'admin/news/edit_category';
        $this->load->view('admin/_layout_main', $this->data);
	}
    
    public function delete($id)
	{
        if($this->config->item('app_type') == 'demo')
        {
            $this->session->set_flashdata('error', 
                    lang('Data editing disabled in demo'));
            redirect('admin/page');
            exit();
        }
       
		$this->page_m->delete($id);
        redirect('admin/news/categories');
	}
    
    public function _unique_slug($str)
    {
        // Do NOT validate if slug alredy exists
        // UNLESS it's the slug for the current page
        
        $id = $this->uri->segment(4);
        $this->db->where('slug', $this->input->post('slug'));
        !$id || $this->db->where('id !=', $id);
        
        $page = $this->page_m->get();
        
        if(count($page))
        {
            $this->form_validation->set_message('_unique_slug', '%s should be unique');
            return FALSE;
        }
        
        return TRUE;
    }
    
}