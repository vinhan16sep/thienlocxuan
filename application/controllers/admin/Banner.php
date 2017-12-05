<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Banner extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('banner_model');
        $this->load->library('session');
    }

    public function index() {
        $this->load->library('pagination');
        $config = array();
        $base_url = base_url() . 'admin/banner/index';
        $total_rows = $this->banner_model->count_all();
        $per_page = 10;
        $uri_segment = 4;
        foreach ($this->pagination_config($base_url, $total_rows, $per_page, $uri_segment) as $key => $value) {
            $config[$key] = $value;
        }
        $this->pagination->initialize($config);

        $this->data['page_links'] = $this->pagination->create_links();
        $this->data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

        $this->data['banners'] = $this->banner_model->get_all_with_pagination($per_page, $this->data['page']);

        $this->render('admin/banner/list_banner_view');
    }

     public function create() {
         $this->load->helper('form');
         $this->load->library('form_validation');

         $this->form_validation->set_rules('banner', 'Banner', 'callback_file_selected_test');

         if ($this->form_validation->run() == FALSE) {
             $this->render('admin/banner/create_banner_view');
         } else {
             if ($this->input->post()) {
//                 $active = $this->input->post('is_actived',TRUE) == null ? 0 : 1;
                 $image = $this->upload_image('banner', $_FILES['banner']['name'], 'assets/upload/banner', 'assets/upload/banner/thumb');
                 $data = array(
                     'image' => $image,
//                     'is_actived' => $active,
                     'text' => $this->input->post('text'),
                     'url' => $this->input->post('url'),
                     'created_at' => $this->author_info['created'],
                     'created_by' => $this->author_info['created_by'],
                     'modified_at' => $this->author_info['modified'],
                     'modified_by' => $this->author_info['modified_by']
                 );

                 try {
                     $this->banner_model->insert($data);

                     $this->session->set_flashdata('message', 'Item added successfully');
                 } catch (Exception $e) {
                     $this->session->set_flashdata('message', 'There was an error inserting item: ' . $e->getMessage());
                 }

                 redirect('admin/banner', 'refresh');
             }
         }
     }

    function file_selected_test(){

        $this->form_validation->set_message('file_selected_test', 'Please select file.');
        if (empty($_FILES['banner']['name'])) {
            return false;
        }else{
            return true;
        }
    }

    public function delete() {
        $id = $this->input->get('id');

        $result = $this->banner_model->get_by_id($id);

        if (!$result) {
            redirect('admin/banner', 'refresh');
        }

        try {
            $this->banner_model->remove($id);

            $image = explode('.', $result['image']);
            $thumbnail = $image[0] . '_thumb.' . $image[1];
            unlink('assets/upload/banner/' . $result['image']);
            unlink('assets/upload/banner/thumb/' . $thumbnail);

            $this->output
                ->set_status_header(200)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode($result));
        } catch (Exception $e) {
            $this->output
                ->set_status_header(404)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode($result));
        }
    }

}
