<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends Public_Controller {

    private $_lang = '';

    public function __construct() {
        parent::__construct();
        $this->load->model('blog_model');
        $this->load->model('product_model');
        $this->load->model('physic_model');
        $this->data['lang'] = $this->session->userdata('langAbbreviation');
    }

    public function index() {
        $this->data['current_link'] = 'search';

        if ($this->input->get()) {
            $blog = $this->blog_model->search_article($this->input->get('text'), $this->data['lang']);
            $product = $this->product_model->search($this->input->get('text'), $this->data['lang']);
            $physic = $this->physic_model->search($this->input->get('text'), $this->data['lang']);
        }
        $this->data['result']['blogs'] = $blog;
        $this->data['result']['products'] = $product;
        $this->data['result']['physics'] = $physic;

        $this->render('search_view');
    }

}