<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Member_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_all_with_pagination($limit = NULL, $start = NULL) {
        $this->db->select('*');
        $this->db->from('member');
        $this->db->where('is_deleted', 0);
        $this->db->limit($limit, $start);
        $this->db->order_by("role", "asc");

        return $result = $this->db->get()->result_array();
    }

    public function count_all() {
        $this->db->select('*');
        $this->db->from('member');
        $this->db->where('is_deleted', 0);

        return $result = $this->db->get()->num_rows();
    }

    public function get_by_id($id) {
        $this->db->query('SET SESSION group_concat_max_len = 10000000');
        $this->db->select('member.*, GROUP_CONCAT(member_lang.name ORDER BY member_lang.language separator \'|\') as member_name,
                                GROUP_CONCAT(member_lang.bio ORDER BY member_lang.language separator \'|\') as member_bio');
        $this->db->from('member');
        $this->db->join('member_lang', 'member_lang.member_id = member.id', 'left');
        $this->db->where('member.is_deleted', 0);
        $this->db->where('member.id', $id);
        $this->db->limit(1);

        return $this->db->get()->row_array();
    }

    public function check_exist(){
        $this->db->select('*');
        $this->db->from('member');
        $this->db->where('is_deleted', 0);
        $this->db->where('role', 0);

        $count = $this->db->get()->num_rows();

        return ($count > 0) ? TRUE : FALSE;
    }

    public function get_by_language($id, $lang) {
        $this->db->select('*');
        $this->db->from('member');
        $this->db->join('member_lang', 'member_lang.member_id = member.id', 'left');
        $this->db->where('member_lang.language', $lang);
        $this->db->where('member.is_deleted', 0);
        $this->db->where('member.id', $id);
        $this->db->limit(1);

        return $this->db->get()->row_array();
    }

    public function get_all_by_language($lang){
        $this->db->select('*');
        $this->db->from('member');
        $this->db->join('member_lang', 'member_lang.member_id = member.id', 'left');
        $this->db->where('member_lang.language', $lang);
        $this->db->where('member.is_deleted', 0);
        $this->db->order_by("member.id", "desc");

        return $result = $this->db->get()->result_array();
    }

    public function insert($data) {
        $this->db->set($data)->insert('member');

        if($this->db->affected_rows() == 1){
            return $this->db->insert_id();
        }

        return false;
    }

    public function insert_with_language($data_vi, $data_en){
        $data_merge = array($data_vi, $data_en);
        return $this->db->insert_batch('member_lang', $data_merge);
    }

    public function update($id, $data) {
        $this->db->where('id', $id);

        return $this->db->update('member', $data);
    }

    public function update_with_language_vi($type_id, $data_vi){
        $this->db->where('member_id', $type_id);
        $this->db->where('language', 'vi');
        return $this->db->update('member_lang', $data_vi);
    }

    public function update_with_language_en($type_id, $data_en){
        $this->db->where('member_id', $type_id);
        $this->db->where('language', 'en');
        return $this->db->update('member_lang', $data_en);
    }

    public function remove($id, $set_delete) {
        $this->db->where('id', $id);

        return $this->db->update('member', $set_delete);
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
