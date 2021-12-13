<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index(){
		$username = $this->input->post('username');
        $password = $this->input->post('password');
        //function login
        //insert users
        //insert keys
        $data['message'] = "login success";
        $data['status'] = "success";
        $data['data'] = [
            'userid' => 1,
            'x-api-key' => 'abcdef'
        ];
        echo json_encode($data);
        header("Content-type:application/json");
	}
}
