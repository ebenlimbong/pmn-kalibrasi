<div class="d-flex justify-content-between align-items-center mb-4 mt-3">
    <h6 class="text-uppercase fw-bold text-secondary mb-0" style="letter-spacing: 0.5px;">DETAIL INSTRUMEN</h6>
</div>

<div class="row">
    <!-- LEFT COLUMN: INSTRUMENT INFO -->
    <div class="col-md-3 mb-4">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body p-4">
                <!-- FOTO ALAT -->
                <div class="mb-4 text-center border rounded p-2 bg-light" style="min-height: 200px; display: flex; align-items: center; justify-content: center;">
                    <?php if(!empty($instrumen->foto_alat)): ?>
                        <img src="<?= base_url('uploads/instrumen/' . esc($instrumen->foto_alat)) ?>" alt="Foto Instrumen" class="img-fluid rounded" style="max-height: 200px; object-fit: contain;">
                    <?php else: ?>
                        <span class="text-muted fw-bold">FOTO ALAT</span>
                    <?php endif; ?>
                </div>

                <!-- INSTRUMENT DETAILS -->
                <div class="mb-4" style="font-size: 0.9rem;">
                    <dl class="row mb-0">
                        <dt class="col-sm-12 text-uppercase fw-bold text-dark mb-0" style="font-size: 0.8rem;">Nama Instrumen</dt>
                        <dd class="col-sm-12 text-muted mb-2"><?= esc($instrumen->nama_instrumen) ?></dd>
                        
                        <dt class="col-sm-12 text-uppercase fw-bold text-dark mb-0" style="font-size: 0.8rem;">Seksi Pemakai</dt>
                        <dd class="col-sm-12 text-muted mb-2"><?= esc($instrumen->seksi_pemakai ?? '-') ?></dd>

                        <dt class="col-sm-12 text-uppercase fw-bold text-dark mb-0" style="font-size: 0.8rem;">Kategori Alat</dt>
                        <dd class="col-sm-12 text-muted mb-2"><?= esc($instrumen->kategori_alat ?? '-') ?></dd>
                        
                        <dt class="col-sm-12 text-uppercase fw-bold text-dark mb-0" style="font-size: 0.8rem;">Nomor Identifikasi</dt>
                        <dd class="col-sm-12 text-muted mb-2"><?= esc($instrumen->nomor_identifikasi) ?></dd>

                        <dt class="col-sm-12 text-uppercase fw-bold text-dark mb-0" style="font-size: 0.8rem;">Tanggal Pertama Digunakan</dt>
                        <dd class="col-sm-12 text-muted mb-2"><?= !empty($instrumen->tanggal_mulai_digunakan) ? date('d-m-Y', strtotime($instrumen->tanggal_mulai_digunakan)) : '-' ?></dd>
                        
                        <dt class="col-sm-12 text-uppercase fw-bold text-dark mb-0" style="font-size: 0.8rem;">Umur Instrumen</dt>
                        <dd class="col-sm-12 text-muted mb-2"><span class="badge bg-light text-secondary border rounded-pill px-2.5 py-1 fw-medium" style="font-size: 0.78rem; background-color: #f8f9fa !important; border-color: #dee2e6 !important;"><i class="bi bi-clock-history me-1 opacity-75"></i><?= esc(hitung_umur_instrumen($instrumen->tanggal_mulai_digunakan ?? '')) ?></span></dd>
                        
                        <dt class="col-sm-12 text-uppercase fw-bold text-dark mb-0" style="font-size: 0.8rem;">Kondisi Alat</dt>
                        <dd class="col-sm-12 text-muted mb-3">
                            <?php
                                $kondisiVal = strtolower($instrumen->kondisi ?? 'baik');
                                if ($kondisiVal === 'rusak') {
                                    echo '<span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-3 py-1.5 rounded-pill fw-semibold"><i class="bi bi-x-circle-fill me-1"></i> Rusak</span>';
                                } else if ($kondisiVal === 'perbaikan') {
                                    echo '<span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 px-3 py-1.5 rounded-pill fw-semibold"><i class="bi bi-tools me-1"></i> Dalam Perbaikan</span>';
                                } else {
                                    echo '<span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-1.5 rounded-pill fw-semibold"><i class="bi bi-check-circle-fill me-1"></i> Baik</span>';
                                }
                            ?>
                        </dd>
                        
                        <dt class="col-sm-12 text-uppercase fw-bold text-dark mb-1" style="font-size: 0.85rem; border-bottom: 1px solid #eee; padding-bottom: 4px;">Spesifikasi</dt>
                        <dd class="col-sm-12 text-muted mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="fw-medium text-dark">Kapasitas</span>
                                <span><?= esc($instrumen->interval_kapasitas ?? '-') ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <span class="fw-medium text-dark">Ketelitian</span>
                                <span><?= esc($instrumen->ketelitian ?? '-') ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <span class="fw-medium text-dark">Model / Tipe</span>
                                <span><?= esc($instrumen->model_tipe ?? '-') ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <span class="fw-medium text-dark">Pembuat</span>
                                <span><?= esc($instrumen->pembuat ?? '-') ?></span>
                            </div>
                        </dd>

                        <dt class="col-sm-12 text-uppercase fw-bold text-dark mb-0" style="font-size: 0.8rem;">Periode</dt>
                        <dd class="col-sm-12 text-muted mb-2"><?= esc($instrumen->periode_kalibrasi) ?> Tahun</dd>

                        <dt class="col-sm-12 text-uppercase fw-bold text-dark mb-0" style="font-size: 0.8rem;">Kegunaan</dt>
                        <dd class="col-sm-12 text-muted mb-0"><?= esc($instrumen->kegunaan ?? '-') ?></dd>
                    </dl>
                </div>

                <!-- QR CODE -->
                <?php if(isset($qrcode)): ?>
                <div class="text-center mt-4">
                    <div class="d-inline-block p-2 bg-white rounded border shadow-sm w-100" style="max-width: 250px;">
                        <img src="<?= $qrcode ?>" alt="QR Code" class="img-fluid w-100" />
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- RIGHT COLUMN: HISTORY KALIBRASI -->
    <div class="col-md-9 mb-4">
        <div class="card shadow-sm border-0 rounded-4 h-100">
            <div class="card-header bg-white pt-4 pb-3 border-0 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-uppercase">HISTORY KALIBRASI</h5>
                <button type="button" class="btn btn-outline-dark fw-bold px-4" data-bs-toggle="modal" data-bs-target="#updateKalibrasiModal">
                    Update Kalibrasi
                </button>
            </div>
            
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover table-borderless border-bottom mb-0 align-middle text-nowrap text-center" style="font-size: 0.9rem;">
                        <thead class="bg-light align-middle text-dark text-center" style="font-size: 0.85rem;">
                            <tr class="border-bottom border-light">
                                <th class="fw-bold border-bottom-0">Tanggal Kalibrasi</th>
                                <th class="fw-bold border-bottom-0">Badan Kalibrasi</th>
                                <th class="fw-bold border-bottom-0">No sertifikat</th>
                                <th class="fw-bold border-bottom-0">Kalibrasi Berikutnya</th>
                                <th class="fw-bold border-bottom-0">Standar Batas Penerimaan Hasil</th>
                                <th class="fw-bold border-bottom-0">Keterangan</th>
                                <th class="fw-bold border-bottom-0">Status</th>
                                <th class="fw-bold border-bottom-0">Sertifikat</th>
                                <th class="fw-bold border-bottom-0">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($riwayat)) : ?>
                                <tr>
                                    <td colspan="9" class="text-center py-4 text-muted">Belum ada riwayat kalibrasi.</td>
                                </tr>
                            <?php else : ?>
                                <?php foreach($riwayat as $r) : ?>
                                    <tr>
                                        <td><?= esc($r->tanggal_terakhir) ?></td>
                                        <td><?= esc($r->badan_kalibrasi ?? '-') ?></td>
                                        <td><?= esc($r->nomor_sertifikat ?? '-') ?></td>
                                        <td><?= esc($r->tanggal_berikutnya) ?></td>
                                        <td><?= esc($r->batas_penerimaan ?? '-') ?></td>
                                        <td><?= esc($r->keterangan ?? '-') ?></td>
                                        <td class="text-center">
                                            <?php
                                                $stText = (isset($r->status) && $r->status === 'Aktif') ? 'Aktif' : 'Tidak aktif';
                                                $stClass = (isset($r->status) && $r->status === 'Aktif') ? 'text-success' : 'text-danger';
                                            ?>
                                            <span class="<?= $stClass ?> fw-bold"><?= esc($stText) ?></span>
                                        </td>
                                        <td class="text-center">
                                            <?php if(!empty($r->file_sertifikat)): ?>
                                                <a href="<?= base_url('uploads/sertifikat/' . esc($r->file_sertifikat)) ?>" target="_blank" class="btn btn-sm btn-info text-white shadow-sm px-2 py-1 rounded-2 d-inline-flex align-items-center gap-1" style="font-size: 0.75rem;">
                                                    <i class="bi bi-cloud-download"></i> Download
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <form action="<?= base_url('kalibrasi/deleteRiwayat/' . $r->id) ?>" method="post" onsubmit="return confirm('Apakah Anda yakin ingin menghapus riwayat ini?');">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="btn btn-sm btn-danger text-white shadow-sm p-2 rounded-2 d-inline-flex align-items-center justify-content-center" title="Hapus" style="width: 32px; height: 32px;">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Update Kalibrasi -->
<div class="modal fade" id="updateKalibrasiModal" tabindex="-1" aria-labelledby="updateKalibrasiModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content rounded-4 border-0 shadow">
      <div class="modal-header border-bottom-0">
        <h5 class="modal-title fw-bold" id="updateKalibrasiModalLabel">Update Kalibrasi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="<?= base_url('kalibrasi/storeRiwayat/' . $instrumen->id) ?>" method="post" enctype="multipart/form-data">
          <?= csrf_field() ?>
          <div class="modal-body">
              <div class="mb-3">
                  <label class="form-label text-muted fw-medium">Tanggal Kalibrasi <span class="text-danger">*</span></label>
                  <input type="date" class="form-control" name="tanggal_terakhir" required>
              </div>
              <div class="mb-3">
                  <label class="form-label text-muted fw-medium">Badan Kalibrasi</label>
                  <input type="text" class="form-control" name="badan_kalibrasi">
              </div>
              <div class="mb-3">
                  <label class="form-label text-muted fw-medium">Nomor Sertifikat</label>
                  <input type="text" class="form-control" name="nomor_sertifikat">
              </div>
              <div class="mb-3">
                  <label class="form-label text-muted fw-medium">Standar Batas Penerimaan Hasil</label>
                  <input type="text" class="form-control" name="batas_penerimaan" placeholder="0.2 mx">
              </div>
              <div class="mb-3">
                  <label class="form-label text-muted fw-medium">Keterangan</label>
                  <textarea class="form-control" name="keterangan" rows="2"></textarea>
              </div>
              <div class="mb-3">
                  <label class="form-label text-muted fw-medium">File Sertifikat</label>
                  <input type="file" class="form-control" name="file_sertifikat" accept=".pdf,image/*">
              </div>
          </div>
          <div class="modal-footer border-top-0">
            <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary px-4 fw-bold">Simpan</button>
          </div>
      </form>
    </div>
  </div>
</div>

