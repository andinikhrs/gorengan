<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('role') != 'admin') redirect('auth/login');
        $this->load->model('Product_model');
        $this->load->library('upload');
    }

    public function dashboard() {
        $data['products'] = $this->Product_model->get_all();
        $this->load->view('admin/dashboard', $data);
    }

    public function products() {
        $data['products'] = $this->Product_model->get_all();
        $this->load->view('admin/products', $data);
    }

    public function add_product() {
        if ($this->input->post()) {
            // Konfigurasi upload foto
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size'] = 2048; // 2MB
            $config['encrypt_name'] = TRUE;
            
            $this->upload->initialize($config);

            if ($this->upload->do_upload('photo')) {
                $upload_data = $this->upload->data();
                $photo = $upload_data['file_name'];
            } else {
                $photo = NULL;
            }

            $data = [
                'name' => $this->input->post('name'),
                'price' => $this->input->post('price'),
                'description' => $this->input->post('description'),
                'photo' => $photo
            ];

            if ($this->Product_model->create($data)) {
                $this->session->set_flashdata('success', 'Produk berhasil ditambahkan');
                redirect('admin/products');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan produk');
            }
        }
        $this->load->view('admin/add_product');
    }

    public function edit_product($id) {
        $data['product'] = $this->Product_model->get_by_id($id);
        
        if (!$data['product']) {
            show_404();
        }

        if ($this->input->post()) {
            // Konfigurasi upload foto
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size'] = 2048; // 2MB
            $config['encrypt_name'] = TRUE;
            
            $this->upload->initialize($config);

            if ($this->upload->do_upload('photo')) {
                $upload_data = $this->upload->data();
                $photo = $upload_data['file_name'];
                
                // Hapus foto lama jika ada
                if ($data['product']->photo && file_exists('./uploads/' . $data['product']->photo)) {
                    unlink('./uploads/' . $data['product']->photo);
                }
            } else {
                $photo = $data['product']->photo;
            }

            $update_data = [
                'name' => $this->input->post('name'),
                'price' => $this->input->post('price'),
                'description' => $this->input->post('description'),
                'photo' => $photo
            ];

            if ($this->Product_model->update($id, $update_data)) {
                $this->session->set_flashdata('success', 'Produk berhasil diupdate');
                redirect('admin/products');
            } else {
                $this->session->set_flashdata('error', 'Gagal mengupdate produk');
            }
        }

        $this->load->view('admin/edit_product', $data);
    }

    public function delete_product($id) {
        $product = $this->Product_model->get_by_id($id);
        
        if (!$product) {
            show_404();
        }

        // Hapus foto jika ada
        if ($product->photo && file_exists('./uploads/' . $product->photo)) {
            unlink('./uploads/' . $product->photo);
        }

        if ($this->Product_model->delete($id)) {
            $this->session->set_flashdata('success', 'Produk berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus produk');
        }
        
        redirect('admin/products');
    }
}
