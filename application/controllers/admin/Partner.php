<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Partner extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('partner_model');
        $this->load->library('session');
    }

    public function index() {
        $this->load->helper('form');
        $this->load->library('pagination');
        $base_url = base_url() . 'admin/partner/index';
        $total_rows = $this->partner_model->count_all();
        $per_page = 10;
        $uri_segment = 4;

        $config = $this->pagination_config($base_url, $total_rows, $per_page, $uri_segment);
        $this->pagination->initialize($config);

        $this->data['page_links'] = $this->pagination->create_links();
        $this->data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

        $result = $this->partner_model->get_all_with_pagination($per_page, $this->data['page']);

        $output = array();
        foreach($result as $key => $value){
            $output[$key]['id'] = $value['id'];
            $output[$key]['data'] = $this->partner_model->get_by_id($value['id']);
        }
        $this->data['partners'] = $output;

        $this->render('admin/partner/list_partner_view');
    }

    public function create() {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('name_vi', 'Tiêu đề', 'required');
        $this->form_validation->set_rules('name_en', 'Title', 'required');
        $this->form_validation->set_rules('partner', 'Partner', 'callback_file_selected_test');

        if ($this->form_validation->run() == FALSE) {
            $this->render('admin/partner/create_partner_view');
        } else {
            if ($this->input->post()) {
                $image = $this->upload_image('partner', $_FILES['partner']['name'], 'assets/upload/partner', 'assets/upload/partner/thumb');
                $data = array(
                    'url' => $this->input->post('url'),
                    'image' => $image,
                    'created_at' => $this->author_info['created'],
                    'created_by' => $this->author_info['created_by'],
                    'updated_at' => $this->author_info['modified'],
                    'updated_by' => $this->author_info['modified_by']
                );

                try {
                    $insert_id = $this->partner_model->insert($data);
                    $data_vi = array(
                        'partner_id' => $insert_id,
                        'language' => 'vi',
                        'name' => $this->input->post('name_vi'),
                        'description' => $this->input->post('description_vi'),
                    );
                    $data_en = array(
                        'partner_id' => $insert_id,
                        'language' => 'en',
                        'name' => $this->input->post('name_en'),
                        'description' => $this->input->post('description_en'),
                    );

                    $this->partner_model->insert_with_language($data_vi, $data_en);

                    $this->session->set_flashdata('message', 'Item added successfully');
                } catch (Exception $e) {
                    $this->session->set_flashdata('message', 'There was an error inserting item: ' . $e->getMessage());
                }

                redirect('admin/partner', 'refresh');
            }
        }
    }

    public function edit($id = NULL) {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('name_vi', 'Tiêu đề', 'required');
        $this->form_validation->set_rules('name_en', 'Title', 'required');

        $input_id = isset($id) ? (int) $id : (int) $this->input->post('id');
        $result = $this->partner_model->get_by_id($input_id);

        if (!$result) {
            redirect('admin/partner', 'refresh');
        }

        // Title
        $title = explode('|||', $result['partner_name']);
        $result['name_en'] = $title[0];
        $result['name_vi'] = $title[1];

        // Description
        $description = explode('|||', $result['partner_description']);
        $result['description_en'] = $description[0];
        $result['description_vi'] = $description[1];

        if ($this->form_validation->run() == FALSE) {
            $this->data['partner'] = $result;
            $this->render('admin/partner/edit_partner_view');
        } else {
            if ($this->input->post()) {
                $image = $this->upload_image('partner', $_FILES['partner']['name'], 'assets/upload/partner', 'assets/upload/partner/thumb');
                $data = array(
                    'url' => $this->input->post('url'),
                    'image' => $image,
                    'updated_at' => $this->author_info['modified'],
                    'updated_by' => $this->author_info['modified_by']
                );

                if ($image == '') {
                    unset($data['description_image']);
                }

                try {
                    $this->partner_model->update($input_id, $data);
                    $data_vi = array(
                        'name' => $this->input->post('name_vi'),
                        'description' => $this->input->post('description_vi'),
                    );
                    $this->partner_model->update_with_language_vi($input_id, $data_vi);

                    $data_en = array(
                        'name' => $this->input->post('name_en'),
                        'description' => $this->input->post('description_en'),
                    );

                    $this->partner_model->update_with_language_en($input_id, $data_en);

                    $this->session->set_flashdata('message', 'Item updated successfully');
                } catch (Exception $e) {
                    $this->session->set_flashdata('message', 'There was an error updating the item: ' . $e->getMessage());
                }

                redirect('admin/partner', 'refresh');
            }
        }
    }

    public function delete() {
        $input = $this->input->get();
        $blog = $this->partner_model->get_by_id($input['id']);

        if (!$blog) {
            $this->output->set_status_header(404)
                ->set_output(json_encode(array('message' => 'Fail', 'data' => $input)));
        }

        $set_delete = array('is_deleted' => 1);
        $result = $this->partner_model->remove($input['id'], $set_delete);

        if($result == false){
            $this->output->set_status_header(404)
                ->set_output(json_encode(array('message' => 'Fail', 'data' => $input)));
        }else{
            $this->output->set_status_header(200)
                ->set_output(json_encode(array('message' => 'Success', 'data' => $input)));
        }
    }

    public function delete_multiple(){
        $ids = $this->input->get('ids');
        return $this->delete_multiple_common('partner', 'partner_model', $ids);
    }

    function file_selected_test(){

        $this->form_validation->set_message('file_selected_test', 'Please select file.');
        if (empty($_FILES['partner']['name'])) {
            return false;
        }else{
            return true;
        }
    }

}
