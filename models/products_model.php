<?php
class Product_model extends CI_Model {
    public function get_all() {
        return $this->db->get('products')->result();
    }

    public function insert($data) {
        return $this->db->insert('products', $data);
    }
}
