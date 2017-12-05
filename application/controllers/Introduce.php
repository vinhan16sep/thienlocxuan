<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Introduce extends Public_Controller {

    private $_lang = '';

    public function __construct() {
        parent::__construct();
        $this->_lang = $this->session->userdata('langAbbreviation');
    }

    public function index() {
//        $this->data['references'] = $this->references_model->fetch_all();
//        $this->data['location'] = 'homepage';
        $this->data['current_link'] = '';
        $this->data['lang'] = $this->_lang;
        $this->render('homepage_view');
    }

    public function history(){
        $this->load->model('history_model');
        $this->data['lang'] = $this->_lang;
        $this->data['current_link'] = 'history';

        $this->data['histories'] = $this->history_model->get_all_by_language($this->_lang);
        for($i = 0; $i < count($this->data['histories']); $i++){
            $this->data['histories'][$i]['number'] = $i + 1;
        }

        $this->render('history_view');
    }

    public function duty(){
        $this->data['lang'] = $this->_lang;
        $this->data['current_link'] = 'duty';

        $this->render('duty_view');
    }

    // public function structure(){
    //     $this->load->model('member_model');
    //     $this->data['lang'] = $this->_lang;
    //     $this->data['current_link'] = 'structure';
        
    //     $this->data['members'] = $this->member_model->get_all_by_language($this->_lang);

    //     $this->render('structure_view');
    // }

    public function culture(){
        $this->data['lang'] = $this->_lang;
        $this->data['current_link'] = 'culture';

        $this->render('culture_view');
    }
    
    public function structure(){
        $this->load->model('member_model');
        $this->data['lang'] = $this->_lang;
        $this->data['current_link'] = 'structure';
        
        $members = $this->member_model->get_all_by_language($this->_lang);
        
        foreach($members as $key => $value){
            // Fetch Director
            if($value['role'] == 0){
                $this->data['director'] = $value;
            }
            
            // Fetch Vice Director
            if(isset($value['role']) && $value['role'] == 1){
                $this->data['vice_director'][$value['id']] = $value;
            }
            
            // Fetch Member
            if(isset($value['role']) && $value['role'] == 2){
                $this->data['members'][$value['id']] = $value;
            }
        }
        
        // echo "<pre>";
        // print_r($this->data); die;
        
        
        $this->render('structure_view');
    }

}