<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class User extends RestController {

    public function __construct(){
        parent::__construct();
        $this->load->model('users_model','user');
    }

    public function index_get(){
        $id = $this->uri->segment(2);
        if($id){
            $data['data'] = $this->user->find_by_id($id);
            if(empty($data['data'])){
                $data['message'] = "No data found";
                $data['status'] = "success";
                $this->response($data,404);
            }
            $this->response($data);
        }else{
            $data['status'] = "success";
            $data['data'] = $this->user->find_all();
            $data['message'] = "";
            $this->response($data);
        }
        
    }

    function index_post(){
        //validasi server side
        $this->form_validation->set_rules('username','Username','required');
        $this->form_validation->set_rules('password','Password','required');
        if($this->form_validation->run() == FALSE){
            $data['status'] = "failed";
            $data['message'] = "error submit";
            $data['error'] = validation_errors();
            $this->response($data,RestController::HTTP_BAD_REQUEST);
        }else{
            $row = [
                'username' => $this->post('username'),
                'password' => $this->post('password'),
				'role' => $this->post('role'),
				'idkaryawan' => $this->post('idkaryawan'),
				'tgllahir' => $this->post('tgllahir'),
            ];
            $row['id'] = $this->user->insert($row);
            $data['status'] = "success";
            $data['message'] = "new record added";
            $data['data'] = $row;
            $this->response($data);
        }
    }

    function update_post(){
        //validasi server side
        $this->form_validation->set_rules('id','id user','required');
        $this->form_validation->set_rules('username','Username','required');
        $this->form_validation->set_rules('password','Password','required');
        if($this->form_validation->run() == FALSE){
            $data['status'] = "failed";
            $data['message'] = "error submit";
            $data['error'] = validation_errors();
            $this->response($data,RestController::HTTP_BAD_REQUEST);
        }else{
            $id = $this->post('id');
			$row = [
                'username' => $this->post('username'),
                'password' => $this->post('password'),
				'role' => $this->post('role'),
				'idkaryawan' => $this->post('idkaryawan'),
				'tgllahir' => $this->post('tgllahir'),
            ];
            $row['id'] = $id;
            $this->user->update($id,$row);
            $data['status'] = "success";
            $data['message'] = "record updated";
            $data['data'] = $row;
            $this->response($data);
        }
    }

    function index_delete(){
        $id = $this->uri->segment(2);
        if(!$id){
            $data['status'] = "failed";
            $data['error'] = "id required";
            $data['message'] = "";
            $this->response($data,RestController::HTTP_BAD_REQUEST);
        }else{
            $data['status'] = "success";
            $this->user->delete($id);
            $data['message'] = "data deleted";
            $this->response($data);
        }

    }

}
