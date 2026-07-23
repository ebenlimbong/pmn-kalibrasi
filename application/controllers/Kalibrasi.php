<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kalibrasi extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('MasterInstrumen_model');
        $this->load->model('RiwayatKalibrasi_model');
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
        $instrumenList = $this->MasterInstrumen_model->getInstrumenWithLatestKalibrasi();
        $allRiwayat = $this->RiwayatKalibrasi_model->get_all();

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
        $seksiStats = array();
        $katStats = array();

        foreach ($instrumenList as $item) {
            $item->tahun_sertifikasi_berikutnya = '-';
            if (!empty($item->tanggal_terakhir) && !empty($item->periode_kalibrasi)) {
                $year = (int) date('Y', strtotime($item->tanggal_terakhir));
                $item->tahun_sertifikasi_berikutnya = $year + (int) $item->periode_kalibrasi;
            }

            $isRusak = (!empty($item->kondisi) && strtolower($item->kondisi) === 'rusak');
            if ($isRusak) {
                $rusakCount++;
            }

            $isOverdue = false;
            if (empty($item->tanggal_terakhir) || empty($item->tanggal_berikutnya) || $item->tanggal_berikutnya < $today || $isRusak) {
                $isOverdue = true;
            }

            if ($isOverdue) {
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

            $seksi = !empty($item->seksi_pemakai) ? $item->seksi_pemakai : 'QC Lab';
            if (!isset($seksiStats[$seksi])) {
                $seksiStats[$seksi] = array('aktif' => 0, 'tidak_aktif' => 0, 'belum_dikalibrasi' => 0);
            }
            if (empty($item->tanggal_terakhir)) {
                $seksiStats[$seksi]['belum_dikalibrasi']++;
            } else if ($isOverdue) {
                $seksiStats[$seksi]['tidak_aktif']++;
            } else {
                $seksiStats[$seksi]['aktif']++;
            }

            $kat = !empty($item->kategori_alat) ? $item->kategori_alat : '';
            if (!empty($kat)) {
                if (!isset($katStats[$kat])) {
                    $katStats[$kat] = array('in_cal' => 0, 'due_soon' => 0, 'overdue' => 0);
                }
                if ($isOverdue) {
                    $katStats[$kat]['overdue']++;
                } else if ($item->tanggal_berikutnya <= $in30days) {
                    $katStats[$kat]['due_soon']++;
                } else {
                    $katStats[$kat]['in_cal']++;
                }
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
            'seksi_categories' => array_keys($seksiStats),
            'seksi_aktif' => array_column($seksiStats, 'aktif'),
            'seksi_tidak_aktif' => array_column($seksiStats, 'tidak_aktif'),
            'seksi_belum_kalibrasi' => array_column($seksiStats, 'belum_dikalibrasi'),
            'kat_categories' => array_keys($katStats),
            'kat_in_cal' => array_column($katStats, 'in_cal'),
            'kat_due_soon' => array_column($katStats, 'due_soon'),
            'kat_overdue' => array_column($katStats, 'overdue')
        );

        $data = array(
            'title' => 'E-Calibration | Data Instrumen',
            'instrumen' => $instrumenList,
            'summary' => $summary,
            'chartData' => $chartData,
            'selectedYear' => $selectedYear,
            'availableYears' => $availableYears
        );
        $this->load->view('layout/header', $data);
        $this->load->view('kalibrasi/index', $data);
        $this->load->view('layout/footer', $data);
    }

    public function detail($id)
    {
        $instrumen = $this->MasterInstrumen_model->get_by_id($id);
        if (!$instrumen) {
            show_404();
        }

        $this->load->library('qrcode');
        $qrUrl = $this->qrcode->generate(base_url('kalibrasi/detail/' . $id));

        $riwayat = $this->RiwayatKalibrasi_model->get_by_nomor($instrumen->nomor_identifikasi);
        // Order by tanggal_terakhir DESC for view display
        usort($riwayat, function ($a, $b) {
            return strtotime($b->tanggal_terakhir) - strtotime($a->tanggal_terakhir);
        });

        $data = array(
            'title' => 'Detail Instrumen',
            'instrumen' => $instrumen,
            'riwayat' => $riwayat,
            'qrcode' => $qrUrl
        );

        $this->load->view('layout/header', $data);
        $this->load->view('kalibrasi/detail', $data);
        $this->load->view('layout/footer', $data);
    }

    public function create()
    {
        $data = array(
            'title' => 'Tambah Instrumen Baru'
        );
        $this->load->view('layout/header', $data);
        $this->load->view('kalibrasi/form', $data);
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

        $this->MasterInstrumen_model->insert($masterData);

        // Check if initial calibration data is provided
        $tanggalTerakhir = $this->input->post('tanggal_terakhir');
        if (!empty($tanggalTerakhir)) {
            $riwayatData = array(
                'nomor_identifikasi' => $nomorIdentifikasi,
                'tanggal_terakhir' => $tanggalTerakhir,
                'tanggal_berikutnya' => date('Y-m-d', strtotime('+' . (int) $periodeKalibrasi . ' years', strtotime($tanggalTerakhir))),
                'badan_kalibrasi' => $this->input->post('badan_kalibrasi'),
                'nomor_sertifikat' => $this->input->post('nomor_sertifikat'),
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

            $this->RiwayatKalibrasi_model->insert($riwayatData);
            $this->updateRiwayatStatus($nomorIdentifikasi);
        }

        $this->session->set_flashdata('success', 'Data instrumen berhasil ditambahkan.');
        redirect('kalibrasi');
    }

    public function edit($id)
    {
        $instrumen = $this->MasterInstrumen_model->get_by_id($id);
        if (!$instrumen) {
            show_404();
        }

        $riwayatList = $this->RiwayatKalibrasi_model->get_by_nomor($instrumen->nomor_identifikasi);
        $latestRiwayat = !empty($riwayatList) ? $riwayatList[0] : null;

        $data = array(
            'title' => 'Edit Instrumen',
            'instrumen' => $instrumen,
            'riwayat' => $latestRiwayat
        );
        $this->load->view('layout/header', $data);
        $this->load->view('kalibrasi/edit', $data);
        $this->load->view('layout/footer', $data);
    }

    public function update($id)
    {
        $instrumen = $this->MasterInstrumen_model->get_by_id($id);
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

        // Handle foto upload
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

        $this->MasterInstrumen_model->update($id, $updateData);

        // Update or insert latest calibration history
        $riwayatId = $this->input->post('riwayat_id');
        $tanggalTerakhir = $this->input->post('tanggal_terakhir');

        if (!empty($tanggalTerakhir)) {
            $periodeKalibrasi = $updateData['periode_kalibrasi'];
            $riwayatData = array(
                'nomor_identifikasi' => $updateData['nomor_identifikasi'],
                'tanggal_terakhir' => $tanggalTerakhir,
                'tanggal_berikutnya' => date('Y-m-d', strtotime('+' . (int) $periodeKalibrasi . ' years', strtotime($tanggalTerakhir))),
                'badan_kalibrasi' => $this->input->post('badan_kalibrasi'),
                'nomor_sertifikat' => $this->input->post('nomor_sertifikat'),
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
                $this->RiwayatKalibrasi_model->update($riwayatId, $riwayatData);
            } else {
                $this->RiwayatKalibrasi_model->insert($riwayatData);
            }
            $this->updateRiwayatStatus($updateData['nomor_identifikasi']);
        }

        $this->session->set_flashdata('success', 'Data instrumen berhasil diupdate.');
        redirect('kalibrasi');
    }

    public function delete($id)
    {
        $instrumen = $this->MasterInstrumen_model->get_by_id($id);
        if ($instrumen) {
            if (!empty($instrumen->foto_alat) && file_exists('./uploads/instrumen/' . $instrumen->foto_alat)) {
                @unlink('./uploads/instrumen/' . $instrumen->foto_alat);
            }

            $riwayat = $this->RiwayatKalibrasi_model->get_by_nomor($instrumen->nomor_identifikasi);
            foreach ($riwayat as $r) {
                if (!empty($r->file_sertifikat) && file_exists('./uploads/sertifikat/' . $r->file_sertifikat)) {
                    @unlink('./uploads/sertifikat/' . $r->file_sertifikat);
                }
                $this->RiwayatKalibrasi_model->delete($r->id);
            }

            $this->MasterInstrumen_model->delete($id);
        }
        $this->session->set_flashdata('success', 'Data instrumen berhasil dihapus.');
        redirect('kalibrasi');
    }

    public function storeRiwayat($id)
    {
        $instrumen = $this->MasterInstrumen_model->get_by_id($id);
        if (!$instrumen) {
            show_404();
        }

        $tanggalTerakhir = $this->input->post('tanggal_terakhir');
        if (!empty($tanggalTerakhir)) {
            $riwayatData = array(
                'nomor_identifikasi' => $instrumen->nomor_identifikasi,
                'tanggal_terakhir' => $tanggalTerakhir,
                'tanggal_berikutnya' => date('Y-m-d', strtotime('+' . (int) $instrumen->periode_kalibrasi . ' years', strtotime($tanggalTerakhir))),
                'badan_kalibrasi' => $this->input->post('badan_kalibrasi'),
                'nomor_sertifikat' => $this->input->post('nomor_sertifikat'),
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

            $this->RiwayatKalibrasi_model->insert($riwayatData);
            $this->updateRiwayatStatus($instrumen->nomor_identifikasi);
        }

        $this->session->set_flashdata('success', 'Riwayat kalibrasi berhasil ditambahkan.');
        redirect('kalibrasi/detail/' . $id);
    }

    public function deleteRiwayat($id)
    {
        $riwayat = $this->RiwayatKalibrasi_model->get_by_id($id);
        if ($riwayat) {
            if (!empty($riwayat->file_sertifikat) && file_exists('./uploads/sertifikat/' . $riwayat->file_sertifikat)) {
                @unlink('./uploads/sertifikat/' . $riwayat->file_sertifikat);
            }
            $this->RiwayatKalibrasi_model->delete($id);
        }
        $this->session->set_flashdata('success', 'Riwayat kalibrasi berhasil dihapus.');
        if ($riwayat) {
            $this->updateRiwayatStatus($riwayat->nomor_identifikasi);
        }
        if (isset($_SERVER['HTTP_REFERER'])) {
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            redirect('kalibrasi');
        }
    }

    private function updateRiwayatStatus($nomorIdentifikasi)
    {
        $this->db->where('nomor_identifikasi', $nomorIdentifikasi)->update('riwayat_kalibrasi', array('status' => 'Tidak aktif'));
        $latest = $this->db->where('nomor_identifikasi', $nomorIdentifikasi)
            ->order_by('tanggal_terakhir', 'DESC')
            ->order_by('id', 'DESC')
            ->get('riwayat_kalibrasi')
            ->row();
        if ($latest) {
            $this->db->where('id', $latest->id)->update('riwayat_kalibrasi', array('status' => 'Aktif'));
        }
    }

    public function chartData($id)
    {
        $instrumen = $this->MasterInstrumen_model->get_by_id($id);
        if (!$instrumen) {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(array('error' => 'Not Found')));
        }

        $riwayat = $this->RiwayatKalibrasi_model->get_by_nomor($instrumen->nomor_identifikasi);

        $labels = array();
        $data = array();

        foreach ($riwayat as $r) {
            $labels[] = $r->tanggal_terakhir;
            $data[] = (float) $r->deviasi_aktual;
        }

        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array(
                'labels' => $labels,
                'data' => $data
            )));
    }
}