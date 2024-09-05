<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pinjam_model extends CI_model{
    public function getSubMenu(){
        $query = "SELECT `user_sub_menu`.*, `user_menu`.`menu`
                  FROM `user_sub_menu` JOIN `user_menu`
                  ON `user_sub_menu`.`menu_id` = `user_menu`.`id`
                ";
        return $this->db->query($query)->result_array();
    }
    public function delete($id){
        $this->db->where('id',$id);
        return $this->db->delete('pinjam');
    }
    public function check_jadwal_bentrok($tanggal, $jam_mulai, $jam_selesai,$nama_lab) {
        // Menggunakan where dengan kondisi kompleks sebagai string
        $this->db->where('tanggal_pinjam', $tanggal);
        $this->db->where('nama_lab', $nama_lab);
        $this->db->where("(
            (jam < '$jam_selesai' AND selesai > '$jam_mulai')
        )");
        $query = $this->db->get('pinjam');
        return $query->num_rows() > 0;
    }
    public function deleteUser($id){
        $this->db->where('id',$id);
        return $this->db->delete('user');
    }
    public function deleteLab($id){
        $this->db->where('id',$id);
        return $this->db->delete('lab');
    }
    
    // public function search_by_date($tanggal) {
    //     // Query untuk mencari mahasiswa berdasarkan tanggal tertentu
    //     $this->db->where('tanggal_pinjam', $tanggal); // Sesuaikan nama kolom dengan tabel Anda
    //     $query = $this->db->get('pinjam'); // Ganti 'mahasiswa' dengan nama tabel yang sesuai
    //     return $query->result_array();
    // }

    public function editRole($id,$data){
        $this->db->where('id',$id);
        return $this->db->update('users', $data);
    }

    public function get_user_role() {
        $this->db->select('*');
        $this->db->from('user_role');
        $query = $this->db->get();
        return $query->result_array();
    }
}