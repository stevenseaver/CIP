<!-- Begin Page Content -->
<style>
    /* ── Design Tokens ── */
    :root {
        --brand:        #1a56a0;
        --brand-dark:   #103d7a;
        --brand-light:  #e8f0fb;
        --accent:       #e67e22;
        --success:      #1a7a4a;
        --danger:       #c0392b;
        --surface:      #f5f7fa;
        --card-bg:      #ffffff;
        --border:       #d0d8e4;
        --text-main:    #1a202c;
        --text-muted:   #5a6a7e;
        --radius:       14px;
        --radius-sm:    8px;
        --shadow:       0 2px 12px rgba(26,86,160,0.08);
        --shadow-lg:    0 4px 24px rgba(26,86,160,0.14);
    }

    body { background: var(--surface); color: var(--text-main); }

    /* ── Page Title ── */
    .page-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--brand);
        letter-spacing: -0.3px;
        margin-bottom: 0;
    }
    .page-subtitle {
        font-size: 0.95rem;
        color: var(--text-muted);
    }

    /* ── Nav / back bar ── */
    .top-bar { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; margin-bottom: 1.5rem; }

    .btn-back {
        display: inline-flex; align-items: center; gap: 8px;
        background: #fff; border: 2px solid var(--border);
        border-radius: var(--radius-sm); padding: 10px 20px;
        font-size: 1rem; font-weight: 600; color: var(--text-main);
        text-decoration: none; transition: all .18s;
    }
    .btn-back:hover { border-color: var(--brand); color: var(--brand); text-decoration: none; }

    .btn-add-item-modal {
        display: inline-flex; align-items: center; gap: 8px;
        background: var(--brand); border: none;
        border-radius: var(--radius-sm); padding: 10px 22px;
        font-size: 1rem; font-weight: 700; color: #fff;
        cursor: pointer; transition: background .18s;
        text-decoration: none;
    }
    .btn-add-item-modal:hover { background: var(--brand-dark); color: #fff; text-decoration: none; }

    /* ── Section Cards ── */
    .section-card {
        background: var(--card-bg);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        border: 1.5px solid var(--border);
        margin-bottom: 1.5rem;
        overflow: hidden;
    }
    .section-card-header {
        background: var(--brand-light);
        border-bottom: 1.5px solid var(--border);
        padding: 14px 22px;
        display: flex; align-items: center; gap: 10px;
    }
    .section-card-header .icon {
        width: 34px; height: 34px; background: var(--brand);
        border-radius: 8px; display: flex; align-items: center; justify-content: center;
    }
    .section-card-header .icon i { color: #fff; font-size: 1rem; }
    .section-card-header h6 {
        margin: 0; font-weight: 700; font-size: 1.05rem; color: var(--brand-dark);
    }
    .section-card-body { padding: 20px 22px; }

    /* ── Labels ── */
    .field-label {
        font-size: 0.82rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        color: var(--text-muted);
        margin-bottom: 6px;
        display: block;
    }

    /* ── Inputs ── */
    .form-control {
        height: 52px !important;
        font-size: 1.1rem !important;
        font-weight: 500;
        border: 2px solid var(--border);
        border-radius: var(--radius-sm) !important;
        padding: 10px 14px !important;
        transition: border-color .18s, box-shadow .18s;
    }
    .form-control:focus {
        border-color: var(--brand) !important;
        box-shadow: 0 0 0 3px rgba(26,86,160,0.15) !important;
    }
    .form-control[readonly] {
        background: #f0f4fa !important;
        color: var(--text-muted);
    }
    .input-group-text {
        height: 52px !important;
        font-size: 1rem;
        font-weight: 700;
        background: #eef2f8;
        border: 2px solid var(--border);
        color: var(--brand-dark);
    }
    .input-group > .form-control { z-index: 0; }

    /* ── Scan Buttons ── */
    .btn-scan {
        height: 52px !important;
        min-width: 60px;
        font-size: 1.15rem;
        background: var(--brand);
        color: #fff;
        border: 2px solid var(--brand);
        border-radius: 0 var(--radius-sm) var(--radius-sm) 0 !important;
        display: flex; align-items: center; justify-content: center; gap: 6px;
        font-weight: 700;
        transition: background .18s;
        padding: 0 16px;
    }
    .btn-scan:hover { background: var(--brand-dark); color: #fff; }

    /* ── Weight Cards (big number inputs) ── */
    .weight-card {
        background: var(--card-bg);
        border: 2px solid var(--border);
        border-radius: var(--radius);
        padding: 18px;
        text-align: center;
        height: 100%;
        transition: border-color .18s;
    }
    .weight-card.primary { border-color: var(--brand); background: var(--brand-light); }
    .weight-card .wc-label {
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        color: var(--text-muted);
        margin-bottom: 10px;
    }
    .weight-card.primary .wc-label { color: var(--brand); }
    .weight-card input.wc-input {
        height: 64px !important;
        font-size: 1.6rem !important;
        font-weight: 800 !important;
        text-align: center;
        border: 2px solid var(--border);
        border-radius: var(--radius-sm) !important;
        background: #fff;
        color: var(--text-main);
        width: 100%;
    }
    .weight-card.primary input.wc-input {
        border-color: var(--brand);
        color: var(--brand);
        background: #fff;
    }
    .weight-card .wc-unit {
        font-size: 0.9rem;
        font-weight: 700;
        color: var(--text-muted);
        margin-top: 6px;
    }
    .weight-card.primary .wc-unit { color: var(--brand); }

    /* ── Submit Button ── */
    .btn-submit {
        background: var(--accent);
        border: none;
        border-radius: var(--radius);
        padding: 18px 48px;
        font-size: 1.25rem;
        font-weight: 800;
        color: #fff;
        letter-spacing: 0.2px;
        box-shadow: 0 4px 16px rgba(230,126,34,0.35);
        transition: all .18s;
        display: inline-flex; align-items: center; gap: 10px;
        cursor: pointer;
        min-width: 240px;
        justify-content: center;
    }
    .btn-submit:hover:not(:disabled) { background: #cf6d17; transform: translateY(-1px); box-shadow: 0 6px 20px rgba(230,126,34,0.4); }
    .btn-submit:disabled { background: #ccc; box-shadow: none; cursor: not-allowed; }
    .btn-submit i { font-size: 1.3rem; }

    /* ── Alerts ── */
    #po-alert, #roll-alert {
        border-radius: var(--radius-sm);
        font-size: 1rem;
        font-weight: 600;
        padding: 14px 18px;
    }

    /* ── Info pill (readonly field display) ── */
    .info-pill {
        background: #eef2f8;
        border: 1.5px solid var(--border);
        border-radius: var(--radius-sm);
        padding: 10px 16px;
        font-size: 1.05rem;
        font-weight: 600;
        color: var(--text-main);
        min-height: 52px;
        display: flex; align-items: center;
    }
    .info-pill.empty { color: var(--text-muted); font-style: italic; font-weight: 400; }

    /* ── Scanner container ── */
    .scanner-box {
        border: 2px dashed var(--brand);
        border-radius: var(--radius);
        padding: 12px;
        background: var(--brand-light);
        margin-top: 10px;
    }
    .btn-stop-scan {
        width: 100%;
        margin-top: 8px;
        height: 46px;
        font-size: 1rem;
        font-weight: 700;
        border-radius: var(--radius-sm);
        background: var(--danger);
        color: #fff;
        border: none;
        display: flex; align-items: center; justify-content: center; gap: 8px;
    }

    /* ── Table ── */
    .table-card {
        background: var(--card-bg);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        border: 1.5px solid var(--border);
        overflow: hidden;
    }
    .table-card-header {
        background: var(--brand);
        padding: 14px 22px;
        display: flex; align-items: center; gap: 10px;
    }
    .table-card-header h6 { margin: 0; color: #fff; font-size: 1.05rem; font-weight: 700; }

    #table1 thead th {
        background: var(--brand-dark);
        color: #fff;
        font-size: 0.82rem;
        font-weight: 700;
        letter-spacing: 0.4px;
        text-transform: uppercase;
        border: none;
        padding: 12px 10px;
        white-space: nowrap;
    }
    #table1 tbody tr { transition: background .15s; }
    #table1 tbody tr:hover { background: var(--brand-light); }
    #table1 tbody td { vertical-align: middle; font-size: 0.95rem; padding: 10px; border-color: var(--border); }
    #table1 tfoot td { font-size: 0.95rem; padding: 10px; background: #f8faff; border-top: 2px solid var(--border); }

    /* inline editable cells */
    .roll-qty, .roll-price, .roll-batch, .roll-desc {
        height: 42px !important;
        font-size: 0.95rem !important;
        min-width: 90px;
        border: 1.5px solid var(--border);
        border-radius: 6px !important;
    }

    .badge-primary { background: var(--brand); font-size: 0.82rem; padding: 5px 10px; border-radius: 6px; }
    .badge-danger  { background: var(--danger);  font-size: 0.82rem; padding: 5px 10px; border-radius: 6px; }
    .clickable { cursor: pointer; }

    /* ── Modal ── */
    .modal-header { background: var(--brand); border-radius: var(--radius) var(--radius) 0 0; }
    .modal-title { color: #fff; font-weight: 700; }
    .modal-header .close { color: #fff; opacity: 1; font-size: 1.5rem; }
    .modal-content { border-radius: var(--radius); border: none; box-shadow: var(--shadow-lg); }
    .modal-footer .btn { height: 48px; font-size: 1rem; font-weight: 700; border-radius: var(--radius-sm); padding: 0 28px; }

    /* ── Responsive ── */
    @media (max-width: 768px) {
        .section-card-body { padding: 14px; }
        .btn-submit { width: 100%; }
        .wc-input { font-size: 1.3rem !important; }
    }
</style>

<div class="container-fluid pb-5">

    <!-- ── Page Header ── -->
    <div class="d-flex align-items-center justify-content-between flex-wrap mb-3 pt-2">
        <div>
            <div class="page-title">Input Roll Produksi</div>
            <div class="page-subtitle">Catat hasil produksi roll baru</div>
        </div>
    </div>

    <!-- ── Flash / Alert messages ── -->
    <div class="row">
        <div class="col-12">
            <?= $this->session->flashdata('message'); ?>
            <div id="po-alert" class="d-none mb-2"></div>
            <div id="roll-alert" class="d-none mb-2"></div>
        </div>
    </div>

    <!-- ── Top Action Bar ── -->
    <div class="top-bar">
        <?php $periode = getPeriodeByDate($getID['date']); ?>
        <a href="<?= base_url('production/inputRoll/index?' . http_build_query(['start_date' => $periode['start_date'], 'end_date' => $periode['end_date'], 'name' => $periode['id']])) ?>" class="btn-back">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
        <a href="" class="btn-add-item-modal" data-toggle="modal" data-target="#newItem">
            <i class="bi bi-plus-lg"></i> Pilih Roll Manual
        </a>
    </div>

    <!-- ══════════════════════════════════════════
         MAIN INPUT FORM
    ══════════════════════════════════════════ -->
    <form action="<?= base_url('production/add_roll_general') ?>" method="post" id="main-roll-form">

        <!-- ── Section 1: Order & Tanggal ── -->
        <div class="section-card">
            <div class="section-card-header">
                <div class="icon"><i class="fas fa-clipboard-list"></i></div>
                <h6>1 &nbsp;·&nbsp; Order Produksi &amp; Tanggal</h6>
            </div>
            <div class="section-card-body">
                <div class="row">
                    <!-- PO ID -->
                    <div class="col-lg-9 col-md-7 mb-3">
                        <label class="field-label" for="po_id">ID Order Produksi</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="po_id" name="po_id"
                                   readonly placeholder="Scan atau ketuk tombol Scan →"
                                   value="<?= isset($last_po_id) ? $last_po_id : '' ?>">
                            <div class="input-group-append">
                                <button class="btn-scan" type="button" id="btn-scan">
                                    <i class="fa fa-qrcode"></i> Scan
                                </button>
                            </div>
                        </div>
                        <?= form_error('po_id', '<small class="text-danger d-block mt-1 font-weight-bold"><i class="fas fa-exclamation-circle mr-1"></i>', '</small>') ?>
                        <!-- PO Scanner -->
                        <div id="qr-scanner-container" class="scanner-box" style="display:none; max-width:25rem;">
                            <div id="qr-reader" style="width:100%;"></div>
                            <button class="btn-stop-scan" type="button" id="btn-stop-scan">
                                <i class="fa fa-times"></i> Tutup Scanner
                            </button>
                        </div>
                    </div>

                    <!-- Date -->
                    <div class="col-lg-3 col-md-5 mb-3">
                        <label class="field-label" for="report_date">Tanggal Produksi</label>
                        <input type="datetime-local" class="form-control" id="report_date" name="report_date"
                               value="<?= set_value('tanggal', date('Y-m-d H:i:s')) ?>">
                        <?= form_error('report_date', '<small class="text-danger d-block mt-1 font-weight-bold"><i class="fas fa-exclamation-circle mr-1"></i>', '</small>') ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- ── Section 2: Item Roll ── -->
        <div class="section-card">
            <div class="section-card-header">
                <div class="icon"><i class="fas fa-scroll"></i></div>
                <h6>2 &nbsp;·&nbsp; Item Roll</h6>
            </div>
            <div class="section-card-body">
                <div class="row align-items-end">
                    <!-- Roll Name (readonly, filled by scan/modal) -->
                    <div class="col-lg-3 col-md-6 mb-3">
                        <label class="field-label" for="rollName">Nama Roll</label>
                        <input type="text" class="form-control" id="rollName" name="rollName" readonly
                               placeholder="Scan kode atau pilih manual"
                               value="<?= isset($lastRoll['name']) ? $lastRoll['name'] : set_value('rollName'); ?>">
                        <?= form_error('rollName', '<small class="text-danger d-block mt-1 font-weight-bold"><i class="fas fa-exclamation-circle mr-1"></i>', '</small>') ?>
                    </div>

                    <!-- Code + Scan Roll -->
                    <div class="col-lg-3 col-md-6 mb-3">
                        <label class="field-label" for="code">Kode Roll</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="code" name="code" readonly
                                   placeholder="—"
                                   value="<?= isset($lastRoll['code']) ? $lastRoll['code'] : set_value('code'); ?>">
                            <div class="input-group-append">
                                <button class="btn-scan" type="button" id="btn-scan-roll">
                                    <i class="fa fa-qrcode"></i>
                                </button>
                            </div>
                        </div>
                        <?= form_error('code', '<small class="text-danger d-block mt-1 font-weight-bold"><i class="fas fa-exclamation-circle mr-1"></i>', '</small>') ?>
                        <!-- Roll Scanner -->
                        <div id="qr-roll-scanner-container" class="scanner-box" style="display:none; max-width:25rem;">
                            <div id="qr-roll-reader" style="width:100%;"></div>
                            <button class="btn-stop-scan" type="button" id="btn-stop-scan-roll">
                                <i class="fa fa-times"></i> Tutup Scanner
                            </button>
                        </div>
                    </div>

                    <!-- Gramatur -->
                    <div class="col-lg-2 col-sm-4 mb-3">
                        <label class="field-label" for="weight">Gramatur</label>
                        <input type="text" class="form-control" id="weight" name="weight" readonly placeholder="—" value="<?= isset($lastRoll['weight']) ? $lastRoll['weight'] : set_value('weight'); ?>">
                    </div>

                    <!-- Lipatan -->
                    <div class="col-lg-2 col-sm-4 mb-3">
                        <label class="field-label" for="lipatan">Lipatan</label>
                        <input type="text" class="form-control" id="lipatan" name="lipatan" readonly placeholder="—" value="<?= isset($lastRoll['lipatan']) ? $lastRoll['lipatan'] : set_value('lipatan'); ?>">
                    </div>

                    <!-- Price -->
                    <div class="col-lg-2 col-sm-4 mb-3">
                        <label class="field-label" for="price_roll">Harga</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" style="border-radius: var(--radius-sm) 0 0 var(--radius-sm);">Rp</span>
                            </div>
                            <input type="text" class="form-control" id="price_roll" name="price_roll" placeholder="—" value="<?= isset($lastRoll['price']) ? $lastRoll['price'] : set_value('price'); ?>">
                        </div>
                        <small class="text-muted">Isi dengan harga HPP di form produksi!</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- ── Section 3: Berat ── -->
        <div class="section-card">
            <div class="section-card-header">
                <div class="icon"><i class="fas fa-weight-hanging"></i></div>
                <h6>3 &nbsp;·&nbsp; Berat Roll</h6>
            </div>
            <div class="section-card-body">
                <div class="row mb-3">
                    <!-- Gross weight -->
                    <div class="col-lg-4 col-md-4 col-6 mb-3">
                        <div class="weight-card">
                            <div class="wc-label">Berat Total (Kotor)</div>
                            <input type="number" step=".01" class="form-control wc-input" id="gross" name="gross"
                                   value="<?= set_value('gross'); ?>" placeholder="0.00"
                                   onchange="calculate()" inputmode="decimal">
                            <div class="wc-unit">kilogram (kg)</div>
                            <?= form_error('gross', '<small class="text-danger d-block mt-1 font-weight-bold">', '</small>') ?>
                        </div>
                    </div>

                    <!-- Bobin weight -->
                    <div class="col-lg-4 col-md-4 col-6 mb-3">
                        <div class="weight-card">
                            <div class="wc-label">Berat Bobin</div>
                            <input type="number" step="1" class="form-control wc-input" id="bobin" name="bobin"
                                   value="<?= set_value('bobin'); ?>" placeholder="0"
                                   onchange="calculate()" inputmode="numeric">
                            <div class="wc-unit">gram (g)</div>
                            <?= form_error('bobin', '<small class="text-danger d-block mt-1 font-weight-bold">', '</small>') ?>
                        </div>
                    </div>

                    <!-- Net weight (result) -->
                    <div class="col-lg-4 col-md-4 col-12 mb-3">
                        <div class="weight-card primary">
                            <div class="wc-label">✔ Berat Neto (Hasil)</div>
                            <input type="number" step=".01" class="form-control wc-input" id="amount" name="amount"
                                   value="<?= set_value('amount'); ?>" placeholder="0.00" readonly inputmode="decimal">
                            <div class="wc-unit">kilogram (kg)</div>
                            <?= form_error('amount', '<small class="text-danger d-block mt-1 font-weight-bold">', '</small>') ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <?php 
                        if($lastRoll['batch']){
                            $parts    = explode('-', $lastRoll['batch'], 4);
    
                            $batch    = $parts[0] ?? '';
                            $machine  = $parts[1] ?? '';
                            $shift    = $parts[2] ?? '';
                            $operator = $parts[3] ?? '';
                        } else {
                            $batch    = $getID['description'];
                            $machine  = '';
                            $shift    = '';
                            $operator = '';
                        }
                    ?>
                    <!-- Keterangan / Batch -->
                    <div class="col-lg-3 col-md-6 mb-3">
                        <label class="field-label" for="batch">Kode Partai</label>
                        <input type="text" class="form-control" id="batch" name="batch"
                               value="<?= $batch ?>">
                        <?= form_error('batch', '<small class="text-danger d-block mt-1 font-weight-bold"><i class="fas fa-exclamation-circle mr-1"></i>', '</small>') ?>
                    </div>
                    <div class="col-lg-2 col-md-6 mb-3">
                        <label class="field-label" for="machine">Mesin</label>
                        <input type="text" class="form-control" id="machine" name="machine"
                               value="<?= $machine ?>">
                        <?= form_error('machine', '<small class="text-danger d-block mt-1 font-weight-bold"><i class="fas fa-exclamation-circle mr-1"></i>', '</small>') ?>
                    </div>
                    <div class="col-lg-2 col-md-6 mb-3">
                        <label class="field-label" for="shift">Shift</label>
                        <input type="text" class="form-control" id="shift" name="shift"
                               value="<?= $shift ?>">
                        <?= form_error('shift', '<small class="text-danger d-block mt-1 font-weight-bold"><i class="fas fa-exclamation-circle mr-1"></i>', '</small>') ?>
                    </div>
                    <div class="col-lg-2 col-md-6 mb-3">
                        <label class="field-label" for="operator">Operator</label>
                        <input type="text" class="form-control" id="operator" name="operator"
                               value="<?= $operator ?>">
                        <?= form_error('operator', '<small class="text-danger d-block mt-1 font-weight-bold"><i class="fas fa-exclamation-circle mr-1"></i>', '</small>') ?>
                    </div>

                    <!-- Roll Number / Desc -->
                    <div class="col-lg-3 col-md-6 mb-3">
                        <label class="field-label" for="roll_no">Nomor Roll</label>
                        <input type="text" class="form-control" id="roll_no" name="roll_no"
                               placeholder="Contoh: 1, 2, 3 atau tipe roll..."
                               value="<?php
                                    if (isset($lastRoll['transaction_desc'])) {
                                        if (is_numeric($lastRoll['transaction_desc'])) {
                                            echo $lastRoll['transaction_desc'] + 1;
                                        } else {
                                            echo $lastRoll['transaction_desc'];
                                        }
                                    } else {
                                        echo set_value('transaction_desc');
                                    }
                                ?>">
                        <?= form_error('roll_no', '<small class="text-danger d-block mt-1 font-weight-bold"><i class="fas fa-exclamation-circle mr-1"></i>', '</small>') ?>
                        <small class="text-muted"><strong>Hanya angka!</strong></small>
                    </div>
                </div>
            </div>
        </div>

        <!-- ── Submit ── -->
        <div class="d-flex align-items-center flex-wrap gap-3 mb-4">
            <button class="btn-submit mr-3 my-2" type="submit" id="btn-submit">
                <i class="fas fa-save"></i> Simpan Data Roll
            </button>
            <span class="text-muted" style="font-size:0.9rem;">
                <i class="fas fa-info-circle mr-1"></i> Data tersimpan otomatis setelah submit.
            </span>
        </div>

    </form>


    <!-- ══════════════════════════════════════════
         ROLL TABLE
    ══════════════════════════════════════════ -->
    <div class="table-card mb-5">
        <div class="table-card-header">
            <i class="fas fa-list-alt text-white" style="font-size:1.1rem;"></i>
            <h6>Data Roll Hari Ini</h6>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="table1" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Item</th>
                        <th>Kode</th>
                        <th>Gramatur</th>
                        <th>Lipatan</th>
                        <th>Jumlah (kg)</th>
                        <th>Harga</th>
                        <th>Subtotal</th>
                        <th>Batch</th>
                        <th>No. Roll</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $temp = 0;
                    $temp_value = 0;
                    $waste = 0;

                    $data['items'] = $this->db->get_where('settings', ['parameter' => 'process_waste'])->row_array();
                    $max_process_waste = $data['items']['value'];
                    $data['items'] = $this->db->get_where('settings', ['parameter' => 'max_waste'])->row_array();
                    $max_waste = $data['items']['value'];
                    ?>
                    <?php foreach ($rollType as $ms) : ?>
                        <tr>
                            <td><?= $i ?></td>
                            <td style="white-space:nowrap;"><?= date('d M Y H:i', $ms['date']) ?></td>
                            <td><?= $ms['name'] ?></td>
                            <td><span class="badge badge-secondary" style="font-size:0.85rem;padding:5px 9px;"><?= $ms['code'] ?></span></td>
                            <td><?= $ms['weight'] ?></td>
                            <td><?= $ms['lipatan'] ?></td>
                            <?php if ($ms['status'] != 9) : ?>
                                <td><input id="rollAmount-<?= $ms['id'] ?>" class="roll-qty form-control" data-id="<?= $ms['id'] ?>" data-prodid="<?= $ms['transaction_id'] ?>" value="<?= number_format($ms['incoming'], 2, ',', '.') ?>"></td>
                            <?php else : ?>
                                <?php if ($ms['transaction_desc'] == 'Bulk cut') : ?>
                                    <td class="text-danger font-weight-bold">-<?= number_format($ms['outgoing'], 2, ',', '.') ?> kg</td>
                                <?php else : ?>
                                    <td class="text-primary font-weight-bold"><?= number_format($ms['incoming'], 2, ',', '.') ?> kg</td>
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php $subtotal = $ms['incoming'] * $ms['price']; ?>
                            <td><input id="rollPrice-<?= $ms['id'] ?>" class="roll-price form-control" data-id="<?= $ms['id'] ?>" value="<?= number_format($ms['price'], 2, ',', '.') ?>"></td>
                            <td style="white-space:nowrap;"><?= number_format($subtotal, 2, ',', '.') ?></td>
                            <td><input id="rollBatch-<?= $ms['id'] ?>" class="roll-batch form-control" data-id="<?= $ms['id'] ?>" value="<?= $ms['batch'] ?>"></td>
                            <td><input id="rollDesc-<?= $ms['id'] ?>" class="roll-desc form-control" data-id="<?= $ms['id'] ?>" value="<?= $ms['transaction_desc'] ?>"></td>
                            <td style="white-space:nowrap;">
                                <a data-toggle="modal" data-target="#printDetails"
                                   data-po="<?= $ms['transaction_id'] ?>"
                                   data-id="<?= $ms['id'] ?>"
                                   data-batch="<?= $ms['batch'] ?>"
                                   data-name="<?= $ms['name'] ?>"
                                   data-itemcode="<?= $ms['code'] ?>"
                                   data-amount="<?= $ms['incoming'] ?>"
                                   data-weight="<?= $ms['weight'] ?>"
                                   data-lipatan="<?= $ms['lipatan'] ?>"
                                   data-desc="<?= $ms['transaction_desc'] ?>"
                                   class="badge badge-primary clickable mr-1">
                                    <i class="fas fa-print mr-1"></i>Print
                                </a>
                                <?php if ($ms['status'] != 9) : ?>
                                    <a data-toggle="modal" data-target="#deleteItemProdOrder"
                                       data-po="<?= $ms['transaction_id'] ?>"
                                       data-id="<?= $ms['id'] ?>"
                                       data-name="<?= $ms['name'] ?>"
                                       data-amount="<?= $ms['incoming'] ?>"
                                       class="badge badge-danger clickable">
                                        <i class="fas fa-trash mr-1"></i>Hapus
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php
                        $temp       += $ms['incoming'];
                        $temp_value += $subtotal;

                        $avalan_name    = "AVALAN ROLL";
                        $prongkolan_name = "PRONGKOLAN ROLL";
                        similar_text($ms['transaction_desc'], "avalan",    $percent_av);
                        similar_text($ms['transaction_desc'], "prongkolan", $percent_prong);
                        if ($percent_av > 50 || $percent_prong > 50 || $ms['name'] == $avalan_name || $ms['name'] == $prongkolan_name) {
                            $waste += $ms['incoming'];
                        }
                        $i++;
                        ?>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <?php $grandTotal = $temp_value; ?>
                    <tr>
                        <td colspan="6" class="text-right font-weight-bold">Total Berat:</td>
                        <td class="font-weight-bold"><?= number_format($temp, 2, ',', '.') ?> kg</td>
                        <td class="text-right font-weight-bold">Nilai Produksi:</td>
                        <td class="font-weight-bold">Rp <?= number_format($grandTotal, 2, ',', '.') ?></td>
                        <td colspan="3"></td>
                    </tr>
                    <tr>
                        <td colspan="6" class="text-right font-weight-bold">Berat Neto Roll:</td>
                        <?php $net_weight = $temp - $waste; ?>
                        <td class="font-weight-bold text-primary"><?= number_format($net_weight, 2, ',', '.') ?> kg</td>
                        <td class="text-right font-weight-bold">Waste Extrusi:</td>
                        <td class="font-weight-bold <?= ($waste >= $max_waste) ? 'text-danger' : 'text-success' ?>">
                            <?= number_format($waste, 2, ',', '.') ?> kg
                        </td>
                        <td colspan="3"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

</div><!-- /.container-fluid -->


<!-- ══════════════════════════════════════════
     MODAL: Pilih Roll Manual
══════════════════════════════════════════ -->
<div class="modal fade" id="newItem" tabindex="-1" aria-labelledby="newItemLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newItemLabel"><i class="fas fa-list mr-2"></i>Pilih Item Roll</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="padding: 0;">
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="background:var(--brand-dark);color:#fff;padding:12px 10px;">No</th>
                                <th style="background:var(--brand-dark);color:#fff;padding:12px 10px;">Nama Roll</th>
                                <th style="background:var(--brand-dark);color:#fff;padding:12px 10px;">Kode</th>
                                <th style="background:var(--brand-dark);color:#fff;padding:12px 10px;">Gramatur</th>
                                <th style="background:var(--brand-dark);color:#fff;padding:12px 10px;">Lipatan</th>
                                <th style="background:var(--brand-dark);color:#fff;padding:12px 10px;">Stok</th>
                                <th style="background:var(--brand-dark);color:#fff;padding:12px 10px;">Harga</th>
                                <th style="background:var(--brand-dark);color:#fff;padding:12px 10px;">Pilih</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($rollSelect as $fs) : ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td class="name font-weight-bold"><?= $fs['name'] ?></td>
                                    <td class="code"><span class="badge badge-secondary" style="font-size:0.85rem;padding:4px 8px;"><?= $fs['code'] ?></span></td>
                                    <td class="weight"><?= $fs['weight'] ?></td>
                                    <td class="lipatan"><?= $fs['lipatan'] ?></td>
                                    <td class="in_stock"><?= $fs['in_stock'] ?></td>
                                    <td class="price"><?= $fs['price'] ?></td>
                                    <td>
                                        <a data-dismiss="modal" type="button"
                                           class="select-item-roll btn btn-primary btn-sm"
                                           style="border-radius:6px; font-weight:700; padding:7px 18px;">
                                            <i class="fas fa-plus mr-1"></i> Pilih
                                        </a>
                                    </td>
                                </tr>
                                <?php $i++; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- ══════════════════════════════════════════
     MODAL: Print
══════════════════════════════════════════ -->
<div class="modal fade" id="printDetails" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-print mr-2"></i>Print Label Roll</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <p class="mx-3 mt-3 mb-0 text-muted">Periksa kembali data sebelum print.</p>
            <form action="<?= base_url('production/print_general_ticket') ?>" method="get">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="field-label">ID Order Produksi</label>
                        <input type="text" class="form-control" id="po_id_print" name="po_id" readonly>
                        <input type="hidden" id="id_print" name="id">

                        <label class="field-label mt-3">Batch</label>
                        <input type="text" class="form-control" id="print_batch" name="batch" readonly>

                        <label class="field-label mt-3">Item</label>
                        <input type="text" class="form-control" id="name_print" name="name" readonly>

                        <label class="field-label mt-3">Code</label>
                        <input type="text" class="form-control" id="code_print" name="code" readonly>

                        <label class="field-label mt-3">Gramatur</label>
                        <input type="text" class="form-control" id="gram_print" name="gram" readonly>

                        <label class="field-label mt-3">Gusset / Lipatan</label>
                        <input type="text" class="form-control" id="guset_print" name="guset" readonly>

                        <label class="field-label mt-3">Berat Neto</label>
                        <div class="input-group">
                            <input type="number" step=".01" class="form-control" id="amount_print" name="amount" readonly>
                            <div class="input-group-append">
                                <span class="input-group-text">kg</span>
                            </div>
                        </div>

                        <label class="field-label mt-3">Deskripsi</label>
                        <input type="text" class="form-control" id="desc_print" name="desc" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times mr-1"></i>Tutup</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-print mr-1"></i>Print</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ══════════════════════════════════════════
     MODAL: Delete
══════════════════════════════════════════ -->
<div class="modal fade" id="deleteItemProdOrder" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background:#c0392b;">
                <h5 class="modal-title"><i class="fas fa-exclamation-triangle mr-2"></i>Hapus Data?</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <p class="mx-3 mt-3 mb-0">Anda akan menghapus data ini. Tindakan ini <strong>tidak dapat dibatalkan.</strong></p>
            <form action="<?= base_url('production/delete_item_roll_general_form') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="field-label">ID Order Produksi</label>
                        <input type="text" class="form-control" id="delete_po_id" name="delete_po_id" readonly>
                        <input type="hidden" id="delete_id" name="delete_id">

                        <label class="field-label mt-3">Item</label>
                        <input type="text" class="form-control" id="delete_name" name="delete_name" readonly>

                        <label class="field-label mt-3">Jumlah</label>
                        <input type="text" class="form-control" id="delete_amount" name="delete_amount" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times mr-1"></i>Batal</button>
                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash mr-1"></i>Ya, Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- ══════════════════════════════════════════
     SCRIPTS
══════════════════════════════════════════ -->
<script>
/* ── Berat calculation ── */
function calculate() {
    const gross  = parseFloat(document.getElementById('gross').value)  || 0;
    const bobin  = parseFloat(document.getElementById('bobin').value)  || 0;
    const net    = (gross * 1000) - bobin;
    document.getElementById('amount').value = (net / 1000).toFixed(2);
}

/* ── DataTable ── */
var table1 = $('#table1').DataTable({
    paging: false,
    columnDefs: [{ targets: [0, 1, 2, 3], orderable: true, searchable: true }]
});

// Prevent double-submit: disable button immediately on first submit
document.getElementById('main-roll-form').addEventListener('submit', function(e) {
    var gross  = parseFloat(document.getElementById('gross').value)  || 0;
    var amount = parseFloat(document.getElementById('amount').value) || 0;

    if (gross <= 0 || amount <= 0) {
        e.preventDefault();
        var msg = gross <= 0
            ? 'Berat Total (Kotor) tidak boleh 0 atau kosong.'
            : 'Berat Neto tidak boleh 0. Periksa isian Berat Total dan Berat Bobin.';
        var el = document.getElementById('roll-alert');
        el.className = 'alert alert-danger alert-dismissible fade show mb-2';
        el.innerHTML = '<i class="fas fa-exclamation-circle mr-2"></i><strong>Tidak dapat menyimpan:</strong> ' + msg +
            '<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>';
        document.getElementById('gross').focus();
        return;
    }  
    
    var btn = document.getElementById('btn-submit');

    // If already submitted, block the second submit entirely
    if (btn.getAttribute('data-submitted') === 'true') {
        e.preventDefault();
        return;
    }

    // Mark as submitted and update button appearance
    btn.setAttribute('data-submitted', 'true');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
});


/* ══════════════════════════════
   PO ID SCANNER
══════════════════════════════ */
let html5QrCode = null;

document.getElementById('btn-scan').addEventListener('click', function() {
    const container = document.getElementById('qr-scanner-container');
    container.style.display = 'block';
    this.disabled = true;
    html5QrCode = new Html5Qrcode("qr-reader");
    html5QrCode.start(
        { facingMode: "user" },
        { fps: 10, qrbox: { width: 175, height: 175 } },
        function(decodedText) { document.getElementById('po_id').value = decodedText; checkPoId(decodedText); stopScanner(); },
        function() {}
    ).then(function() {
        var video = document.querySelector('#qr-reader video');
        if (video) video.style.transform = 'scaleX(-1)';
    }).catch(function(err) {
        console.error("Camera error:", err);
        alert("Tidak dapat mengakses kamera. Pastikan izin kamera diberikan.");
        stopScanner();
    });
});

document.getElementById('btn-stop-scan').addEventListener('click', stopScanner);

function stopScanner() {
    if (html5QrCode && html5QrCode.isScanning) {
        html5QrCode.stop().then(function() {
            html5QrCode.clear();
            document.getElementById('qr-scanner-container').style.display = 'none';
            document.getElementById('btn-scan').disabled = false;
        }).catch(function(err) { console.error("Stop error:", err); });
    } else {
        document.getElementById('qr-scanner-container').style.display = 'none';
        document.getElementById('btn-scan').disabled = false;
    }
}

/* ── PO Validation ── */
function showPoAlert(type, message) {
    var el = document.getElementById('po-alert');
    el.className = 'alert alert-' + type + ' alert-dismissible fade show mb-2';
    el.innerHTML = message + '<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>';
}

let lastValidPoId = '';

document.addEventListener('DOMContentLoaded', function() {
    var poInput = document.getElementById('po_id');
    lastValidPoId = poInput.value;
    if (poInput.value) checkPoId(poInput.value);
});

function checkPoId(po_id) {
    if (!po_id) return;
    showPoAlert('secondary', '<i class="fas fa-spinner fa-spin mr-1"></i> Memeriksa ID <strong>' + po_id + '</strong>...');
    fetch('<?= base_url('production/check_po_id') ?>?po_id=' + encodeURIComponent(po_id))
        .then(function(r) { return r.json(); })
        .then(function(res) {
            if (res.status === 'found') {
                lastValidPoId = po_id;
                showPoAlert('success',
                    '<i class="fas fa-check-circle mr-1"></i> ID <strong>' + po_id + '</strong> ditemukan' +
                    (res.data.product_name ? ' &mdash; ' + res.data.product_name : ''));
                                
                // ── Update batch input with description ──
                if (res.data.description) {
                    document.getElementById('batch').value = res.data.description;
                }
                
                document.getElementById('btn-submit').disabled = false;
            } else {
                document.getElementById('po_id').value = lastValidPoId;
                showPoAlert('danger', '<i class="fas fa-times-circle mr-1"></i> ID <strong>"' + po_id + '"</strong> tidak ditemukan.');
                document.getElementById('btn-submit').disabled = true;
            }
        })
        .catch(function(err) {
            console.error('Check PO error:', err);
            document.getElementById('po_id').value = lastValidPoId;
            showPoAlert('warning', '<i class="fas fa-exclamation-triangle mr-1"></i> Gagal memeriksa ID. Periksa koneksi.');
        });
}

/* ══════════════════════════════
   ROLL ITEM SCANNER
══════════════════════════════ */
let html5QrCodeRoll = null;

document.getElementById('btn-scan-roll').addEventListener('click', function() {
    const container = document.getElementById('qr-roll-scanner-container');
    container.style.display = 'block';
    this.disabled = true;
    html5QrCodeRoll = new Html5Qrcode("qr-roll-reader");
    html5QrCodeRoll.start(
        { facingMode: "user" },
        { fps: 10, qrbox: { width: 150, height: 150} },
        function(decodedText) { stopRollScanner(); lookupRollByCode(decodedText); },
        function() {}
    ).then(function() {
        var video = document.querySelector('#qr-roll-reader video');
        if (video) video.style.transform = 'scaleX(-1)';
    }).catch(function(err) {
        console.error("Camera error:", err);
        alert("Tidak dapat mengakses kamera. Pastikan izin kamera diberikan.");
        stopRollScanner();
    });
});

document.getElementById('btn-stop-scan-roll').addEventListener('click', stopRollScanner);

function stopRollScanner() {
    if (html5QrCodeRoll && html5QrCodeRoll.isScanning) {
        html5QrCodeRoll.stop().then(function() {
            html5QrCodeRoll.clear();
            document.getElementById('qr-roll-scanner-container').style.display = 'none';
            document.getElementById('btn-scan-roll').disabled = false;
        }).catch(function(err) { console.error("Stop error:", err); });
    } else {
        document.getElementById('qr-roll-scanner-container').style.display = 'none';
        document.getElementById('btn-scan-roll').disabled = false;
    }
}

/* ── Roll lookup ── */
function showRollAlert(type, message) {
    var el = document.getElementById('roll-alert');
    el.className = 'alert alert-' + type + ' alert-dismissible fade show mb-2';
    el.innerHTML = message + '<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>';
}

function lookupRollByCode(code) {
    fetch('<?= base_url('production/get_roll_by_code') ?>?code=' + encodeURIComponent(code))
        .then(function(r) { return r.json(); })
        .then(function(res) {
            if (res.status === 'found') {
                var roll = res.data;
                document.getElementById('rollName').value   = roll.name    || '';
                document.getElementById('code').value       = roll.code    || '';
                document.getElementById('weight').value     = roll.weight  || '';
                document.getElementById('lipatan').value    = roll.lipatan || '';
                document.getElementById('price_roll').value = roll.price   || '';
                showRollAlert('success',
                    '<i class="fas fa-check-circle mr-1"></i><strong>' + roll.name + '</strong> ditemukan — Kode: <strong>' + roll.code + '</strong>');
            } else {
                document.getElementById('rollName').value   = '';
                document.getElementById('code').value       = '';
                document.getElementById('weight').value     = '';
                document.getElementById('lipatan').value    = '';
                document.getElementById('price_roll').value = '';
                showRollAlert('danger', '<i class="fas fa-times-circle mr-1"></i>Roll kode <strong>"' + code + '"</strong> tidak ditemukan.');
            }
        })
        .catch(function(err) {
            console.error('Lookup error:', err);
            showRollAlert('warning', '<i class="fas fa-exclamation-triangle mr-1"></i>Gagal mengambil data roll. Periksa koneksi.');
        });
}

/* ══════════════════════════════
   MODAL: Select Roll from table
══════════════════════════════ */
$(document).on('click', '.select-item-roll', function() {
    var row = $(this).closest('tr');
    var name    = row.find('.name').text().trim();
    var code    = row.find('.code').text().trim();
    var weight  = row.find('.weight').text().trim();
    var lipatan = row.find('.lipatan').text().trim();
    var price   = row.find('.price').text().trim();

    $('#rollName').val(name);
    $('#code').val(code);
    $('#weight').val(weight);
    $('#lipatan').val(lipatan);
    $('#price_roll').val(price);

    showRollAlert('success',
        '<i class="fas fa-check-circle mr-1"></i><strong>' + name + '</strong> dipilih — Kode: <strong>' + code + '</strong>');
});

/* ══════════════════════════════
   MODAL: Print — populate fields
══════════════════════════════ */
// $('#printDetails').on('show.bs.modal', function(event) {
//     var btn = $(event.relatedTarget);
//     $(this).find('#po_id_print').val(btn.data('po'));
//     $(this).find('#id_print').val(btn.data('id'));
//     $(this).find('#print_batch').val(btn.data('batch'));
//     $(this).find('#name_print').val(btn.data('name'));
//     $(this).find('#amount_print').val(btn.data('amount'));
//     $(this).find('#gram_print').val(btn.data('weight'));
//     $(this).find('#guset_print').val(btn.data('lipatan'));
//     $(this).find('#desc_print').val(btn.data('desc'));
// });

// Override form submit — print via hidden iframe
$('#printDetails form').on('submit', function(e) {
    e.preventDefault();

    var formData = $(this).serialize() + '&type=2';
    var printUrl  = '<?= base_url('production/print_general_ticket') ?>?' + formData;

    var iframe = document.getElementById('print-iframe');
    if (!iframe) {
        iframe = document.createElement('iframe');
        iframe.id = 'print-iframe';
        iframe.style.cssText = 'position:fixed;top:-9999px;left:-9999px;width:0;height:0;border:none;';
        document.body.appendChild(iframe);
    }

    iframe.onload = function() {
        setTimeout(function() {
            iframe.contentWindow.focus();
            iframe.contentWindow.print();
        }, 500);
    };

    iframe.src = printUrl;
    $('#printDetails').modal('hide');
});

/* ══════════════════════════════
   MODAL: Delete — populate fields
══════════════════════════════ */
$('#deleteItemProdOrder').on('show.bs.modal', function(event) {
    var btn = $(event.relatedTarget);
    $(this).find('#delete_po_id').val(btn.data('po'));
    $(this).find('#delete_id').val(btn.data('id'));
    $(this).find('#delete_name').val(btn.data('name'));
    $(this).find('#delete_amount').val(btn.data('amount'));
});

/* ══════════════════════════════
   Also check PO on DOMContentLoaded (persisted via flashdata)
══════════════════════════════ */
document.addEventListener('DOMContentLoaded', function() {
    var existingPoId = document.getElementById('po_id').value;
    if (existingPoId) checkPoId(existingPoId);
});
</script>