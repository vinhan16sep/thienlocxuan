<?php

include "class.phpmailer.php"; 
include "class.smtp.php"; 

defined('BASEPATH') OR exit('No direct script access allowed');

class Quotation extends Admin_Controller {

    private $_lang = '';

    public function __construct() {
        parent::__construct();
        $this->load->model('quotation_model');
        $this->load->library('session');
        $this->load->helper('url');
    }

    public function index() {
        $this->load->helper('form');
        $this->load->library('pagination');
        $config = array();

        $base_url = base_url() . 'admin/quotation/index';
        $total_rows = $this->quotation_model->count_all(0);
        $per_page = 10;
        $uri_segment = 4;

        foreach ($this->pagination_config($base_url, $total_rows, $per_page, $uri_segment) as $key => $value) {
            $config[$key] = $value;
        }
        $this->pagination->initialize($config);

        $this->data['page_links'] = $this->pagination->create_links();
        $this->data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $this->data['quotations'] = $this->quotation_model->fetch_all_with_pagination($per_page, $this->data['page'], 0);

        $this->render('admin/quotation/list_quotation_view');
    }

    public function approve_list() {
        $this->load->helper('form');
        $this->load->library('pagination');
        $config = array();

        $base_url = base_url() . 'admin/quotation/approve_list';
        $total_rows = $this->quotation_model->count_all(1);
        $per_page = 10;
        $uri_segment = 4;

        foreach ($this->pagination_config($base_url, $total_rows, $per_page, $uri_segment) as $key => $value) {
            $config[$key] = $value;
        }
        $this->pagination->initialize($config);

        $this->data['page_links'] = $this->pagination->create_links();
        $this->data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $this->data['quotations'] = $this->quotation_model->fetch_all_with_pagination($per_page, $this->data['page'], 1);

        $this->render('admin/quotation/list_approve_quotation_view');
    }

    public function reject_list() {
        $this->load->helper('form');
        $this->load->library('pagination');
        $config = array();

        $base_url = base_url() . 'admin/quotation/reject_list';
        $total_rows = $this->quotation_model->count_all(2);
        $per_page = 10;
        $uri_segment = 4;

        foreach ($this->pagination_config($base_url, $total_rows, $per_page, $uri_segment) as $key => $value) {
            $config[$key] = $value;
        }
        $this->pagination->initialize($config);

        $this->data['page_links'] = $this->pagination->create_links();
        $this->data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $this->data['quotations'] = $this->quotation_model->fetch_all_with_pagination($per_page, $this->data['page'], 2);

        $this->render('admin/quotation/list_reject_quotation_view');
    }

    public function workflow(){
        $input = $this->input->get();
        $data['status'] = ($input['action'] == 'approve') ? 1 : 2;
        $result = $this->quotation_model->workflow($input['id'], $data);

        if($result == false){
            $this->output->set_status_header(404)
                ->set_output(json_encode(array('message' => 'Fail', 'data' => $input)));
        }else{
            $this->send_mail($input);
            $this->output->set_status_header(200)
                ->set_output(json_encode(array('message' => 'Success', 'data' => $input)));
        }
    }

    public function send_mail($data) {
        $mail = new PHPMailer();
        $mail->IsSMTP(); // set mailer to use SMTP
        $mail->Host = "host07.emailserver.vn"; // specify main and backup server
        $mail->Port = 465; // set the port to use
        $mail->SMTPAuth = true; // turn on SMTP authentication
        $mail->SMTPSecure = 'ssl';
        $mail->Username = "info@thienlocxuan.com.vn"; // your SMTP username or your gmail username
        $mail->Password = "Abcd!234"; // your SMTP password or your gmail password
        $from = "info@thienlocxuan.com.vn"; // Reply to this email
        $to = strip_tags($data['email']); // Recipients email ID
        $name = strip_tags($data['name']); // Recipient's name
        $mail->From = $from;
        $mail->FromName = "info@thienlocxuan.com.vn"; // Name to indicate where the email came from when the recepient received
        $mail->AddAddress($to, $name);
        $mail->AddReplyTo($from);
        $mail->CharSet = 'UTF-8';
        $mail->WordWrap = 50; // set word wrap
        $mail->IsHTML(true); // send as HTML
        $mail->Subject = "Hi " . strip_tags($data['name']);
        $message = $this->email_template($data['action']);

        $mail->Body = $message; //HTML Body
        if($data['action'] == 'approve'){
            $mail->AddAttachment($_SERVER["DOCUMENT_ROOT"] . '/assets/admin/file/Basic_Design_Maymimi_2017-10-17.docx');
        }
        
        //$mail->SMTPDebug = 2;

        $mail->Send();
    }
    
    public function email_template($action){
        $message = '';
        if($action == 'approve'){
            $message = '<html><body>';
            $message .= '<p>Approve</p>';
            $message .= "</body></html>";
        }elseif($action == 'reject'){
            $message = '<html><body>';
            $message .= '<p>Reject</p>';
            $message .= "</body></html>";
        }else{
            $message = '<html><body>';
            $message .= '<p>Pending</p>';
            $message .= "</body></html>";
        }
        
        return $message;
    }

}