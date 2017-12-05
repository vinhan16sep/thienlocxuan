<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Quotation_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function fetch_all_with_pagination($limit = NULL, $start = NULL, $status) {
        $this->db->select('*');
        $this->db->from('quotation');
        $this->db->where('status', $status);
        $this->db->where('is_deleted', 0);
        $this->db->limit($limit, $start);
        $this->db->order_by("id", "desc");

        return $result = $this->db->get()->result_array();
    }

    public function count_all($status) {
        $this->db->select('*');
        $this->db->from('quotation');
        $this->db->where('status', $status);
        $this->db->where('is_deleted', 0);

        return $result = $this->db->get()->num_rows();
    }

    public function insert($data) {
        $this->db->set($data)->insert('quotation');

        if($this->db->affected_rows() == 1){
            return $this->db->insert_id();
        }

        return false;
    }

    public function workflow($id, $data){
        $this->db->set($data)->where('id', $id)->update('quotation');

        if($this->db->affected_rows() == 1){
            return true;
        }

        return false;
    }

}
