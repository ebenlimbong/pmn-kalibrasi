<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MasterInstrumenInternal_model extends CI_Model {

    protected $table = 'master_instrumen_internal';

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
        $this->db->select('master_instrumen_internal.*, latest_riwayat.tanggal_terakhir, latest_riwayat.file_sertifikat, latest_riwayat.tanggal_berikutnya, latest_riwayat.status as status_riwayat');
        $subquery = '(
            SELECT r1.* 
            FROM riwayat_kalibrasi_internal r1 
            INNER JOIN (
                SELECT r_inner.nomor_identifikasi, MAX(r_inner.id) AS max_id
                FROM riwayat_kalibrasi_internal r_inner
                INNER JOIN (
                    SELECT nomor_identifikasi, MAX(tanggal_terakhir) AS max_tgl
                    FROM riwayat_kalibrasi_internal
                    GROUP BY nomor_identifikasi
                ) r_max ON r_inner.nomor_identifikasi = r_max.nomor_identifikasi AND r_inner.tanggal_terakhir = r_max.max_tgl
                GROUP BY r_inner.nomor_identifikasi
            ) r2 ON r1.id = r2.max_id
        ) latest_riwayat';
        $this->db->join($subquery, 'master_instrumen_internal.nomor_identifikasi = latest_riwayat.nomor_identifikasi', 'left');
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
