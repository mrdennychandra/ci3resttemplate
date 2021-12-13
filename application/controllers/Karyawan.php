<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Karyawan extends RestController {

    public function __construct(){
        parent::__construct();
        $this->load->model('karyawan_model','karyawan');
    }

    public function index_get(){
        $id = $this->uri->segment(2);
        if($id){
            $data['data'] = $this->karyawan->find_by_id($id);
            if(empty($data['data'])){
                $data['message'] = "No data found";
                $data['status'] = "success";
                $this->response($data,404);
            }
            $this->response($data);
        }else{
            $data['status'] = "success";
            $data['data'] = $this->karyawan->find_all();
            $data['message'] = "";
            $this->response($data);
        }
        
    }

    function index_post(){
        //validasi server side
        $this->form_validation->set_rules('nama','Nama karyawan','required');
        $this->form_validation->set_rules('email','email karyawan','required');
        if($this->form_validation->run() == FALSE){
            $data['status'] = "failed";
            $data['message'] = "error submit";
            $data['error'] = validation_errors();
            $this->response($data,RestController::HTTP_BAD_REQUEST);
        }else{
            //handle upload foto
            $config = array(
                'upload_path' => "./assets/uploads/",
                'allowed_types' => "*",
                'overwrite' => TRUE,
                'max_size' => "2048000" // Can be set to particular file size , here it is 2 MB(2048 Kb)
            );
            $file_name = "";
            $this->load->library('upload', $config);
                if($_FILES['foto']['name'] != ""){
                if ($this->upload->do_upload('foto')) {
                    $upload_data = $this->upload->data(); //Returns array of containing all of the data related to the file you uploaded.
                    $file_name = $upload_data['file_name'];
                } else {
                    $error = array('error' => $this->upload->display_errors());
                    $data['status'] = "failed";
                    $data['message'] = "error submit";
                    $data['error'] = $error;
                    $this->response($data,RestController::HTTP_BAD_REQUEST);
                }
            }
            //lolos validasi
            $row = [
                'nama' => $this->input->post('nama'),
                'email' => $this->input->post('email'),
                'telpon' => $this->input->post('telpon'),
                'jabatan' => $this->input->post('jabatan'),
                'jeniskelamin' => $this->input->post('jeniskelamin'),
                'iddivisi' => $this->input->post('iddivisi'),
                'foto' => $file_name
            ];
            $row['id'] = $this->karyawan->insert($row);
            $data['status'] = "success";
            $data['message'] = "new record added";
            $data['data'] = $row;
            $this->response($data);
        }
    }

 function update_post(){
        //validasi server side
        $this->form_validation->set_rules('id','id karyawan','required');
        $this->form_validation->set_rules('nama','Nama karyawan','required');
        $this->form_validation->set_rules('email','email karyawan','required');
        if($this->form_validation->run() == FALSE){
            $data['status'] = "failed";
            $data['message'] = "error submit";
            $data['error'] = validation_errors();
            $this->response($data,RestController::HTTP_BAD_REQUEST);
        }else{
            //handle upload foto
            $config = array(
                'upload_path' => "./assets/uploads/",
                'allowed_types' => "*",
                'overwrite' => TRUE,
                'max_size' => "2048000" // Can be set to particular file size , here it is 2 MB(2048 Kb)
            );
            $file_name = "";
            $this->load->library('upload', $config);
                if($_FILES['foto']['name'] != ""){
                if ($this->upload->do_upload('foto')) {
                    $upload_data = $this->upload->data(); //Returns array of containing all of the data related to the file you uploaded.
                    $file_name = $upload_data['file_name'];
                } else {
                    $error = array('error' => $this->upload->display_errors());
                    $data['status'] = "failed";
                    $data['message'] = "error submit";
                    $data['error'] = $error;
                    $this->response($data,RestController::HTTP_BAD_REQUEST);
                }
            }
            $id = $this->post('id');
            $row = [
                'nama' => $this->input->post('nama'),
                'email' => $this->input->post('email'),
                'telpon' => $this->input->post('telpon'),
                'jabatan' => $this->input->post('jabatan'),
                'jeniskelamin' => $this->input->post('jeniskelamin'),
                'iddivisi' => $this->input->post('iddivisi'),
                'foto' => $file_name
            ];
            $row['id'] = $id;
            $this->karyawan->update($id,$row);
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
        $this->karyawan->delete($id);
        $data['message'] = "data deleted";
        $this->response($data);
    }

}
}