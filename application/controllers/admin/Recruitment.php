<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Recruitment extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('recruitment_model');
        $this->load->library('session');
    }

    public function index() {
        if (count($_POST) > 0){
            $this->session->set_userdata('search_recruitment', $_POST );
            redirect('admin/recruitment/index');
        }else{
            if($this->session->userdata('search_recruitment')){
                $_POST = $this->session->userdata('search_recruitment');
//                $this->session->unset_userdata('search_recruitment');
            }
        }
        $keywords = '';
        if($this->input->post('search')){
            $keywords = $this->input->post('keywords');
        }
        $this->load->helper('form');
        $this->load->library('pagination');
        $base_url = base_url() . 'admin/recruitment/index';
        if($keywords != ''){
            $total_rows = $this->recruitment_model->count_search($keywords);
        }else{
            $total_rows = $this->recruitment_model->count_all();
        }
        $per_page = 10;
        $uri_segment = 4;

        $config = $this->pagination_config($base_url, $total_rows, $per_page, $uri_segment);
        $this->pagination->initialize($config);

        $this->data['page_links'] = $this->pagination->create_links();
        $this->data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

        $result = array();
        if($keywords != ''){
            $result = $this->recruitment_model->get_all_with_pagination_search($per_page, $this->data['page'], $keywords);
        }else{
            $result = $this->recruitment_model->get_all_with_pagination($per_page, $this->data['page']);
        }

        $output = array();
        foreach($result as $key => $value){
            $output[$key]['id'] = $value['id'];
            if($value['status'] == 0){
                $output[$key]['status'] = 'Hết hạn';
            }else{
                $output[$key]['status'] = 'Đang tuyển';
            }
            $output[$key]['data'] = $this->recruitment_model->get_by_id($value['id']);
        }
        $this->data['recruitments'] = $output;

        $this->render('admin/recruitment/list_recruitment_view');
    }

    public function reset(){
        $this->session->unset_userdata('search_recruitment');
        redirect('admin/recruitment', 'refresh');
    }

    public function create() {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('title_vi', 'Tiêu đề', 'required');
        $this->form_validation->set_rules('title_en', 'Title', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->render('admin/recruitment/create_recruitment_view');
        } else {
            if ($this->input->post()) {
                $image = $this->upload_image('picture', $_FILES['picture']['name'], 'assets/upload/recruitment', 'assets/upload/recruitment/thumbs');
                $data = array(
                    'status' => $this->input->post('status'),
                    'description_image' => $image,
                    'created_at' => $this->author_info['created'],
                    'created_by' => $this->author_info['created_by'],
                    'updated_at' => $this->author_info['modified'],
                    'updated_by' => $this->author_info['modified_by']
                );

                try {
                    $insert_id = $this->recruitment_model->insert($data);
                    $data_vi = array(
                        'recruitment_id' => $insert_id,
                        'language' => 'vi',
                        'title' => $this->input->post('title_vi'),
                        'description' => $this->input->post('description_vi'),
                        'content' => $this->input->post('content_vi')
                    );
                    $data_en = array(
                        'recruitment_id' => $insert_id,
                        'language' => 'en',
                        'title' => $this->input->post('title_en'),
                        'description' => $this->input->post('description_en'),
                        'content' => $this->input->post('content_en')
                    );

                    $this->recruitment_model->insert_with_language($data_vi, $data_en);

                    $this->session->set_flashdata('message', 'Product added successfully');
                } catch (Exception $e) {
                    $this->session->set_flashdata('message', 'There was an error inserting product: ' . $e->getMessage());
                }

                redirect('admin/recruitment', 'refresh');
            }
        }
    }

    public function edit($id = NULL) {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('title_vi', 'Tiêu đề', 'required');
        $this->form_validation->set_rules('title_en', 'Title', 'required');

        $input_id = isset($id) ? (int) $id : (int) $this->input->post('id');
        $result = $this->recruitment_model->get_by_id($input_id);

        if (!$result) {
            redirect('admin/recruitment', 'refresh');
        }

        // Title
        $title = explode('|||', $result['recruitment_title']);
        $result['title_en'] = $title[0];
        $result['title_vi'] = $title[1];

        // Description
        $description = explode('|||', $result['recruitment_description']);
        $result['description_en'] = $description[0];
        $result['description_vi'] = $description[1];

        // Content
        $content = explode('|||', $result['recruitment_content']);
        $result['content_en'] = $content[0];
        $result['content_vi'] = $content[1];

        if ($this->form_validation->run() == FALSE) {
            $this->data['recruitment'] = $result;
            $this->render('admin/recruitment/edit_recruitment_view');
        } else {
            if ($this->input->post()) {
                $image = $this->upload_image('picture', $_FILES['picture']['name'], 'assets/upload/recruitment', 'assets/upload/recruitment/thumbs');
                $data = array(
                    'status' => $this->input->post('status'),
                    'description_image' => $image,
                    'updated_at' => $this->author_info['modified'],
                    'updated_by' => $this->author_info['modified_by']
                );

                if ($image == '') {
                    unset($data['description_image']);
                }

                try {
                    $this->recruitment_model->update($input_id, $data);
                    $data_vi = array(
                        'title' => $this->input->post('title_vi'),
                        'description' => $this->input->post('description_vi'),
                        'content' => $this->input->post('content_vi')
                    );
                    $this->recruitment_model->update_with_language_vi($input_id, $data_vi);

                    $data_en = array(
                        'title' => $this->input->post('title_en'),
                        'description' => $this->input->post('description_en'),
                        'content' => $this->input->post('content_en')
                    );

                    $this->recruitment_model->update_with_language_en($input_id, $data_en);

                    $this->session->set_flashdata('message', 'Item updated successfully');
                } catch (Exception $e) {
                    $this->session->set_flashdata('message', 'There was an error updating the item: ' . $e->getMessage());
                }

                redirect('admin/recruitment', 'refresh');
            }
        }
    }

    public function delete() {
        $input = $this->input->get();
        $blog = $this->recruitment_model->get_by_id($input['id']);

        if (!$blog) {
            $this->output->set_status_header(404)
                ->set_output(json_encode(array('message' => 'Fail', 'data' => $input)));
        }

        $set_delete = array('is_deleted' => 1);
        $result = $this->recruitment_model->remove($input['id'], $set_delete);

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
        return $this->delete_multiple_common('recruitment', 'recruitment_model', $ids);
    }

}
