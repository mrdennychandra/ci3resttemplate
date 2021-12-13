<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Divisi extends RestController {

    public function __construct(){
        parent::__construct();
        $this->load->model('divisi_model','divisi');
    }

    public function index_get(){
        $id = $this->uri->segment(2);
        if($id){
            $data['data'] = $this->divisi->find_by_id($id);
            if(empty($data['data'])){
                $data['message'] = "No data found";
                $data['status'] = "success";
                $this->response($data,404);
            }
            $this->response($data);
        }else{
            $data['status'] = "success";
            $data['data'] = $this->divisi->find_all();
            $data['message'] = "";
            $this->response($data);
        }
        
    }

    function index_post(){
        //validasi server side
        $this->form_validation->set_rules('kode','Kode divisi','required');
        $this->form_validation->set_rules('nama','Nama divisi','required');
        if($this->form_validation->run() == FALSE){
            $data['status'] = "failed";
            $data['message'] = "error submit";
            $data['error'] = validation_errors();
            $this->response($data,RestController::HTTP_BAD_REQUEST);
        }else{
            $row = [
                'kode' => $this->post('kode'),
                'nama' => $this->post('nama')
            ];
            $row['id'] = $this->divisi->insert($row);
            $data['status'] = "success";
            $data['message'] = "new record added";
            $data['data'] = $row;
            $this->response($data);
        }
    }

    function update_post(){
        //validasi server side
        $this->form_validation->set_rules('id','id divisi','required');
        $this->form_validation->set_rules('kode','Kode divisi','required');
        $this->form_validation->set_rules('nama','Nama divisi','required');
        if($this->form_validation->run() == FALSE){
            $data['status'] = "failed";
            $data['message'] = "error submit";
            $data['error'] = validation_errors();
            $this->response($data,RestController::HTTP_BAD_REQUEST);
        }else{
            $id = $this->post('id');
            $row = [
                'kode' => $this->post('kode'),
                'nama' => $this->post('nama')
            ];
            $row['id'] = $id;
            $this->divisi->update($id,$row);
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
            $this->divisi->delete($id);
            $data['message'] = "data deleted";
            $this->response($data);
        }

    }

}