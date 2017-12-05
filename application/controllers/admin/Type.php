<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Type extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('type_model');
        $this->load->library('session');
    }

    public function index() {
        $this->load->helper('form');
        $this->load->library('pagination');
        $config = array();
        $base_url = base_url() . 'admin/type/index';
        $total_rows = $this->type_model->count_all();
        $per_page = 10;
        $uri_segment = 4;
        foreach ($this->pagination_config($base_url, $total_rows, $per_page, $uri_segment) as $key => $value) {
            $config[$key] = $value;
        }
        $this->pagination->initialize($config);

        $this->data['page_links'] = $this->pagination->create_links();
        $this->data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $this->data['type'] = $this->type_model->get_all_with_pagination($per_page, $this->data['page']);

        $this->render('admin/type/list_type_view');
    }

    public function create() {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('title_vi', 'Type name', 'trim|required');
        $this->form_validation->set_rules('title_en', 'Type name', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $this->render('admin/type/create_type_view');
        } else {
            if ($this->input->post()) {
                $data = array(
                    'created_at' => $this->author_info['created'],
                    'created_by' => $this->author_info['created_by'],
                    'updated_at' => $this->author_info['modified'],
                    'updated_by' => $this->author_info['modified_by']
                );

                try {
                    $insert_id = $this->type_model->insert($data);
                    $data_vi = array(
                        'type_id' => $insert_id,
                        'language' => 'vi',
                        'title' => $this->input->post('title_vi')
                    );
                    $data_en = array(
                        'type_id' => $insert_id,
                        'language' => 'en',
                        'title' => $this->input->post('title_en')
                    );

                    $this->type_model->insert_with_language($data_vi, $data_en);

                    $this->session->set_flashdata('message', 'Type added successfully');
                } catch (Exception $e) {
                    $this->session->set_flashdata('message', 'There was an error inserting type: ' . $e->getMessage());
                }

                redirect('admin/type', 'refresh');
            }
        }
    }

    public function edit($id = NULL) {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('title_vi', 'Type name', 'trim|required');
        $this->form_validation->set_rules('title_en', 'Type name', 'trim|required');

        $type_id = isset($id) ? (int) $id : (int) $this->input->post('id');
        $type = $this->type_model->get_by_id($type_id);

        $type_title = explode('|', $type['type_title']);
        $type['title_en'] = $type_title[0];
        $type['title_vi'] = $type_title[1];

        if (!$type) {
            redirect('admin/type', 'refresh');
        }

        if ($this->form_validation->run() == FALSE) {
            $this->data['type'] = $type;
            $this->render('admin/type/edit_type_view');
        } else {
            if ($this->input->post()) {
                $data = array(
                    'updated_at' => $this->author_info['modified'],
                    'updated_by' => $this->author_info['modified_by']
                );

                try {
                    $this->type_model->update($type_id, $data);
                    $data_vi = array(
                        'type_id' => $type_id,
                        'language' => 'vi',
                        'title' => $this->input->post('title_vi')
                    );
                    $this->type_model->update_with_language_vi($type_id, $data_vi);

                    $data_en = array(
                        'type_id' => $type_id,
                        'language' => 'en',
                        'title' => $this->input->post('title_en')
                    );

                    $this->type_model->update_with_language_en($type_id, $data_en);

                    $this->session->set_flashdata('message', 'Type updated successfully');
                } catch (Exception $e) {
                    $this->session->set_flashdata('message', 'There was an error updating the type: ' . $e->getMessage());
                }

                redirect('admin/type', 'refresh');
            }
        }
    }

    public function delete($id = NULL) {
        $result = $this->type_model->get_by_id($id);

        if (!$result) {
            redirect('admin/type', 'refresh');
        }

        $set_delete = array('is_deleted' => 1);
        try {
            $this->type_model->remove($id, $set_delete);
            $this->session->set_flashdata('message', 'Item has deleted successful.');
        } catch (Exception $e) {
            $this->session->set_flashdata('message', 'Have error while delete item: ' . $e->getMessage());
        }
        redirect('admin/type', 'refresh');
    }

    public function delete_multiple(){
        $ids = $this->input->get('ids');
        return $this->delete_multiple_common('product_type', 'type_model', $ids);
    }

}
