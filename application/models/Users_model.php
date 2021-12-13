<?php
class Users_model extends CI_Model{

    public $table = "users";

    public function __construct(){
        parent::__construct();
    }

    public function insert($data){
        $this->db->insert($this->table,$data);
        return $this->db->insert_id();
    }

    public function update($id,$data){
        //ci akan men-generate statement where 
        $this->db->where('id',$id);
        //ci mengupdate sesuai where diatas
        return $this->db->update($this->table,$data);
    }

    public function find_all(){
        return $this->db->query("SELECT users.*,karyawan.nama as namakaryawan 
        FROM users 
        INNER JOIN karyawan ON users.idkaryawan = karyawan.id")->result_array();
    }

    public function find_by_id($id){
        return $this->db->query("SELECT users.*,karyawan.nama as namakaryawan 
        FROM users 
        INNER JOIN karyawan ON users.idkaryawan = karyawan.id WHERE users.id='$id'")->row_array();
    }

    public function delete($id){
        $this->db->where('id',$id);
        $this->db->delete($this->table);
    }

    public function pagination($limit,$start){
        $result =  $this->db->query("SELECT users.*,karyawan.nama as namakaryawan 
        FROM users 
        INNER JOIN karyawan ON users.idkaryawan = karyawan.id LIMIT $start,$limit")->result_array();
        if(count($result) > 0){
            return $result;
        }
        return false;
    }

    public function get_total(){
        return $this->db->count_all($this->table);
    }
}