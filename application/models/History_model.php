<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class History_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_all_with_pagination($limit = NULL, $start = NULL) {
        $this->db->select('*');
        $this->db->from('history');
        $this->db->where('is_deleted', 0);
        $this->db->limit($limit, $start);
        $this->db->order_by("id", "desc");

        return $result = $this->db->get()->result_array();
    }

    public function get_all_by_language($lang){
        $this->db->select('*');
        $this->db->from('history');
        $this->db->join('history_lang', 'history_lang.history_id = history.id', 'left');
        $this->db->where('history_lang.language', $lang);
        $this->db->where('history.is_deleted', 0);
        $this->db->order_by("history.id", "desc");

        return $result = $this->db->get()->result_array();
    }

    public function get_all() {
        $this->db->select('*');
        $this->db->from('history');
        $this->db->where('is_deleted', 0);
        $this->db->order_by("id", "desc");

        return $result = $this->db->get()->result_array();
    }

    public function get_all_history_information($lang){
        $this->db->select('*');
        $this->db->from('history');
        $this->db->join('history_lang', 'history_lang.history_id = history.id', 'left');
        $this->db->where('history_lang.language', $lang);
        $this->db->where('type', 0);
        $this->db->where('history.is_deleted', 0);
        $this->db->order_by("history.id", "desc");

        return $result = $this->db->get()->result_array();
    }

    public function get_all_history_medicine($lang){
        $this->db->select('*');
        $this->db->from('history');
        $this->db->join('history_lang', 'history_lang.history_id = history.id', 'left');
        $this->db->where('history_lang.language', $lang);
        $this->db->where('type', 1);
        $this->db->where('history.is_deleted', 0);
        $this->db->order_by("history.id", "desc");

        return $result = $this->db->get()->result_array();
    }

    public function search_article($string, $lang){
        $this->db->select('*');
        $this->db->from('history');
        $this->db->join('history_lang', 'history_lang.history_id = history.id', 'left');
        $this->db->where('history_lang.language', $lang);
        $this->db->like('title', $string);
        $this->db->where('history.is_deleted', 0);
        $this->db->order_by("history.id", "desc");

        return $result = $this->db->get()->result_array();
    }

    public function get_latest_article($lang, $type){
        $this->db->select('*');
        $this->db->from('history');
        $this->db->join('history_lang', 'history_lang.history_id = history.id', 'left');
        $this->db->where('history_lang.language', $lang);
        $this->db->where('type', $type);
        $this->db->where('history.is_deleted', 0);
        $this->db->limit(3);
        $this->db->order_by("history.id", "desc");

        return $result = $this->db->get()->result_array();
    }

    public function fetch_most_viewed_article($type, $lang){
        $this->db->select('*');
        $this->db->from('history');
        $this->db->join('history_lang', 'history_lang.history_id = history.id', 'left');
        $this->db->where('history_lang.language', $lang);
        $this->db->where('type', $type);
        $this->db->where('history.is_deleted', 0);
        $this->db->order_by('viewed', 'desc');
        $this->db->limit(3);
        $this->db->order_by("history.id", "desc");

        return $result = $this->db->get()->result_array();
    }

    public function count_all() {
        $this->db->select('*');
        $this->db->from('history');
        $this->db->where('is_deleted', 0);

        return $result = $this->db->get()->num_rows();
    }

    public function get_by_id($id, $lang = '') {
        $this->db->query('SET SESSION group_concat_max_len = 10000000');
        $this->db->select('history.*, GROUP_CONCAT(history_lang.content ORDER BY history_lang.language separator \'|||\') as history_content');
        $this->db->from('history');
        $this->db->join('history_lang', 'history_lang.history_id = history.id', 'left');
        if($lang != ''){
            $this->db->where('history_lang.language', $lang);
        }
        $this->db->where('history.is_deleted', 0);
        $this->db->where('history.id', $id);
        $this->db->limit(1);

        return $this->db->get()->row_array();
    }

    public function insert($data) {
        $this->db->set($data)->insert('history');

        if($this->db->affected_rows() == 1){
            return $this->db->insert_id();
        }

        return false;
//        return $this->db->insert('history', $data);
    }

    public function insert_with_language($data_vi, $data_en){
        $data_merge = array($data_vi, $data_en);
        return $this->db->insert_batch('history_lang', $data_merge);
    }

    public function update($id, $data) {
        $this->db->where('id', $id);

        return $this->db->update('history', $data);
    }

    public function update_with_language_vi($id, $data_vi){
        $this->db->where('history_id', $id);
        $this->db->where('language', 'vi');
        return $this->db->update('history_lang', $data_vi);
    }

    public function update_with_language_en($id, $data_en){
        $this->db->where('history_id', $id);
        $this->db->where('language', 'en');
        return $this->db->update('history_lang', $data_en);
    }

    public function update_view_number($id, $data){
        $this->db->where('id', $id);

        return $this->db->update('history', $data);
    }

    public function remove($id, $set_delete) {
        $this->db->where('id', $id);

        return $this->db->update('history', $set_delete);
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
