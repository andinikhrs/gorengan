<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Auth extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('session');
    }

    public function login() {
        if ($this->input->post()) {
            $user = $this->User_model->get_by_email($this->input->post('email'));
            if ($user && password_verify($this->input->post('password'), $user->password)) {
                $this->session->set_userdata(['user_id' => $user->id, 'role' => $user->role]);
                redirect($user->role == 'admin' ? 'admin/dashboard' : 'customer/dashboard');
            } else {
                $this->session->set_flashdata('error', 'Login gagal');
            }
        }
        $this->load->view('auth/login');
    }

    public function register() {
        if ($this->input->post()) {
            $data = [
                'email' => $this->input->post('email'),
                'password' => $this->input->post('password'),
                'role' => $this->input->post('role')
            ];
            
            if (empty($data['role'])) {
                $this->session->set_flashdata('error', 'Role harus dipilih');
                $this->load->view('auth/register');
                return;
            }

            if ($this->User_model->register($data)) {
                $this->session->set_flashdata('success', 'Registrasi berhasil, silahkan login');
                redirect('auth/login');
            } else {
                $this->session->set_flashdata('error', 'Registrasi gagal');
            }
        }
        $this->load->view('auth/register');
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('auth/login');
    }
}
