<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Members extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        //$this->load->model('members_model');
        //$this->load->library('session');
    }
    
    public function index(){
        $this->load->library('pagination');
        $config = array();
        
        $base_url = base_url() . 'admin/members/index';
        $total_rows = $this->references_model->count_references();
        $per_page = 10;
        $uri_segment = 4;
        
        foreach ($this->pagination_config($base_url, $total_rows, $per_page, $uri_segment) as $key => $value) {
            $config[$key] = $value;
        }
        $this->pagination->initialize($config);

        $this->data['page_links'] = $this->pagination->create_links();
        $this->data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $this->data['references'] = $this->references_model->fetch_all_references($per_page, $this->data['page']);

        $this->render('admin/references/list_references_view');
    }
    
    public function create(){
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('reference_category', 'Project name', 'trim|required');
        $this->form_validation->set_rules('reference_title', 'Project name', 'trim|required');
        $this->form_validation->set_rules('reference_url', 'Project name', 'trim|required');
        
        if ($this->form_validation->run() == FALSE) {
            $this->render('admin/references/create_reference_view');
        }else{
            if($this->input->post()){
                $image = $this->upload_image('reference_image', $_FILES['reference_image']['name'], 'assets/upload/references', NULL);
                
                $reference_data = array(
                    'filter' => $this->input->post('reference_category'),
                    'title' => $this->input->post('reference_title'),
                    'image' => $image,
                    'url' => $this->input->post('reference_url'),
                    'created' => $this->author_info['created'],
                    'created_by' => $this->author_info['created_by'],
                    'modified' => $this->author_info['modified'],
                    'modified_by' => $this->author_info['modified_by'],
                );

                try {
                    $this->references_model->insert($reference_data);
                    $this->session->set_flashdata('message', 'Item added successfully');
                } catch (Exception $e) {
                    $this->session->set_flashdata('message', 'There was an error inserting item: ' . $e->getMessage());
                }

                redirect('admin/references', 'refresh');
            }
        }
    }

}
