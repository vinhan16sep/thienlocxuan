<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Group extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('group_model');
        $this->load->library('session');
    }

    public function index() {
        $this->load->helper('form');
        $this->load->library('pagination');
        $config = array();
        $base_url = base_url() . 'admin/group/index';
        $total_rows = $this->group_model->count_all();
        $per_page = 10;
        $uri_segment = 4;
        foreach ($this->pagination_config($base_url, $total_rows, $per_page, $uri_segment) as $key => $value) {
            $config[$key] = $value;
        }
        $this->pagination->initialize($config);

        $this->data['page_links'] = $this->pagination->create_links();
        $this->data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $this->data['group'] = $this->group_model->get_all_with_pagination($per_page, $this->data['page']);

        $this->render('admin/group/list_group_view');
    }

    public function create() {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('title_vi', 'Group name', 'trim|required');
        $this->form_validation->set_rules('title_en', 'Group name', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $this->render('admin/group/create_group_view');
        } else {
            if ($this->input->post()) {
                $data = array(
                    'created_at' => $this->author_info['created'],
                    'created_by' => $this->author_info['created_by'],
                    'updated_at' => $this->author_info['modified'],
                    'updated_by' => $this->author_info['modified_by']
                );

                try {
                    $insert_id = $this->group_model->insert($data);
                    $data_vi = array(
                        'group_id' => $insert_id,
                        'language' => 'vi',
                        'title' => $this->input->post('title_vi')
                    );
                    $data_en = array(
                        'group_id' => $insert_id,
                        'language' => 'en',
                        'title' => $this->input->post('title_en')
                    );

                    $this->group_model->insert_with_language($data_vi, $data_en);

                    $this->session->set_flashdata('message', 'Group added successfully');
                } catch (Exception $e) {
                    $this->session->set_flashdata('message', 'There was an error inserting group: ' . $e->getMessage());
                }

                redirect('admin/group', 'refresh');
            }
        }
    }

    public function edit($id = NULL) {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('title_vi', 'Group name', 'trim|required');
        $this->form_validation->set_rules('title_en', 'Group name', 'trim|required');

        $group_id = isset($id) ? (int) $id : (int) $this->input->post('id');
        $group = $this->group_model->get_by_id($group_id);

        if (!$group) {
            redirect('admin/group', 'refresh');
        }

        $group_title = explode('|', $group['group_title']);
        $group['title_en'] = $group_title[0];
        $group['title_vi'] = $group_title[1];

        if ($this->form_validation->run() == FALSE) {
            $this->data['group'] = $group;
            $this->render('admin/group/edit_group_view');
        } else {
            if ($this->input->post()) {
                $data = array(
                    'updated_at' => $this->author_info['modified'],
                    'updated_by' => $this->author_info['modified_by']
                );

                try {
                    $this->group_model->update($group_id, $data);
                    $data_vi = array(
                        'group_id' => $group_id,
                        'language' => 'vi',
                        'title' => $this->input->post('title_vi')
                    );
                    $this->group_model->update_with_language_vi($group_id, $data_vi);

                    $data_en = array(
                        'group_id' => $group_id,
                        'language' => 'en',
                        'title' => $this->input->post('title_en')
                    );

                    $this->group_model->update_with_language_en($group_id, $data_en);

                    $this->session->set_flashdata('message', 'Group updated successfully');
                } catch (Exception $e) {
                    $this->session->set_flashdata('message', 'There was an error updating the group: ' . $e->getMessage());
                }

                redirect('admin/group', 'refresh');
            }
        }
    }

    public function delete($id = NULL) {
        $result = $this->group_model->get_by_id($id);

        if (!$result) {
            redirect('admin/group', 'refresh');
        }

        $set_delete = array('is_deleted' => 1);
        try {
            $this->group_model->remove($id, $set_delete);
            $this->session->set_flashdata('message', 'Item has deleted successful.');
        } catch (Exception $e) {
            $this->session->set_flashdata('message', 'Have error while delete item: ' . $e->getMessage());
        }
        redirect('admin/group', 'refresh');
    }

    public function delete_multiple(){
        $ids = $this->input->get('ids');
        return $this->delete_multiple_common('product_group', 'group_model', $ids);
    }

}
