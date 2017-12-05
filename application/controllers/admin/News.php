<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class News extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('news_model');
        $this->load->library('session');
    }

    public function index() {
        $this->load->library('pagination');
        $config = array();
        $base_url = base_url() . 'admin/news/index';
        $total_rows = $this->news_model->count_news();
        $per_page = 10;
        $uri_segment = 4;
        foreach ($this->pagination_config($base_url, $total_rows, $per_page, $uri_segment) as $key => $value) {
            $config[$key] = $value;
        }
        $this->pagination->initialize($config);

        $this->data['page_links'] = $this->pagination->create_links();
        $this->data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $this->data['news'] = $this->news_model->get_all_news($per_page, $this->data['page']);

        $this->render('admin/news/list_news_view');
    }

    public function create() {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('news_title', 'News name', 'trim|required');

        $count_hot_news = $this->news_model->count_hot_news();

        if ($this->form_validation->run() == FALSE) {
            $this->render('admin/news/create_news_view');
        } else {
            if ($this->input->post()) {
                if ($count_hot_news >= 5 && $this->input->post('news_is_hot') == 1) {
                    $this->session->set_flashdata('message', 'Over 5 hot news');
                    $this->render('admin/news/create_news_view');
                    return false;
                }
                $image = $this->upload_image('news_picture', $_FILES['news_picture']['name'], 'assets/upload/news', 'assets/upload/news/thumbs');
                $news_data = array(
                    'news_title' => $this->input->post('news_title'),
                    'news_description_image' => $image,
                    'news_description' => $this->input->post('news_description'),
                    'news_content' => $this->input->post('news_content'),
                    'news_is_hot' => $this->input->post('news_is_hot'),
                    'news_created' => $this->author_info['created'],
                    'news_created_by' => $this->author_info['created_by'],
                    'news_modified' => $this->author_info['modified'],
                    'news_modified_by' => $this->author_info['modified_by']
                );

                try {
                    $this->news_model->insert_news($news_data);
                    $this->session->set_flashdata('message', 'News added successfully');
                } catch (Exception $e) {
                    $this->session->set_flashdata('message', 'There was an error inserting news: ' . $e->getMessage());
                }

                redirect('admin/news', 'refresh');
            }
        }
    }

    public function edit($id = NULL) {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('news_title', 'News name', 'trim|required');

        $news_id = isset($id) ? (int) $id : (int) $this->input->post('id');
        $news = $this->news_model->get_news_by_id($news_id);
        $count_hot_news = $this->news_model->count_hot_news();

        if (!$news) {
            redirect('admin/news', 'refresh');
        }

        if ($this->form_validation->run() == FALSE) {
            $this->data['news'] = $news;
            $this->render('admin/news/edit_news_view');
        } else {
            if ($this->input->post()) {
                if ($count_hot_news >= 5 && $this->input->post('news_is_hot') == 1) {
                    $this->session->set_flashdata('message', 'Over 5 hot news');
                    $this->render('admin/news/edit_news_view');
                }
                $image = $this->upload_image('news_picture', $_FILES['news_picture']['name'], 'assets/upload/news', 'assets/upload/news/thumbs');
                $new_news_data = array(
                    'news_title' => $this->input->post('news_title'),
                    'news_description_image' => $image,
                    'news_description' => $this->input->post('news_description'),
                    'news_is_hot' => $this->input->post('news_is_hot'),
                    'news_content' => $this->input->post('news_content'),
                    'news_modified' => $this->author_info['modified'],
                    'news_modified_by' => $this->author_info['modified_by']
                );
                if ($image == '') {
                    unset($new_news_data['news_description_image']);
                }

                try {
                    $this->news_model->update_news($news_id, $new_news_data);
                    $this->session->set_flashdata('message', 'News updated successfully');
                } catch (Exception $e) {
                    $this->session->set_flashdata('message', 'There was an error updating the news: ' . $e->getMessage());
                }

                redirect('admin/news', 'refresh');
            }
        }
    }

    public function delete($id = NULL) {
        $news = $this->news_model->get_news_by_id($id);

        if (!$news) {
            redirect('admin/news', 'refresh');
        }

        $set_delete = array('news_is_delete' => 1);
        try {
            $this->news_model->delete_news($id, $set_delete);
            $this->session->set_flashdata('message', 'Item has deleted successful.');
        } catch (Exception $e) {
            $this->session->set_flashdata('message', 'Have error while delete item: ' . $e->getMessage());
        }
        redirect('admin/news', 'refresh');
    }

}
