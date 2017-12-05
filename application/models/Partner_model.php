<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Partner_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_all_with_pagination($limit = NULL, $start = NULL) {
        $this->db->select('*');
        $this->db->from('partner');
        $this->db->where('is_deleted', 0);
        $this->db->limit($limit, $start);
        $this->db->order_by("id", "desc");

        return $result = $this->db->get()->result_array();
    }

    public function get_all_by_language($lang){
        $this->db->select('*');
        $this->db->from('partner');
        $this->db->join('partner_lang', 'partner_lang.partner_id = partner.id', 'left');
        $this->db->where('partner_lang.language', $lang);
        $this->db->where('partner.is_deleted', 0);
        $this->db->order_by("partner.id", "desc");

        return $result = $this->db->get()->result_array();
    }

    public function get_all() {
        $this->db->select('*');
        $this->db->from('blog');
        $this->db->where('is_deleted', 0);
        $this->db->order_by("id", "desc");

        return $result = $this->db->get()->result_array();
    }

    public function get_latest_article($lang){
        $this->db->select('*');
        $this->db->from('partner');
        $this->db->join('partner_lang', 'partner_lang.partner_id = partner.id', 'left');
        $this->db->where('partner_lang.language', $lang);
        $this->db->where('partner.is_deleted', 0);
        $this->db->limit(3);
        $this->db->order_by("partner.id", "desc");

        return $result = $this->db->get()->result_array();
    }

    public function count_all() {
        $this->db->select('*');
        $this->db->from('partner');
        $this->db->where('is_deleted', 0);

        return $result = $this->db->get()->num_rows();
    }

    public function get_by_id($id, $lang = '') {
        $this->db->query('SET SESSION group_concat_max_len = 10000000');
        $this->db->select('partner.*, GROUP_CONCAT(partner_lang.name ORDER BY partner_lang.language separator \'|||\') as partner_name, 
                            GROUP_CONCAT(partner_lang.description ORDER BY partner_lang.language separator \'|||\') as partner_description');
        $this->db->from('partner');
        $this->db->join('partner_lang', 'partner_lang.partner_id = partner.id', 'left');
        if($lang != ''){
            $this->db->where('partner_lang.language', $lang);
        }
        $this->db->where('partner.is_deleted', 0);
        $this->db->where('partner.id', $id);
        $this->db->limit(1);

        return $this->db->get()->row_array();
    }

    public function insert($data) {
        $this->db->set($data)->insert('partner');

        if($this->db->affected_rows() == 1){
            return $this->db->insert_id();
        }

        return false;
//        return $this->db->insert('blog', $data);
    }

    public function insert_with_language($data_vi, $data_en){
        $data_merge = array($data_vi, $data_en);
        return $this->db->insert_batch('partner_lang', $data_merge);
    }

    public function update($id, $data) {
        $this->db->where('id', $id);

        return $this->db->update('partner', $data);
    }

    public function update_with_language_vi($id, $data_vi){
        $this->db->where('partner_id', $id);
        $this->db->where('language', 'vi');
        return $this->db->update('partner_lang', $data_vi);
    }

    public function update_with_language_en($id, $data_en){
        $this->db->where('partner_id', $id);
        $this->db->where('language', 'en');
        return $this->db->update('partner_lang', $data_en);
    }

    public function remove($id, $set_delete) {
        $this->db->where('id', $id);

        return $this->db->update('partner', $set_delete);
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
