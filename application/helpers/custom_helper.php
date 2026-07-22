<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('esc')) {
    function esc($data, $context = 'html') {
        if ($data === null) return '';
        return html_escape($data);
    }
}

if (!function_exists('csrf_field')) {
    function csrf_field() {
        $CI =& get_instance();
        if ($CI->config->item('csrf_protection') === TRUE) {
            $name = $CI->security->get_csrf_token_name();
            $hash = $CI->security->get_csrf_hash();
            return '<input type="hidden" name="' . $name . '" value="' . $hash . '" />';
        }
        return '';
    }
}

if (!function_exists('hitung_umur_instrumen')) {
    function hitung_umur_instrumen($tanggal_mulai) {
        if (empty($tanggal_mulai) || $tanggal_mulai === '0000-00-00') {
            return '-';
        }
        try {
            $tgl_mulai = new DateTime($tanggal_mulai);
            $sekarang  = new DateTime();
            $diff      = $tgl_mulai->diff($sekarang);

            if ($diff->y > 0 && $diff->m > 0) {
                return $diff->y . ' Thn ' . $diff->m . ' Bln';
            } else if ($diff->y > 0) {
                return $diff->y . ' Tahun';
            } else if ($diff->m > 0) {
                return $diff->m . ' Bulan';
            } else if ($diff->days > 0) {
                return $diff->days . ' Hari';
            } else {
                return '0 Hari';
            }
        } catch (Exception $e) {
            return '-';
        }
    }
}
