<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class History extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('history_model');
        $this->load->library('session');
    }

    public function index() {
        $this->load->helper('form');
        $this->load->library('pagination');
        $config = array();
        $base_url = base_url() . 'admin/history/index';
        $total_rows = $this->history_model->count_all();
        $per_page = 10;
        $uri_segment = 4;

        $config = $this->pagination_config($base_url, $total_rows, $per_page, $uri_segment);
        $this->pagination->initialize($config);

        $this->data['page_links'] = $this->pagination->create_links();
        $this->data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

        $result = $this->history_model->get_all_with_pagination($per_page, $this->data['page']);

        $output = array();
        foreach($result as $key => $value){
            $output[$key]['id'] = $value['id'];
            $output[$key]['year'] = $value['year'];
            $output[$key]['data'] = $this->history_model->get_by_id($value['id']);
        }
        $this->data['histories'] = $output;

        $this->render('admin/history/list_history_view');
    }

    public function create() {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('year', 'History name', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $this->render('admin/history/create_history_view');
        } else {
            if ($this->input->post()) {
                $data = array(
                    'year' => $this->input->post('year'),
                    'created_at' => $this->author_info['created'],
                    'created_by' => $this->author_info['created_by'],
                    'modified_at' => $this->author_info['modified'],
                    'modified_by' => $this->author_info['modified_by']
                );

                try {
                    $insert_id = $this->history_model->insert($data);
                    $data_vi = array(
                        'history_id' => $insert_id,
                        'language' => 'vi',
                        'content' => $this->input->post('content_vi')
                    );
                    $data_en = array(
                        'history_id' => $insert_id,
                        'language' => 'en',
                        'content' => $this->input->post('content_en')
                    );

                    $this->history_model->insert_with_language($data_vi, $data_en);

                    $this->session->set_flashdata('message', 'history added successfully');
                } catch (Exception $e) {
                    $this->session->set_flashdata('message', 'There was an error inserting history: ' . $e->getMessage());
                }

                redirect('admin/history', 'refresh');
            }
        }
    }

    public function edit($id = NULL) {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('year', 'History name', 'trim|required');

        $input_id = isset($id) ? (int) $id : (int) $this->input->post('id');
        $result = $this->history_model->get_by_id($input_id);

        if (!$result) {
            redirect('admin/history', 'refresh');
        }

        // Content
        $content = explode('|||', $result['history_content']);
        $result['content_en'] = isset($content[0]) ? $content[0] : '';
        $result['content_vi'] = isset($content[1]) ? $content[1] : '';

        if ($this->form_validation->run() == FALSE) {
            $this->data['history'] = $result;
            $this->render('admin/history/edit_history_view');
        } else {
            if ($this->input->post()) {
                $data = array(
                    'year' => $this->input->post('year'),
                    'modified_at' => $this->author_info['modified'],
                    'modified_by' => $this->author_info['modified_by']
                );

                try {
                    $this->history_model->update($input_id, $data);
                    $data_vi = array(
                        'history_id' => $input_id,
                        'language' => 'vi',
                        'content' => $this->input->post('content_vi')
                    );
                    $this->history_model->update_with_language_vi($input_id, $data_vi);

                    $data_en = array(
                        'history_id' => $input_id,
                        'language' => 'en',
                        'content' => $this->input->post('content_en')
                    );
                    $this->history_model->update_with_language_en($input_id, $data_en);

                    $this->session->set_flashdata('message', 'Item added successfully');
                } catch (Exception $e) {
                    $this->session->set_flashdata('message', 'There was an error update item: ' . $e->getMessage());
                }

                redirect('admin/history', 'refresh');
            }
        }
    }

    public function delete() {
        $input = $this->input->get();
        $blog = $this->history_model->get_by_id($input['id']);

        if (!$blog) {
            $this->output->set_status_header(404)
                ->set_output(json_encode(array('message' => 'Fail', 'data' => $input)));
        }

        $set_delete = array('is_deleted' => 1);
        $result = $this->history_model->remove($input['id'], $set_delete);

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
        return $this->delete_multiple_common('history', 'history_model', $ids);
    }
}
