<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class KalabTeknisi extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Pinjam_model');
        date_default_timezone_set('Asia/Makassar');
        }
        public function index()
    {
        $data['title'] = "Dashboard ";
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();
        $user = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();
        if ($user['level'] != 1) {
            $data['inputLab'] = $this->input->post('lab');
            $this->db->where('id',$user['level']);
            $lab = $this->db->get('lab')->row_array();
            $data['nama_lab'] = $lab['nama'];
        }else{
            $data['inputLab'] = $this->input->post('lab');
            // $this->db->where('id',$data['inputLab']);
            // $lab = $this->db->get('lab')->row_array();
            // $data['nama_lab'] = $lab['nama'];
            if (!empty($data['inputLab'])) {
                $this->db->where('id', $data['inputLab']);
                $lab = $this->db->get('lab')->row_array();
            
                // Pastikan bahwa query mengembalikan hasil sebelum mengakses array
                if (!empty($lab)) {
                    $data['nama_lab'] = $lab['nama'];
                } else {
                    $data['nama_lab'] = 'Lab tidak ditemukan';  // Tanggapan jika tidak ada lab ditemukan
                }
            } else {
                $data['nama_lab'] = '';  // Pesan ketika lab belum dipilih
            }
        }
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('kalabTeknisi/index', $data);
        $this->load->view('templates/footer');
    }
    
    
        public function pinjam(){
            $data['user'] = $this->db->get_where('user' , ['email' => 
            $this->session->userdata('email')])->row_array();
            $data['level'] = $this->Pinjam_model->getNamaLab();
        
            $this->form_validation->set_rules('peminjam','Peminjam','required');
            $this->form_validation->set_rules('tanggal','Tanggal','required');
            $this->form_validation->set_rules('mulai','Mulai','required');
            $this->form_validation->set_rules('selesai','Selesai','required');
            $this->form_validation->set_rules('teori','Teori','required');
            $this->form_validation->set_rules('kelas','Kelas','required');
            $this->form_validation->set_rules('matkul','Matkul','required');
        
            $data = [
                'Teori/Praktek' => $this->input->post('teori'),
                'wakil_mhs' => $this->input->post('mhs'),
                'matkul' => $this->input->post('matkul'),
                'kelas' => $this->input->post('kelas'),
                'dosen_pengajar' => $this->input->post('peminjam'),
                'penginput' => $this->input->post('penginput'),
                'tanggal_pinjam' => $this->input->post('tanggal'),
                'jam' => $this->input->post('mulai'),
                'selesai' => $this->input->post('selesai'),
                'nama_lab' => $this->input->post('lab')
            ];

            $datetime_input = $data['tanggal_pinjam'] . ' ' . $data['jam'];
            $datetime_now = date('Y-m-d H:i:s');
            $current_date = date('Y-m-d');
            $current_time = date('H:i:s');

            
        
            if ($this->form_validation->run() == false) {
                $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">
                                                input anda salah
                                                </div>');
                redirect('kalabTeknisi/jadwal');
            } else {
                // Pengecekan jika tanggal sama dengan hari ini
                if ($data['tanggal_pinjam'] == $current_date && $data['jam'] <= $current_time ) {
                    $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">
                                                Jam mulai harus lebih dari waktu sekarang!
                                            </div>');
                    redirect('kalabTeknisi/jadwal');
                } else {
                    if ($datetime_input <= $datetime_now) {
                        $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">
                                                Input Salah
                                            </div>');
                        redirect('kalabTeknisi/jadwal');
                    } else {
                        if ($this->Pinjam_model->check_jadwal_bentrok($data['tanggal_pinjam'], $data['jam'], $data['selesai'], $data['nama_lab'])) {
                            $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">
                                                    Jadwal Bentrok!!
                                                </div>');
                            redirect('kalabTeknisi/jadwal');
                        } else {
                            if ($data['jam'] > $data['selesai']) {
                                $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">
                                                Input Salah
                                            </div>');
                                redirect('kalabTeknisi/jadwal');
                            } else {
                                $this->db->insert('pinjam', $data);
                                $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">
                                                        Peminjaman lab berhasil
                                                    </div>');
                                redirect('kalabTeknisi/jadwal');
                            }
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
            redirect('kalabteknisi/jadwal');
        }
        public function editPinjam() {
            $id = $this->input->post('id');
            $teori = $this->input->post('teori');
            $mhs = $this->input->post('mhs');
            $matkul = $this->input->post('matkul');
            $kelas = $this->input->post('kelas');
            $dosen = $this->input->post('peminjam');
            $tanggal = $this->input->post('tanggal');
            $mulai = $this->input->post('mulai');
            $selesai = $this->input->post('selesai');
            $lab = $this->input->post('lab');
        
            $data = [
                'Teori/Praktek' => $teori,
                'wakil_mhs' => $mhs,
                'kelas' => $kelas,
                'matkul' => $matkul,
                'dosen_pengajar' => $dosen,
                'tanggal_pinjam' => $tanggal,
                'jam' => $mulai,
                'selesai' => $selesai,  
                'nama_lab' => $lab
            ];
        
            $datetime_input = $tanggal . ' ' . $mulai;
            $datetime_now = date('Y-m-d H:i:s');
        
            if ($datetime_input <= $datetime_now) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Input Salah</div>');
                redirect('kalabteknisi/jadwal');
            } else {
                // Tambahkan $id sebagai parameter untuk mengecualikan record yang sedang diedit
                if ($this->Pinjam_model->check_jadwal_bentrok($tanggal, $mulai, $selesai, $lab, $id)) {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Jadwal Bentrok!!</div>');
                    redirect('kalabteknisi/jadwal');
                } else {
                    if ($mulai > $selesai) {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Input salah</div>');
                        redirect('kalabteknisi/jadwal');
                    } else {
                        $this->db->where('id', $id);
                        $this->db->update('pinjam', $data);
                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Peminjaman lab berhasil diedit</div>');
                        redirect('kalabteknisi/jadwal');
                    }
                }
            }
        }
        
    public function print(){
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $tanggal_input = $this->input->post('tanggal');;
        $tanggal_obj = new DateTime($tanggal_input);
        $tanggal = $tanggal_obj->format('Y-m-d');
        $bulan = $tanggal_obj->format('m');
        $tahun = $tanggal_obj->format('Y');
        $query_bulanan = $this->db->query("SELECT * FROM pinjam WHERE MONTH(tanggal_pinjam) = $bulan AND YEAR(tanggal_pinjam) = $tahun");
        $data['print'] = $query_bulanan;
        $this->load->view('kalabTeknisi/cetak',$data);
        }
        public function jadwal()
    {
        $data['title'] = "Daftar Peminjaman Lab";
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('kalabTeknisi/jadwal', $data);
        $this->load->view('templates/footer');

        $data['mahasiswa'] = [];
    }
    public function changePassword()
    {
        $data['title'] = "Ganti Password";
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();
        $this->form_validation->set_rules('currentPassword', 'Current Password', 'required|trim');
        $this->form_validation->set_rules('newPassword1', 'New Password', 'required|trim|min_length[8]|matches[newPassword2]');
        $this->form_validation->set_rules('newPassword2', 'Confirm New Password', 'required|trim|min_length[8]|matches[newPassword1]');


        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('kalabTeknisi/changePassword', $data);
            $this->load->view('templates/footer');
        } else {
            $currentPassword = $this->input->post('currentPassword');
            $newPassword = $this->input->post('newPassword1');
            if (!password_verify($currentPassword, $data['user']['password'])) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                                                Wrong Current Password
                                                </div>');
                redirect('kalabTeknisi/changePassword');
            } else {
                if ($currentPassword == $newPassword) {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                                                The Password cant be same as current password
                                                </div>');
                } else {
                    $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);
                    $this->db->set('password', $passwordHash);
                    $this->db->where('email', $this->session->userdata('email'));
                    $this->db->update('user');

                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                                                Your Password Has Changed
                                                </div>');
                    redirect('kalabTeknisi/changePassword');
                }
            }
        }
    }
    public function edit()
    {
        $data['title'] = "Edit Profile";
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();
        $this->form_validation->set_rules('name', 'Full Name', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('kalabTeknisi/edit', $data);
            $this->load->view('templates/footer');
        } else {
            $name = $this->input->post('name');
            $email = $this->input->post('email');
            $this->db->set('name', $name);
            $this->db->where('email', $email);
            $this->db->update('user');

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                                                Profil telah di perbarui!!!
                                                </div>');
            redirect('kalabTeknisi/edit');
        }
    }
    }

