<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Process extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('banners_model');
        $this->load->model('process_en_model');
        $this->load->library('session');
    }

    public function index() {
        $this->load->library('pagination');
        $this->load->helper('form');
        if ($this->input->post('checkbox')) {

            $ids = array_keys($this->input->post('checkbox'));
            foreach ($ids as $id){
                $banner = $this->banners_model->get_banner_by_id($id);

                if (!$banner) {
                    redirect('admin/process', 'refresh');
                }

                $set_delete = array('is_delete' => 1);
                try {
                    $this->banners_model->delete_banner($id, $set_delete);
                    $this->session->set_flashdata('message', 'Item has deleted successful.');
                } catch (Exception $e) {
                    $this->session->set_flashdata('message', 'Have error while delete item: ' . $e->getMessage());
                }
                redirect('admin/process', 'refresh');
            }
        }
        $config = array();
        $base_url = base_url() . 'admin/banners/index';
        $total_rows = 1;
        $total_rows = $this->banners_model->count_banners();
        $per_page = 10;
        $uri_segment = 4;
        foreach ($this->pagination_config($base_url, $total_rows, $per_page, $uri_segment) as $key => $value) {
            $config[$key] = $value;
        }
        $this->pagination->initialize($config);

        $this->data['page_links'] = $this->pagination->create_links();
        $this->data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $this->data['Process'] = $this->banners_model->get_all_banner_en_by_paging($per_page, $this->data['page']);

        $this->render('admin/banners/list_banners_view');
    }

    public function create() {
        $this->load->helper('form');

        if ($this->input->post()) {
        $banner_data = array(
            'title' => $this->input->post('title'),
            'content' => $this->input->post('description')
        );

        $banner_data_en = array(
            'title' => $this->input->post('title_en'),
            'content' => $this->input->post('description_en')
        );

        try {
            $this->banners_model->insert_banner($banner_data);
            $process_id = $this->banners_model->get_last_id();
            $process_id = $process_id ? intval($process_id['id']) : 0;
            if($process_id){
                $banner_data_en['process_id'] = $process_id;
                $this->process_en_model->insert_banner($banner_data_en);
            }
            $this->session->set_flashdata('message', 'Process added successfully');
        } catch (Exception $e) {
            $this->session->set_flashdata('message', 'There was an error inserting Process ' . $e->getMessage());
        }

        redirect('admin/process', 'refresh');
        }
        $this->render('admin/banners/create_banner_view');
    }
    public function edit($id) {
        $this->load->helper('form');
        $id = intval($id);
        if(empty($id)){
            redirect('admin/process', 'refresh');
        }
        $this->data['Process'] = $this->banners_model->get_process_by_process_id($id);
        if ($this->input->post()) {
            $banner_data = array(
                'title' => $this->input->post('title'),
                'content' => $this->input->post('description')
            );

            $banner_data_en = array(
                'title' => $this->input->post('title_en'),
                'content' => $this->input->post('description_en')
            );

            try {
                $this->banners_model->update_process($id,$banner_data);

                $process_en = $this->process_en_model->get_banner_by_id($id);
                if(!empty($process_en)){
                    $this->process_en_model->update_process_en($id,$banner_data_en);
                }else{
                    $banner_data_en['process_id'] = $id;
                    $this->process_en_model->insert_banner($banner_data_en);
                }
                $this->session->set_flashdata('message', 'Process added successfully');
            } catch (Exception $e) {
                $this->session->set_flashdata('message', 'There was an error inserting Process ' . $e->getMessage());
            }

            redirect('admin/process', 'refresh');
        }
        $this->render('admin/banners/edit_banner_view');
    }


}
