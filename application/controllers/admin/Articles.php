<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Articles extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('articles_model');
        $this->load->library('session');
    }

    public function index() {
        $this->load->library('pagination');
        $config = array();
        $base_url = base_url() . 'admin/articles/index';
        $total_rows = $this->articles_model->count_articles();
        $per_page = 10;
        $uri_segment = 4;
        foreach ($this->pagination_config($base_url, $total_rows, $per_page, $uri_segment) as $key => $value) {
            $config[$key] = $value;
        }
        $this->pagination->initialize($config);

        $this->data['page_links'] = $this->pagination->create_links();
        $this->data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $this->data['articles'] = $this->articles_model->get_all_articles($per_page, $this->data['page']);

        $this->render('admin/articles/list_articles_view');
    }

    public function create() {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('article_title', 'Article name', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $this->data['list_projects'] = $this->get_list_project();
            $this->render('admin/articles/create_article_view');
        } else {
            if ($this->input->post()) {
                $image = $this->upload_image('article_picture', $_FILES['article_picture']['name'], 'assets/upload/articles', 'assets/upload/articles/thumbs');

                $article_data = array(
                    'article_project_id' => $this->input->post('article_project'),
                    'article_title' => $this->input->post('article_title'),
                    'article_description_image' => $image,
                    'article_description' => $this->input->post('article_description'),
                    'article_content' => $this->input->post('article_content')
                );

                $insert = $this->articles_model->insert_article($article_data);
                if (!$insert) {
                    $this->session->set_flashdata('message', 'There was an error inserting article');
                }
                $this->session->set_flashdata('message', 'Article added successfully');

                redirect('admin/articles', 'refresh');
            }
        }
    }

    public function edit($id = NULL) {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('article_title', 'Article name', 'trim|required');

        $article_id = isset($id) ? (int) $id : (int) $this->input->post('id');
        if ($this->form_validation->run() == FALSE) {
            $this->data['article'] = $this->articles_model->get_article_by_id($article_id);

            if (!$this->data['article']) {
                redirect('admin/articles', 'refresh');
            }
            $this->data['list_projects'] = $this->get_list_project();
            $this->render('admin/articles/edit_article_view');
        } else {
            if ($this->input->post()) {
                $image = $this->upload_image('article_picture', $_FILES['article_picture']['name'], 'assets/upload/articles', 'assets/upload/articles/thumbs');
                $new_article_data = array(
                    'article_project_id' => $this->input->post('article_project'),
                    'article_title' => $this->input->post('article_title'),
                    'article_description_image' => $image,
                    'article_description' => $this->input->post('article_description'),
                    'article_content' => $this->input->post('article_content'),
                    'article_modified' => $this->author_info['modified'],
                    'article_modified_by' => $this->author_info['modified_by']
                );
                if ($image == '') {
                    unset($new_article_data['article_description_image']);
                }

                try {
                    $this->articles_model->update_article($article_id, $new_article_data);
                    $this->session->set_flashdata('message', 'Article updated successfully');
                } catch (Exception $e) {
                    $this->session->set_flashdata('message', 'There was an error updating the article: ' . $e->getMessage());
                }

                redirect('admin/articles', 'refresh');
            }
        }
    }
    
    public function delete($id = NULL){
        $project = $this->articles_model->get_article_by_id($id);
        if(!$project){
            redirect('admin/articles', 'refresh');
        }
        
        $set_delete = array(
            'article_is_delete' => 1
        );
        try{
            $this->articles_model->delete_article($id, $set_delete);
            $this->session->set_flashdata('message', 'Article deleted successfully');
        }catch(Exception $e){
            $this->session->set_flashdata('message', 'There was an error delete the article: ' . $e->getMessage());
        }
        
        redirect('admin/articles', 'refresh');
    }

    public function get_list_project() {
        $this->load->model('projects_model');
        $list_project = array();
        $projects = $this->projects_model->get_all_projects(NULL, NULL);
        foreach ($projects as $key => $project) {
            $list_project[$project['project_id']] = $project['project_title'];
        }
        
        return $list_project;
    }

}
