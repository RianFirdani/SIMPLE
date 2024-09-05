<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mahasiswa extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Pinjam_model');
        }
        public function index(){
            $data['title'] = "Daftar Peminjaman Lab ";
            $data['user'] = $this->db->get_where('user' , ['email' => 
            $this->session->userdata('email')])->row_array();
            $this->load->view('templates/header',$data);
            $this->load->view('templates/sidebar',$data);
            $this->load->view('templates/topbar',$data);
            $this->load->view('mahasiswa/index',$data);
            $this->load->view('templates/footer');

            $data['mahasiswa'] = [];
        }
        // public function search(){
        //     $tanggal = $this->input->post('tanggal');
        //     $data['pinjam'] = $this->Pinjam_model->search_by_date($tanggal);
        //     $data['title'] = "Daftar Peminjaman Lab ";
        //     $data['user'] = $this->db->get_where('user' , ['email' => 
        //     $this->session->userdata('email')])->row_array();
        //     $this->load->view('Mahasiswa/index',$data);
        // }
        public function changePassword(){
            $data['title'] = "Change Password";
            $data['user'] = $this->db->get_where('user' , ['email' => 
            $this->session->userdata('email')])->row_array();
            $this->form_validation->set_rules('currentPassword','Current Password','required|trim');
            $this->form_validation->set_rules('newPassword1','New Password','required|trim|min_length[8]|matches[newPassword2]');
            $this->form_validation->set_rules('newPassword2','Confirm New Password','required|trim|min_length[8]|matches[newPassword1]');
    
    
            if($this->form_validation->run()==false){
                $this->load->view('templates/header',$data);
            $this->load->view('templates/sidebar',$data);
            $this->load->view('templates/topbar',$data);
            $this->load->view('mahasiswa/changePassword',$data);
            $this->load->view('templates/footer');
            }else{
                $currentPassword = $this->input->post('currentPassword');
                $newPassword = $this->input->post('newPassword1');
                if(!password_verify($currentPassword,$data['user']['password'])){
                    $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">
                                                Wrong Current Password
                                                </div>');
                redirect('mahasiswa/changePassword');
                }else {
                    if ($currentPassword == $newPassword) {
                        $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">
                                                The Password cant be same as current password
                                                </div>');
                    }else{
                        $passwordHash = password_hash($newPassword,PASSWORD_DEFAULT);
                        $this->db->set('password',$passwordHash);
                        $this->db->where('email',$this->session->userdata('email'));
                        $this->db->update('user');
    
                        $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">
                                                Your Password Has Changed
                                                </div>');
                        redirect('mahasiswa/changePassword');
                    }
                }
            }
        }
        public function edit(){
            $data['title'] = "Edit Profile";
                $data['user'] = $this->db->get_where('user' , ['email' => 
                $this->session->userdata('email')])->row_array();
                $this->form_validation->set_rules('name','Full Name','required|trim');
    
                if($this->form_validation->run() == false){
                    $this->load->view('templates/header',$data);
                    $this->load->view('templates/sidebar',$data);
                    $this->load->view('templates/topbar',$data);
                    $this->load->view('mahasiswa/edit',$data);
                    $this->load->view('templates/footer');
                }else{
                    $name = $this->input->post('name');
                    $email = $this->input->post('email');
                    $this->db->set('name',$name);
                    $this->db->where('email',$email);
                    $this->db->update('user');
    
                    $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">
                                                Profil telah di perbarui!!!
                                                </div>');
                redirect('mahasiswa/edit');
                }        
        }
    }
        
