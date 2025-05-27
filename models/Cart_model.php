<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart_model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }

    public function get_by_user($user_id) {
        $this->db->select('cart.*, products.name, products.price, products.photo');
        $this->db->from('cart');
        $this->db->join('products', 'products.id = cart.product_id');
        $this->db->where('cart.user_id', $user_id);
        return $this->db->get()->result();
    }

    public function get_total_items($user_id) {
        $this->db->select_sum('quantity');
        $this->db->where('user_id', $user_id);
        $result = $this->db->get('cart')->row();
        return $result->quantity ?? 0;
    }

    public function get_total_price($user_id) {
        $this->db->select('SUM(cart.quantity * products.price) as total');
        $this->db->from('cart');
        $this->db->join('products', 'products.id = cart.product_id');
        $this->db->where('cart.user_id', $user_id);
        $result = $this->db->get()->row();
        return $result->total ?? 0;
    }

    public function add_item($user_id, $product_id) {
        // Check if product exists in cart
        $existing = $this->db->get_where('cart', [
            'user_id' => $user_id,
            'product_id' => $product_id
        ])->row();

        if ($existing) {
            // Update quantity if product exists
            return $this->db->update('cart', 
                ['quantity' => $existing->quantity + 1],
                ['id' => $existing->id]
            );
        } else {
            // Add new item if product doesn't exist
            return $this->db->insert('cart', [
                'user_id' => $user_id,
                'product_id' => $product_id,
                'quantity' => 1
            ]);
        }
    }

    public function update_quantity($cart_id, $quantity, $user_id) {
        if ($quantity < 1) {
            return $this->remove_item($cart_id, $user_id);
        }

        return $this->db->update('cart',
            ['quantity' => $quantity],
            ['id' => $cart_id, 'user_id' => $user_id]
        );
    }

    public function remove_item($cart_id, $user_id) {
        return $this->db->delete('cart', [
            'id' => $cart_id,
            'user_id' => $user_id
        ]);
    }

    public function clear_cart($user_id) {
        return $this->db->delete('cart', ['user_id' => $user_id]);
    }
} 