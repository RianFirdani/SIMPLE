<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        
    }


    public function index(){

            if ($this->session->userdata('email')) {
                redirect('mahasiswa');
            }

            $this->form_validation->set_rules('email','Email','trim|required|valid_email');
            $this->form_validation->set_rules('password','Password','trim|required');
            
        if($this->form_validation->run() == false){  
            $data ['title'] = 'Halaman Login';
            $this->load->view('templates/auth_header',$data);
            $this->load->view('auth/login');
            $this->load->view('templates/auth_footer');
        }else{
            $this->_login();
        }
    }

    private function _login(){
        $email = $this->input->post('email');
        $pass = $this->input->post('password');
        $user = $this->db->get_where('user',['email'=> $email])->row_array();

        if ($user) {
            
            if($user ['is_active'] == 1){
                if(password_verify($pass,$user['password'])){
                    $data = [
                        'email' => $user['email'],
                        'role_id' => $user['role_id']
                    ];
                    $this->session->set_userdata($data);
                    if ($user['role_id'] == 1) {
                        redirect('admin');
                    }else if($user['role_id'] == 2){
                        redirect('dosen');
                    }else if($user['role_id'] == 3){
                        redirect('mahasiswa');
                    }
    


                }else{
                    $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">
                                            Wrong password!!
                                            </div>');
                    redirect('auth');

                }

            }else{
                $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">
                                            This Email has not been activated
                                            </div>');
            redirect('auth');
            }


        }else {
            $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">
                                            Email is not registered
                                            </div>');
            redirect('auth');
        }
    }

    public function registration(){
        
        if ($this->session->userdata('email')) {
            redirect('auth');
        }

        $this->form_validation->set_rules('name','Name','required|trim');
        $this->form_validation->set_rules('email','Email','required|trim|valid_email|is_unique[user.email]',[
            'is_unique' => 'This email has already registered!'
        ]);
        $this->form_validation->set_rules('nip','Nip','trim|is_unique[user.nip]',[
            'is_unique' => 'NIP Ini sudah di registrasikan'
        ]);
        $this->form_validation->set_rules('password1','Password','required|trim|min_length[8]|matches[password2]',['matches' => "Password Doesn't Match !!",
            'min_length' => "Minimum length is 8"
    
            ]);
        $this->form_validation->set_rules('password2','Password','required|trim|matches[password1]');
        

        if( $this->form_validation-> run() == false ){
            $data['title'] =   'Halaman Pendaftaran';
            $this->load->view('templates/auth_header',$data);
            $this->load->view('auth/registration');
            $this->load->view('templates/auth_footer');
        }else{
            $data = [
                'name' => htmlspecialchars($this->input->post('name',true)),
                'email' => htmlspecialchars($this->input->post('email',true)),
                'nip' => htmlspecialchars($this->input->post('nip',true)),
                'password' => password_hash($this->input->post('password1'),PASSWORD_DEFAULT),
                'role_id' => 3,
                'is_active'=> 1
            ];
            $this->db->insert('user',$data);

            // $this->_sendEmail();


            $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">
                                            Akun anda telah berhasil dibuat
                                            </div>');
            redirect('auth');
        }
    }

    // private function _sendEmail(){
    //     $config = [
    //         'protocol' => 'smtp',
    //         'smtp_host' => 'ssl://smtp.googlemail.com',
    //         'smtp_user' => 'bkkrian07@gmail.com',
    //         'smtp_pass' => '12345678',
    //         'smtp_port' => 465,
    //         'mailtype' => 'html',
    //         'charset' => 'utf-8',
    //         'newline' => "\r\n"
    //     ];   

    //     $this->load->library('email',$config);
    //     $this->email->initialize($config);

    //     $this->email->from('bkkrian07@gmail.com','Rian Firdani');
    //     $this->email->to('juliwickszzz@gmail.com');
    //     $this->email->subject('Testing');
    //     $this->email->message('Hello Guys');
        
    //     if ($this->email->send()) {
    //         return true;
    //     }else{
    //         echo $this->email->print_debugger();
    //         die;
    //     }
        
    // }


    public function logout(){
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');
        $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">
                                            You have been looged out
                                            </div>');
            redirect('auth');
        
    }
    public function blocked(){
        $this->load->view('auth/blocked');
    }
}