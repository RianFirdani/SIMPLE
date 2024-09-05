<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dosen extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Pinjam_model');
        }
        public function index(){
            $data['title'] = "Pinjam Lab Elektro";
            $data['user'] = $this->db->get_where('user' , ['email' => 
            $this->session->userdata('email')])->row_array();
            $this->load->view('templates/header',$data);
            $this->load->view('templates/sidebar',$data);
            $this->load->view('templates/topbar',$data);
            $this->load->view('dosen/index',$data);
            $this->load->view('templates/footer');
        }
    
    
    public function pinjam(){
        $data['user'] = $this->db->get_where('user' , ['email' => 
        $this->session->userdata('email')])->row_array();
        
        $this->form_validation->set_rules('peminjam','Peminjam','required');
        $this->form_validation->set_rules('tanggal','Tanggal','required');
        $this->form_validation->set_rules('mulai','Mulai','required');
        $this->form_validation->set_rules('selesai','Selesai','required');
        $data = [
            'peminjam' => $this->input->post('peminjam'),
            'penginput' => $this->input->post('penginput'),
            'tanggal_pinjam' => $this->input->post('tanggal'),
            'jam' => $this->input->post('mulai'),
            'selesai' => $this->input->post('selesai'),
            'nama_lab' =>$this->input->post('lab')
        ];
        $datetime_input = $data['tanggal_pinjam'] . ' ' . $data['jam'];
        $datetime_now = date('Y-m-d H:i:s');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">
                                            input anda salah
                                            </div>');
            redirect('Dosen');
        }else{
            if ($datetime_input <= $datetime_now) {
                $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">
                                            Input Salah
                                        </div>');
                    redirect('Dosen');
            }else{
                if ($this->Pinjam_model->check_jadwal_bentrok($data['tanggal_pinjam'],$data['jam'],$data['selesai'],$data['nama_lab'])) {
                    $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">
                                            Jadwal Bentrok!!
                                        </div>');
                    redirect('Dosen');
                } else {
                if ($data['jam']>$data['selesai']) {
                    $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">
                                    Input Salah
                                </div>');
                    redirect('Dosen');
                }else{
                    $this->db->insert('pinjam',$data);
                    $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">
                                            Peminjaman lab berhasil
                                        </div>');
                    redirect('mahasiswa/index');
                }
            }
            }
        }
    } 
    public function hapusPinjam(){
        $id = $this->input->post('id');
        $this->db->where('id',$id);
        $this->db->delete('pinjam');
        $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">
                                        Peminjaman lab berhasil di hapus!!!
                                    </div>');
            redirect('mahasiswa/index');
        }
    public function editPinjam(){
        $id = $this->input->post('id');
        $peminjam = $this->input->post('peminjam');
        $penginput = $this->input->post('penginput');
        $tanggal = $this->input->post('tanggal');
        $mulai = $this->input->post('mulai');
        $selesai = $this->input->post('selesai');
        $lab = $this->input->post('lab');

        $data = [
            'peminjam' => $peminjam,
            'penginput' => $penginput,
            'tanggal_pinjam' => $tanggal,
            'jam' => $mulai,
            'selesai' => $selesai,
            'nama_lab' => $lab
        ];
        $datetime_input = $tanggal . ' ' . $mulai;
        $datetime_now = date('Y-m-d H:i:s');
        if ($datetime_input <= $datetime_now) {
            $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">
                                        Input Salah
                                    </div>');
                redirect('Mahasiswa');
        }else{
            if ($this->Pinjam_model->check_jadwal_bentrok($tanggal,$mulai,$selesai,$lab)) {
                $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">
                                        Jadwal Bentrok!!
                                    </div>');
                redirect('Mahasiswa');
            } else {
                if($mulai>$selesai){
                    $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">
                                        Input salah
                                    </div>');
                    redirect('mahasiswa');
                }else{
                    $this->db->where('id',$id);
                    $this->db->update('pinjam',$data);
                    $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">
                                                Peminjaman lab berhasil di edit
                                            </div>');
                    redirect('mahasiswa');
                }
            
        }
        }

    }
    }

