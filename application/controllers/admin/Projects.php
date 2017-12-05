<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Projects extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('projects_model');
        $this->load->library('session');
    }

    public function index() {
        $this->load->library('pagination');
        $config = array();
        $base_url = base_url() . 'admin/projects/index';
        $total_rows = $this->projects_model->count_projects();
        $per_page = 10;
        $uri_segment = 4;
        foreach ($this->pagination_config($base_url, $total_rows, $per_page, $uri_segment) as $key => $value) {
            $config[$key] = $value;
        }
        $this->pagination->initialize($config);

        $this->data['page_links'] = $this->pagination->create_links();
        $this->data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $this->data['projects'] = $this->projects_model->get_all_projects($per_page, $this->data['page']);

        $this->render('admin/projects/list_projects_view');
    }

    public function create() {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('project_title', 'Project name', 'trim|required');

        $this->data['over_main'] = 0;
        $number_main_projects = $this->projects_model->count_main_projects();

        if ($this->form_validation->run() == FALSE) {
            $this->render('admin/projects/create_project_view');
        } else if ($this->input->post('project_ismain') == 1 && $number_main_projects == 3) {
            $this->data['over_main'] = 1;
            $this->render('admin/projects/create_project_view');
        } else {
            if ($this->input->post()) {

                // Upload single image
                $description_image = $this->upload_image('project_description_picture', $_FILES['project_description_picture']['name'], 'assets/upload/projects/description', NULL);

                //Upload multiple images
                $number_of_files = sizeof($_FILES['project_picture']['tmp_name']);
                $files = $_FILES['project_picture'];
                $errors = array();
                $project_banner = '';

                for ($i = 0; $i < $number_of_files; $i++) {
                    if ($_FILES['project_picture']['error'][$i] != 0) {
                        $errors[$i][] = 'Couldn\'t upload file ' . $_FILES['project_picture']['name'][$i];
                    }
                }
                if (sizeof($errors) == 0) {
                    $this->load->library('upload');

                    $config['upload_path'] = 'assets/upload/projects';
                    $config['allowed_types'] = 'jpg|jpeg|png|gif';

                    for ($i = 0; $i < $number_of_files; $i++) {
                        $_FILES['project_picture']['name'] = $files['name'][$i];
                        $_FILES['project_picture']['type'] = $files['type'][$i];
                        $_FILES['project_picture']['tmp_name'] = $files['tmp_name'][$i];
                        $_FILES['project_picture']['error'] = $files['error'][$i];
                        $_FILES['project_picture']['size'] = $files['size'][$i];

                        $this->upload->initialize($config);
                        if ($this->upload->do_upload('project_picture')) {
                            $upload_data[$i] = $this->upload->data();
                            $image[$i] = $upload_data[$i]['file_name'];

                            if ($i == ($number_of_files - 1)) {
                                $project_banner .= $image[$i];
                            } else {
                                $project_banner .= $image[$i] . '|-|';
                            }


                            $this->load->library('image_lib');

                            $config_thumb[$i]['source_image'] = 'assets/upload/projects/' . $image[$i];
                            $config_thumb[$i]['create_thumb'] = TRUE;
                            $config_thumb[$i]['maintain_ratio'] = TRUE;
                            $config_thumb[$i]['new_image'] = 'assets/upload/projects/thumbs';
                            $config_thumb[$i]['width'] = 300;
                            $config_thumb[$i]['height'] = 200;

                            $this->image_lib->initialize($config_thumb[$i]);

                            $this->image_lib->resize();
                            $this->image_lib->clear();
                        }
                    }
                }

                $project_data = array(
                    'project_title' => $this->input->post('project_title'),
                    'project_banner' => $project_banner,
                    'project_is_main' => $this->input->post('project_ismain'),
                    'project_description' => $this->input->post('project_description'),
                    'project_description_image' => $description_image
                );

                try {
                    $this->projects_model->insert_project($project_data);
                    $this->session->set_flashdata('message', 'Project added successfully');
                } catch (Exception $e) {
                    $this->session->set_flashdata('message', 'There was an error inserting project: ' . $e->getMessage());
                }

                redirect('admin/projects', 'refresh');
            }
        }
    }

    public function edit($id = NULL) {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('project_title', 'Project name', 'trim|required');

        $project_id = isset($id) ? (int) $id : (int) $this->input->post('id');
        $this->data['project'] = $this->projects_model->get_project_by_id($project_id);

        if (!$this->data['project']) {
            redirect('admin/projects', 'refresh');
        }

        $this->data['over_main'] = 0;
        $number_main_projects = $this->projects_model->count_main_projects();

        if ($this->form_validation->run() == FALSE) {
            $this->render('admin/projects/edit_project_view');
        } else if ($this->input->post('project_ismain') == 1 && $number_main_projects == 3 && $this->data['project']['project_is_main'] == 0) {
            $this->data['over_main'] = 1;
            $this->session->set_flashdata('message', 'Over 3 main projects');
            $this->render('admin/projects/edit_project_view');
        } else {
            if ($this->input->post()) {

                // Upload single image
                $description_image = $description_image = $this->upload_image('project_description_picture', $_FILES['project_description_picture']['name'], 'assets/upload/projects/description', NULL);

                //Upload multiple images
                $number_of_files = sizeof($_FILES['project_picture']['tmp_name']);
                $files = $_FILES['project_picture'];
                $errors = array();
                $project_banner = '';

                for ($i = 0; $i < $number_of_files; $i++) {
                    if ($_FILES['project_picture']['error'][$i] != 0) {
                        $errors[$i][] = 'Couldn\'t upload file ' . $_FILES['project_picture']['name'][$i];
                    }
                }
                if (sizeof($errors) == 0) {
                    $this->load->library('upload');

                    $config['upload_path'] = 'assets/upload/projects';
                    $config['allowed_types'] = 'jpg|jpeg|png|gif';

                    for ($i = 0; $i < $number_of_files; $i++) {
                        $_FILES['project_picture']['name'] = $files['name'][$i];
                        $_FILES['project_picture']['type'] = $files['type'][$i];
                        $_FILES['project_picture']['tmp_name'] = $files['tmp_name'][$i];
                        $_FILES['project_picture']['error'] = $files['error'][$i];
                        $_FILES['project_picture']['size'] = $files['size'][$i];

                        $this->upload->initialize($config);
                        if ($this->upload->do_upload('project_picture')) {
                            $upload_data[$i] = $this->upload->data();
                            $image[$i] = $upload_data[$i]['file_name'];

                            if ($i == ($number_of_files - 1)) {
                                $project_banner .= $image[$i];
                            } else {
                                $project_banner .= $image[$i] . '|-|';
                            }


                            $this->load->library('image_lib');

                            $config_thumb[$i]['source_image'] = 'assets/upload/projects/' . $image[$i];
                            $config_thumb[$i]['create_thumb'] = TRUE;
                            $config_thumb[$i]['maintain_ratio'] = TRUE;
                            $config_thumb[$i]['new_image'] = 'assets/upload/projects/thumbs';
                            $config_thumb[$i]['width'] = 300;
                            $config_thumb[$i]['height'] = 200;

                            $this->image_lib->initialize($config_thumb[$i]);

                            $this->image_lib->resize();
                            $this->image_lib->clear();
                        }
                    }
                }

                $project_data = array(
                    'project_title' => $this->input->post('project_title'),
                    'project_banner' => $project_banner,
                    'project_is_main' => $this->input->post('project_ismain'),
                    'project_description' => $this->input->post('project_description'),
                    'project_description_image' => $description_image
                );

                $converted_data = $this->convert_data_for_edit($project_data);

                try {
                    $this->projects_model->update_project($project_id, $converted_data);
                    $this->session->set_flashdata('message', 'Project update successfully');
                } catch (Exception $e) {
                    $this->session->set_flashdata('message', 'There was an error updating the project: ' . $e->getMessage());
                }
                
                redirect('admin/projects', 'refresh');
            }
        }
    }

    public function delete($id = NULL) {
        $project_id = isset($id) ? (int) $id : (int) $this->input->post('id');
        $project = $this->projects_model->get_project_by_id($project_id);

        if (!$project) {
            redirect('admin/projects', 'refresh');
        }

        $set_delete = array('project_is_delete' => 1);
        try {
            $this->projects_model->delete_project($id, $set_delete);
            $this->session->set_flashdata('message', 'Item has deleted successful.');
        } catch (Exception $e) {
            $this->session->set_flashdata('message', 'Have error while delete item: ' . $e->getMessage());
        }
        
        redirect('admin/projects', 'refresh');
    }

    public function convert_data_for_edit($data = array()) {
        if ($data['project_banner'] == '' && $data['project_description_image'] == '') {
            unset($data['project_banner']);
            unset($data['project_description_image']);
        } elseif ($data['project_banner'] == '') {
            unset($data['project_banner']);
        } elseif ($data['project_description_image'] == '') {
            unset($data['project_description_image']);
        }

        return $data;
    }

}
