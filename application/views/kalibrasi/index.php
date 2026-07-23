<style>
.kalibrasi-tabs {
    display: inline-flex;
    background-color: #e9ecef;
    border-radius: 10px;
    padding: 4px;
}
.kalibrasi-tab {
    padding: 8px 24px;
    color: #6c757d;
    text-decoration: none;
    font-weight: 500;
    font-size: 0.9rem;
    border-radius: 8px;
    transition: all 0.2s ease;
    white-space: nowrap;
    text-align: center;
}
.kalibrasi-tab:hover {
    color: #343a40;
}
.kalibrasi-tab.active {
    background-color: #ffffff;
    color: #2c3e50;
    font-weight: 600;
    box-shadow: 0 2px 5px rgba(0,0,0,0.08);
}
@media (max-width: 575.98px) {
    .kalibrasi-tabs {
        width: 100%;
        display: flex;
    }
    .kalibrasi-tabs .dropdown {
        flex: 1;
        display: flex;
    }
    .kalibrasi-tab {
        width: 100%;
        padding: 8px 10px;
        font-size: 0.85rem;
    }
}
</style>

<div class="mb-4 mt-3">
    <h6 class="text-uppercase fw-bold text-secondary mb-2" style="letter-spacing: 0.5px;">MASTER KALIBRASI</h6>
    <div class="kalibrasi-tabs shadow-sm">
        <!-- Eksternal Dropdown -->
        <div class="dropdown">
            <button type="button" id="btn-eksternal-dropdown" class="kalibrasi-tab active dropdown-toggle border-0" data-bs-toggle="dropdown" aria-expanded="false">
                Eksternal
            </button>
            <ul class="dropdown-menu shadow-sm border-0 rounded-3 mt-1">
                <li>
                    <a class="dropdown-item py-2 px-3 fw-medium d-flex align-items-center gap-2" href="#" onclick="switchViewMode('dashboard'); return false;">
                        <i class="bi bi-speedometer2 text-primary"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a class="dropdown-item py-2 px-3 fw-medium d-flex align-items-center gap-2" href="#" onclick="switchViewMode('data'); return false;">
                        <i class="bi bi-table text-primary"></i> Instrumen
                    </a>
                </li>
            </ul>
        </div>

        <!-- Internal Dropdown -->
        <div class="dropdown">
            <button type="button" id="btn-internal-dropdown" class="kalibrasi-tab dropdown-toggle border-0" data-bs-toggle="dropdown" aria-expanded="false">
                Internal
            </button>
            <ul class="dropdown-menu shadow-sm border-0 rounded-3 mt-1">
                <li>
                    <a class="dropdown-item py-2 px-3 fw-medium d-flex align-items-center gap-2" href="<?= base_url('kalibrasi-internal?tab=dashboard') ?>">
                        <i class="bi bi-speedometer2 text-primary"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a class="dropdown-item py-2 px-3 fw-medium d-flex align-items-center gap-2" href="<?= base_url('kalibrasi-internal?tab=data') ?>">
                        <i class="bi bi-table text-primary"></i> Instrumen
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<!-- SECTION 1: DASHBOARD OVERVIEW -->
<div id="section-dashboard-view">

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

<!-- CHARTS ROW 1 (MATCHING GAMBAR 1 FROM MENTOR) -->
<div class="row g-3 mb-4">
    <!-- Chart 1: Yearly Maintenance Execution Curve -->
    <div class="col-12 col-lg-7">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white pt-3 pb-2 border-0 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold text-dark mb-0">Yearly Maintenance Execution Curve</h6>
                <div class="d-flex align-items-center gap-2">
                    <label for="selectTahun" class="form-label mb-0 text-muted fw-semibold" style="font-size: 0.78rem;">Tahun:</label>
                    <select id="selectTahun" class="form-select form-select-sm shadow-sm border" style="width: 95px; font-size: 0.82rem; font-weight: 600;" onchange="location.href='?tahun=' + this.value;">
                        <?php foreach ($availableYears as $y): ?>
                            <option value="<?= $y ?>" <?= $y == $selectedYear ? 'selected' : '' ?>><?= $y ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="card-body p-3">
                <div id="yearlyExecutionCurve" style="min-height: 240px;"></div>
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
                <div id="yearlyNotFinishedChart" style="min-height: 240px;"></div>
            </div>
        </div>
    </div>
</div>

<!-- CHARTS ROW 2 (STATUS POPULASI & BREAKDOWN PER KATEGORI ALAT) -->
<div class="row g-3 mb-4">
    <!-- Chart 3: Status Populasi Instrumen (Donut Chart) -->
    <div class="col-12 col-lg-5">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white pt-3 pb-2 border-0 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold text-dark mb-0">Status Populasi Instrumen</h6>
                <span class="badge bg-light text-secondary border">Overview</span>
            </div>
            <div class="card-body p-3 d-flex align-items-center justify-content-center">
                <div id="statusPopulasiChart" style="width: 100%; min-height: 240px;"></div>
            </div>
        </div>
    </div>

    <!-- Chart 4: Breakdown Status per Jenis/Kategori Alat (Horizontal Stacked Bar) -->
    <div class="col-12 col-lg-7">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white pt-3 pb-2 border-0 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold text-dark mb-0">Breakdown Status per Jenis Alat</h6>
                <span class="badge bg-light text-secondary border">Kategori Alat</span>
            </div>
            <div class="card-body p-3">
                <div id="breakdownJenisAlatChart" style="min-height: 240px;"></div>
            </div>
        </div>
    </div>
</div> <!-- END Charts Row 2 -->
</div> <!-- END #section-dashboard-view -->

<!-- SECTION 2: DATA INSTRUMEN TABLE -->
<div id="section-data-view" style="display: none;">

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
                        <th class="fw-bold text-dark text-center">Tanggal Kalibrasi</th>
                        <th class="fw-bold text-dark text-center">Badan Kalibrasi</th>
                        <th class="fw-bold text-dark text-center">NO Sertifikat</th>
                        <th class="fw-bold text-dark text-center">Tahun Berikutnya</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($instrumen)) : ?>
                        <tr>
                            <td colspan="20" class="text-center py-4 text-muted">Belum ada data instrumen.</td>
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
</div> <!-- END #section-data-view -->

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
    
    var seksiCategories = <?= json_encode(!empty($chartData['seksi_categories']) ? $chartData['seksi_categories'] : array('QC Lab', 'Maintenance', 'Bengkel')) ?>;
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
        colors: ['#2ecc71', '#3498db'],
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth', width: 3 },
        xaxis: {
            categories: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12']
        },
        yaxis: {
            forceNiceScale: true,
            decimalsInFloat: 0,
            labels: {
                formatter: function (val) {
                    return Math.round(val);
                }
            }
        },
        legend: { position: 'bottom' },
        grid: { borderColor: '#f1f1f1' }
    };
    var curveChart = new ApexCharts(document.querySelector("#yearlyExecutionCurve"), curveOptions);
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
    var barChart = new ApexCharts(document.querySelector("#yearlyNotFinishedChart"), barOptions);
    barChart.render();

    // Chart 3: Status Populasi Instrumen (Donut Chart)
    var donutOptions = {
        series: [<?= (int)($summary['aktif'] ?? 0) ?>, <?= (int)($summary['due_soon'] ?? 0) ?>, <?= (int)($summary['overdue'] ?? 0) ?>],
        chart: {
            type: 'donut',
            height: 240
        },
        labels: ['In-Cal (Aktif)', 'Due Soon', 'Overdue'],
        colors: ['#2ecc71', '#f1c40f', '#e74c3c'],
        legend: { position: 'right' },
        dataLabels: { enabled: true },
        plotOptions: {
            pie: {
                donut: {
                    size: '65%',
                    labels: {
                        show: true,
                        total: {
                            show: true,
                            label: 'Total Unit',
                            formatter: function () {
                                return '<?= (int)($summary['total'] ?? 0) ?> Unit';
                            }
                        }
                    }
                }
            }
        }
    };
    var donutChart = new ApexCharts(document.querySelector("#statusPopulasiChart"), donutOptions);
    donutChart.render();

    // Chart 4: Breakdown Status per Jenis/Kategori Alat (Horizontal Stacked Bar)
    var katCategories = <?= json_encode(!empty($chartData['kat_categories']) ? $chartData['kat_categories'] : array('Pressure Gauge', 'Pressure Switch', 'RTD', 'Multimeter', 'Transducer', 'Thermometer')) ?>;
    var katInCal = <?= json_encode(!empty($chartData['kat_in_cal']) ? $chartData['kat_in_cal'] : array(14, 10, 8, 12, 9, 6)) ?>;
    var katDueSoon = <?= json_encode(!empty($chartData['kat_due_soon']) ? $chartData['kat_due_soon'] : array(2, 1, 1, 1, 0, 1)) ?>;
    var katOverdue = <?= json_encode(!empty($chartData['kat_overdue']) ? $chartData['kat_overdue'] : array(1, 1, 0, 1, 1, 0)) ?>;

    var horizBarOptions = {
        series: [{
            name: 'In-Cal (Aktif)',
            data: katInCal
        }, {
            name: 'Due Soon',
            data: katDueSoon
        }, {
            name: 'Overdue',
            data: katOverdue
        }],
        chart: {
            type: 'bar',
            height: 250,
            stacked: true,
            toolbar: { show: false }
        },
        colors: ['#2ecc71', '#f1c40f', '#e74c3c'],
        plotOptions: {
            bar: {
                horizontal: true,
                barHeight: '55%',
                borderRadius: 4,
                dataLabels: {
                    total: {
                        enabled: true,
                        style: {
                            fontSize: '11px',
                            fontWeight: 700
                        }
                    }
                }
            }
        },
        dataLabels: {
            enabled: true,
            style: {
                fontSize: '10px',
                colors: ['#ffffff']
            }
        },
        xaxis: { categories: katCategories },
        legend: { position: 'bottom' },
        fill: { opacity: 1 }
    };
    var horizBarChart = new ApexCharts(document.querySelector("#breakdownJenisAlatChart"), horizBarOptions);
    horizBarChart.render();
});

function switchViewMode(mode) {
    var dashboardSec = document.getElementById('section-dashboard-view');
    var dataSec = document.getElementById('section-data-view');
    var btnDashboard = document.getElementById('btn-view-dashboard');
    var btnData = document.getElementById('btn-view-data');

    if (!dashboardSec || !dataSec) return;

    if (mode === 'data') {
        dashboardSec.style.display = 'none';
        dataSec.style.display = 'block';

        if (btnDashboard) btnDashboard.classList.remove('active');
        if (btnData) btnData.classList.add('active');

        setTimeout(function() {
            if (window.jQuery && $.fn && $.fn.DataTable && $.fn.DataTable.isDataTable('#tabelInstrumen')) {
                $('#tabelInstrumen').DataTable().columns.adjust();
            }
        }, 50);

        if (window.history && window.history.replaceState) {
            var url = new URL(window.location);
            url.searchParams.set('tab', 'data');
            window.history.replaceState({}, '', url);
        }
    } else {
        dataSec.style.display = 'none';
        dashboardSec.style.display = 'block';

        if (btnData) btnData.classList.remove('active');
        if (btnDashboard) btnDashboard.classList.add('active');

        if (window.history && window.history.replaceState) {
            var url = new URL(window.location);
            url.searchParams.set('tab', 'dashboard');
            window.history.replaceState({}, '', url);
        }
    }
}

(function() {
    function checkInitialTab() {
        var urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('tab') === 'data' || urlParams.get('view') === 'data') {
            switchViewMode('data');
        }
    }
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', checkInitialTab);
    } else {
        checkInitialTab();
    }
})();
</script>