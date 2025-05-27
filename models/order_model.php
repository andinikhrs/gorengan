<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }

    public function get_by_user($user_id) {
        $this->db->select('orders.*, order_items.quantity, products.name, products.price');
        $this->db->from('orders');
        $this->db->join('order_items', 'order_items.order_id = orders.id');
        $this->db->join('products', 'products.id = order_items.product_id');
        $this->db->where('orders.user_id', $user_id);
        $this->db->order_by('orders.created_at', 'DESC');
        return $this->db->get()->result();
    }

    public function create($order_data, $cart_items) {
        $this->db->trans_start();

        // Insert order
        $this->db->insert('orders', $order_data);
        $order_id = $this->db->insert_id();

        // Insert order items
        foreach ($cart_items as $item) {
            $this->db->insert('order_items', [
                'order_id' => $order_id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->price
            ]);
        }

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function update_status($order_id, $status) {
        return $this->db->update('orders',
            ['status' => $status],
            ['id' => $order_id]
        );
    }

    public function get_order_details($order_id) {
        $this->db->select('orders.*, order_items.quantity, products.name, products.price');
        $this->db->from('orders');
        $this->db->join('order_items', 'order_items.order_id = orders.id');
        $this->db->join('products', 'products.id = order_items.product_id');
        $this->db->where('orders.id', $order_id);
        return $this->db->get()->result();
    }
}
