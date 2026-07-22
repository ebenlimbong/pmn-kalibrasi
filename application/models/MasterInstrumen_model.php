<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MasterInstrumen_model extends CI_Model {

    protected $table = 'master_instrumen';

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
        return $this->db->get_where($this->table, array('nomor_identifikasi' => $nomor_identifikasi))->row();
    }

    public function getInstrumenWithLatestKalibrasi() {
        $this->db->select('master_instrumen.*, latest_riwayat.tanggal_terakhir, latest_riwayat.nomor_sertifikat, latest_riwayat.badan_kalibrasi, latest_riwayat.file_sertifikat, latest_riwayat.tanggal_berikutnya');
        $subquery = '(
            SELECT r1.* 
            FROM riwayat_kalibrasi r1 
            INNER JOIN (
                SELECT nomor_identifikasi, MAX(id) as max_id 
                FROM riwayat_kalibrasi 
                GROUP BY nomor_identifikasi
            ) r2 ON r1.id = r2.max_id
        ) latest_riwayat';
        $this->db->join($subquery, 'master_instrumen.nomor_identifikasi = latest_riwayat.nomor_identifikasi', 'left');
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
