<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Type_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_all_with_pagination($limit = NULL, $start = NULL) {
        $this->db->select('product_type.*, GROUP_CONCAT(product_type_lang.title ORDER BY product_type_lang.language separator \' | \') as type_title');
        $this->db->from('product_type');
        $this->db->join('product_type_lang', 'product_type_lang.type_id = product_type.id', 'left');
        $this->db->where('product_type.is_deleted', 0);
        $this->db->limit($limit, $start);
        $this->db->order_by("product_type.id", "desc");
        $this->db->group_by("product_type.id");

        return $result = $this->db->get()->result_array();
    }

    public function get_all_by_language($lang){
        $this->db->select('*');
        $this->db->from('product_type');
        $this->db->join('product_type_lang', 'product_type_lang.type_id = product_type.id', 'left');
        $this->db->where('product_type_lang.language', $lang);
        $this->db->where('product_type.is_deleted', 0);
        $this->db->order_by("product_type.id", "desc");

        return $result = $this->db->get()->result_array();
    }

    public function count_all() {
        $this->db->select('*');
        $this->db->from('product_type');
        $this->db->where('is_deleted', 0);

        return $result = $this->db->get()->num_rows();
    }

    public function get_by_id($id) {
        $this->db->select('product_type.*, GROUP_CONCAT(product_type_lang.title ORDER BY product_type_lang.language separator \'|\') as type_title');
        $this->db->from('product_type');
        $this->db->join('product_type_lang', 'product_type_lang.type_id = product_type.id', 'left');
        $this->db->where('product_type.is_deleted', 0);
        $this->db->where('product_type.id', $id);
        $this->db->limit(1);

        return $this->db->get()->row_array();
    }

    public function insert($data) {
        $this->db->set($data)->insert('product_type');

        if($this->db->affected_rows() == 1){
            return $this->db->insert_id();
        }

        return false;
    }

    public function insert_with_language($data_vi, $data_en){
        $data_merge = array($data_vi, $data_en);
        return $this->db->insert_batch('product_type_lang', $data_merge);
    }

    public function update($id, $data) {
        $this->db->where('id', $id);

        return $this->db->update('product_type', $data);
    }

    public function update_with_language_vi($type_id, $data_vi){
        $this->db->where('type_id', $type_id);
        $this->db->where('language', 'vi');
        return $this->db->update('product_type_lang', $data_vi);
    }

    public function update_with_language_en($type_id, $data_en){
        $this->db->where('type_id', $type_id);
        $this->db->where('language', 'en');
        return $this->db->update('product_type_lang', $data_en);
    }

    public function remove($id, $set_delete) {
        $this->db->where('id', $id);

        return $this->db->update('product_type', $set_delete);
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
