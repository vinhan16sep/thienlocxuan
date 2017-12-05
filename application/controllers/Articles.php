<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';

class Articles extends REST_Controller {

    function __construct(){
        parent::__construct();

        $this->load->model('article_model');
    }

    public function article_get(){
        $articles = $this->article_model->get();

        if($articles){
            $this->response(array('response' => $articles), 200);
        }else{
            $this->response(array('error' => 'No article fetched'), 404);
        }
    }

    public function find_get($id){
        if(!$id){
            $this->response(null, 400);
        }

        $article = $this->article_model->get($id);

        if($article){
            $this->response(array('response' => $article), 200);
        }else{
            $this->response(array('error' => 'Cannot get article'), 404);
        }
    }

    public function article_post(){
        if(!$this->post()){
            $this->response(null, 400);
        }

        $id = $this->article_model->save($this->post());

        if($id){
            $this->response(array('response' => $id), 200);
        }else{
            $this->response(array('error' => 'Cannot save article'), 400);
        }
    }

    public function article_put($id){
        if(!$this->put() || !$id){
            $this->response(null, 400);
        }

        $update = $this->article_model->update($id, $this->put());

        if($update){
            $this->response(array('response' => $update), 200);
        }else{
            $this->response(array('error' => 'Cannot update article'), 400);
        }
    }

    public function article_delete($id){
        if(!$id){
            $this->response(null, 400);
        }

        $delete = $this->article_model->delete($id);

        if($delete){
            $this->response(array('response' => $delete), 200);
        }else{
            $this->response(array('error' => 'Cannot delete article'), 400);
        }
    }
}
