<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_all_with_pagination($limit = NULL, $start = NULL) {
        $this->db->select('*');
        $this->db->from('product');
        $this->db->where('is_deleted', 0);
        $this->db->limit($limit, $start);
        $this->db->order_by("id", "desc");

        return $result = $this->db->get()->result_array();
    }

    public function get_all_with_pagination_search($limit = NULL, $start = NULL, $keywords) {
        $this->db->select('product.*');
        $this->db->from('product');
        $this->db->join('product_lang', 'product_lang.product_id = product.id');
        $this->db->like('product_lang.title', $keywords);
        $this->db->where('product.is_deleted', 0);
        $this->db->limit($limit, $start);
        $this->db->group_by('product_lang.product_id');
        $this->db->order_by("product.id", "desc");

        return $result = $this->db->get()->result_array();
    }

    public function get_all() {
        $this->db->select('*');
        $this->db->from('product');
        $this->db->where('is_deleted', 0);
        $this->db->order_by("id", "desc");

        return $result = $this->db->get()->result_array();
    }

    public function get_all_by_language($lang){
        $this->db->select('*');
        $this->db->from('product');
        $this->db->join('product_lang', 'product_lang.product_id = product.id', 'left');
        $this->db->where('product_lang.language', $lang);
        $this->db->where('product.is_deleted', 0);
        $this->db->order_by("product.id", "desc");

        return $result = $this->db->get()->result_array();
    }

    public function search($string, $lang){
        $this->db->select('*');
        $this->db->from('product');
        $this->db->join('product_lang', 'product_lang.product_id = product.id', 'left');
        $this->db->where('product_lang.language', $lang);
        $this->db->like('title', $string);
        $this->db->where('product.is_deleted', 0);
        $this->db->order_by("product.id", "desc");

        return $result = $this->db->get()->result_array();
    }

    public function fetch_special(){
        $result = $this->db->select('*')
            ->from('product')
            ->where('is_special', 1)
            ->where('is_deleted', 0)
            ->order_by('id', 'desc')
            ->get();

        return $result->result_array();
    }

    public function filter($lang, $data){
        $this->db->select('*');
        $this->db->from('product');
        $this->db->join('product_lang', 'product_lang.product_id = product.id', 'left');
        $this->db->where('product_lang.language', $lang);
        if($data['type'] != 0){
            $this->db->where('product.type_id', $data['type']);
        }
        if($data['group'] != 0){
            $this->db->where('product.group_id', $data['group']);
        }
        $this->db->where('product.is_deleted', 0);
        $this->db->order_by("product.id", "desc");

        return $result = $this->db->get()->result_array();
    }

    public function count_all() {
        $this->db->select('*');
        $this->db->from('product');
        $this->db->where('is_deleted', 0);

        return $result = $this->db->get()->num_rows();
    }

    public function count_search($keyword){
        $this->db->select('*');
        $this->db->from('product');
        $this->db->join('product_lang', 'product_lang.product_id = product.id');
        $this->db->like('product_lang.title', $keyword);
        $this->db->group_by('product_lang.product_id');
        $this->db->where('product.is_deleted', 0);

        return $result = $this->db->get()->num_rows();
    }

    public function get_by_id($id, $lang = '') {
        $this->db->query('SET SESSION group_concat_max_len = 10000000');
        $this->db->select('product.*, GROUP_CONCAT(product_lang.title ORDER BY product_lang.language separator \'|||\') as product_title, 
                            GROUP_CONCAT(product_lang.description ORDER BY product_lang.language separator \'|||\') as product_description,
                            GROUP_CONCAT(product_lang.content ORDER BY product_lang.language separator \'|||\') as product_content,
                            GROUP_CONCAT(product_lang.faq ORDER BY product_lang.language separator \'|||\') as product_faq,
                            GROUP_CONCAT(product_lang.ingredients ORDER BY product_lang.language separator \'|||\') as product_ingredients,
                            GROUP_CONCAT(product_lang.attribution ORDER BY product_lang.language separator \'|||\') as product_attribution,
                            GROUP_CONCAT(product_lang.dosage ORDER BY product_lang.language separator \'|||\') as product_dosage,
                            GROUP_CONCAT(product_lang.contraindicating ORDER BY product_lang.language separator \'|||\') as product_contraindicating,
                            GROUP_CONCAT(product_lang.expired ORDER BY product_lang.language separator \'|||\') as product_expired,
                            GROUP_CONCAT(product_lang.certification ORDER BY product_lang.language separator \'|||\') as product_certification,
                            GROUP_CONCAT(product_lang.presentation ORDER BY product_lang.language separator \'|||\') as product_presentation');
        $this->db->from('product');
        $this->db->join('product_lang', 'product_lang.product_id = product.id', 'left');
        if($lang != ''){
            $this->db->where('product_lang.language', $lang);
        }
        $this->db->where('product.is_deleted', 0);
        $this->db->where('product.id', $id);
        $this->db->limit(1);

        return $this->db->get()->row_array();
    }

    public function insert($data) {
        $this->db->set($data)->insert('product');

        if($this->db->affected_rows() == 1){
            return $this->db->insert_id();
        }

        return false;
//        return $this->db->insert('blog', $data);
    }

    public function insert_with_language($data_vi, $data_en){
        $data_merge = array($data_vi, $data_en);
        return $this->db->insert_batch('product_lang', $data_merge);
    }

    public function update($id, $data) {
        $this->db->where('id', $id);

        return $this->db->update('product', $data);
    }

    public function update_with_language_vi($id, $data_vi){
        $this->db->where('product_id', $id);
        $this->db->where('language', 'vi');
        return $this->db->update('product_lang', $data_vi);
    }

    public function update_with_language_en($id, $data_en){
        $this->db->where('product_id', $id);
        $this->db->where('language', 'en');
        return $this->db->update('product_lang', $data_en);
    }

    public function remove($id, $set_delete) {
        $this->db->where('id', $id);

        return $this->db->update('product', $set_delete);
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
