<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Physic_model extends CI_Model {

    protected $_physics = null;

    public function __construct() {
        parent::__construct();
    }

    public function get_all_with_pagination($limit = NULL, $start = NULL) {
        $this->db->select('*');
        $this->db->from('physic');
        $this->db->where('is_deleted', 0);
        $this->db->limit($limit, $start);
        $this->db->order_by("id", "desc");

        return $result = $this->db->get()->result_array();
    }

    public function get_all_with_pagination_search($limit = NULL, $start = NULL, $keywords) {
        $this->db->select('physic.*');
        $this->db->from('physic');
        $this->db->join('physic_lang', 'physic_lang.physic_id = physic.id');
        $this->db->like('physic_lang.title', $keywords);
        $this->db->where('physic.is_deleted', 0);
        $this->db->limit($limit, $start);
        $this->db->group_by('physic_lang.physic_id');
        $this->db->order_by("physic.id", "desc");

        return $result = $this->db->get()->result_array();
    }

    public function get_all_by_language($lang){
        $this->db->select('*');
        $this->db->from('physic');
        $this->db->join('physic_lang', 'physic_lang.physic_id = physic.id', 'left');
        $this->db->where('physic_lang.language', $lang);
        $this->db->where('physic.is_deleted', 0);
        $this->db->order_by("physic.id", "desc");

        return $result = $this->db->get()->result_array();
    }

    public function search($string, $lang){
        $this->db->select('*');
        $this->db->from('physic');
        $this->db->join('physic_lang', 'physic_lang.physic_id = physic.id', 'left');
        $this->db->where('physic_lang.language', $lang);
        $this->db->like('title', $string);
        $this->db->where('physic.is_deleted', 0);
        $this->db->order_by("physic.id", "desc");

        return $result = $this->db->get()->result_array();
    }

    public function fetch_special(){
        $result = $this->db->select('*')
            ->from('physic')
            ->where('is_special', 1)
            ->where('is_deleted', 0)
            ->order_by('id', 'desc')
            ->get();

        return $result->result_array();
    }

    public function filter($lang, $data){
        $this->db->select('*');
        $this->db->from('physic');
        $this->db->join('physic_lang', 'physic_lang.physic_id = physic.id', 'left');
        $this->db->where('physic_lang.language', $lang);
        if($data['type'] != 0){
            $this->db->where('physic.type_id', $data['type']);
        }
        if($data['group'] != 0){
            $this->db->where('physic.group_id', $data['group']);
        }
        $this->db->where('physic.is_deleted', 0);
        $this->db->order_by("physic.id", "desc");

        return $result = $this->db->get()->result_array();
    }

    public function count_all() {
        $this->db->select('*');
        $this->db->from('physic');
        $this->db->where('is_deleted', 0);

        return $result = $this->db->get()->num_rows();
    }

    public function count_search($keyword){
        $this->db->select('*');
        $this->db->from('physic');
        $this->db->join('physic_lang', 'physic_lang.physic_id = physic.id');
        $this->db->like('physic_lang.title', $keyword);
        $this->db->group_by('physic_lang.physic_id');
        $this->db->where('physic.is_deleted', 0);

        return $result = $this->db->get()->num_rows();
    }

    public function get_by_id($id, $lang = '') {
        $this->db->query('SET SESSION group_concat_max_len = 10000000');
        $this->db->select('physic.*, GROUP_CONCAT(physic_lang.title ORDER BY physic_lang.language separator \'|||\') as physic_title, 
                            GROUP_CONCAT(physic_lang.description ORDER BY physic_lang.language separator \'|||\') as physic_description,
                            GROUP_CONCAT(physic_lang.content ORDER BY physic_lang.language separator \'|||\') as physic_content,
                            GROUP_CONCAT(physic_lang.faq ORDER BY physic_lang.language separator \'|||\') as physic_faq,
                            GROUP_CONCAT(physic_lang.ingredients ORDER BY physic_lang.language separator \'|||\') as physic_ingredients,
                            GROUP_CONCAT(physic_lang.attribution ORDER BY physic_lang.language separator \'|||\') as physic_attribution,
                            GROUP_CONCAT(physic_lang.dosage ORDER BY physic_lang.language separator \'|||\') as physic_dosage,
                            GROUP_CONCAT(physic_lang.contraindicating ORDER BY physic_lang.language separator \'|||\') as physic_contraindicating,
                            GROUP_CONCAT(physic_lang.expired ORDER BY physic_lang.language separator \'|||\') as physic_expired,
                            GROUP_CONCAT(physic_lang.certification ORDER BY physic_lang.language separator \'|||\') as physic_certification,
                            GROUP_CONCAT(physic_lang.presentation ORDER BY physic_lang.language separator \'|||\') as physic_presentation');
        $this->db->from('physic');
        $this->db->join('physic_lang', 'physic_lang.physic_id = physic.id', 'left');
        if($lang != ''){
            $this->db->where('physic_lang.language', $lang);
        }
        $this->db->where('physic.is_deleted', 0);
        $this->db->where('physic.id', $id);
        $this->db->limit(1);

        return $this->db->get()->row_array();
    }

    public function insert($data) {
        $this->db->set($data)->insert('physic');

        if($this->db->affected_rows() == 1){
            return $this->db->insert_id();
        }

        return false;
    }

    public function insert_with_language($data_vi, $data_en){
        $data_merge = array($data_vi, $data_en);
        return $this->db->insert_batch('physic_lang', $data_merge);
    }

    public function update($id, $data) {
        $this->db->where('id', $id);

        return $this->db->update('physic', $data);
    }

    public function update_with_language_vi($id, $data_vi){
        $this->db->where('physic_id', $id);
        $this->db->where('language', 'vi');
        return $this->db->update('physic_lang', $data_vi);
    }

    public function update_with_language_en($id, $data_en){
        $this->db->where('physic_id', $id);
        $this->db->where('language', 'en');
        return $this->db->update('physic_lang', $data_en);
    }

    public function remove($id, $set_delete) {
        $this->db->where('id', $id);

        return $this->db->update('physic', $set_delete);
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
