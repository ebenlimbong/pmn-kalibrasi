<div class="d-flex justify-content-between align-items-center mb-4 mt-3">
    <h6 class="text-uppercase fw-bold text-secondary mb-0" style="letter-spacing: 0.5px;">EDIT INSTRUMEN</h6>
</div>

<div class="row">
    <div class="col-md-10 mx-auto">
        <form action="<?= base_url('kalibrasi/update/' . $instrumen->id) ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            
            <div class="card shadow-sm border-0 rounded-4 mb-4">
                <div class="card-header bg-white pt-4 pb-0 border-0">
                    <h5 class="text-dark fw-bold mb-0">Informasi Master Instrumen</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <!-- Row 1: Basic Info -->
                        <div class="col-md-4">
                            <label class="form-label text-dark fw-medium">Nama Instrumen <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nama_instrumen" required value="<?= esc($instrumen->nama_instrumen) ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-dark fw-medium">Seksi Pemakai</label>
                            <input type="text" class="form-control" name="seksi_pemakai" value="<?= esc($instrumen->seksi_pemakai ?? '') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-dark fw-medium">No. Identifikasi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nomor_identifikasi" required value="<?= esc($instrumen->nomor_identifikasi) ?>">
                        </div>
                        
                        <!-- Kategori Alat -->
                        <div class="col-12 mt-4">
                            <h6 class="fw-bold text-dark mb-2">Kategori</h6>
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
                            <div class="d-flex flex-wrap gap-2 mb-3" id="kategori-container">
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

                        <div class="col-12 mt-2">
                            <h6 class="fw-bold text-dark mb-0">Spesifikasi</h6>
                        </div>

                        <!-- Row 2: Spesifikasi -->
                        <?php
                            $known_units = ['°C', '°F', 'K', 'V', 'mV', 'A', 'mA', 'Ω', 'kΩ', 'MΩ', 'kg/cm²', 'Bar', 'Psi', 'Pa', 'kPa', 'MPa', 'mmHg', 'mL', 'L', 'µL', 'mm', 'cm', 'm', 'inch', '°', 'rad', 'Lux', 'Lumen', 'Cd', 'ppm', 'mg/m³', '%'];
                            
                            function parseMultiInput($data_str, $known_units) {
                                $items = array();
                                if (trim($data_str) !== '') {
                                    $raw_items = array_map('trim', explode(',', $data_str));
                                    foreach ($raw_items as $item) {
                                        $parts = explode(' ', $item);
                                        if (count($parts) > 1) {
                                            $sat = array_pop($parts);
                                            if (in_array($sat, $known_units)) {
                                                $val = implode(' ', $parts);
                                                $items[] = array('nilai' => $val, 'satuan' => $sat);
                                            } else {
                                                $items[] = array('nilai' => $item, 'satuan' => '');
                                            }
                                        } else {
                                            $items[] = array('nilai' => $item, 'satuan' => '');
                                        }
                                    }
                                }
                                if (empty($items)) {
                                    $items[] = array('nilai' => '', 'satuan' => '');
                                }
                                return $items;
                            }
                            
                            $interval_items = parseMultiInput($instrumen->interval_kapasitas ?? '', $known_units);
                            $ketelitian_items = parseMultiInput($instrumen->ketelitian ?? '', $known_units);
                            $batas_items = parseMultiInput($instrumen->batas_penerimaan ?? '', $known_units);

                            $interval_first = array_shift($interval_items);
                            if (!$interval_first) $interval_first = array('nilai' => '', 'satuan' => '');
                            
                            $ketelitian_first = array_shift($ketelitian_items);
                            if (!$ketelitian_first) $ketelitian_first = array('nilai' => '', 'satuan' => '');

                            $batas_first = array_shift($batas_items);
                            if (!$batas_first) $batas_first = array('nilai' => '', 'satuan' => '');
                        ?>
                        <div class="col-md-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label class="form-label text-dark fw-medium mb-0">Interval / Kapasitas</label>
                                <button type="button" class="btn btn-sm btn-primary text-white py-0 px-2 rounded-pill shadow-sm" style="font-size: 0.75rem;" id="add-interval">Tambah</button>
                            </div>
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" name="interval_nilai[]" id="interval-nilai-input" value="<?= esc($interval_first['nilai']) ?>" placeholder="1-10">
                                <select class="form-select unit-select interval-unit" name="interval_satuan[]" id="interval-satuan-input" data-selected="<?= esc($interval_first['satuan']) ?>" style="max-width: 80px; padding-left: 0.5rem; padding-right: 0.5rem;" disabled>
                                    <option value="">-</option>
                                </select>
                            </div>
                            <div id="interval-tags" class="d-flex flex-wrap gap-2">
                                <?php foreach ($interval_items as $item): ?>
                                    <?php if (trim($item['nilai']) !== ''): ?>
                                        <div class="badge bg-primary bg-opacity-10 text-primary border border-primary rounded-pill d-flex align-items-center px-3 py-2 fw-medium shadow-sm" style="font-size: 0.8rem;">
                                            <span><?= esc($item['nilai'] . ($item['satuan'] ? ' ' . $item['satuan'] : '')) ?></span>
                                            <input type="hidden" name="interval_nilai[]" value="<?= esc($item['nilai']) ?>">
                                            <input type="hidden" name="interval_satuan[]" value="<?= esc($item['satuan']) ?>">
                                            <span class="ms-2 text-danger cursor-pointer" style="cursor: pointer; font-weight: bold;" onclick="this.parentElement.remove();">&times;</span>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label class="form-label text-dark fw-medium mb-0">Ketelitian</label>
                                <button type="button" class="btn btn-sm btn-primary text-white py-0 px-2 rounded-pill shadow-sm" style="font-size: 0.75rem;" id="add-ketelitian">Tambah</button>
                            </div>
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" name="ketelitian_nilai[]" id="ketelitian-nilai-input" value="<?= esc($ketelitian_first['nilai']) ?>" placeholder="0.01">
                                <select class="form-select unit-select ketelitian-unit" name="ketelitian_satuan[]" id="ketelitian-satuan-input" data-selected="<?= esc($ketelitian_first['satuan']) ?>" style="max-width: 80px; padding-left: 0.5rem; padding-right: 0.5rem;" disabled>
                                    <option value="">-</option>
                                </select>
                            </div>
                            <div id="ketelitian-tags" class="d-flex flex-wrap gap-2">
                                <?php foreach ($ketelitian_items as $item): ?>
                                    <?php if (trim($item['nilai']) !== ''): ?>
                                        <div class="badge bg-primary bg-opacity-10 text-primary border border-primary rounded-pill d-flex align-items-center px-3 py-2 fw-medium shadow-sm" style="font-size: 0.8rem;">
                                            <span><?= esc($item['nilai'] . ($item['satuan'] ? ' ' . $item['satuan'] : '')) ?></span>
                                            <input type="hidden" name="ketelitian_nilai[]" value="<?= esc($item['nilai']) ?>">
                                            <input type="hidden" name="ketelitian_satuan[]" value="<?= esc($item['satuan']) ?>">
                                            <span class="ms-2 text-danger cursor-pointer" style="cursor: pointer; font-weight: bold;" onclick="this.parentElement.remove();">&times;</span>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-dark fw-medium">Model</label>
                            <input type="text" class="form-control" name="model_tipe" value="<?= esc($instrumen->model_tipe ?? '') ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-dark fw-medium">Pembuat</label>
                            <input type="text" class="form-control" name="pembuat" value="<?= esc($instrumen->pembuat ?? '') ?>">
                        </div>

                        <!-- Row 3: Kegunaan & Periode & Batas -->
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-medium">Kegunaan</label>
                            <input type="text" class="form-control" name="kegunaan" value="<?= esc($instrumen->kegunaan ?? '') ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-dark fw-medium">Periode <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="periode_kalibrasi" required value="<?= esc($instrumen->periode_kalibrasi) ?>">
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label class="form-label text-dark fw-medium mb-0">Batas Penerimaan</label>
                                <button type="button" class="btn btn-sm btn-primary text-white py-0 px-2 rounded-pill shadow-sm" style="font-size: 0.75rem;" id="add-batas">Tambah</button>
                            </div>
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" name="batas_nilai[]" id="batas-nilai-input" value="<?= esc($batas_first['nilai']) ?>" placeholder="0.05">
                                <select class="form-select unit-select" name="batas_satuan[]" id="batas-satuan-input" data-selected="<?= esc($batas_first['satuan']) ?>" style="max-width: 80px; padding-left: 0.5rem; padding-right: 0.5rem;" disabled>
                                    <option value="">-</option>
                                </select>
                            </div>
                            <div id="batas-tags" class="d-flex flex-wrap gap-2">
                                <?php foreach ($batas_items as $item): ?>
                                    <?php if (trim($item['nilai']) !== ''): ?>
                                        <div class="badge bg-primary bg-opacity-10 text-primary border border-primary rounded-pill d-flex align-items-center px-3 py-2 fw-medium shadow-sm" style="font-size: 0.8rem;">
                                            <span><?= esc($item['nilai'] . ($item['satuan'] ? ' ' . $item['satuan'] : '')) ?></span>
                                            <input type="hidden" name="batas_nilai[]" value="<?= esc($item['nilai']) ?>">
                                            <input type="hidden" name="batas_satuan[]" value="<?= esc($item['satuan']) ?>">
                                            <span class="ms-2 text-danger cursor-pointer" style="cursor: pointer; font-weight: bold;" onclick="this.parentElement.remove();">&times;</span>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label text-dark fw-medium">Keterangan</label>
                            <textarea class="form-control" name="keterangan" rows="2"><?= esc($instrumen->keterangan ?? '') ?></textarea>
                        </div>
                        
                        <div class="col-12">
                            <label class="form-label text-dark fw-medium">Foto Alat (Upload baru untuk mengganti)</label>
                            <?php if(!empty($instrumen->foto_alat)): ?>
                                <div class="mb-2">
                                    <a href="<?= base_url('uploads/instrumen/' . $instrumen->foto_alat) ?>" target="_blank" class="badge bg-info text-decoration-none">Lihat Foto Saat Ini</a>
                                </div>
                            <?php endif; ?>
                            <input type="file" class="form-control" name="foto_alat" accept="image/*">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0 rounded-4 mb-4">
                <div class="card-header bg-white pt-4 pb-0 border-0">
                    <h5 class="text-dark fw-bold mb-0">Data Kalibrasi Terakhir</h5>
                </div>
                <div class="card-body p-4">
                    <input type="hidden" name="riwayat_id" value="<?= esc($riwayat->id ?? '') ?>">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-medium">Tanggal Terakhir Kalibrasi</label>
                            <input type="date" class="form-control" name="tanggal_terakhir" value="<?= esc($riwayat->tanggal_terakhir ?? '') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-medium">Badan Kalibrasi</label>
                            <input type="text" class="form-control" name="badan_kalibrasi" value="<?= esc($riwayat->badan_kalibrasi ?? '') ?>">
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-medium">Nomor Sertifikat</label>
                            <input type="text" class="form-control" name="nomor_sertifikat" value="<?= esc($riwayat->nomor_sertifikat ?? '') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-medium">File Sertifikat (Upload baru untuk mengganti)</label>
                            <?php if(!empty($riwayat->file_sertifikat)): ?>
                                <div class="mb-2">
                                    <a href="<?= base_url('uploads/sertifikat/' . $riwayat->file_sertifikat) ?>" target="_blank" class="badge bg-info text-decoration-none">Lihat File Saat Ini</a>
                                </div>
                            <?php endif; ?>
                            <input type="file" class="form-control" name="file_sertifikat" accept=".pdf,image/*">
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end mb-5">
                <a href="<?= base_url('kalibrasi') ?>" class="btn btn-outline-dark px-4 me-2">Batal</a>
                <button type="submit" class="btn btn-primary px-5 fw-bold" style="background-color: #3b5998; border-color: #3b5998;">Simpan Perubahan</button>
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

    const firstIntervalSelect = document.querySelector('.interval-unit');
    const firstKetelitianSelect = document.querySelector('.ketelitian-unit');
    
    const intervalSelectedUnit = firstIntervalSelect ? firstIntervalSelect.getAttribute('data-selected') : '';
    const ketelitianSelectedUnit = firstKetelitianSelect ? firstKetelitianSelect.getAttribute('data-selected') : '';
    
    let activeKategori = null;
    let existingUnit = intervalSelectedUnit || ketelitianSelectedUnit;
    if (existingUnit) {
        for (const [kat, units] of Object.entries(unitMap)) {
            if (units.includes(existingUnit)) {
                activeKategori = kat;
                break;
            }
        }
    }

    function updateDropdowns(kategori) {
        const units = unitMap[kategori] || [];
        document.querySelectorAll('.unit-select').forEach(select => {
            const selectedUnit = select.getAttribute('data-selected');
            select.innerHTML = '<option value="">-</option>';
            units.forEach(unit => {
                const isSelected = (unit === selectedUnit) ? 'selected' : '';
                select.innerHTML += `<option value="${unit}" ${isSelected}>${unit}</option>`;
            });
            select.disabled = false;
        });
    }

    if (activeKategori) {
        const activeBtn = document.querySelector(`.kategori-btn[data-kategori="${activeKategori}"]`);
        if (activeBtn) {
            activeBtn.classList.add('active-kategori');
            updateDropdowns(activeKategori);
        }
    }

    document.querySelectorAll('.kategori-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.kategori-btn').forEach(b => {
                b.classList.remove('active-kategori');
            });
            this.classList.add('active-kategori');

            const kategori = this.getAttribute('data-kategori');
            const units = unitMap[kategori] || [];
            
            document.querySelectorAll('.unit-select').forEach(select => {
                const currentVal = select.value || select.getAttribute('data-selected');
                select.setAttribute('data-selected', (currentVal && units.includes(currentVal)) ? currentVal : '');
            });
            
            updateDropdowns(kategori);
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
            
            const removeBtn = document.createElement('span');
            removeBtn.innerHTML = '&times;';
            removeBtn.className = 'ms-2 text-danger cursor-pointer';
            removeBtn.style.cursor = 'pointer';
            removeBtn.style.fontWeight = 'bold';
            removeBtn.onclick = function() { tag.remove(); };
            tag.appendChild(removeBtn);
            
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
            
            const removeBtn = document.createElement('span');
            removeBtn.innerHTML = '&times;';
            removeBtn.className = 'ms-2 text-danger cursor-pointer';
            removeBtn.style.cursor = 'pointer';
            removeBtn.style.fontWeight = 'bold';
            removeBtn.onclick = function() { tag.remove(); };
            tag.appendChild(removeBtn);
            
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
            
            const removeBtn = document.createElement('span');
            removeBtn.innerHTML = '&times;';
            removeBtn.className = 'ms-2 text-danger';
            removeBtn.style.cursor = 'pointer';
            removeBtn.style.fontWeight = 'bold';
            removeBtn.onclick = function() { tag.remove(); };
            tag.appendChild(removeBtn);
            
            container.appendChild(tag);
            valInput.value = '';
        }
    });
});
</script>
