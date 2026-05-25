<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-folder-open text-primary mr-2"></i> Document Control
        </h1>
        <div>
            <button class="btn btn-sm btn-success shadow-sm mr-2" id="btnAddDoc">
                <i class="fas fa-plus fa-sm text-white-50 mr-1"></i> New Document
            </button>
            <a href="<?= base_url('qms/document_structure') ?>" class="btn btn-sm btn-outline-secondary shadow-sm">
                <i class="fas fa-sitemap fa-sm mr-1"></i> Manage Structure
            </a>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="card shadow mb-3">
        <div class="card-body py-2">
            <form id="frmFilter" class="form-inline flex-wrap">
                <div class="form-group mr-3 mb-2">
                    <label class="mr-1 text-xs font-weight-bold text-gray-600">Category</label>
                    <select class="form-control form-control-sm" name="category_id" id="filterCategory">
                        <option value="">All Categories</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>">
                                <?= htmlspecialchars($cat['code']) ?> – <?= htmlspecialchars($cat['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group mr-3 mb-2">
                    <label class="mr-1 text-xs font-weight-bold text-gray-600">Status</label>
                    <select class="form-control form-control-sm" name="status" id="filterStatus">
                        <option value="">All</option>
                        <option value="draft">Draft</option>
                        <option value="active">Active</option>
                        <option value="superseded">Superseded</option>
                        <option value="obsolete">Obsolete</option>
                    </select>
                </div>
                <div class="form-group mr-3 mb-2">
                    <label class="mr-1 text-xs font-weight-bold text-gray-600">Active</label>
                    <select class="form-control form-control-sm" name="is_active" id="filterActive">
                        <option value="">All</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
                <button type="button" class="btn btn-sm btn-primary mb-2" id="btnApplyFilter">
                    <i class="fas fa-filter mr-1"></i> Apply
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary mb-2 ml-1" id="btnResetFilter">
                    <i class="fas fa-undo mr-1"></i> Reset
                </button>
            </form>
        </div>
    </div>

    <!-- Documents Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Document Register</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="tblDocuments" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>Doc. Number</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Department</th>
                            <th>Version</th>
                            <th>Status</th>
                            <th>Effective Date</th>
                            <th class="text-center" style="width:130px">Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- ================================================================
     MODAL: Create / Edit Document Master
     ================================================================ -->
<div class="modal fade" id="modalDocMaster" tabindex="-1" role="dialog" aria-labelledby="modalDocMasterLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalDocMasterLabel"><i class="fas fa-file-alt mr-2"></i> Document Details</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="masterIdField">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold small">Doc. Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="fDocNumber" maxlength="50" placeholder="e.g. SOP-QMS-001">
                            <small class="text-muted">Unique identifier (auto-uppercased)</small>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="font-weight-bold small">Document Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" id="fTitle" maxlength="255">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold small">Category <span class="text-danger">*</span></label>
                            <select class="form-control form-control-sm" id="fCategory">
                                <option value="">-- Select --</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= $cat['id'] ?>">
                                        <?= htmlspecialchars($cat['code']) ?> – <?= htmlspecialchars($cat['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold small">Department</label>
                            <input type="text" class="form-control form-control-sm" id="fDepartment" maxlength="100">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold small">Process Owner</label>
                            <input type="text" class="form-control form-control-sm" id="fProcessOwner" maxlength="100">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="font-weight-bold small">Retention (Years)</label>
                            <input type="number" class="form-control form-control-sm" id="fRetention" value="3" min="1" max="99">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="font-weight-bold small">Active</label>
                            <select class="form-control form-control-sm" id="fIsActive">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary btn-sm" id="btnSaveMaster">
                    <i class="fas fa-save mr-1"></i> Save Document
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ================================================================
     MODAL: Upload New Version
     ================================================================ -->
<div class="modal fade" id="modalUpload" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="fas fa-cloud-upload-alt mr-2"></i> Upload New Version</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info py-2 small mb-3" id="uploadDocInfo"></div>

                <!-- Version History (collapsed) -->
                <div class="mb-3">
                    <a data-toggle="collapse" href="#collapseHistory" class="text-xs text-primary">
                        <i class="fas fa-history mr-1"></i> View Version History
                    </a>
                    <div class="collapse mt-2" id="collapseHistory">
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered small mb-0" id="tblVersionHistory">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Version</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th>Uploaded By</th>
                                        <th>Date</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <hr>

                <input type="hidden" id="uploadMasterId">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="font-weight-bold small">Version <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" id="fVersion"
                                   placeholder="e.g. 1.0" pattern="^\d+\.\d+$">
                            <small class="text-muted">Format: X.Y</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="font-weight-bold small">Effective Date</label>
                            <input type="date" class="form-control form-control-sm" id="fEffectiveDate">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold small">Revision Description <span class="text-danger">*</span></label>
                            <textarea class="form-control form-control-sm" id="fVersionDesc" rows="2"
                                      placeholder="Describe what changed in this version…"></textarea>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold small">Document File <span class="text-danger">*</span>
                        <small class="text-muted font-weight-normal"> (PDF, Word, Excel, PPT · max 20 MB)</small>
                    </label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="fDocFile"
                               accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx">
                        <label class="custom-file-label" for="fDocFile">Choose file…</label>
                    </div>
                </div>

                <div class="progress d-none mt-2" id="uploadProgress">
                    <div class="progress-bar progress-bar-striped progress-bar-animated"
                         role="progressbar" style="width:0%"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success btn-sm" id="btnUpload">
                    <i class="fas fa-upload mr-1"></i> Upload Version
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ================================================================
     JAVASCRIPT
     ================================================================ -->
<script>
$(function () {
    'use strict';

    const BASE = '<?= base_url() ?>';
    let currentMasterId = null;

    // ────────────────────────────────────────────────
    // DataTable Initialisation
    // ────────────────────────────────────────────────
    const table = $('#tblDocuments').DataTable({
        processing  : true,
        serverSide  : true,
        ajax        : {
            url  : BASE + 'qms/ajax/doc/list',
            type : 'POST',
            data : function (d) {
                d.search      = $('#tblDocuments_filter input').val();
                d.category_id = $('#filterCategory').val();
                d.status      = $('#filterStatus').val();
                d.is_active   = $('#filterActive').val();
                return d;
            },
            error: function () {
                toastError('Failed to load documents. Please refresh.');
            }
        },
        columns: [
            { data: 'doc_number',     className: 'font-weight-bold text-primary small' },
            { data: 'title',          className: 'small' },
            {
                data: null,
                render: function (d) {
                    return '<span class="badge badge-secondary">' + esc(d.category_code) + '</span> ' + esc(d.category_name);
                }
            },
            { data: 'department',  className: 'small', defaultContent: '–' },
            {
                data: 'current_version',
                defaultContent: '–',
                render: function (d) {
                    return d ? '<span class="badge badge-light border">v' + esc(d) + '</span>' : '–';
                }
            },
            {
                data: 'current_status',
                defaultContent: '–',
                render: function (d) {
                    const map = {
                        draft: 'badge-warning', active: 'badge-success',
                        superseded: 'badge-secondary', obsolete: 'badge-danger'
                    };
                    return d ? '<span class="badge ' + (map[d] || 'badge-light') + '">' + esc(d.charAt(0).toUpperCase() + d.slice(1)) + '</span>' : '–';
                }
            },
            { data: 'effective_date', defaultContent: '–', className: 'small' },
            {
                data: 'id',
                orderable: false,
                className: 'text-center',
                render: function (id, _, row) {
                    let btns = '<button class="btn btn-xs btn-info mr-1 btnEdit" data-id="' + id + '" title="Edit"><i class="fas fa-edit"></i></button>';
                    btns    += '<button class="btn btn-xs btn-success mr-1 btnUpload" data-id="' + id + '" data-num="' + esc(row.doc_number) + '" data-title="' + esc(row.title) + '" title="Upload Version"><i class="fas fa-upload"></i></button>';
                    if (row.current_version_id) {
                        btns += '<a href="' + BASE + 'qms/ajax/doc/download/' + row.current_version_id + '" class="btn btn-xs btn-outline-primary" title="Download Current"><i class="fas fa-download"></i></a>';
                    }
                    return btns;
                }
            }
        ],
        order      : [[0, 'asc']],
        pageLength : 15,
        language   : { processing: '<i class="fas fa-spinner fa-spin"></i> Loading…' },
    });

    // ────────────────────────────────────────────────
    // Filters
    // ────────────────────────────────────────────────
    $('#btnApplyFilter').on('click', function () { table.ajax.reload(); });
    $('#btnResetFilter').on('click', function () {
        $('#frmFilter')[0].reset();
        table.ajax.reload();
    });

    // ────────────────────────────────────────────────
    // Add / Edit Document Master
    // ────────────────────────────────────────────────
    $('#btnAddDoc').on('click', function () {
        resetMasterModal();
        $('#modalDocMasterLabel').html('<i class="fas fa-file-alt mr-2"></i> New Document');
        $('#modalDocMaster').modal('show');
    });

    $(document).on('click', '.btnEdit', function () {
        const id = $(this).data('id');
        $.getJSON(BASE + 'qms/ajax/doc/master/' + id, function (res) {
            if (!res.success) { return toastError(res.error); }
            const d = res.data;
            $('#masterIdField').val(d.id);
            $('#fDocNumber').val(d.doc_number);
            $('#fTitle').val(d.title);
            $('#fCategory').val(d.category_id);
            $('#fDepartment').val(d.department);
            $('#fProcessOwner').val(d.process_owner);
            $('#fRetention').val(d.retention_years);
            $('#fIsActive').val(d.is_active);
            $('#modalDocMasterLabel').html('<i class="fas fa-edit mr-2"></i> Edit Document');
            $('#modalDocMaster').modal('show');
        }).fail(function () { toastError('Could not load record.'); });
    });

    $('#btnSaveMaster').on('click', function () {
        const id = $('#masterIdField').val();
        if (!$('#fDocNumber').val().trim()) { return toastError('Document number is required.'); }
        if (!$('#fTitle').val().trim())     { return toastError('Title is required.'); }
        if (!$('#fCategory').val())         { return toastError('Category is required.'); }

        const btn = $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Saving…');

        $.ajax({
            url  : BASE + 'qms/ajax/doc/master/save',
            type : 'POST',
            data : {
                id             : id,
                doc_number     : $('#fDocNumber').val(),
                title          : $('#fTitle').val(),
                category_id    : $('#fCategory').val(),
                department     : $('#fDepartment').val(),
                process_owner  : $('#fProcessOwner').val(),
                retention_years: $('#fRetention').val(),
                is_active      : $('#fIsActive').val(),
            },
            dataType: 'json',
        }).done(function (res) {
            if (res.success) {
                toastSuccess(id ? 'Document updated.' : 'Document created.');
                $('#modalDocMaster').modal('hide');
                table.ajax.reload(null, false);
            } else {
                toastError(res.error || 'Save failed.');
            }
        }).fail(function () {
            toastError('Request failed. Please try again.');
        }).always(function () {
            btn.prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Save Document');
        });
    });

    // ────────────────────────────────────────────────
    // Upload Version Modal
    // ────────────────────────────────────────────────
    $(document).on('click', '.btnUpload', function () {
        currentMasterId = $(this).data('id');
        resetUploadModal();

        $('#uploadMasterId').val(currentMasterId);
        $('#uploadDocInfo').html(
            '<strong>' + esc($(this).data('num')) + '</strong> – ' + esc($(this).data('title'))
        );

        // Load version history
        loadVersionHistory(currentMasterId);
        $('#modalUpload').modal('show');
    });

    // Custom file label
    $('#fDocFile').on('change', function () {
        const name = this.files[0] ? this.files[0].name : 'Choose file…';
        $(this).next('.custom-file-label').text(name);
    });

    $('#btnUpload').on('click', function () {
        const ver  = $('#fVersion').val().trim();
        const desc = $('#fVersionDesc').val().trim();
        const file = document.getElementById('fDocFile').files[0];

        if (!ver)  { return toastError('Version number is required.'); }
        if (!/^\d+\.\d+$/.test(ver)) { return toastError('Version must be in X.Y format (e.g. 1.0).'); }
        if (!desc) { return toastError('Version description is required.'); }
        if (!file) { return toastError('Please select a file.'); }
        if (file.size > 20 * 1024 * 1024) { return toastError('File must not exceed 20 MB.'); }

        const fd = new FormData();
        fd.append('master_id',      currentMasterId);
        fd.append('version',        ver);
        fd.append('version_desc',   desc);
        fd.append('effective_date', $('#fEffectiveDate').val());
        fd.append('document',       file);

        const btn = $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Uploading…');
        $('#uploadProgress').removeClass('d-none').find('.progress-bar').css('width', '0%');

        $.ajax({
            url         : BASE + 'qms/ajax/doc/upload',
            type        : 'POST',
            data        : fd,
            processData : false,
            contentType : false,
            dataType    : 'json',
            xhr: function () {
                const x = $.ajaxSettings.xhr();
                x.upload.addEventListener('progress', function (e) {
                    if (e.lengthComputable) {
                        const pct = Math.round(e.loaded / e.total * 100);
                        $('#uploadProgress .progress-bar').css('width', pct + '%').text(pct + '%');
                    }
                }, false);
                return x;
            },
        }).done(function (res) {
            if (res.success) {
                toastSuccess('Version ' + ver + ' uploaded successfully.');
                $('#modalUpload').modal('hide');
                table.ajax.reload(null, false);
            } else {
                toastError(res.error || 'Upload failed.');
                $('#uploadProgress').addClass('d-none');
            }
        }).fail(function () {
            toastError('Upload request failed.');
            $('#uploadProgress').addClass('d-none');
        }).always(function () {
            btn.prop('disabled', false).html('<i class="fas fa-upload mr-1"></i> Upload Version');
        });
    });

    // ────────────────────────────────────────────────
    // Version History loader
    // ────────────────────────────────────────────────
    function loadVersionHistory(masterId) {
        $.getJSON(BASE + 'qms/ajax/doc/versions/' + masterId, function (res) {
            const tbody = $('#tblVersionHistory tbody').empty();
            if (!res.success || !res.data.length) {
                tbody.append('<tr><td colspan="6" class="text-center text-muted">No versions yet.</td></tr>');
                return;
            }
            const statusBadge = {
                draft: 'badge-warning', active: 'badge-success',
                superseded: 'badge-secondary', obsolete: 'badge-danger'
            };
            res.data.forEach(function (v) {
                const badge = '<span class="badge ' + (statusBadge[v.status] || 'badge-light') + '">' + esc(v.status) + '</span>';
                const dl    = '<a href="' + BASE + 'qms/ajax/doc/download/' + v.id + '" class="btn btn-xs btn-outline-primary" title="Download"><i class="fas fa-download"></i></a>';
                tbody.append('<tr>' +
                    '<td><strong>v' + esc(v.version) + '</strong>' + (v.is_current ? ' <span class="badge badge-success">Current</span>' : '') + '</td>' +
                    '<td>' + esc(v.version_desc) + '</td>' +
                    '<td>' + badge + '</td>' +
                    '<td>' + esc(v.uploaded_by) + '</td>' +
                    '<td>' + esc(v.created_at) + '</td>' +
                    '<td>' + dl + '</td>' +
                '</tr>');
            });
        });
    }

    // ────────────────────────────────────────────────
    // Helpers
    // ────────────────────────────────────────────────
    function resetMasterModal() {
        $('#masterIdField, #fDocNumber, #fTitle, #fDepartment, #fProcessOwner').val('');
        $('#fCategory').val('');
        $('#fRetention').val(3);
        $('#fIsActive').val(1);
    }

    function resetUploadModal() {
        $('#fVersion, #fVersionDesc, #fEffectiveDate').val('');
        $('#fDocFile').val('');
        $('#fDocFile').next('.custom-file-label').text('Choose file…');
        $('#uploadProgress').addClass('d-none').find('.progress-bar').css('width', '0%');
        $('#tblVersionHistory tbody').empty();
        $('#collapseHistory').removeClass('show');
    }

    function esc(str) {
        if (str === null || str === undefined) return '';
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }

    function toastSuccess(msg) {
        // Uses SBAdmin2 + toastr if available, else alert
        if (window.toastr) { toastr.success(msg); }
        else { alert('✔ ' + msg); }
    }

    function toastError(msg) {
        if (window.toastr) { toastr.error(msg); }
        else { alert('✖ ' + msg); }
    }
});
</script>
