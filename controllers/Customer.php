<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('role') != 'customer') redirect('auth/login');
        $this->load->model('Product_model');
        $this->load->model('Cart_model');
        $this->load->model('Order_model');
    }

    public function dashboard() {
        $data['products'] = $this->Product_model->get_all();
        $this->load->view('customer/dashboard', $data);
    }

    public function cart() {
        $user_id = $this->session->userdata('user_id');
        $data['cart_items'] = $this->Cart_model->get_by_user($user_id);
        $data['total_items'] = $this->Cart_model->get_total_items($user_id);
        $data['total_price'] = $this->Cart_model->get_total_price($user_id);
        $this->load->view('customer/cart', $data);
    }

    public function add_to_cart() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $product_id = $this->input->post('product_id');
        $user_id = $this->session->userdata('user_id');

        if ($this->Cart_model->add_item($user_id, $product_id)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }

    public function update_cart() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $cart_id = $this->input->post('cart_id');
        $quantity = $this->input->post('quantity');
        $user_id = $this->session->userdata('user_id');

        if ($this->Cart_model->update_quantity($cart_id, $quantity, $user_id)) {
            $total_price = $this->Cart_model->get_total_price($user_id);
            echo json_encode([
                'status' => 'success',
                'total_price' => $total_price
            ]);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }

    public function remove_from_cart() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $cart_id = $this->input->post('cart_id');
        $user_id = $this->session->userdata('user_id');

        if ($this->Cart_model->remove_item($cart_id, $user_id)) {
            $total_price = $this->Cart_model->get_total_price($user_id);
            echo json_encode([
                'status' => 'success',
                'total_price' => $total_price
            ]);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }

    public function checkout() {
        if (!$this->input->post()) {
            redirect('customer/cart');
        }

        $user_id = $this->session->userdata('user_id');
        $cart_items = $this->Cart_model->get_by_user($user_id);

        if (empty($cart_items)) {
            $this->session->set_flashdata('error', 'Keranjang belanja kosong');
            redirect('customer/cart');
        }

        $order_data = [
            'user_id' => $user_id,
            'customer_name' => $this->input->post('customer_name'),
            'address' => $this->input->post('address'),
            'phone' => $this->input->post('phone'),
            'total_price' => $this->Cart_model->get_total_price($user_id),
            'status' => 'pending'
        ];

        if ($this->Order_model->create($order_data, $cart_items)) {
            $this->Cart_model->clear_cart($user_id);
            $this->session->set_flashdata('success', 'Pesanan berhasil dibuat');
            redirect('customer/orders');
        } else {
            $this->session->set_flashdata('error', 'Gagal membuat pesanan');
            redirect('customer/cart');
        }
    }

    public function orders() {
        $user_id = $this->session->userdata('user_id');
        $data['orders'] = $this->Order_model->get_by_user($user_id);
        $this->load->view('customer/orders', $data);
    }
}
