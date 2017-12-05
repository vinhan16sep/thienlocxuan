<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends Public_Controller {

    private $_lang = '';

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('product_model');
        $this->load->model('type_model');
        $this->load->model('group_model');
        $this->_lang = $this->session->userdata('langAbbreviation');
    }

    public function index() {
        $this->data['current_link'] = 'list_product';
        $this->data['lang'] = $this->_lang;
        $this->data['types'] = $this->type_model->get_all_by_language($this->_lang);
        $this->data['groups'] = $this->group_model->get_all_by_language($this->_lang);
        $this->data['products'] = $this->product_model->get_all_by_language($this->_lang);

        $this->render('product_view');
    }

    public function detail($id = null){
        $product_id = isset($id) ? (int) $id : (int) $this->input->post('id');
        $this->data['current_link'] = 'product_detail';
        $this->data['product_id'] = $product_id;
        $this->data['product'] = $this->product_model->get_by_id($product_id, $this->_lang);

        $group = $this->group_model->get_by_language($this->data['product']['group_id'], $this->_lang);
        $this->data['product']['group_name'] = $group['title'];

        if (!$this->data['product']) {
            redirect('', 'refresh');
        }

        $this->render('detail_product_view');
    }
    
    public function filter_product(){
        $params = $this->input->get();

        $result = $this->product_model->filter($this->_lang, $params);

        $this->output->set_output(json_encode($result));
    }

}
