<?php
class User_model extends CI_Model {
    public function get_by_email($email) {
        return $this->db->get_where('users', ['email' => $email])->row();
    }

    public function register($data) {
        // Validasi data
        if (empty($data['email']) || empty($data['password']) || empty($data['role'])) {
            return false;
        }

        // Cek apakah email sudah terdaftar
        if ($this->get_by_email($data['email'])) {
            return false;
        }

        $insert = [
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_BCRYPT),
            'role' => $data['role']
        ];
        
        return $this->db->insert('users', $insert);
    }
}
