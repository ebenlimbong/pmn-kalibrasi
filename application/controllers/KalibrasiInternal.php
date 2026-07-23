<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class KalibrasiInternal extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('MasterInstrumenInternal_model');
        $this->load->model('RiwayatKalibrasiInternal_model');
    }

    private function processMultiInput($nilaiArr, $satuanArr)
    {
        $gabungan = array();
        if (is_array($nilaiArr)) {
            foreach ($nilaiArr as $key => $val) {
                $val = trim($val);
                $satuan = isset($satuanArr[$key]) ? trim($satuanArr[$key]) : '';
                if ($val !== '') {
                    $gabungan[] = trim($val . ' ' . $satuan);
                }
            }
        } else {
            $val = trim($nilaiArr);
            $satuan = trim($satuanArr);
            if ($val !== '') {
                $gabungan[] = trim($val . ' ' . $satuan);
            }
        }
        return implode(', ', $gabungan);
    }

    public function index()
    {
        $this->load->model('RiwayatKalibrasiInternal_model');
        $instrumenList = $this->MasterInstrumenInternal_model->getInstrumenWithLatestKalibrasi();
        $allRiwayat = $this->RiwayatKalibrasiInternal_model->get_all();

        $selectedYear = $this->input->get('tahun') ? (int) $this->input->get('tahun') : (int) date('Y');

        // Extract all available years from database
        $yearsSet = array((int) date('Y'), 2026, 2025, 2024);
        foreach ($instrumenList as $item) {
            if (!empty($item->tanggal_berikutnya)) {
                $y = (int) date('Y', strtotime($item->tanggal_berikutnya));
                if ($y > 2000)
                    $yearsSet[] = $y;
            }
            if (!empty($item->tanggal_terakhir)) {
                $y = (int) date('Y', strtotime($item->tanggal_terakhir));
                if ($y > 2000)
                    $yearsSet[] = $y;
            }
        }
        foreach ($allRiwayat as $r) {
            if (!empty($r->tanggal_terakhir)) {
                $y = (int) date('Y', strtotime($r->tanggal_terakhir));
                if ($y > 2000)
                    $yearsSet[] = $y;
            }
        }
        $availableYears = array_values(array_unique($yearsSet));
        rsort($availableYears);

        $today = date('Y-m-d');
        $in30days = date('Y-m-d', strtotime('+30 days'));

        $totalCount = count($instrumenList);
        $aktifCount = 0;
        $dueSoonCount = 0;
        $rusakCount = 0;
        $overdueCalCount = 0;

        $targetMonthly = array_fill(1, 12, 0);
        $finishedMonthly = array_fill(1, 12, 0);
        $kondisiKatStats = array();
        $katStats = array();

        foreach ($instrumenList as $item) {
            $item->tahun_sertifikasi_berikutnya = '-';
            if (!empty($item->tanggal_terakhir) && !empty($item->periode_kalibrasi)) {
                $year = (int) date('Y', strtotime($item->tanggal_terakhir));
                $item->tahun_sertifikasi_berikutnya = $year + (int) $item->periode_kalibrasi;
            }

            // Kondisi count (independent of calibration status)
            $kondisiLower = !empty($item->kondisi) ? strtolower($item->kondisi) : 'baik';
            if ($kondisiLower === 'rusak') {
                $rusakCount++;
            }

            // Calibration Status (independent of condition)
            $isOverdueCal = false;
            if (empty($item->tanggal_terakhir) || empty($item->tanggal_berikutnya) || $item->tanggal_berikutnya < $today) {
                $isOverdueCal = true;
            }

            if ($isOverdueCal) {
                $overdueCalCount++;
            } else {
                $aktifCount++;
                if ($item->tanggal_berikutnya <= $in30days) {
                    $dueSoonCount++;
                }
            }

            if (!empty($item->tanggal_berikutnya)) {
                // Count target for selected year only
                if ((int) date('Y', strtotime($item->tanggal_berikutnya)) === $selectedYear) {
                    $mTarget = (int) date('n', strtotime($item->tanggal_berikutnya));
                    $targetMonthly[$mTarget]++;
                }
            }

            // Chart 2: Grafik Kondisi Alat per Kategori
            $kat = !empty($item->kategori_alat) ? $item->kategori_alat : 'Lainnya';
            if (!isset($kondisiKatStats[$kat])) {
                $kondisiKatStats[$kat] = array('baik' => 0, 'rusak' => 0, 'perbaikan' => 0);
            }
            if ($kondisiLower === 'rusak') {
                $kondisiKatStats[$kat]['rusak']++;
            } else if ($kondisiLower === 'perbaikan') {
                $kondisiKatStats[$kat]['perbaikan']++;
            } else {
                $kondisiKatStats[$kat]['baik']++;
            }

            // Chart 4: Breakdown Status Kalibrasi per Kategori
            if (!isset($katStats[$kat])) {
                $katStats[$kat] = array('in_cal' => 0, 'due_soon' => 0, 'overdue' => 0);
            }
            if ($isOverdueCal) {
                $katStats[$kat]['overdue']++;
            } else if ($item->tanggal_berikutnya <= $in30days) {
                $katStats[$kat]['due_soon']++;
            } else {
                $katStats[$kat]['in_cal']++;
            }
        }

        // Count finished calibrations for selected year (from all history and master records)
        $finishedRecords = array();
        foreach ($allRiwayat as $r) {
            if (!empty($r->tanggal_terakhir)) {
                $finishedRecords[] = array(
                    'nomor' => $r->nomor_identifikasi,
                    'tanggal' => $r->tanggal_terakhir
                );
            }
        }
        foreach ($instrumenList as $item) {
            if (!empty($item->tanggal_terakhir)) {
                $finishedRecords[] = array(
                    'nomor' => $item->nomor_identifikasi,
                    'tanggal' => $item->tanggal_terakhir
                );
            }
        }

        $uniqueFinished = array();
        foreach ($finishedRecords as $fr) {
            $key = $fr['nomor'] . '_' . $fr['tanggal'];
            if (!isset($uniqueFinished[$key])) {
                $uniqueFinished[$key] = true;
                if ((int) date('Y', strtotime($fr['tanggal'])) === $selectedYear) {
                    $mFinished = (int) date('n', strtotime($fr['tanggal']));
                    $finishedMonthly[$mFinished]++;
                }
            }
        }

        $summary = array(
            'total' => $totalCount,
            'aktif' => $aktifCount,
            'due_soon' => $dueSoonCount,
            'overdue' => $rusakCount,
            'overdue_populasi' => $overdueCalCount,
            'in_cal_slice' => max(0, $aktifCount - $dueSoonCount)
        );

        $chartData = array(
            'target_monthly' => array_values($targetMonthly),
            'finished_monthly' => array_values($finishedMonthly),
            'kondisi_kat_categories' => array_keys($kondisiKatStats),
            'kondisi_kat_baik' => array_column($kondisiKatStats, 'baik'),
            'kondisi_kat_rusak' => array_column($kondisiKatStats, 'rusak'),
            'kondisi_kat_perbaikan' => array_column($kondisiKatStats, 'perbaikan'),
            'kat_categories' => array_keys($katStats),
            'kat_in_cal' => array_column($katStats, 'in_cal'),
            'kat_due_soon' => array_column($katStats, 'due_soon'),
            'kat_overdue' => array_column($katStats, 'overdue')
        );

        $data = array(
            'title' => 'E-Calibration | Data Instrumen Internal',
            'instrumen' => $instrumenList,
            'summary' => $summary,
            'chartData' => $chartData,
            'selectedYear' => $selectedYear,
            'availableYears' => $availableYears
        );
        $this->load->view('layout/header', $data);
        $this->load->view('kalibrasi_internal/index', $data);
        $this->load->view('layout/footer', $data);
    }

    public function detail($id)
    {
        $instrumen = $this->MasterInstrumenInternal_model->get_by_id($id);
        if (!$instrumen) {
            show_404();
        }

        $this->load->library('qrcode');
        $qrUrl = $this->qrcode->generate(base_url('kalibrasi-internal/detail/' . $id));

        $riwayat = $this->RiwayatKalibrasiInternal_model->get_by_nomor($instrumen->nomor_identifikasi);
        usort($riwayat, function ($a, $b) {
            return strtotime($b->tanggal_terakhir) - strtotime($a->tanggal_terakhir);
        });

        $data = array(
            'title' => 'Detail Instrumen Standar Kerja',
            'instrumen' => $instrumen,
            'riwayat' => $riwayat,
            'qrcode' => $qrUrl
        );

        $this->load->view('layout/header', $data);
        $this->load->view('kalibrasi_internal/detail', $data);
        $this->load->view('layout/footer', $data);
    }

    public function create()
    {
        $data = array(
            'title' => 'Tambah Instrumen Standar Kerja'
        );
        $this->load->view('layout/header', $data);
        $this->load->view('kalibrasi_internal/form', $data);
        $this->load->view('layout/footer', $data);
    }

    public function store()
    {
        $nomorIdentifikasi = $this->input->post('nomor_identifikasi');
        $periodeKalibrasi = $this->input->post('periode_kalibrasi');

        $masterData = array(
            'nomor_identifikasi' => $nomorIdentifikasi,
            'nama_instrumen' => $this->input->post('nama_instrumen'),
            'seksi_pemakai' => $this->input->post('seksi_pemakai'),
            'kategori_alat' => $this->input->post('kategori_alat'),
            'interval_kapasitas' => $this->processMultiInput($this->input->post('interval_nilai'), $this->input->post('interval_satuan')),
            'ketelitian' => $this->processMultiInput($this->input->post('ketelitian_nilai'), $this->input->post('ketelitian_satuan')),
            'model_tipe' => $this->input->post('model_tipe'),
            'pembuat' => $this->input->post('pembuat'),
            'kegunaan' => $this->input->post('kegunaan'),
            'periode_kalibrasi' => $periodeKalibrasi,
            'tanggal_mulai_digunakan' => $this->input->post('tanggal_mulai_digunakan'),
            'batas_penerimaan' => $this->processMultiInput($this->input->post('batas_nilai'), $this->input->post('batas_satuan')),
            'keterangan' => $this->input->post('keterangan'),
            'kondisi' => $this->input->post('kondisi') ? strtolower($this->input->post('kondisi')) : 'baik',
        );

        // Handle foto_alat upload
        if (!empty($_FILES['foto_alat']['name'])) {
            $config['upload_path'] = './uploads/instrumen/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png|webp';
            $config['encrypt_name'] = TRUE;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('foto_alat')) {
                $uploadData = $this->upload->data();
                $masterData['foto_alat'] = $uploadData['file_name'];
            }
        }

        $this->MasterInstrumenInternal_model->insert($masterData);

        // Check if initial calibration data is provided
        $tanggalTerakhir = $this->input->post('tanggal_terakhir');
        if (!empty($tanggalTerakhir)) {
            $riwayatData = array(
                'nomor_identifikasi' => $nomorIdentifikasi,
                'tanggal_terakhir' => $tanggalTerakhir,
                'tanggal_berikutnya' => date('Y-m-d', strtotime('+' . (int) $periodeKalibrasi . ' years', strtotime($tanggalTerakhir))),
                'status' => 'Aktif'
            );

            if (!empty($_FILES['file_sertifikat']['name'])) {
                $configCert['upload_path'] = './uploads/sertifikat/';
                $configCert['allowed_types'] = 'pdf|gif|jpg|jpeg|png';
                $configCert['encrypt_name'] = TRUE;
                $this->load->library('upload', $configCert);
                $this->upload->initialize($configCert);

                if ($this->upload->do_upload('file_sertifikat')) {
                    $uploadCert = $this->upload->data();
                    $riwayatData['file_sertifikat'] = $uploadCert['file_name'];
                }
            }

            $this->RiwayatKalibrasiInternal_model->insert($riwayatData);
            $this->updateRiwayatStatus($nomorIdentifikasi);
        }

        $this->session->set_flashdata('success', 'Data instrumen standar kerja berhasil ditambahkan.');
        redirect('kalibrasi-internal');
    }

    public function edit($id)
    {
        $instrumen = $this->MasterInstrumenInternal_model->get_by_id($id);
        if (!$instrumen) {
            show_404();
        }

        $riwayatList = $this->RiwayatKalibrasiInternal_model->get_by_nomor($instrumen->nomor_identifikasi);
        $latestRiwayat = !empty($riwayatList) ? $riwayatList[0] : null;

        $data = array(
            'title' => 'Edit Instrumen Standar Kerja',
            'instrumen' => $instrumen,
            'riwayat' => $latestRiwayat
        );
        $this->load->view('layout/header', $data);
        $this->load->view('kalibrasi_internal/edit', $data);
        $this->load->view('layout/footer', $data);
    }

    public function update($id)
    {
        $instrumen = $this->MasterInstrumenInternal_model->get_by_id($id);
        if (!$instrumen) {
            show_404();
        }

        $updateData = array(
            'nomor_identifikasi' => $this->input->post('nomor_identifikasi'),
            'nama_instrumen' => $this->input->post('nama_instrumen'),
            'seksi_pemakai' => $this->input->post('seksi_pemakai'),
            'kategori_alat' => $this->input->post('kategori_alat'),
            'interval_kapasitas' => $this->processMultiInput($this->input->post('interval_nilai'), $this->input->post('interval_satuan')),
            'ketelitian' => $this->processMultiInput($this->input->post('ketelitian_nilai'), $this->input->post('ketelitian_satuan')),
            'model_tipe' => $this->input->post('model_tipe'),
            'pembuat' => $this->input->post('pembuat'),
            'kegunaan' => $this->input->post('kegunaan'),
            'periode_kalibrasi' => $this->input->post('periode_kalibrasi'),
            'tanggal_mulai_digunakan' => $this->input->post('tanggal_mulai_digunakan'),
            'batas_penerimaan' => $this->processMultiInput($this->input->post('batas_nilai'), $this->input->post('batas_satuan')),
            'keterangan' => $this->input->post('keterangan'),
            'kondisi' => $this->input->post('kondisi') ? strtolower($this->input->post('kondisi')) : 'baik',
        );

        if (!empty($_FILES['foto_alat']['name'])) {
            $config['upload_path'] = './uploads/instrumen/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png|webp';
            $config['encrypt_name'] = TRUE;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('foto_alat')) {
                $uploadData = $this->upload->data();
                $updateData['foto_alat'] = $uploadData['file_name'];

                if (!empty($instrumen->foto_alat) && file_exists('./uploads/instrumen/' . $instrumen->foto_alat)) {
                    @unlink('./uploads/instrumen/' . $instrumen->foto_alat);
                }
            }
        }

        $this->MasterInstrumenInternal_model->update($id, $updateData);

        // Update or insert latest calibration history
        $riwayatId = $this->input->post('riwayat_id');
        $tanggalTerakhir = $this->input->post('tanggal_terakhir');

        if (!empty($tanggalTerakhir)) {
            $periodeKalibrasi = $updateData['periode_kalibrasi'];
            $riwayatData = array(
                'nomor_identifikasi' => $updateData['nomor_identifikasi'],
                'tanggal_terakhir' => $tanggalTerakhir,
                'tanggal_berikutnya' => date('Y-m-d', strtotime('+' . (int) $periodeKalibrasi . ' years', strtotime($tanggalTerakhir))),
                'status' => 'Aktif'
            );

            // Handle file_sertifikat upload
            if (!empty($_FILES['file_sertifikat']['name'])) {
                $configCert['upload_path'] = './uploads/sertifikat/';
                $configCert['allowed_types'] = 'pdf|gif|jpg|jpeg|png';
                $configCert['encrypt_name'] = TRUE;
                $this->load->library('upload', $configCert);
                $this->upload->initialize($configCert);

                if ($this->upload->do_upload('file_sertifikat')) {
                    $uploadCert = $this->upload->data();
                    $riwayatData['file_sertifikat'] = $uploadCert['file_name'];
                }
            }

            if (!empty($riwayatId)) {
                $this->RiwayatKalibrasiInternal_model->update($riwayatId, $riwayatData);
            } else {
                $this->RiwayatKalibrasiInternal_model->insert($riwayatData);
            }
            $this->updateRiwayatStatus($updateData['nomor_identifikasi']);
        }

        $this->session->set_flashdata('success', 'Data instrumen standar kerja berhasil diupdate.');
        redirect('kalibrasi-internal');
    }

    public function delete($id)
    {
        $instrumen = $this->MasterInstrumenInternal_model->get_by_id($id);
        if ($instrumen) {
            if (!empty($instrumen->foto_alat) && file_exists('./uploads/instrumen/' . $instrumen->foto_alat)) {
                @unlink('./uploads/instrumen/' . $instrumen->foto_alat);
            }

            $riwayat = $this->RiwayatKalibrasiInternal_model->get_by_nomor($instrumen->nomor_identifikasi);
            foreach ($riwayat as $r) {
                if (!empty($r->file_sertifikat) && file_exists('./uploads/sertifikat/' . $r->file_sertifikat)) {
                    @unlink('./uploads/sertifikat/' . $r->file_sertifikat);
                }
                $this->RiwayatKalibrasiInternal_model->delete($r->id);
            }

            $this->MasterInstrumenInternal_model->delete($id);
        }
        $this->session->set_flashdata('success', 'Data instrumen standar kerja berhasil dihapus.');
        redirect('kalibrasi-internal');
    }

    public function storeRiwayat($id)
    {
        $instrumen = $this->MasterInstrumenInternal_model->get_by_id($id);
        if (!$instrumen) {
            show_404();
        }

        $tanggalTerakhir = $this->input->post('tanggal_terakhir');
        if (!empty($tanggalTerakhir)) {
            $riwayatData = array(
                'nomor_identifikasi' => $instrumen->nomor_identifikasi,
                'tanggal_terakhir' => $tanggalTerakhir,
                'tanggal_berikutnya' => date('Y-m-d', strtotime('+' . (int) $instrumen->periode_kalibrasi . ' years', strtotime($tanggalTerakhir))),
                'batas_penerimaan' => $this->input->post('batas_penerimaan'),
                'keterangan' => $this->input->post('keterangan'),
                'status' => 'Aktif'
            );

            if (!empty($_FILES['file_sertifikat']['name'])) {
                $configCert['upload_path'] = './uploads/sertifikat/';
                $configCert['allowed_types'] = 'pdf|gif|jpg|jpeg|png';
                $configCert['encrypt_name'] = TRUE;
                $this->load->library('upload', $configCert);
                $this->upload->initialize($configCert);

                if ($this->upload->do_upload('file_sertifikat')) {
                    $uploadCert = $this->upload->data();
                    $riwayatData['file_sertifikat'] = $uploadCert['file_name'];
                }
            }

            $this->RiwayatKalibrasiInternal_model->insert($riwayatData);
            $this->updateRiwayatStatus($instrumen->nomor_identifikasi);
        }

        $this->session->set_flashdata('success', 'Riwayat kalibrasi internal berhasil ditambahkan.');
        redirect('kalibrasi-internal/detail/' . $id);
    }

    public function deleteRiwayat($id)
    {
        $riwayat = $this->RiwayatKalibrasiInternal_model->get_by_id($id);
        if ($riwayat) {
            if (!empty($riwayat->file_sertifikat) && file_exists('./uploads/sertifikat/' . $riwayat->file_sertifikat)) {
                @unlink('./uploads/sertifikat/' . $riwayat->file_sertifikat);
            }
            $this->RiwayatKalibrasiInternal_model->delete($id);
        }
        $this->session->set_flashdata('success', 'Riwayat kalibrasi internal berhasil dihapus.');
        if ($riwayat) {
            $this->updateRiwayatStatus($riwayat->nomor_identifikasi);
        }
        if (isset($_SERVER['HTTP_REFERER'])) {
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            redirect('kalibrasi-internal');
        }
    }

    private function updateRiwayatStatus($nomorIdentifikasi)
    {
        $this->db->where('nomor_identifikasi', $nomorIdentifikasi)->update('riwayat_kalibrasi_internal', array('status' => 'Tidak aktif'));
        $latest = $this->db->where('nomor_identifikasi', $nomorIdentifikasi)
            ->order_by('tanggal_terakhir', 'DESC')
            ->order_by('id', 'DESC')
            ->get('riwayat_kalibrasi_internal')
            ->row();
        if ($latest) {
            $this->db->where('id', $latest->id)->update('riwayat_kalibrasi_internal', array('status' => 'Aktif'));
        }
    }

    public function chartData($id)
    {
        $instrumen = $this->MasterInstrumenInternal_model->get_by_id($id);
        if (!$instrumen) {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(array('error' => 'Not Found')));
        }

        $riwayat = $this->RiwayatKalibrasiInternal_model->get_by_nomor($instrumen->nomor_identifikasi);

        $labels = array();
        $data = array();

        foreach ($riwayat as $r) {
            $labels[] = $r->tanggal_terakhir;
            $data[] = isset($r->deviasi_aktual) ? (float) $r->deviasi_aktual : 0;
        }

        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array(
                'labels' => $labels,
                'data' => $data
            )));
    }
}