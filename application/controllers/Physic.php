<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Physic extends Public_Controller {

    private $_lang = '';

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('physic_model');
        $this->load->model('physictype_model');
        $this->load->model('physicgroup_model');
        $this->_lang = $this->session->userdata('langAbbreviation');
    }

    public function index() {
        $this->data['current_link'] = 'list_physic';
        $this->data['lang'] = $this->_lang;
        $this->data['types'] = $this->physictype_model->get_all_by_language($this->_lang);
        $this->data['groups'] = $this->physicgroup_model->get_all_by_language($this->_lang);
        $this->data['physics'] = $this->physic_model->get_all_by_language($this->_lang);

        $this->render('physic_view');
    }

    public function detail($id = null){
        $physic_id = isset($id) ? (int) $id : (int) $this->input->post('id');
        $this->data['current_link'] = 'physic_detail';
        $this->data['physic_id'] = $physic_id;
        $this->data['physic'] = $this->physic_model->get_by_id($physic_id, $this->_lang);

        $group = $this->physicgroup_model->get_by_language($this->data['physic']['group_id'], $this->_lang);
        $this->data['physic']['group_name'] = $group['title'];

        if (!$this->data['physic']) {
            redirect('', 'refresh');
        }

        $this->render('detail_physic_view');
    }

    public function filter_product(){
        $params = $this->input->get();

        $result = $this->physic_model->filter($this->_lang, $params);

        $this->output->set_output(json_encode($result));
    }

}
