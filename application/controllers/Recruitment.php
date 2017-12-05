<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Recruitment extends Public_Controller {

    private $_lang = '';

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('recruitment_model');
        $this->load->model('cover_model');
        $this->_lang = $this->session->userdata('langAbbreviation');
    }

    public function index() {
        $this->data['current_link'] = 'list_recruitment';
        $this->data['lang'] = $this->_lang;
        $this->data['recruitments'] = $this->recruitment_model->get_all_by_language($this->_lang);
        $this->data['cover'] = $this->cover_model->get_by_id(3);

        $this->render('recruitment_view');
    }

    public function detail($id = null){
        $request_id = isset($id) ? (int) $id : (int) $this->input->post('id');
        $this->data['current_link'] = 'recruitment_detail';
        $this->data['recruitment_id'] = $request_id;
        $this->data['latest_recruitment'] = $this->recruitment_model->get_latest_article($this->_lang);
        $this->data['recruitment'] = $this->recruitment_model->get_by_id($request_id, $this->_lang);

        if (!$this->data['recruitment']) {
            redirect('', 'refresh');
        }

        $this->render('detail_recruitment_view');
    }

}
