<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cover extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('cover_model');
        $this->load->library('session');
    }

    public function index() {
        $this->load->library('pagination');
        $config = array();
        $base_url = base_url() . 'admin/cover/index';
        $total_rows = $this->cover_model->count_all();
        $per_page = 10;
        $uri_segment = 4;
        foreach ($this->pagination_config($base_url, $total_rows, $per_page, $uri_segment) as $key => $value) {
            $config[$key] = $value;
        }
        $this->pagination->initialize($config);

        $this->data['page_links'] = $this->pagination->create_links();
        $this->data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

        $this->data['covers'] = $this->cover_model->get_all_with_pagination($per_page, $this->data['page']);

        $this->render('admin/cover/list_cover_view');
    }

    public function edit($id = NULL) {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('text', 'Text', 'trim|required');

        $id = isset($id) ? (int) $id : (int) $this->input->post('id');
        $cover = $this->cover_model->get_by_id($id);

        if (!$cover) {
            redirect('admin/cover', 'refresh');
        }

        if ($this->form_validation->run() == FALSE) {
            $this->data['cover'] = $cover;
            $this->render('admin/cover/edit_cover_view');
        } else {
            if ($this->input->post()) {
                $image = $this->upload_image('cover', $_FILES['cover']['name'], 'assets/upload/cover', 'assets/upload/cover/thumb');
                $data = array(
                    'text' => $this->input->post('text'),
                    'image' => $image,
                );
                if ($image == '') {
                    unset($data['image']);
                }

                try {
                    $this->cover_model->update($id, $data);
                    $this->session->set_flashdata('message', 'Item updated successfully');
                } catch (Exception $e) {
                    $this->session->set_flashdata('message', 'There was an error updating item: ' . $e->getMessage());
                }

                redirect('admin/cover', 'refresh');
            }
        }
    }
}
