<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Physic extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('physic_model');
        $this->load->model('physictype_model');
        $this->load->model('physicgroup_model');
        $this->load->library('session');
    }

    public function index() {
        if (count($_POST) > 0){
            $this->session->set_userdata('search_physic', $_POST );
            redirect('admin/physic/index');
        }else{
            if($this->session->userdata('search_physic')){
                $_POST = $this->session->userdata('search_physic');
//                $this->session->unset_userdata('search_physic');
            }
        }
        $keywords = '';
        if($this->input->post('search')){
            $keywords = $this->input->post('keywords');
        }
        $this->load->helper('form');
        $this->load->library('pagination');
        $base_url = base_url() . 'admin/physic/index';
        if($keywords != ''){
            $total_rows = $this->physic_model->count_search($keywords);
        }else{
            $total_rows = $this->physic_model->count_all();
        }

        $per_page = 10;
        $uri_segment = 4;

        $config = $this->pagination_config($base_url, $total_rows, $per_page, $uri_segment);
        $this->pagination->initialize($config);

        $this->data['page_links'] = $this->pagination->create_links();
        $this->data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

        $result = array();
        if($keywords != ''){
            $result = $this->physic_model->get_all_with_pagination_search($per_page, $this->data['page'], $keywords);
        }else{
            $result = $this->physic_model->get_all_with_pagination($per_page, $this->data['page']);
        }

        $output = array();
        foreach($result as $key => $value){
            $output[$key]['id'] = $value['id'];
            $output[$key]['data'] = $this->physic_model->get_by_id($value['id']);

            $type = $this->physictype_model->get_by_id($value['type_id']);
            $group = $this->physicgroup_model->get_by_id($value['group_id']);

            $output[$key]['type_name'] = $type['type_title'];
            $output[$key]['group_name'] = $group['group_title'];
        }
        $this->data['physics'] = $output;

        $this->render('admin/physic/list_physic_view');
    }

    public function reset(){
        $this->session->unset_userdata('search_physic');
        redirect('admin/physic', 'refresh');
    }

    public function create() {
        $this->load->helper('form');
        $this->load->library('form_validation');

        // Get physic type
        $type_array = array();
        $types = $this->physictype_model->get_all_with_pagination();
        foreach($types as $key => $type){
            $type_array[$type['id']] = $type['type_title'];
        }
        // Get physic group
        $group_array = array();
        $groups = $this->physicgroup_model->get_all_with_pagination();
        foreach($groups as $key => $group){
            $group_array[$group['id']] = $group['group_title'];
        }

        $this->form_validation->set_rules('physic_type', 'Type', 'required');
        $this->form_validation->set_rules('physic_group', 'Group', 'required');
        $this->form_validation->set_rules('is_special', 'Sản phẩm đặc biệt', 'callback_check_over_special_item');

        if ($this->form_validation->run() == FALSE) {
            $this->data['types'] = $type_array;
            $this->data['groups'] = $group_array;
            $this->render('admin/physic/create_physic_view');
        } else {
            if ($this->input->post()) {
                $image = $this->upload_image('picture', $_FILES['picture']['name'], 'assets/upload/physic', 'assets/upload/physic/thumbs');
                $data = array(
                    'type_id' => $this->input->post('physic_type'),
                    'group_id' => $this->input->post('physic_group'),
                    'description_image' => $image,
                    'is_special' => array_key_exists('is_special', $this->input->post()) ? $this->input->post('is_special') : 0,
                    'created_at' => $this->author_info['created'],
                    'created_by' => $this->author_info['created_by'],
                    'updated_at' => $this->author_info['modified'],
                    'updated_by' => $this->author_info['modified_by']
                );

                try {
                    $insert_id = $this->physic_model->insert($data);
                    $data_vi = array(
                        'physic_id' => $insert_id,
                        'language' => 'vi',
                        'title' => $this->input->post('title_vi'),
                        'description' => $this->input->post('description_vi'),
                        'content' => $this->input->post('content_vi'),
                        'ingredients' => $this->input->post('ingredients_vi'),
                        'attribution' => $this->input->post('attribution_vi'),
                        'dosage' => $this->input->post('dosage_vi'),
                        'contraindicating' => $this->input->post('contraindicating_vi'),
                        'expired' => $this->input->post('expired_vi'),
                        'certification' => $this->input->post('certification_vi'),
                        'presentation' => $this->input->post('presentation_vi'),
                        'faq' => $this->input->post('faq_vi')
                    );
                    $data_en = array(
                        'physic_id' => $insert_id,
                        'language' => 'en',
                        'title' => $this->input->post('title_en'),
                        'description' => $this->input->post('description_en'),
                        'content' => $this->input->post('content_en'),
                        'ingredients' => $this->input->post('ingredients_en'),
                        'attribution' => $this->input->post('attribution_en'),
                        'dosage' => $this->input->post('dosage_en'),
                        'contraindicating' => $this->input->post('contraindicating_en'),
                        'expired' => $this->input->post('expired_en'),
                        'certification' => $this->input->post('certification_en'),
                        'presentation' => $this->input->post('presentation_en'),
                        'faq' => $this->input->post('faq_en')
                    );

                    $this->physic_model->insert_with_language($data_vi, $data_en);

                    $this->session->set_flashdata('message', 'physic added successfully');
                } catch (Exception $e) {
                    $this->session->set_flashdata('message', 'There was an error inserting physic: ' . $e->getMessage());
                }

                redirect('admin/physic', 'refresh');
            }
        }
    }

    public function edit($id = NULL) {
        $this->load->helper('form');
        $this->load->library('form_validation');

        // Get physic type
        $type_array = array();
        $types = $this->physictype_model->get_all_with_pagination();
        foreach($types as $key => $type){
            $type_array[$type['id']] = $type['type_title'];
        }
        // Get physic group
        $group_array = array();
        $groups = $this->physicgroup_model->get_all_with_pagination();
        foreach($groups as $key => $group){
            $group_array[$group['id']] = $group['group_title'];
        }

        $this->form_validation->set_rules('physic_type', 'Type', 'required');
        $this->form_validation->set_rules('physic_group', 'Group', 'required');
        $this->form_validation->set_rules('is_special', 'Sản phẩm đặc biệt', 'callback_check_over_special_item');

        $input_id = isset($id) ? (int) $id : (int) $this->input->post('id');
        $result = $this->physic_model->get_by_id($input_id);

        if (!$result) {
            redirect('admin/physic', 'refresh');
        }

        // Title
        $title = explode('|||', $result['physic_title']);
        $result['title_en'] = $title[0];
        $result['title_vi'] = $title[1];

        // Description
        $description = explode('|||', $result['physic_description']);
        $result['description_en'] = isset($description[0]) ? $description[0] : '';
        $result['description_vi'] = isset($description[1]) ? $description[1] : '';

        // Content
        $content = explode('|||', $result['physic_content']);
        $result['content_en'] = isset($content[0]) ? $content[0] : '';
        $result['content_vi'] = isset($content[1]) ? $content[1] : '';

        // FAQ
        $faq = explode('|||', $result['physic_faq']);
        $result['faq_en'] = isset($faq[0]) ? $faq[0] : '';
        $result['faq_vi'] = isset($faq[1]) ? $faq[1] : '';
        
        // Ingredients
        $ingredients = explode('|||', $result['physic_ingredients']);
        $result['ingredients_en'] = isset($ingredients[0]) ? $ingredients[0] : '';
        $result['ingredients_vi'] = isset($ingredients[1]) ? $ingredients[1] : '';
        
        // Attribution
        $attribution = explode('|||', $result['physic_attribution']);
        $result['attribution_en'] = isset($attribution[0]) ? $attribution[0] : '';
        $result['attribution_vi'] = isset($attribution[1]) ? $attribution[1] : '';
        
        // Dosage
        $dosage = explode('|||', $result['physic_dosage']);
        $result['dosage_en'] = isset($dosage[0]) ? $dosage[0] : '';
        $result['dosage_vi'] = isset($dosage[1]) ? $dosage[1] : '';
        
        // Contraindicating
        $contraindicating = explode('|||', $result['physic_contraindicating']);
        $result['contraindicating_en'] = isset($contraindicating[0]) ? $contraindicating[0] : '';
        $result['contraindicating_vi'] = isset($contraindicating[1]) ? $contraindicating[1] : '';
        
        // Expired
        $expired = explode('|||', $result['physic_expired']);
        $result['expired_en'] = isset($expired[0]) ? $expired[0] : '';
        $result['expired_vi'] = isset($expired[1]) ? $expired[1] : '';
        
        // Certification
        $certification = explode('|||', $result['physic_certification']);
        $result['certification_en'] = isset($certification[0]) ? $certification[0] : '';
        $result['certification_vi'] = isset($certification[1]) ? $certification[1] : '';
        
        // Presentation
        $presentation = explode('|||', $result['physic_presentation']);
        $result['presentation_en'] = isset($presentation[0]) ? $presentation[0] : '';
        $result['presentation_vi'] = isset($presentation[1]) ? $presentation[1] : '';

        if ($this->form_validation->run() == FALSE) {
            $this->data['types'] = $type_array;
            $this->data['groups'] = $group_array;
            $this->data['physic'] = $result;
            $this->render('admin/physic/edit_physic_view');
        } else {
            if ($this->input->post()) {
                $image = $this->upload_image('picture', $_FILES['picture']['name'], 'assets/upload/physic', 'assets/upload/physic/thumbs');
                $data = array(
                    'type_id' => $this->input->post('physic_type'),
                    'group_id' => $this->input->post('physic_group'),
                    'description_image' => $image,
                    'is_special' => array_key_exists('is_special', $this->input->post()) ? $this->input->post('is_special') : 0,
                    'updated_at' => $this->author_info['modified'],
                    'updated_by' => $this->author_info['modified_by']
                );

                if ($image == '') {
                    unset($data['description_image']);
                }

                try {
                    $this->physic_model->update($input_id, $data);
                    $data_vi = array(
                        'title' => $this->input->post('title_vi'),
                        'description' => $this->input->post('description_vi'),
                        'content' => $this->input->post('content_vi'),
                        'ingredients' => $this->input->post('ingredients_vi'),
                        'attribution' => $this->input->post('attribution_vi'),
                        'dosage' => $this->input->post('dosage_vi'),
                        'contraindicating' => $this->input->post('contraindicating_vi'),
                        'expired' => $this->input->post('expired_vi'),
                        'certification' => $this->input->post('certification_vi'),
                        'presentation' => $this->input->post('presentation_vi'),
                        'faq' => $this->input->post('faq_vi')
                    );
                    $this->physic_model->update_with_language_vi($input_id, $data_vi);

                    $data_en = array(
                        'title' => $this->input->post('title_en'),
                        'description' => $this->input->post('description_en'),
                        'content' => $this->input->post('content_en'),
                        'ingredients' => $this->input->post('ingredients_en'),
                        'attribution' => $this->input->post('attribution_en'),
                        'dosage' => $this->input->post('dosage_en'),
                        'contraindicating' => $this->input->post('contraindicating_en'),
                        'expired' => $this->input->post('expired_en'),
                        'certification' => $this->input->post('certification_en'),
                        'presentation' => $this->input->post('presentation_en'),
                        'faq' => $this->input->post('faq_en')
                    );

                    $this->physic_model->update_with_language_en($input_id, $data_en);

                    $this->session->set_flashdata('message', 'Item updated successfully');
                } catch (Exception $e) {
                    $this->session->set_flashdata('message', 'There was an error updating the item: ' . $e->getMessage());
                }

                redirect('admin/physic', 'refresh');
            }
        }
    }

    public function delete() {
        $input = $this->input->get();
        $blog = $this->physic_model->get_by_id($input['id']);

        if (!$blog) {
            $this->output->set_status_header(404)
                ->set_output(json_encode(array('message' => 'Fail', 'data' => $input)));
        }

        $set_delete = array('is_deleted' => 1);
        $result = $this->physic_model->remove($input['id'], $set_delete);

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
        return $this->delete_multiple_common('physic', 'physic_model', $ids);
    }

    public function check_over_special_item(){
        $this->form_validation->set_message('check_over_special_item', 'Quá số lượng sản phẩm đặc biệt');

        $count = count($this->physic_model->fetch_special());

        if(($this->input->post('is_special') == 1) && $count >= 5){
            return false;
        }else{
            return true;
        }
    }

}
