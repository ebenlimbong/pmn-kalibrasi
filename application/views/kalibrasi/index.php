<style>
.kalibrasi-tabs {
    display: inline-flex;
    background-color: #f1f3f5;
    border-radius: 8px;
    padding: 4px;
}
.kalibrasi-tab {
    padding: 8px 40px;
    color: #6c757d;
    text-decoration: none;
    font-weight: 500;
    font-size: 0.95rem;
    border-radius: 6px;
    transition: all 0.2s ease;
}
.kalibrasi-tab:hover {
    color: #495057;
}
.kalibrasi-tab.active {
    background-color: #ffffff;
    color: #3b5998;
    font-weight: 600;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}
</style>

<div class="mb-4 mt-3">
    <h6 class="text-uppercase fw-bold text-secondary mb-3" style="letter-spacing: 0.5px;">MASTER KALIBRASI</h6>
    <div class="kalibrasi-tabs shadow-sm">
        <a href="<?= base_url('kalibrasi') ?>" class="kalibrasi-tab active">Eksternal</a>
        <a href="<?= base_url('kalibrasi-internal') ?>" class="kalibrasi-tab">Internal</a>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        <div class="row align-items-center mb-3 g-2">
            <!-- First Group (Length & Search) -->
            <div class="col-12 col-md-5 col-lg-4 d-flex gap-2">
                <select id="customLength" class="form-select form-select-sm shadow-sm border-0" style="width: 70px; flex-shrink: 0;">
                    <option value="10">10</option>
                    <option value="15" selected>15</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
                <div class="input-group input-group-sm shadow-sm border-0 bg-white rounded flex-grow-1">
                    <span class="input-group-text bg-white border-0 text-muted"><i class="bi bi-search"></i></span>
                    <input type="text" id="customSearch" class="form-control border-0 shadow-none" placeholder="Cari...">
                </div>
            </div>
            
            <!-- Second Group (Date Filter & Clear) -->
            <div class="col-12 col-md-auto d-flex gap-2 mt-2 mt-md-0">
                <input type="date" id="customDateFilter" class="form-control form-control-sm shadow-sm border-0 flex-grow-1" style="min-width: 140px;" title="Pilih tanggal">
                <button id="clearFilterBtn" class="btn btn-sm text-white shadow-sm text-nowrap px-3" style="background-color: #3b5998;">Clear Filter</button>
            </div>
            
            <!-- Third Group (Refresh & Tambah) -->
            <div class="col-12 col-md-auto ms-md-auto mt-2 mt-md-0 d-flex justify-content-end gap-2">
                <button id="refreshBtn" class="btn btn-sm text-white shadow-sm text-nowrap px-3" style="background-color: #fbb03b;"><i class="bi bi-arrow-clockwise"></i> Refresh</button>
                <a href="<?= base_url('kalibrasi/create') ?>" class="btn btn-sm btn-primary shadow-sm px-3 fw-medium" style="background-color: #3b5998; border: none;">+ Tambah Data</a>
            </div>
        </div>

        <table id="tabelInstrumen" class="table table-hover align-middle mb-0 table-sm text-nowrap text-center" style="width:100%">
                <thead class="bg-light align-middle text-center text-dark" style="font-size: 0.85rem;">
                    <tr class="border-bottom border-light">
                        <th rowspan="2" class="fw-bold border-bottom-0 align-middle text-center">Foto</th>
                        <th rowspan="2" class="fw-bold border-bottom-0 align-middle text-center">Nama Instrumen</th>
                        <th rowspan="2" class="fw-bold border-bottom-0 align-middle text-center">Seksi Pemakai</th>
                        <th rowspan="2" class="fw-bold border-bottom-0 align-middle text-center">No Identifikasi</th>
                        <th colspan="4" class="fw-bold border-bottom-0 text-center">Spesifikasi</th>
                        <th rowspan="2" class="fw-bold border-bottom-0 align-middle text-center">Kegunaan</th>
                        <th rowspan="2" class="fw-bold border-bottom-0 align-middle text-center">Periode</th>
                        <th colspan="4" class="fw-bold border-bottom-0 text-center">Detail Kalibrasi</th>
                        <th rowspan="2" class="fw-bold border-bottom-0 align-middle text-center">Standar Batas</th>
                        <th rowspan="2" class="fw-bold border-bottom-0 align-middle text-center">Keterangan</th>
                        <th rowspan="2" class="fw-bold border-bottom-0 align-middle text-center">Status</th>
                        <th rowspan="2" class="fw-bold border-bottom-0 align-middle text-center">Aksi</th>
                    </tr>
                    <tr>
                        <th class="fw-bold text-dark text-center">Interval</th>
                        <th class="fw-bold text-dark text-center">Ketelitian</th>
                        <th class="fw-bold text-dark text-center">Model</th>
                        <th class="fw-bold text-dark text-center">Pembuat</th>
                        <th class="fw-bold text-dark text-center">Terakhir Kalibrasi</th>
                        <th class="fw-bold text-dark text-center">Badan Kalibrasi</th>
                        <th class="fw-bold text-dark text-center">NO Sertifikat</th>
                        <th class="fw-bold text-dark text-center">Tahun Berikutnya</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($instrumen)) : ?>
                        <tr>
                            <td colspan="18" class="text-center py-4 text-muted">Belum ada data instrumen.</td>
                        </tr>
                    <?php else : ?>
                        <?php foreach($instrumen as $item) : ?>
                            <tr>
                                <td>
                                    <?php if(!empty($item->foto_alat)): ?>
                                        <img src="<?= base_url('uploads/instrumen/' . esc($item->foto_alat)) ?>" alt="Foto" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                                    <?php else: ?>
                                        <div class="bg-light d-flex align-items-center justify-content-center text-muted border rounded" style="width: 50px; height: 50px; font-size: 0.8rem;">No Img</div>
                                    <?php endif; ?>
                                </td>
                                <td class="text-start"><?= esc($item->nama_instrumen ?? '-') ?></td>
                                <td><?= esc($item->seksi_pemakai ?? '-') ?></td>
                                <td class="fw-medium text-primary"><?= esc($item->nomor_identifikasi) ?></td>
                                <td><?= esc($item->interval_kapasitas ?? '-') ?></td>
                                <td><?= esc($item->ketelitian ?? '-') ?></td>
                                <td><?= esc($item->model_tipe ?? '-') ?></td>
                                <td><?= esc($item->pembuat ?? '-') ?></td>
                                <td class="text-start"><?= esc($item->kegunaan ?? '-') ?></td>
                                <td><?= esc($item->periode_kalibrasi ? $item->periode_kalibrasi . ' Tahun' : '-') ?></td>
                                <td><?= esc($item->tanggal_terakhir ?? '-') ?></td>
                                <td><?= esc($item->badan_kalibrasi ?? '-') ?></td>
                                <td><?= esc($item->nomor_sertifikat ?? '-') ?></td>
                                <td><?= esc($item->tahun_sertifikasi_berikutnya ?? '-') ?></td>
                                <td><?= esc($item->batas_penerimaan ?? '-') ?></td>
                                <td class="text-start"><?= esc($item->keterangan ?? '-') ?></td>
                                <td>
                                    <?php
                                        $statusText = 'Aktif';
                                        $textClass = 'text-success';
                                        if (empty($item->tanggal_terakhir)) {
                                            $statusText = 'Belum dikalibrasi';
                                            $textClass = 'text-warning';
                                        } else {
                                            if (!empty($item->tanggal_berikutnya) && strtotime($item->tanggal_berikutnya) < time()) {
                                                $statusText = 'Tidak aktif';
                                                $textClass = 'text-danger';
                                            }
                                        }
                                    ?>
                                    <span class="<?= $textClass ?> fw-bold"><?= esc($statusText) ?></span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="<?= base_url('kalibrasi/detail/' . $item->id) ?>" class="btn btn-info text-white shadow-sm p-2 rounded-3 d-flex align-items-center justify-content-center border-0" title="Detail" style="width: 35px; height: 35px;">
                                            <i class="bi bi-eye" style="font-size: 1.1rem;"></i>
                                        </a>
                                        <a href="<?= base_url('kalibrasi/edit/' . $item->id) ?>" class="btn btn-primary text-white shadow-sm p-2 rounded-3 d-flex align-items-center justify-content-center border-0" title="Edit" style="width: 35px; height: 35px;">
                                            <i class="bi bi-pencil" style="font-size: 1.1rem;"></i>
                                        </a>
                                        <form action="<?= base_url('kalibrasi/delete/' . $item->id) ?>" method="post" class="d-inline m-0" onsubmit="return confirm('Apakah Anda yakin ingin menghapus instrumen ini?');">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-danger text-white shadow-sm p-2 rounded-3 d-flex align-items-center justify-content-center border-0" title="Hapus" style="width: 35px; height: 35px;">
                                                <i class="bi bi-trash" style="font-size: 1.1rem;"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
        </table>
    </div>
</div>

<style>
    @media (max-width: 767.98px) {
        div.dataTables_wrapper div.dataTables_length,
        div.dataTables_wrapper div.dataTables_filter {
            text-align: left !important;
            margin-top: 10px;
            float: none !important;
            width: 100%;
        }
        div.dataTables_wrapper div.dataTables_filter label {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }
        div.dataTables_wrapper div.dataTables_filter input {
            width: 100% !important;
            margin-left: 0 !important;
            display: block !important;
            margin-top: 0.5rem;
            box-sizing: border-box;
        }
        .dataTables_wrapper .row > div {
            margin-bottom: 0.5rem;
        }
    }
</style>

<script>
window.addEventListener('DOMContentLoaded', function() {
    if (typeof jQuery !== 'undefined' && $.fn.DataTable) {
        var table = $('#tabelInstrumen').DataTable({
            scrollX: true,
            pageLength: 15,
            dom: 'rt<"row mt-3"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            language: {
                zeroRecords: "Data tidak ditemukan",
                info: "Menampilkan Data _START_ - _END_ dari _TOTAL_ Data",
                infoEmpty: "Menampilkan Data 0 - 0 dari 0 Data",
                infoFiltered: ""
            }
        });

        $('#customLength').on('change', function() {
            table.page.len($(this).val()).draw();
        });

        $('#customSearch').on('keyup', function() {
            table.search(this.value).draw();
        });

        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                var filterDate = $('#customDateFilter').val();
                if (!filterDate) {
                    return true;
                }
                var rowDate = data[10];
                return rowDate === filterDate;
            }
        );

        $('#customDateFilter').on('change', function() {
            table.draw();
        });

        $('#clearFilterBtn').on('click', function() {
            $('#customSearch').val('');
            $('#customDateFilter').val('');
            table.search('').draw();
        });

        $('#refreshBtn').on('click', function() {
            location.reload();
        });
    }
});
</script>
