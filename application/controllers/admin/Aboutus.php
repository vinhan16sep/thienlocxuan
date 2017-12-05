<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Aboutus extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('aboutus_model');
        $this->load->library('session');
    }

    public function index() {
        $this->load->library('pagination');
        $config = array();
        $base_url = base_url() . 'admin/aboutus/index';
        $total_rows = $this->aboutus_model->count_all();
        $per_page = 10;
        $uri_segment = 4;
        foreach ($this->pagination_config($base_url, $total_rows, $per_page, $uri_segment) as $key => $value) {
            $config[$key] = $value;
        }
        $this->pagination->initialize($config);

        $this->data['page_links'] = $this->pagination->create_links();
        $this->data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $this->data['aboutus'] = $this->aboutus_model->get_all_with_pagination($per_page, $this->data['page']);

        $this->render('admin/aboutus/list_aboutus_view');
    }

    public function edit($id = null) {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('title_vi', 'Title', 'trim|required');
        $this->form_validation->set_rules('title_en', 'Title', 'trim|required');

        $result = $this->aboutus_model->get_by_id($id);

        if (!$result) {
            redirect('admin/aboutus', 'refresh');
        }

        // Title
        $title = explode('|||', $result['aboutus_title']);
        $result['title_en'] = $title[0];
        $result['title_vi'] = $title[1];

        // Content
        $content = explode('|||', $result['aboutus_content']);
        $result['content_en'] = isset($content[0]) ? $content[0] : '';
        $result['content_vi'] = isset($content[1]) ? $content[1] : '';

        if($this->form_validation->run() == FALSE){
            $this->data['aboutus'] = $result;
            $this->render('admin/aboutus/edit_aboutus_view');
        }else {
            if ($this->input->post()) {
                $data = array(
                    'modified_at' => $this->author_info['modified'],
                    'modified_by' => $this->author_info['modified_by']
                );

                try {
                    $this->aboutus_model->update($id, $data);
                    $data_vi = array(
                        'title' => $this->input->post('title_vi'),
                        'content' => $this->input->post('content_vi'),
                    );
                    $this->aboutus_model->update_with_language_vi($id, $data_vi);

                    $data_en = array(
                        'title' => $this->input->post('title_en'),
                        'content' => $this->input->post('content_en'),
                    );
                    $this->aboutus_model->update_with_language_en($id, $data_en);

                    $this->session->set_flashdata('message', 'Item added successfully');
                } catch (Exception $e) {
                    $this->session->set_flashdata('message', 'There was an error update item: ' . $e->getMessage());
                }

                redirect('admin/aboutus', 'refresh');
            }
        }
    }

}
