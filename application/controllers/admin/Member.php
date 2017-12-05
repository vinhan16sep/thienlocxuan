<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class member extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('member_model');
        $this->load->library('session');
    }

    public function index() {
        $this->load->helper('form');
        $this->load->library('pagination');
        $config = array();
        $base_url = base_url() . 'admin/member/index';
        $total_rows = $this->member_model->count_all();
        $per_page = 10;
        $uri_segment = 4;

        $config = $this->pagination_config($base_url, $total_rows, $per_page, $uri_segment);
        $this->pagination->initialize($config);

        $this->data['page_links'] = $this->pagination->create_links();
        $this->data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

        $result = $this->member_model->get_all_with_pagination($per_page, $this->data['page']);

        $output = array();
        foreach($result as $key => $value){
            $output[$key]['id'] = $value['id'];
            if($value['role'] == 0){
                $output[$key]['role'] = 'Giám đốc';
            }elseif($value['role'] == 1){
                $output[$key]['role'] = 'Phó giám đốc';
            }else{
                $output[$key]['role'] = 'Nhân viên';
            }
            $output[$key]['data'] = $this->member_model->get_by_id($value['id']);
        }
        $this->data['members'] = $output;

        $this->render('admin/member/list_member_view');
    }

    public function create() {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('name_vi', 'member name', 'trim|required');
        $this->form_validation->set_rules('name_en', 'member name', 'trim|required');
        $this->form_validation->set_rules('role', 'Chức vụ', 'callback_check_existing_director');

        if ($this->form_validation->run() == FALSE) {
            $this->render('admin/member/create_member_view');
        } else {
            if ($this->input->post()) {
                $image = $this->upload_image('image', $_FILES['image']['name'], 'assets/upload/member', 'assets/upload/member/thumb');
                $data = array(
                    'role' => $this->input->post('role'),
                    'image' => $image,
                    'created_at' => $this->author_info['created'],
                    'created_by' => $this->author_info['created_by'],
                    'modified_at' => $this->author_info['modified'],
                    'modified_by' => $this->author_info['modified_by']
                );

                try {
                    $insert_id = $this->member_model->insert($data);
                    $data_vi = array(
                        'member_id' => $insert_id,
                        'language' => 'vi',
                        'name' => $this->input->post('name_vi'),
                        'bio' => $this->input->post('bio_vi')
                    );
                    $data_en = array(
                        'member_id' => $insert_id,
                        'language' => 'en',
                        'name' => $this->input->post('name_en'),
                        'bio' => $this->input->post('bio_en')
                    );

                    $this->member_model->insert_with_language($data_vi, $data_en);

                    $this->session->set_flashdata('message', 'member added successfully');
                } catch (Exception $e) {
                    $this->session->set_flashdata('message', 'There was an error inserting member: ' . $e->getMessage());
                }

                redirect('admin/member', 'refresh');
            }
        }
    }

    public function edit($id = NULL) {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('name_vi', 'member name', 'trim|required');
        $this->form_validation->set_rules('name_en', 'member name', 'trim|required');

        $member_id = isset($id) ? (int) $id : (int) $this->input->post('id');
        $member = $this->member_model->get_by_id($member_id);

        if (!$member) {
            redirect('admin/member', 'refresh');
        }

        $name = explode('|', $member['member_name']);
        $member['name_en'] = isset($name[0]) ? $name[0] : '';
        $member['name_vi'] = isset($name[1]) ? $name[1] : '';

        $bio = explode('|', $member['member_bio']);
        $member['bio_en'] = isset($bio[0]) ? $bio[0] : '';
        $member['bio_vi'] = isset($bio[1]) ? $bio[1] : '';

        if ($this->form_validation->run() == FALSE) {
            $this->data['member'] = $member;
            $this->render('admin/member/edit_member_view');
        } else {
            if ($this->input->post()) {
                $image = $this->upload_image('image', $_FILES['image']['name'], 'assets/upload/member', 'assets/upload/member/thumb');
                $data = array(
                    'role' => $this->input->post('role'),
                    'image' => $image,
                    'modified_at' => $this->author_info['modified'],
                    'modified_by' => $this->author_info['modified_by']
                );

                if ($image == '') {
                    unset($data['image']);
                }

                try {
                    $this->member_model->update($member_id, $data);
                    $data_vi = array(
                        'name' => $this->input->post('name_vi'),
                        'bio' => $this->input->post('bio_vi')
                    );
                    $this->member_model->update_with_language_vi($member_id, $data_vi);

                    $data_en = array(
                        'name' => $this->input->post('name_en'),
                        'bio' => $this->input->post('bio_en')
                    );

                    $this->member_model->update_with_language_en($member_id, $data_en);

                    $this->session->set_flashdata('message', 'member updated successfully');
                } catch (Exception $e) {
                    $this->session->set_flashdata('message', 'There was an error updating the member: ' . $e->getMessage());
                }

                redirect('admin/member', 'refresh');
            }
        }
    }

    public function delete() {
        $input = $this->input->get();
        $blog = $this->member_model->get_by_id($input['id']);

        if (!$blog) {
            $this->output->set_status_header(404)
                ->set_output(json_encode(array('message' => 'Fail', 'data' => $input)));
        }

        $set_delete = array('is_deleted' => 1);
        $result = $this->member_model->remove($input['id'], $set_delete);

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
        return $this->delete_multiple_common('product_member', 'member_model', $ids);
    }

    function check_existing_director(){
        $this->form_validation->set_message('check_existing_director', 'Chỉ được phép có 1 giám đốc');
        $exist = $this->member_model->check_exist();
        if ($this->input->post('role') == 0 && $exist) {
            return false;
        }else{
            return true;
        }
    }

}
