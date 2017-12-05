<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Descriptions extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('descriptions_model');
        $this->load->library('session');
    }

    public function index() {
        $this->data['descriptions'] = $this->descriptions_model->get_all_descriptions();

        $this->render('admin/descriptions/list_descriptions_view');
    }
    
    public function edit($id = NULL) {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('description_content', 'Description name', 'trim|required');

        $description_id = isset($id) ? (int) $id : (int) $this->input->post('id');
        if ($this->form_validation->run() == FALSE) {
            $this->data['description'] = $this->descriptions_model->get_description_by_id($description_id);

            if (!$this->data['description']) {
                redirect('admin/descriptions', 'refresh');
            }
            $this->render('admin/descriptions/edit_description_view');
        } else {
            if ($this->input->post()) {
                $new_description_data = array(
                    'description_content' => $this->input->post('description_content')
                );

                try {
                    $this->descriptions_model->update_description($description_id, $new_description_data);
                    $this->session->set_flashdata('message', 'Description updated successfully');
                } catch (Exception $e) {
                    $this->session->set_flashdata('message', 'There was an error updating the description: ' . $e->getMessage());
                }

                redirect('admin/descriptions', 'refresh');
            }
        }
    }

}
