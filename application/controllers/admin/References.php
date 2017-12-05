<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class References extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('references_model');
        $this->load->library('session');
    }
    
    public function index(){
        $this->load->library('pagination');
        $config = array();
        
        $base_url = base_url() . 'admin/references/index';
        $total_rows = $this->references_model->count();
        $per_page = 100;
        $uri_segment = 4;
        
        foreach ($this->pagination_config($base_url, $total_rows, $per_page, $uri_segment) as $key => $value) {
            $config[$key] = $value;
        }
        $this->pagination->initialize($config);

        $this->data['page_links'] = $this->pagination->create_links();
        $this->data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $this->data['references'] = $this->references_model->fetch_all_with_pagination($per_page, $this->data['page']);

        $this->render('admin/references/list_references_view');
    }
    
    public function create(){
        $this->load->helper('form');
        $this->load->library('form_validation');
        $count = $this->references_model->count();
        
        $this->form_validation->set_rules('reference_category', 'Project Category', 'trim|required');
        $this->form_validation->set_rules('reference_title', 'Project Title', 'trim|required');
        
        if ($this->form_validation->run() == FALSE) {
            $this->data['count'] = $count;
            $this->render('admin/references/create_reference_view');
        }else{
            if($this->input->post()){
                $image = $this->upload_image('reference_image', $_FILES['reference_image']['name'], 'assets/upload/references', NULL);
                
                $reference_data = array(
                    'sorting' => $this->input->post('reference_sorting'),
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

                    if($this->input->post('reference_sorting') != $count + 1){
                        $replace_item = $this->references_model->get_by_sorting($this->input->post('reference_sorting'));
                        $this->references_model->update($replace_item['id'], array('sorting' => $count + 1));
                    }
                    
                    $this->session->set_flashdata('message', 'Item added successfully');
                } catch (Exception $e) {
                    $this->session->set_flashdata('message', 'There was an error inserting item: ' . $e->getMessage());
                }

                redirect('admin/references', 'refresh');
            }
        }
    }
    
    public function edit($id = NULL) {
        $this->load->helper('form');
        $this->load->library('form_validation');
        $count = $this->references_model->count();

        $this->form_validation->set_rules('reference_category', 'Project Category', 'trim|required');
        $this->form_validation->set_rules('reference_title', 'Project Title', 'trim|required');

        $reference_id = isset($id) ? (int) $id : (int) $this->input->post('id');
        $reference = $this->references_model->get_by_id($reference_id);

        if (!$reference) {
            redirect('admin/references', 'refresh');
        }

        if ($this->form_validation->run() == FALSE) {
     	    $this->data['count'] = $count;
            $this->data['reference'] = $reference;
            $this->render('admin/references/edit_reference_view');
        } else {
            if ($this->input->post()) {
                $image = $this->upload_image('reference_image', $_FILES['reference_image']['name'], 'assets/upload/references', NULL);
                $new_reference_data = array(
                    'sorting' => $this->input->post('reference_sorting'),
                    'filter' => $this->input->post('reference_category'),
                    'title' => $this->input->post('reference_title'),
                    'image' => $image,
                    'url' => $this->input->post('reference_url'),
                    'modified' => $this->author_info['modified'],
                    'modified_by' => $this->author_info['modified_by'],
                );
                if ($image == '') {
                    unset($new_reference_data['image']);
                }

                try {
                    $this->references_model->update($reference_id, $new_reference_data);
                    if($this->input->post('reference_sorting') != $reference['sorting'] && $reference['sorting'] != 0){
                        $replace_item = $this->references_model->get_by_sorting($this->input->post('reference_sorting'));
                        $this->references_model->update($replace_item['id'], array('sorting' => $reference['sorting']));
                        $this->references_model->update($reference_id, $new_reference_data);
                    }
                    $this->session->set_flashdata('message', 'Reference updated successfully');
                } catch (Exception $e) {
                    $this->session->set_flashdata('message', 'There was an error updating the reference: ' . $e->getMessage());
                }

                redirect('admin/references', 'refresh');
            }
        }
    }
    
    public function delete($id = NULL) {
        $reference = $this->references_model->get_by_id($id);

        if (!$reference) {
            redirect('admin/references', 'refresh');
        }

        $set_delete = array('is_delete' => 1);
        try {
            $this->references_model->delete($id, $set_delete);
            $this->session->set_flashdata('message', 'Item has deleted successful.');
        } catch (Exception $e) {
            $this->session->set_flashdata('message', 'Have error while delete item: ' . $e->getMessage());
        }
        redirect('admin/references', 'refresh');
    }

}