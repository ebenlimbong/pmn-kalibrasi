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
        <a href="<?= base_url('kalibrasi') ?>" class="kalibrasi-tab">Eksternal</a>
        <a href="<?= base_url('kalibrasi-internal') ?>" class="kalibrasi-tab active">Internal</a>
    </div>
</div>

<!-- 4 OVERVIEW CARDS (BOOTSTRAP SIMPLE CARDS) -->
<div class="row g-3 mb-4">
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 border-start border-4 border-primary">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-uppercase text-muted fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">Total Instrumen</span>
                        <h3 class="fw-bold text-dark mb-0 mt-1"><?= esc($summary['total'] ?? 0) ?> <span class="fs-6 text-muted fw-normal">Unit</span></h3>
                    </div>
                    <div class="rounded-circle bg-primary bg-opacity-10 p-3 text-primary d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                        <i class="bi bi-tools fs-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 border-start border-4 border-success">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-uppercase text-muted fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">Passed (In-Cal)</span>
                        <h3 class="fw-bold text-success mb-0 mt-1"><?= esc($summary['aktif'] ?? 0) ?> <span class="fs-6 text-muted fw-normal">Unit</span></h3>
                    </div>
                    <div class="rounded-circle bg-success bg-opacity-10 p-3 text-success d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                        <i class="bi bi-check-circle fs-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 border-start border-4 border-warning">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-uppercase text-muted fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">Jatuh Tempo Bulan Ini</span>
                        <h3 class="fw-bold text-warning mb-0 mt-1"><?= esc($summary['due_soon'] ?? 0) ?> <span class="fs-6 text-muted fw-normal">Unit</span></h3>
                    </div>
                    <div class="rounded-circle bg-warning bg-opacity-10 p-3 text-warning d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                        <i class="bi bi-exclamation-triangle fs-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 border-start border-4 border-danger">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-uppercase text-muted fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">Out of Spec (Overdue)</span>
                        <h3 class="fw-bold text-danger mb-0 mt-1"><?= esc($summary['overdue'] ?? 0) ?> <span class="fs-6 text-muted fw-normal">Unit</span></h3>
                    </div>
                    <div class="rounded-circle bg-danger bg-opacity-10 p-3 text-danger d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                        <i class="bi bi-x-circle fs-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CHARTS SECTION (MATCHING GAMBAR 1 FROM MENTOR) -->
<div class="row g-3 mb-4">
    <!-- Chart 1: Yearly Maintenance Execution Curve -->
    <div class="col-12 col-lg-7">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white pt-3 pb-2 border-0 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold text-dark mb-0">Yearly Maintenance Execution Curve</h6>
                <span class="badge bg-light text-secondary border">2026</span>
            </div>
            <div class="card-body p-3">
                <div id="yearlyExecutionCurveInternal" style="min-height: 240px;"></div>
            </div>
        </div>
    </div>

    <!-- Chart 2: Yearly Not Yet Finished Chart -->
    <div class="col-12 col-lg-5">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white pt-3 pb-2 border-0 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold text-dark mb-0">Yearly Not Yet Finished Chart</h6>
                <span class="badge bg-light text-secondary border">Per Seksi</span>
            </div>
            <div class="card-body p-3">
                <div id="yearlyNotFinishedChartInternal" style="min-height: 240px;"></div>
            </div>
        </div>
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
                <a href="<?= base_url('kalibrasi-internal/create') ?>" class="btn btn-sm btn-primary shadow-sm px-3 fw-medium" style="background-color: #3b5998; border: none;">+ Tambah Data</a>
            </div>
        </div>

        <table id="tabelInstrumen" class="table table-hover align-middle mb-0 table-sm text-nowrap text-center" style="width:100%; font-size: 0.9rem;">
                <thead class="bg-light align-middle text-center text-dark" style="font-size: 0.85rem;">
                    <tr class="border-bottom border-light">
                        <th rowspan="2" class="fw-bold border-bottom-0 align-middle text-center">Foto</th>
                        <th rowspan="2" class="fw-bold border-bottom-0 align-middle text-center">Nama Instrumen</th>
                        <th rowspan="2" class="fw-bold border-bottom-0 align-middle text-center">Seksi Pemakai</th>
                        <th rowspan="2" class="fw-bold border-bottom-0 align-middle text-center">Kategori Alat</th>
                        <th rowspan="2" class="fw-bold border-bottom-0 align-middle text-center">No Identifikasi</th>
                        <th rowspan="2" class="fw-bold border-bottom-0 align-middle text-center">Umur Instrumen</th>
                        <th colspan="4" class="fw-bold border-bottom-0 text-center">Spesifikasi</th>
                        <th rowspan="2" class="fw-bold border-bottom-0 align-middle text-center">Kegunaan</th>
                        <th rowspan="2" class="fw-bold border-bottom-0 align-middle text-center">Periode</th>
                        <th colspan="2" class="fw-bold border-bottom-0 text-center">Riwayat Kalibrasi</th>
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
                        <th class="fw-bold text-dark text-center">Tanggal Kalibrasi</th>
                        <th class="fw-bold text-dark text-center">Berikut</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($instrumen)) : ?>
                        <tr>
                            <td colspan="18" class="text-center py-4 text-muted">Belum ada data instrumen standar kerja.</td>
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
                                <td><span class="badge bg-info bg-opacity-10 text-dark border border-info border-opacity-25 px-2 py-1" style="font-size: 0.78rem;"><?= esc($item->kategori_alat ?? '-') ?></span></td>
                                <td class="fw-medium text-dark"><?= esc($item->nomor_identifikasi) ?></td>
                                <td><span class="badge bg-light text-secondary border rounded-pill px-2 py-1 fw-medium" style="font-size: 0.78rem; background-color: #f8f9fa !important; border-color: #dee2e6 !important;"><i class="bi bi-clock-history me-1 opacity-75"></i><?= esc(hitung_umur_instrumen($item->tanggal_mulai_digunakan ?? '')) ?></span></td>
                                <td><?= esc($item->interval_kapasitas ?? '-') ?></td>
                                <td><?= esc($item->ketelitian ?? '-') ?></td>
                                <td><?= esc($item->model_tipe ?? '-') ?></td>
                                <td><?= esc($item->pembuat ?? '-') ?></td>
                                <td class="text-start"><?= esc($item->kegunaan ?? '-') ?></td>
                                <td><?= esc($item->periode_kalibrasi ? $item->periode_kalibrasi . ' Tahun' : '-') ?></td>
                                <td><?= esc($item->tanggal_terakhir ?? '-') ?></td>
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
                                        <a href="<?= base_url('kalibrasi-internal/detail/' . $item->id) ?>" class="btn btn-info text-white shadow-sm p-2 rounded-3 d-flex align-items-center justify-content-center border-0" title="Detail" style="width: 35px; height: 35px;">
                                            <i class="bi bi-eye" style="font-size: 1.1rem;"></i>
                                        </a>
                                        <a href="<?= base_url('kalibrasi-internal/edit/' . $item->id) ?>" class="btn btn-primary text-white shadow-sm p-2 rounded-3 d-flex align-items-center justify-content-center border-0" title="Edit" style="width: 35px; height: 35px;">
                                            <i class="bi bi-pencil" style="font-size: 1.1rem;"></i>
                                        </a>
                                        <form action="<?= base_url('kalibrasi-internal/delete/' . $item->id) ?>" method="post" class="d-inline m-0" onsubmit="return confirm('Apakah Anda yakin ingin menghapus instrumen ini?');">
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

    // Initialize ApexCharts (Matching Gambar 1 from Mentor)
    var targetData = <?= json_encode($chartData['target_monthly'] ?? array_fill(0,12,0)) ?>;
    var finishedData = <?= json_encode($chartData['finished_monthly'] ?? array_fill(0,12,0)) ?>;
    
    var seksiCategories = <?= json_encode(!empty($chartData['seksi_categories']) ? $chartData['seksi_categories'] : array('Bengkel', 'QC Lab', 'Maintenance')) ?>;
    var seksiPostponed = <?= json_encode(!empty($chartData['seksi_postponed']) ? $chartData['seksi_postponed'] : array(0, 0, 0)) ?>;
    var seksiContinued = <?= json_encode(!empty($chartData['seksi_continued']) ? $chartData['seksi_continued'] : array(1, 1, 1)) ?>;

    var curveOptions = {
        series: [{
            name: 'Finished',
            data: finishedData
        }, {
            name: 'Target',
            data: targetData
        }],
        chart: {
            height: 240,
            type: 'line',
            toolbar: { show: true },
            zoom: { enabled: false }
        },
        colors: ['#e74c3c', '#3498db'],
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth', width: 3 },
        xaxis: {
            categories: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12']
        },
        legend: { position: 'bottom' },
        grid: { borderColor: '#f1f1f1' }
    };
    var curveChart = new ApexCharts(document.querySelector("#yearlyExecutionCurveInternal"), curveOptions);
    curveChart.render();

    var barOptions = {
        series: [{
            name: 'Postponed',
            data: seksiPostponed
        }, {
            name: 'Continued',
            data: seksiContinued
        }],
        chart: {
            type: 'bar',
            height: 240,
            stacked: true,
            toolbar: { show: false }
        },
        colors: ['#f1c40f', '#2ecc71'],
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '35%',
                borderRadius: 4
            }
        },
        xaxis: { categories: seksiCategories },
        legend: { position: 'bottom' },
        fill: { opacity: 1 }
    };
    var barChart = new ApexCharts(document.querySelector("#yearlyNotFinishedChartInternal"), barOptions);
    barChart.render();
});
</script>

