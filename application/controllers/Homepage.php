<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Homepage extends Public_Controller {

    private $_lang = '';

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->_lang = $this->session->userdata('langAbbreviation');
    }

    public function index() {
        $this->data['current_link'] = 'homepage';
        $this->data['lang'] = $this->_lang;

        $this->data['banners'] = $this->list_banners();
        $this->data['blogs'] = $this->list_blogs();

        $this->data['specials'] = $this->list_special();

        $this->render('homepage_view');
    }

    public function list_banners(){
        $this->load->model('banner_model');
        $banners = $this->banner_model->get_all();

        return $banners;
    }

    public function list_blogs(){
        $this->load->model('blog_model');
        $blogs = $this->blog_model->get_all_blog($this->_lang);

        return $blogs;
    }

    public function list_special(){
        $this->load->model('product_model');
        $this->load->model('physic_model');

        $special_products = array();
        $products = $this->product_model->fetch_special();
        foreach($products as $key => $product){
            $special_products[$key]['id'] = $product['id'];
            $special_products[$key]['data'] = $this->product_model->get_by_id($product['id'], $this->_lang);
        }

        $special_physics = array();
        $physics = $this->physic_model->fetch_special();
        foreach($physics as $key => $physic){
            $special_physics[$key]['id'] = $physic['id'];
            $special_physics[$key]['data'] = $this->physic_model->get_by_id($physic['id'], $this->_lang);
        }

        return array($special_products, $special_physics);
    }

}