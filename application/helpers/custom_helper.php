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
