<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Quotation extends Public_Controller {

    private $_lang = '';

    public function __construct() {
        parent::__construct();
        $this->load->model('quotation_model');
        $this->data['lang'] = $this->session->userdata('langAbbreviation');
    }

    public function index() {
        $this->data['current_link'] = 'quotation';
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('name', $this->lang->line('contact_name'), 'trim|required');
        $this->form_validation->set_rules('email', $this->lang->line('contact_email'), 'trim|required');
        $this->form_validation->set_rules('phone', $this->lang->line('contact_phone'), 'trim|required');
        $this->form_validation->set_rules('image', 'Image', 'callback_check_file_selected');
        $this->form_validation->set_rules('image', 'Image', 'callback_check_file_type');

        if ($this->form_validation->run() == FALSE) {
            $this->render('quotation_view');
        } else {
            if ($this->input->post()) {
                $image = $this->upload_image('image', $_FILES['image']['name'], 'assets/upload/quotation', 'assets/upload/quotation/thumb');

                $data = array(
                    'name' => $this->input->post('name'),
                    'phone' => $this->input->post('phone'),
                    'email' => $this->input->post('email'),
                    'content' => $this->input->post('content'),
                    'image' => $image,
                );

                $insert = $this->quotation_model->insert($data);
                if (!$insert) {
                    $this->session->set_flashdata('message', 'There was an error inserting item');
                }
                $this->session->set_flashdata('message', 'Đăng ký đã được gửi thành công');

                redirect('quotation', 'refresh');
            }
        }


    }

    function check_file_selected(){

        $this->form_validation->set_message('check_file_selected', 'Please select file.');
        if (empty($_FILES['image']['name'])) {
            return false;
        }else{
            return true;
        }
    }

    function check_file_type(){

        $this->form_validation->set_message('check_file_type', 'Wrong file type.');
        if ($_FILES['image']['type'] == 'image/png' || $_FILES['image']['type'] == 'image/jpg' || $_FILES['image']['type'] == 'image/jpeg') {
            return true;
        }else{
            return false;
        }
    }

}