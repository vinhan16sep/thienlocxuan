<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Partner extends Public_Controller {

    private $_lang = '';

    public function __construct() {
        parent::__construct();
        $this->load->model('partner_model');
        $this->data['lang'] = $this->session->userdata('langAbbreviation');
    }

    public function index() {
        $this->data['current_link'] = 'partner';
        $this->data['partners'] = $this->partner_model->get_all_by_language($this->data['lang']);

        $this->render('partner_view');
    }

}