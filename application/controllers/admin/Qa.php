<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Qa extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('qa_model');
        $this->load->library('session');
    }

    public function index() {
        if (count($_POST) > 0){
            $this->session->set_userdata('search_qa', $_POST );
            redirect('admin/qa/index');
        }else{
            if($this->session->userdata('search_qa')){
                $_POST = $this->session->userdata('search_qa');
//                $this->session->unset_userdata('search_qa');
            }
        }
        $keywords = '';
        if($this->input->post('search')){
            $keywords = $this->input->post('keywords');
        }
        $this->load->helper('form');
        $this->load->library('pagination');
        $base_url = base_url() . 'admin/qa/index';
        if($keywords != ''){
            $total_rows = $this->qa_model->count_search($keywords);
        }else{
            $total_rows = $this->qa_model->count_all();
        }
        $per_page = 10;
        $uri_segment = 4;

        $config = $this->pagination_config($base_url, $total_rows, $per_page, $uri_segment);
        $this->pagination->initialize($config);

        $this->data['page_links'] = $this->pagination->create_links();
        $this->data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

        $result = array();
        if($keywords != ''){
            $result = $this->qa_model->get_all_with_pagination_search($per_page, $this->data['page'], $keywords);
        }else{
            $result = $this->qa_model->get_all_with_pagination($per_page, $this->data['page']);
        }

        $output = array();
        foreach($result as $key => $value){
            $output[$key]['id'] = $value['id'];
            $output[$key]['data'] = $this->qa_model->get_by_id($value['id']);
        }
        $this->data['qas'] = $output;

        $this->render('admin/qa/list_qa_view');
    }

    public function reset(){
        $this->session->unset_userdata('search_qa');
        redirect('admin/qa', 'refresh');
    }

    public function create() {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('title_vi', 'Tiêu đề', 'required');
        $this->form_validation->set_rules('title_en', 'Title', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->render('admin/qa/create_qa_view');
        } else {
            if ($this->input->post()) {
                $data = array(
                    'created_at' => $this->author_info['created'],
                    'created_by' => $this->author_info['created_by'],
                    'updated_at' => $this->author_info['modified'],
                    'updated_by' => $this->author_info['modified_by']
                );

                try {
                    $insert_id = $this->qa_model->insert($data);
                    $data_vi = array(
                        'qa_id' => $insert_id,
                        'language' => 'vi',
                        'title' => $this->input->post('title_vi'),
                        'description' => $this->input->post('description_vi')
                    );
                    $data_en = array(
                        'qa_id' => $insert_id,
                        'language' => 'en',
                        'title' => $this->input->post('title_en'),
                        'description' => $this->input->post('description_en')
                    );

                    $this->qa_model->insert_with_language($data_vi, $data_en);

                    $this->session->set_flashdata('message', 'Item added successfully');
                } catch (Exception $e) {
                    $this->session->set_flashdata('message', 'There was an error insert iten: ' . $e->getMessage());
                }

                redirect('admin/qa', 'refresh');
            }
        }
    }

    public function edit($id = NULL) {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('title_vi', 'Tiêu đề', 'required');
        $this->form_validation->set_rules('title_en', 'Title', 'required');

        $input_id = isset($id) ? (int) $id : (int) $this->input->post('id');
        $result = $this->qa_model->get_by_id($input_id);

        if (!$result) {
            redirect('admin/qa', 'refresh');
        }

        // Title
        $title = explode('|||', $result['qa_title']);
        $result['title_en'] = $title[0];
        $result['title_vi'] = $title[1];

        // Description
        $description = explode('|||', $result['qa_description']);
        $result['description_en'] = $description[0];
        $result['description_vi'] = $description[1];

        if ($this->form_validation->run() == FALSE) {
            $this->data['qa'] = $result;
            $this->render('admin/qa/edit_qa_view');
        } else {
            if ($this->input->post()) {
                $data = array(
                    'updated_at' => $this->author_info['modified'],
                    'updated_by' => $this->author_info['modified_by']
                );

                try {
                    $this->qa_model->update($input_id, $data);
                    $data_vi = array(
                        'title' => $this->input->post('title_vi'),
                        'description' => $this->input->post('description_vi')
                    );
                    $this->qa_model->update_with_language_vi($input_id, $data_vi);

                    $data_en = array(
                        'title' => $this->input->post('title_en'),
                        'description' => $this->input->post('description_en')
                    );

                    $this->qa_model->update_with_language_en($input_id, $data_en);

                    $this->session->set_flashdata('message', 'Item updated successfully');
                } catch (Exception $e) {
                    $this->session->set_flashdata('message', 'There was an error updating the item: ' . $e->getMessage());
                }

                redirect('admin/qa', 'refresh');
            }
        }
    }

    public function delete() {
        $input = $this->input->get();
        $blog = $this->qa_model->get_by_id($input['id']);

        if (!$blog) {
            $this->output->set_status_header(404)
                ->set_output(json_encode(array('message' => 'Fail', 'data' => $input)));
        }

        $set_delete = array('is_deleted' => 1);
        $result = $this->qa_model->remove($input['id'], $set_delete);

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
        return $this->delete_multiple_common('qa', 'qa_model', $ids);
    }

}
