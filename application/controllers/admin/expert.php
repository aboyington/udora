<?php

class Expert extends Admin_Controller
{

	public function __construct(){
		parent::__construct();
        $this->load->model('qa_m');
        $this->load->model('file_m');

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
        $this->data['categories'] = $this->qa_m->get_no_parents_expert_category($this->data['content_language_id']);
        $this->data['questions'] = $this->qa_m->get_lang(NULL, FALSE, $this->data['content_language_id'], 
                                                      array_merge(array('type'=>'QUESTION'), $category_selected));
        $this->data['experts_user'] = $this->user_m->get_experts();

        $config['base_url'] = site_url('admin/expert/index/'.$category_id.'/');
        $config['uri_segment'] = 5;
        $config['total_rows'] = count($this->data['questions']);
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
        
        $this->data['questions'] = $this->qa_m->get_lang(NULL, FALSE, $this->data['content_language_id'], 
                                                          array_merge(array('type'=>'QUESTION'), $category_selected), 
                                                          $config['per_page'], $pagination_offset);
        
        // Load view
		$this->data['subview'] = 'admin/expert/index';
        $this->load->view('admin/_layout_main', $this->data);
	}
    
    public function edit($id = NULL)
	{
	    // Fetch a page or set a new one
	    if($id)
        {
            $this->data['expert'] = $this->qa_m->get_lang($id, FALSE, $this->data['content_language_id']);
            count($this->data['expert']) || $this->data['errors'][] = 'Could not be found';
        }
        else
        {
            $this->data['expert'] = $this->qa_m->get_new();
        }
        
		// Pages for dropdown
        $this->data['experts_no_parents'] = $this->qa_m->get_no_parents_expert($this->data['content_language_id'], lang_check('No category'));
        $this->data['page_languages'] = $this->language_m->get_form_dropdown('language');
        $this->data['experts_user'] = $this->user_m->get_experts($this->data['experts_no_parents']);
        
        // Set up the form
        $rules = $this->qa_m->get_all_rules();
        $rules['date_publish'] = array('field'=>'date_publish', 'label'=>'lang:Date publish', 'rules'=>'trim|required|xss_clean');
        $this->form_validation->set_rules($rules);

        // Process the form
        if($this->form_validation->run() == TRUE)
        {
            if($this->config->item('app_type') == 'demo')
            {
                $this->session->set_flashdata('error', 
                        lang('Data editing disabled in demo'));
                redirect('admin/expert/edit/'.$id);
                exit();
            }
            
            $data = $this->qa_m->array_from_post(array('date_publish', 'parent_id', 'answer_user_id', 'is_readed'));
            
            if($id == NULL)
            {
                //get max order in parent id and set
                $parent_id = $this->input->post('parent_id');
                $data['order'] = $this->qa_m->max_order($parent_id);
            }

            $data_lang = $this->qa_m->array_from_post($this->qa_m->get_lang_post_fields());
            if($id == NULL)
            {
                $data['date'] = date('Y-m-d H:i:s');
            }
            
            $data['type'] = 'QUESTION';
            
            $id = $this->qa_m->save_with_lang($data, $data_lang, $id);
            
            $this->session->set_flashdata('message', 
                    '<p class="label label-success validation">'.lang_check('Changes saved').'</p>');
            
            redirect('admin/expert/edit/'.$id);
        }
        
        // Load the view
		$this->data['subview'] = 'admin/expert/edit';
        $this->load->view('admin/_layout_main', $this->data);
	}
    
    public function categories()
	{
	    //$this->output->enable_profiler(TRUE);
       
	    // Fetch all pages
        $this->data['page_languages'] = $this->language_m->get_form_dropdown('language');
        $this->data['expert_nested'] = $this->qa_m->get_nested_tree($this->data['content_language_id']);
        
        // Load view
		$this->data['subview'] = 'admin/expert/categories';
        $this->load->view('admin/_layout_main', $this->data);
	}
    
    public function update_ajax($filename = NULL)
    {
        // Save order from ajax call
        if(isset($_POST['sortable']) && $this->config->item('app_type') != 'demo')
        {
            $this->qa_m->save_order($_POST['sortable']);
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
            $this->data['expert'] = $this->qa_m->get_lang($id, FALSE, $this->data['content_language_id']);
            count($this->data['expert']) || $this->data['errors'][] = lang_check('Could not be found');
        }
        else
        {
            $this->data['expert'] = $this->qa_m->get_new();
        }
        
		// Pages for dropdown
        $this->data['experts_no_parents'] = $this->qa_m->get_no_parents($this->data['content_language_id']);
        $this->data['page_languages'] = $this->language_m->get_form_dropdown('language');
        
        // Set up the form
        $rules = array_merge($this->qa_m->rules_category, $this->qa_m->rules_lang_categories);
        $this->form_validation->set_rules($rules);

        // Process the form
        if($this->form_validation->run() == TRUE)
        {
            if($this->config->item('app_type') == 'demo')
            {
                $this->session->set_flashdata('error', 
                        lang('Data editing disabled in demo'));
                redirect('admin/expert/edit_category/'.$id);
                exit();
            }
            
            $data = $this->qa_m->array_from_post(array('parent_id'));
            if($id == NULL)$data['order'] = $this->qa_m->max_order()+1;
            $data_lang = $this->qa_m->array_from_post($this->qa_m->get_lang_post_fields('rules_lang_categories'));
            if($id == NULL)
                $data['date'] = date('Y-m-d H:i:s');
                
            $data['type'] = 'CATEGORY';
            
            $id = $this->qa_m->save_with_lang($data, $data_lang, $id);
            
            $this->session->set_flashdata('message', 
                    '<p class="label label-success validation">'.lang_check('Changes saved').'</p>');
            
            redirect('admin/expert/edit_category/'.$id);
        }
        
        // Load the view
		$this->data['subview'] = 'admin/expert/edit_category';
        $this->load->view('admin/_layout_main', $this->data);
	}
    
    public function delete($id)
	{
        if($this->config->item('app_type') == 'demo')
        {
            $this->session->set_flashdata('error', 
                    lang('Data editing disabled in demo'));
            redirect('admin/expert');
            exit();
        }
       
		$this->qa_m->delete($id);
        redirect('admin/expert');
	}
    
    public function _unique_slug($str)
    {
        // Do NOT validate if slug alredy exists
        // UNLESS it's the slug for the current page
        
        $id = $this->uri->segment(4);
        $this->db->where('slug', $this->input->post('slug'));
        !$id || $this->db->where('id !=', $id);
        
        $page = $this->qa_m->get();
        
        if(count($page))
        {
            $this->form_validation->set_message('_unique_slug', '%s should be unique');
            return FALSE;
        }
        
        return TRUE;
    }
    
}