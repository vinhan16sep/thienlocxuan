<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Qa_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_all_with_pagination($limit = NULL, $start = NULL) {
        $this->db->select('*');
        $this->db->from('qa');
        $this->db->where('is_deleted', 0);
        $this->db->limit($limit, $start);
        $this->db->order_by("id", "desc");

        return $result = $this->db->get()->result_array();
    }

    public function get_all_with_pagination_search($limit = NULL, $start = NULL, $keywords) {
        $this->db->select('qa.*');
        $this->db->from('qa');
        $this->db->join('qa_lang', 'qa_lang.qa_id = qa.id');
        $this->db->like('qa_lang.title', $keywords);
        $this->db->where('qa.is_deleted', 0);
        $this->db->limit($limit, $start);
        $this->db->group_by('qa_lang.qa_id');
        $this->db->order_by("qa.id", "desc");

        return $result = $this->db->get()->result_array();
    }

    public function get_all_by_language($lang){
        $this->db->select('*');
        $this->db->from('qa');
        $this->db->join('qa_lang', 'qa_lang.qa_id = qa.id', 'left');
        $this->db->where('qa_lang.language', $lang);
        $this->db->where('qa.is_deleted', 0);
        $this->db->order_by("qa.id", "desc");

        return $result = $this->db->get()->result_array();
    }

    public function get_all() {
        $this->db->select('*');
        $this->db->from('blog');
        $this->db->where('is_deleted', 0);
        $this->db->order_by("id", "desc");

        return $result = $this->db->get()->result_array();
    }

    public function get_latest_article($lang, $type){
        $this->db->select('*');
        $this->db->from('blog');
        $this->db->join('blog_lang', 'blog_lang.blog_id = blog.id', 'left');
        $this->db->where('blog_lang.language', $lang);
        $this->db->where('type', $type);
        $this->db->where('blog.is_deleted', 0);
        $this->db->limit(3);
        $this->db->order_by("blog.id", "desc");

        return $result = $this->db->get()->result_array();
    }

    public function count_all() {
        $this->db->select('*');
        $this->db->from('qa');
        $this->db->where('is_deleted', 0);

        return $result = $this->db->get()->num_rows();
    }

    public function count_search($keyword){
        $this->db->select('*');
        $this->db->from('qa');
        $this->db->join('qa_lang', 'qa_lang.qa_id = qa.id');
        $this->db->like('qa_lang.title', $keyword);
        $this->db->group_by('qa_lang.qa_id');
        $this->db->where('qa.is_deleted', 0);

        return $result = $this->db->get()->num_rows();
    }

    public function get_by_id($id, $lang = '') {
        $this->db->query('SET SESSION group_concat_max_len = 10000000');
        $this->db->select('qa.*, GROUP_CONCAT(qa_lang.title ORDER BY qa_lang.language separator \'|||\') as qa_title, 
                            GROUP_CONCAT(qa_lang.description ORDER BY qa_lang.language separator \'|||\') as qa_description');
        $this->db->from('qa');
        $this->db->join('qa_lang', 'qa_lang.qa_id = qa.id', 'left');
        if($lang != ''){
            $this->db->where('qa_lang.language', $lang);
        }
        $this->db->where('qa.is_deleted', 0);
        $this->db->where('qa.id', $id);
        $this->db->limit(1);

        return $this->db->get()->row_array();
    }

    public function insert($data) {
        $this->db->set($data)->insert('qa');

        if($this->db->affected_rows() == 1){
            return $this->db->insert_id();
        }

        return false;
//        return $this->db->insert('blog', $data);
    }

    public function insert_with_language($data_vi, $data_en){
        $data_merge = array($data_vi, $data_en);
        return $this->db->insert_batch('qa_lang', $data_merge);
    }

    public function update($id, $data) {
        $this->db->where('id', $id);

        return $this->db->update('qa', $data);
    }

    public function update_with_language_vi($id, $data_vi){
        $this->db->where('qa_id', $id);
        $this->db->where('language', 'vi');
        return $this->db->update('qa_lang', $data_vi);
    }

    public function update_with_language_en($id, $data_en){
        $this->db->where('qa_id', $id);
        $this->db->where('language', 'en');
        return $this->db->update('qa_lang', $data_en);
    }

    public function remove($id, $set_delete) {
        $this->db->where('id', $id);

        return $this->db->update('qa', $set_delete);
    }

    public function remove_multiple($table, $data){
        $this->db->trans_begin();
        $this->db->update_batch($table, $data, 'id');
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();

        }else{
            $this->db->trans_commit();
        }

        return $this->db->trans_status();
    }

}
