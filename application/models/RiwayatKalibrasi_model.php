<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RiwayatKalibrasi_model extends CI_Model {

    protected $table = 'riwayat_kalibrasi';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all() {
        return $this->db->get($this->table)->result();
    }

    public function get_by_id($id) {
        return $this->db->get_where($this->table, array('id' => $id))->row();
    }

    public function get_by_nomor($nomor_identifikasi) {
        $this->db->where('nomor_identifikasi', $nomor_identifikasi);
        $this->db->order_by('tanggal_terakhir', 'DESC');
        $this->db->order_by('id', 'DESC');
        return $this->db->get($this->table)->result();
    }

    public function getWithMaster($id = null) {
        $this->db->select('riwayat_kalibrasi.*, master_instrumen.nama_instrumen');
        $this->db->join('master_instrumen', 'master_instrumen.nomor_identifikasi = riwayat_kalibrasi.nomor_identifikasi');
        if ($id) {
            $this->db->where('riwayat_kalibrasi.id', $id);
            return $this->db->get($this->table)->row();
        }
        return $this->db->get($this->table)->result();
    }

    public function insert($data) {
        if (!isset($data['created_at'])) {
            $data['created_at'] = date('Y-m-d H:i:s');
        }
        if (!isset($data['updated_at'])) {
            $data['updated_at'] = date('Y-m-d H:i:s');
        }
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data) {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }
}
