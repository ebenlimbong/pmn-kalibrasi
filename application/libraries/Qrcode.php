<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Qrcode {

    public function generate($data) {
        $encodedData = urlencode($data);
        return 'https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=' . $encodedData;
    }
}
