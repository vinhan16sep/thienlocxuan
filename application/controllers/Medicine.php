<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Medicine extends Public_Controller {

    private $_lang = '';

    public function __construct() {
        parent::__construct();
        $this->_lang = $this->session->userdata('langAbbreviation');
    }

    public function index() {
        $this->data['current_link'] = 'medicine';
        $this->data['lang'] = $this->_lang;
        $this->render('medicine_view');
    }

}