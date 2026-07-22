<?php
$this->load->view('layout/header', isset($data) ? $data : get_defined_vars());
if (isset($subview)) {
    $this->load->view($subview, isset($data) ? $data : get_defined_vars());
}
$this->load->view('layout/footer', isset($data) ? $data : get_defined_vars());
