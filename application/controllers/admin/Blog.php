<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('blog_model');
        $this->load->library('session');
    }

    public function index() {
        if (count($_POST) > 0){
            $this->session->set_userdata('search_blog', $_POST );
            redirect('admin/blog/index');
        }else{
            if($this->session->userdata('search_blog')){
                $_POST = $this->session->userdata('search_blog');
//                $this->session->unset_userdata('search_blog');
            }
        }
        $keywords = '';
        if($this->input->post('search')){
            $keywords = $this->input->post('keywords');
        }
        $this->load->helper('form');
        $this->load->library('pagination');
        $base_url = base_url() . 'admin/blog/index';
        if($keywords != ''){
            $total_rows = $this->blog_model->count_search($keywords);
        }else{
            $total_rows = $this->blog_model->count_all();
        }
        $per_page = 10;
        $uri_segment = 4;

        $config = $this->pagination_config($base_url, $total_rows, $per_page, $uri_segment);
        $this->pagination->initialize($config);

        $this->data['page_links'] = $this->pagination->create_links();
        $this->data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

        $result = array();
        if($keywords != ''){
            $result = $this->blog_model->get_all_with_pagination_search($per_page, $this->data['page'], $keywords);
        }else{
            $result = $this->blog_model->get_all_with_pagination($per_page, $this->data['page']);
        }

        $output = array();
        foreach($result as $key => $value){
            $output[$key]['id'] = $value['id'];
            $output[$key]['type'] = $value['type'];
            $output[$key]['data'] = $this->blog_model->get_by_id($value['id']);
        }
        $this->data['blogs'] = $output;

        $this->render('admin/blog/list_blog_view');
    }

    public function reset(){
        $this->session->unset_userdata('search_blog');
        redirect('admin/blog', 'refresh');
    }

    public function create() {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('title', 'Blog name', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $this->render('admin/blog/create_blog_view');
        } else {
            if ($this->input->post()) {
                $image = $this->upload_image('picture', $_FILES['picture']['name'], 'assets/upload/blog', 'assets/upload/blog/thumbs');
                $data = array(
                    'description_image' => $image,
                    // type == title (need to find out why dropdown cannot set name = type)
                    'type' => $this->input->post('title'),
                    'created_at' => $this->author_info['created'],
                    'created_by' => $this->author_info['created_by'],
                    'updated_at' => $this->author_info['modified'],
                    'updated_by' => $this->author_info['modified_by']
                );

                try {
                    $insert_id = $this->blog_model->insert($data);
                    $data_vi = array(
                        'blog_id' => $insert_id,
                        'language' => 'vi',
                        'title' => $this->input->post('title_vi'),
                        'description' => $this->input->post('description_vi'),
                        'content' => $this->input->post('content_vi'),
                    );
                    $data_en = array(
                        'blog_id' => $insert_id,
                        'language' => 'en',
                        'title' => $this->input->post('title_en'),
                        'description' => $this->input->post('description_en'),
                        'content' => $this->input->post('content_en'),
                    );

                    $this->blog_model->insert_with_language($data_vi, $data_en);

                    $this->session->set_flashdata('message', 'Blog added successfully');
                } catch (Exception $e) {
                    $this->session->set_flashdata('message', 'There was an error inserting blog: ' . $e->getMessage());
                }

                redirect('admin/blog', 'refresh');
            }
        }
    }

    public function edit($id = NULL) {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('title', 'Title', 'trim|required');

        $input_id = isset($id) ? (int) $id : (int) $this->input->post('id');
        $result = $this->blog_model->get_by_id($input_id);

        if (!$result) {
            redirect('admin/blog', 'refresh');
        }

        // Title
        $title = explode('|||', $result['blog_title']);
        $result['title_en'] = $title[0];
        $result['title_vi'] = $title[1];

        // Description
        $description = explode('|||', $result['blog_description']);
        $result['description_en'] = isset($description[0]) ? $description[0] : '';
        $result['description_vi'] = isset($description[1]) ? $description[1] : '';

        // Content
        $content = explode('|||', $result['blog_content']);
        $result['content_en'] = isset($content[0]) ? $content[0] : '';
        $result['content_vi'] = isset($content[1]) ? $content[1] : '';

        if ($this->form_validation->run() == FALSE) {
            $this->data['blog'] = $result;
            $this->render('admin/blog/edit_blog_view');
        } else {
            if ($this->input->post()) {
                $image = $this->upload_image('picture', $_FILES['picture']['name'], 'assets/upload/blog', 'assets/upload/blog/thumbs');
                $data = array(
                    'description_image' => $image,
                    // type == title (need to find out why dropdown cannot set name = type)
                    'type' => $this->input->post('title'),
                    'created_at' => $this->author_info['created'],
                    'created_by' => $this->author_info['created_by'],
                    'updated_at' => $this->author_info['modified'],
                    'updated_by' => $this->author_info['modified_by']
                );
                if ($image == '') {
                    unset($data['description_image']);
                }

                try {
                    $this->blog_model->update($input_id, $data);
                    $data_vi = array(
                        'blog_id' => $input_id,
                        'language' => 'vi',
                        'title' => $this->input->post('title_vi'),
                        'description' => $this->input->post('description_vi'),
                        'content' => $this->input->post('content_vi'),
                    );
                    $this->blog_model->update_with_language_vi($input_id, $data_vi);

                    $data_en = array(
                        'blog_id' => $input_id,
                        'language' => 'en',
                        'title' => $this->input->post('title_en'),
                        'description' => $this->input->post('description_en'),
                        'content' => $this->input->post('content_en'),
                    );
                    $this->blog_model->update_with_language_en($input_id, $data_en);

                    $this->session->set_flashdata('message', 'Item added successfully');
                } catch (Exception $e) {
                    $this->session->set_flashdata('message', 'There was an error update item: ' . $e->getMessage());
                }

                redirect('admin/blog', 'refresh');
            }
        }
    }

    public function delete() {
        $input = $this->input->get();
        $blog = $this->blog_model->get_by_id($input['id']);

        if (!$blog) {
            $this->output->set_status_header(404)
                ->set_output(json_encode(array('message' => 'Fail', 'data' => $input)));
        }

        $set_delete = array('is_deleted' => 1);
        $result = $this->blog_model->remove($input['id'], $set_delete);

        if($result == false){
            $this->output->set_status_header(404)
                ->set_output(json_encode(array('message' => 'Fail', 'data' => $input)));
        }else{
            $this->output->set_status_header(200)
                ->set_output(json_encode(array('message' => 'Success', 'data' => $input)));
        }
    }

    public function delete_multiple(){
        $ids = $this->input->get('ids');
        return $this->delete_multiple_common('blog', 'blog_model', $ids);
    }
}
