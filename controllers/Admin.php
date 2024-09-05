<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('pinjam_model');
        }
        public function index(){
            $data['title'] = "Ubah Role";
            $data['user'] = $this->db->get_where('user' , ['email' => 
            $this->session->userdata('email')])->row_array();
            $data['role'] = $this->pinjam_model->get_user_role();
            $this->load->view('templates/header',$data);
            $this->load->view('templates/sidebar',$data);
            $this->load->view('templates/topbar',$data);
            $this->load->view('admin/index',$data);
            $this->load->view('templates/footer');
        }

        public function roleAccess($role_id){
            $data['title'] = "Role";
            $data['user'] = $this->db->get_where('user' , ['email' => 
            $this->session->userdata('email')])->row_array();

            $data['role'] = $this->db->get_where('user_role',['id'=>$role_id])->row_array();
            $this->db->where('id !=' , 1);
            $data['menu'] = $this->db->get('user_menu')->result_array();

            $this->load->view('templates/header',$data);
            $this->load->view('templates/sidebar',$data);
            $this->load->view('templates/topbar',$data);
            $this->load->view('Admin/role-access',$data);
            $this->load->view('templates/footer');
        }
        public function changeaccess(){
            $menu_id = $this->input->post('menuId');
            $role_id = $this->input->post('roleId');

            $data = [
                'role_id' => $role_id,
                'menu_id' => $menu_id
            ];
            $result = $this->db->get_where('user_access_menu',$data);

            if ($result->num_rows() < 1) {
                $this->db->insert('user_access_menu',$data);
            }else{
                $this->db->delete('user_access_menu',$data);
            }
            $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">
                                            Access Changed!!
                                            </div>');

        }
        public function hapusUser($id){
            if ($this->Pinjam_model->deleteUser($id)) {
                $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">
                                            Data berhasil di hapus!!
                                        </div>');
                redirect('admin');
            }else {
                $this->session->set_flashdata('message','<div class="alert alert-warning" role="alert">
                                            Data gagal di hapus
                                            </div>');
                redirect('admin');
            }
            }
        public function editRole(){
            $id = $this->input->post('id');
            $role = $this->input->post('role');
            $nip = $this->input->post('nip');
            $data = [
                'role_id' => $role,
                'nip' => $nip
            ];
            $this->db->where('id',$id);
            $this->db->update('user',$data);
            $this->session->set_flashdata('message','<div class="alert alert-warning" role="alert">
                                            Data Berhasil Diubah
                                            </div>');
            redirect('admin');
        }
        
        public function TambahLab(){
            $data['title'] = "Tambah Lab";
            $data['user'] = $this->db->get_where('user' , ['email' => 
            $this->session->userdata('email')])->row_array();

            $this->load->view('templates/header',$data);
            $this->load->view('templates/sidebar',$data);
            $this->load->view('templates/topbar',$data);
            $this->load->view('Admin/tambahLab',$data);
            $this->load->view('templates/footer');

            $namaLab = $this->input->post('TambahLab');
            if ($namaLab) {
                // Menggunakan array untuk memasukkan data ke dalam tabel 'lab'
                $this->db->insert('lab', ['nama' => $namaLab]);
        
                // Menambahkan pesan flashdata untuk notifikasi
                $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">Lab berhasil ditambahkan</div>');
        
                // Mengarahkan kembali ke halaman tambahLab
                redirect('Admin/tambahLab');
        }
    }
    public function hapusLab(){
        $id = $this->input->post('idHapus');
        $this->db->where('id',$id);
        $this->db->delete('lab');
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Lab berhasil DiHapus!!</div>');
        redirect('Admin/tambahLab');
    }
    public function editLab(){
        $id = $this->input->post('idEdit');
        $nama = $this->input->post('namLab');
        
        
        
        $this->db->where('id',$id);
        $this->db->update('lab',['nama'=>$nama]);
        echo $this->db->last_query();

    // Debugging: Cek apakah query berhasil mengubah data
    if ($this->db->affected_rows() > 0) {
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Lab berhasil Di Ubah!!!</div>');
        
    } else {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Tidak ada perubahan yang dilakukan! Data mungkin sama atau ID tidak ditemukan.</div>');
    }

    redirect('Admin/tambahLab');
    }
    
}

