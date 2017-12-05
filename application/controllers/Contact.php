<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends Public_Controller {

    private $_lang = '';

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->_lang = $this->session->userdata('langAbbreviation');
    }

    public function index() {
        $this->data['current_link'] = 'contact';
        $this->data['lang'] = $this->_lang;
        $this->render('contact_view');
    }

    public function send_mail() {
        $mail = new PHPMailer();
        $mail->IsSMTP(); // set mailer to use SMTP
        $mail->Host = "host07.emailserver.vn"; // specify main and backup server
        $mail->Port = 465; // set the port to use
        $mail->SMTPAuth = true; // turn on SMTP authentication
        $mail->SMTPSecure = 'ssl';
        $mail->Username = "info@thienlocxuan.com.vn"; // your SMTP username or your gmail username
        $mail->Password = "Abcd!234"; // your SMTP password or your gmail password
        $from = "info@thienlocxuan.com.vn"; // Reply to this email
        $to = "info@thienlocxuan.com.vn"; // Recipients email ID
        $name = "info@thienlocxuan.com.vn"; // Recipient's name
        $mail->From = $from;
        $mail->FromName = "info@thienlocxuan.com.vn"; // Name to indicate where the email came from when the recepient received
        $mail->AddAddress($to, $name);
        $mail->AddReplyTo($from);
        $mail->CharSet = 'UTF-8';
        $mail->WordWrap = 50; // set word wrap
        $mail->IsHTML(true); // send as HTML
        $mail->Subject = "Hi " . "info@thienlocxuan.com.vn";
        $message = "test";

        $mail->Body = $message; //HTML Body

        //$mail->SMTPDebug = 2;

        $mail->Send();
    }
}