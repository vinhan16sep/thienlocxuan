<?php

class Article_model extends CI_Model {

    function __construct(){
        parent::__construct();
    }

    public function get($id = null){
        if(!is_null($id)){
            $query = $this->db->select('*')->from('articles')->where('id', $id)->get();

            if($query->num_rows() == 1){
                return $query->row_array();
            }

            return false;
        }

        $query = $this->db->select('*')->from('articles')->get();

        if($query->num_rows() > 0){
            return $query->result_array();
        }

        return false;
    }

    public function save($article){
        $this->db->set($article)->insert('articles');

        if($this->db->affected_rows() == 1){
            return $this->db->insert_id();
        }

        return false;
    }

    public function update($id, $article){
        $this->db->set($article)->where('id', $id)->update('articles');

        if($this->db->affected_rows() == 1){
            return true;
        }

        return false;
    }

    public function delete($id){
        $this->db->set('is_deleted', 1)->where('id', $id)->update('articles');

        if($this->db->affected_rows() == 1){
            return true;
        }

        return false;
    }
}