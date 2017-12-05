<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Group_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_all_with_pagination($limit = NULL, $start = NULL) {
        $this->db->select('product_group.*, GROUP_CONCAT(product_group_lang.title ORDER BY product_group_lang.language separator \' | \') as group_title');
        $this->db->from('product_group');
        $this->db->join('product_group_lang', 'product_group_lang.group_id = product_group.id', 'left');
        $this->db->where('product_group.is_deleted', 0);
        $this->db->limit($limit, $start);
        $this->db->order_by("product_group.id", "desc");
        $this->db->group_by("product_group.id");

        return $result = $this->db->get()->result_array();
    }

    public function count_all() {
        $this->db->select('*');
        $this->db->from('product_group');
        $this->db->where('is_deleted', 0);

        return $result = $this->db->get()->num_rows();
    }

    public function get_by_id($id) {
        $this->db->select('product_group.*, GROUP_CONCAT(product_group_lang.title ORDER BY product_group_lang.language separator \'|\') as group_title');
        $this->db->from('product_group');
        $this->db->join('product_group_lang', 'product_group_lang.group_id = product_group.id', 'left');
        $this->db->where('product_group.is_deleted', 0);
        $this->db->where('product_group.id', $id);
        $this->db->limit(1);

        return $this->db->get()->row_array();
    }

    public function get_by_language($id, $lang) {
        $this->db->select('*');
        $this->db->from('product_group');
        $this->db->join('product_group_lang', 'product_group_lang.group_id = product_group.id', 'left');
        $this->db->where('product_group_lang.language', $lang);
        $this->db->where('product_group.is_deleted', 0);
        $this->db->where('product_group.id', $id);
        $this->db->limit(1);

        return $this->db->get()->row_array();
    }

    public function get_all_by_language($lang){
        $this->db->select('*');
        $this->db->from('product_group');
        $this->db->join('product_group_lang', 'product_group_lang.group_id = product_group.id', 'left');
        $this->db->where('product_group_lang.language', $lang);
        $this->db->where('product_group.is_deleted', 0);
        $this->db->order_by("product_group.id", "desc");

        return $result = $this->db->get()->result_array();
    }

    public function insert($data) {
        $this->db->set($data)->insert('product_group');

        if($this->db->affected_rows() == 1){
            return $this->db->insert_id();
        }

        return false;
    }

    public function insert_with_language($data_vi, $data_en){
        $data_merge = array($data_vi, $data_en);
        return $this->db->insert_batch('product_group_lang', $data_merge);
    }

    public function update($id, $data) {
        $this->db->where('id', $id);

        return $this->db->update('product_group', $data);
    }

    public function update_with_language_vi($type_id, $data_vi){
        $this->db->where('group_id', $type_id);
        $this->db->where('language', 'vi');
        return $this->db->update('product_group_lang', $data_vi);
    }

    public function update_with_language_en($type_id, $data_en){
        $this->db->where('group_id', $type_id);
        $this->db->where('language', 'en');
        return $this->db->update('product_group_lang', $data_en);
    }

    public function remove($id, $set_delete) {
        $this->db->where('id', $id);

        return $this->db->update('product_group', $set_delete);
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
