<div class="d-flex justify-content-between align-items-center mb-4 mt-3">
    <h6 class="text-uppercase fw-bold text-secondary mb-0" style="letter-spacing: 0.5px;">TAMBAH INSTRUMEN STANDAR KERJA</h6>
</div>

<div class="row">
    <div class="col-md-10 mx-auto">
        <form action="<?= base_url('kalibrasi-internal/store') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            
            <div class="card shadow-sm border-0 rounded-4 mb-4">
                <div class="card-header bg-white pt-4 pb-0 border-0">
                    <h5 class="text-dark fw-bold mb-0">Informasi Master Instrumen Standar Kerja</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <!-- Row 1: Basic Info -->
                        <div class="col-md-4">
                            <label class="form-label text-dark fw-medium">Nama Instrumen <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nama_instrumen" required placeholder="Micrometer Screw">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-dark fw-medium">Seksi Pemakai</label>
                            <input type="text" class="form-control" name="seksi_pemakai" placeholder="Bengkel">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-dark fw-medium">No. Identifikasi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nomor_identifikasi" required placeholder="INS-INT-001">
                        </div>
                        
                        <!-- Kategori (Main Header) -->
                        <div class="col-12 mt-4">
                            <h6 class="fw-bold text-dark mb-3" style="border-bottom: 2px solid #edf2f9; padding-bottom: 8px;">Kategori</h6>
                            <div class="row align-items-start g-3">
                                <!-- Sub Kategori: Satuan (Kiri) -->
                                <div class="col-12 col-lg-7">
                                    <label class="form-label text-muted fw-bold text-uppercase mb-2" style="font-size: 0.78rem; letter-spacing: 0.5px;">Satuan</label>
                                    <style>
                                        .kategori-btn {
                                            color: #495057;
                                            border: 1px solid #ced4da;
                                            background-color: transparent;
                                            font-size: 0.85rem;
                                        }
                                        .kategori-btn:hover {
                                            background-color: #f8f9fa;
                                            color: #212529;
                                        }
                                        .kategori-btn.active-kategori {
                                            background-color: #2c3e50;
                                            border-color: #2c3e50;
                                            color: #ffffff !important;
                                        }
                                    </style>
                                    <div class="d-flex flex-wrap gap-2 mb-2" id="kategori-container">
                                        <button type="button" class="btn rounded-pill kategori-btn fw-medium px-3 py-1" style="font-size: 0.8rem;" data-kategori="suhu">Suhu</button>
                                        <button type="button" class="btn rounded-pill kategori-btn fw-medium px-3 py-1" style="font-size: 0.8rem;" data-kategori="kelistrikan">Kelistrikan</button>
                                        <button type="button" class="btn rounded-pill kategori-btn fw-medium px-3 py-1" style="font-size: 0.8rem;" data-kategori="tekanan">Tekanan</button>
                                        <button type="button" class="btn rounded-pill kategori-btn fw-medium px-3 py-1" style="font-size: 0.8rem;" data-kategori="volume">Volume</button>
                                        <button type="button" class="btn rounded-pill kategori-btn fw-medium px-3 py-1" style="font-size: 0.8rem;" data-kategori="sudut">Sudut & Kemiringan</button>
                                        <button type="button" class="btn rounded-pill kategori-btn fw-medium px-3 py-1" style="font-size: 0.8rem;" data-kategori="cahaya">Cahaya</button>
                                        <button type="button" class="btn rounded-pill kategori-btn fw-medium px-3 py-1" style="font-size: 0.8rem;" data-kategori="gas">Gas & Lingkungan</button>
                                        <button type="button" class="btn rounded-pill kategori-btn fw-medium px-3 py-1" style="font-size: 0.8rem;" data-kategori="dimensi">Dimensi</button>
                                    </div>
                                </div>

                                <!-- Sub Kategori: Alat (Disamping Kiri) -->
                                <div class="col-12 col-lg-5">
                                    <label class="form-label text-muted fw-bold text-uppercase mb-2" style="font-size: 0.78rem; letter-spacing: 0.5px;">Alat</label>
                                    <select class="form-select border shadow-sm" name="kategori_alat" style="max-height: 140px; overflow-y: auto;">
                                        <option value="">-- Pilih Kategori Alat --</option>
                                        <option value="Pressure Gauge">Pressure Gauge</option>
                                        <option value="Pressure Switch">Pressure Switch</option>
                                        <option value="RTD (Resistance Temperature Detector)">RTD (Resistance Temperature Detector)</option>
                                        <option value="Measurement Voltage">Measurement Voltage</option>
                                        <option value="Measurement Current">Measurement Current</option>
                                        <option value="Measurement Resistance">Measurement Resistance</option>
                                        <option value="Multimeter">Multimeter</option>
                                        <option value="Transducer / Transmitter">Transducer / Transmitter</option>
                                        <option value="Thermometer">Thermometer</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mt-2">
                            <h6 class="fw-bold text-dark mb-0">Spesifikasi</h6>
                        </div>

                        <!-- Row 2: Spesifikasi -->
                        <div class="col-md-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label class="form-label text-dark fw-medium mb-0">Interval / Kapasitas</label>
                                <button type="button" class="btn btn-sm btn-primary text-white py-0 px-2 rounded-pill shadow-sm" style="font-size: 0.75rem;" id="add-interval">Tambah</button>
                            </div>
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" name="interval_nilai[]" id="interval-nilai-input" placeholder="0-25">
                                <select class="form-select unit-select" name="interval_satuan[]" id="interval-satuan-input" style="max-width: 80px; padding-left: 0.5rem; padding-right: 0.5rem;" disabled>
                                    <option value="">-</option>
                                </select>
                            </div>
                            <div id="interval-tags" class="d-flex flex-wrap gap-2"></div>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label class="form-label text-dark fw-medium mb-0">Ketelitian</label>
                                <button type="button" class="btn btn-sm btn-primary text-white py-0 px-2 rounded-pill shadow-sm" style="font-size: 0.75rem;" id="add-ketelitian">Tambah</button>
                            </div>
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" name="ketelitian_nilai[]" id="ketelitian-nilai-input" placeholder="0.001">
                                <select class="form-select unit-select" name="ketelitian_satuan[]" id="ketelitian-satuan-input" style="max-width: 80px; padding-left: 0.5rem; padding-right: 0.5rem;" disabled>
                                    <option value="">-</option>
                                </select>
                            </div>
                            <div id="ketelitian-tags" class="d-flex flex-wrap gap-2"></div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-dark fw-medium">Model</label>
                            <input type="text" class="form-control" name="model_tipe" placeholder="103-137">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-dark fw-medium">Pembuat</label>
                            <input type="text" class="form-control" name="pembuat" placeholder="Mitutoyo">
                        </div>

                        <!-- Row 3: Kegunaan & Periode & Tanggal Pertama Digunakan & Batas -->
                        <div class="col-md-3">
                            <label class="form-label text-dark fw-medium">Kegunaan</label>
                            <input type="text" class="form-control" name="kegunaan" placeholder="Pengukuran ketebalan plat">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-dark fw-medium">Periode <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="periode_kalibrasi" required placeholder="1">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-dark fw-medium">Tanggal Pertama Digunakan</label>
                            <input type="date" class="form-control" name="tanggal_mulai_digunakan">
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label class="form-label text-dark fw-medium mb-0">Batas Penerimaan</label>
                                <button type="button" class="btn btn-sm btn-primary text-white py-0 px-2 rounded-pill shadow-sm" style="font-size: 0.75rem;" id="add-batas">Tambah</button>
                            </div>
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" name="batas_nilai[]" id="batas-nilai-input" placeholder="0.003">
                                <select class="form-select unit-select" name="batas_satuan[]" id="batas-satuan-input" style="max-width: 80px; padding-left: 0.5rem; padding-right: 0.5rem;" disabled>
                                    <option value="">-</option>
                                </select>
                            </div>
                            <div id="batas-tags" class="d-flex flex-wrap gap-2"></div>
                        </div>

                        <div class="col-12">
                            <label class="form-label text-dark fw-medium">Keterangan</label>
                            <textarea class="form-control" name="keterangan" rows="2" placeholder="Catatan tambahan..."></textarea>
                        </div>
                        
                        <div class="col-12">
                            <label class="form-label text-dark fw-medium">Foto Alat</label>
                            <input type="file" class="form-control" name="foto_alat" accept="image/*">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0 rounded-4 mb-4">
                <div class="card-header bg-white pt-4 pb-0 border-0">
                    <h5 class="text-dark fw-bold mb-0">Data Kalibrasi Awal (Opsional)</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-medium">Tanggal Kalibrasi</label>
                            <input type="date" class="form-control" name="tanggal_terakhir">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-medium">Lampiran / File Sertifikat (PDF/Image)</label>
                            <input type="file" class="form-control" name="file_sertifikat" accept=".pdf,image/*">
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end mb-5">
                <a href="<?= base_url('kalibrasi-internal') ?>" class="btn btn-outline-dark px-4 me-2">Batal</a>
                <button type="submit" class="btn btn-primary px-5 fw-bold" style="background-color: #3b5998; border-color: #3b5998;">Simpan Data</button>
            </div>
            
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const unitMap = {
        'suhu': ['°C', '°F', 'K'],
        'kelistrikan': ['V', 'mV', 'A', 'mA', 'Ω', 'kΩ', 'MΩ'],
        'tekanan': ['kg/cm²', 'Bar', 'Psi', 'Pa', 'kPa', 'MPa', 'mmHg'],
        'volume': ['mL', 'L', 'µL'],
        'dimensi': ['mm', 'cm', 'm', 'inch'],
        'sudut': ['°', 'rad'],
        'cahaya': ['Lux', 'Lumen', 'Cd'],
        'gas': ['ppm', 'mg/m³', '%']
    };

    document.querySelectorAll('.kategori-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.kategori-btn').forEach(b => {
                b.classList.remove('active-kategori');
            });
            this.classList.add('active-kategori');

            const kategori = this.getAttribute('data-kategori');
            const units = unitMap[kategori];

            let optionsHtml = '<option value="">-</option>';
            units.forEach(unit => {
                optionsHtml += `<option value="${unit}">${unit}</option>`;
            });

            document.querySelectorAll('.unit-select').forEach(select => {
                const currentVal = select.value;
                select.innerHTML = optionsHtml;
                select.removeAttribute('disabled');
                if (currentVal && units.includes(currentVal)) {
                    select.value = currentVal;
                }
            });
        });
    });

    document.getElementById('add-interval').addEventListener('click', function() {
        const valInput = document.getElementById('interval-nilai-input');
        const satInput = document.getElementById('interval-satuan-input');
        
        const val = valInput.value.trim();
        const sat = satInput.value;
        
        if (val !== '') {
            const container = document.getElementById('interval-tags');
            
            const tag = document.createElement('div');
            tag.className = 'badge bg-primary bg-opacity-10 text-primary border border-primary rounded-pill d-flex align-items-center px-3 py-2 fw-medium shadow-sm';
            tag.style.fontSize = '0.8rem';
            
            const textSpan = document.createElement('span');
            textSpan.textContent = val + (sat ? ' ' + sat : '');
            tag.appendChild(textSpan);
            
            const hiddenVal = document.createElement('input');
            hiddenVal.type = 'hidden';
            hiddenVal.name = 'interval_nilai[]';
            hiddenVal.value = val;
            tag.appendChild(hiddenVal);
            
            const hiddenSat = document.createElement('input');
            hiddenSat.type = 'hidden';
            hiddenSat.name = 'interval_satuan[]';
            hiddenSat.value = sat;
            tag.appendChild(hiddenSat);
            
            const closeBtn = document.createElement('button');
            closeBtn.type = 'button';
            closeBtn.className = 'btn-close ms-2';
            closeBtn.style.fontSize = '0.65rem';
            closeBtn.addEventListener('click', function() {
                tag.remove();
            });
            tag.appendChild(closeBtn);
            
            container.appendChild(tag);
            valInput.value = '';
        }
    });

    document.getElementById('add-ketelitian').addEventListener('click', function() {
        const valInput = document.getElementById('ketelitian-nilai-input');
        const satInput = document.getElementById('ketelitian-satuan-input');
        
        const val = valInput.value.trim();
        const sat = satInput.value;
        
        if (val !== '') {
            const container = document.getElementById('ketelitian-tags');
            
            const tag = document.createElement('div');
            tag.className = 'badge bg-primary bg-opacity-10 text-primary border border-primary rounded-pill d-flex align-items-center px-3 py-2 fw-medium shadow-sm';
            tag.style.fontSize = '0.8rem';
            
            const textSpan = document.createElement('span');
            textSpan.textContent = val + (sat ? ' ' + sat : '');
            tag.appendChild(textSpan);
            
            const hiddenVal = document.createElement('input');
            hiddenVal.type = 'hidden';
            hiddenVal.name = 'ketelitian_nilai[]';
            hiddenVal.value = val;
            tag.appendChild(hiddenVal);
            
            const hiddenSat = document.createElement('input');
            hiddenSat.type = 'hidden';
            hiddenSat.name = 'ketelitian_satuan[]';
            hiddenSat.value = sat;
            tag.appendChild(hiddenSat);
            
            const closeBtn = document.createElement('button');
            closeBtn.type = 'button';
            closeBtn.className = 'btn-close ms-2';
            closeBtn.style.fontSize = '0.65rem';
            closeBtn.addEventListener('click', function() {
                tag.remove();
            });
            tag.appendChild(closeBtn);
            
            container.appendChild(tag);
            valInput.value = '';
        }
    });

    document.getElementById('add-batas').addEventListener('click', function() {
        const valInput = document.getElementById('batas-nilai-input');
        const satInput = document.getElementById('batas-satuan-input');
        
        const val = valInput.value.trim();
        const sat = satInput.value;
        
        if (val !== '') {
            const container = document.getElementById('batas-tags');
            
            const tag = document.createElement('div');
            tag.className = 'badge bg-primary bg-opacity-10 text-primary border border-primary rounded-pill d-flex align-items-center px-3 py-2 fw-medium shadow-sm';
            tag.style.fontSize = '0.8rem';
            
            const textSpan = document.createElement('span');
            textSpan.textContent = val + (sat ? ' ' + sat : '');
            tag.appendChild(textSpan);
            
            const hiddenVal = document.createElement('input');
            hiddenVal.type = 'hidden';
            hiddenVal.name = 'batas_nilai[]';
            hiddenVal.value = val;
            tag.appendChild(hiddenVal);
            
            const hiddenSat = document.createElement('input');
            hiddenSat.type = 'hidden';
            hiddenSat.name = 'batas_satuan[]';
            hiddenSat.value = sat;
            tag.appendChild(hiddenSat);
            
            const closeBtn = document.createElement('button');
            closeBtn.type = 'button';
            closeBtn.className = 'btn-close ms-2';
            closeBtn.style.fontSize = '0.65rem';
            closeBtn.addEventListener('click', function() {
                tag.remove();
            });
            tag.appendChild(closeBtn);
            
            container.appendChild(tag);
            valInput.value = '';
        }
    });
});
</script>

