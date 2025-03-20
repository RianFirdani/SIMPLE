<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('pinjam_model');
    }
    public function index()
    {
        $data['title'] = "Role Access";
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();
        $data['role'] = $this->pinjam_model->get_user_role();
        $data['level'] = $this->pinjam_model->getNamaLab();
        
        $role_id_user_login = $data['user']['role_id'];
        $data['role_id_user_login'] = $role_id_user_login;
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('templates/footer');
    }

    public function hapusUser()
    {
        $id = $this->input->post('idHapusUser');
        $this->db->where('id', $id);
        $this->db->delete('user');
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">User berhasil DiHapus!!</div>');
        redirect('Admin');
    }

    public function editRole()
    {       
        $user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $id = $this->input->post('id');
        $role = $this->input->post('role');
        $nip = $this->input->post('nip');
        $level = $this->input->post('level');
        $data = [
            'role_id' => $role,
            'nip' => $nip,
            'level' => $level
        ];
        $this->db->where('id', $id);
        $this->db->update('user', $data);
        $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">
                                            Data Berhasil Diubah
                                            </div>');
        redirect('admin');
    }

    public function TambahLab()
    {
        $data['title'] = "Tambah Lab";
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

        $namaLab = $this->input->post('TambahLab');
        $kalab = $this->input->post('kalab');
        $teknisi = $this->input->post('teknisi');

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('Admin/tambahLab', $data);
        $this->load->view('templates/footer');

        if($namaLab){
            $data=[
                'nama'=>$namaLab,
                'kalab'=>$kalab,
                'teknisi'=>$teknisi
            ];
                // Menggunakan array untuk memasukkan data ke dalam tabel 'lab'
                $this->db->insert('lab', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">Lab berhasil ditambahkan</div>');
            redirect('admin/TambahLab');
        }


            // Menambahkan pesan flashdata untuk notifikasi

            
    }
    public function hapusLab()
    {
        $id = $this->input->post('idHapus');
        $this->db->where('id', $id);
        $this->db->delete('lab');
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Lab berhasil DiHapus!!</div>');
        redirect('Admin/tambahLab');
    }
    public function editLab()
    {
        $id = $this->input->post('idEdit');
        $nama = $this->input->post('namLab');
        $this->db->where('id', $id);
        $this->db->update('lab', ['nama' => $nama]);
        echo $this->db->last_query();

        // Debugging: Cek apakah query berhasil mengubah data
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Lab berhasil Di Ubah!!!</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Tidak ada perubahan yang dilakukan! Data mungkin sama atau ID tidak ditemukan.</div>');
        }

        redirect('Admin/tambahLab');
    }

    public function dashboard()
    {
        $data['title'] = "Dashboard";
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();
        

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('Admin/dashboard', $data);
        $this->load->view('templates/footer');

    }
    public function registrationAdmin(){    
            $data = [
                'name' => htmlspecialchars($this->input->post('name',true)),
                'email' => htmlspecialchars($this->input->post('email',true)),
                'nip' => htmlspecialchars($this->input->post('nip',true)),
                'password' => password_hash($this->input->post('pass'),PASSWORD_DEFAULT),
                'role_id' => htmlspecialchars($this->input->post('role',true)),
                'level' => htmlspecialchars($this->input->post('level',true)),
                'is_active'=> 1
            ];
            $this->db->insert('user',$data);
            $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">
                                            Akun anda telah berhasil dibuat
                                            </div>');
            redirect('admin/index');
        }
}
