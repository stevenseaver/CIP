    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-sitemap text-primary mr-2"></i> Document Structure
            </h1>
            <a href="<?= base_url('qms/document_control') ?>" class="btn btn-sm btn-outline-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm mr-1"></i> Back to Document Control
            </a>
        </div>

        <div class="row">
            <!-- ── LEFT: Categories ── -->
            <div class="col-lg-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Document Categories</h6>
                        <button class="btn btn-sm btn-success" id="btnAddCat">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover mb-0" id="tblCategories">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Code</th>
                                        <th>Name</th>
                                        <th class="text-center" style="width:60px">Status</th>
                                        <th class="text-center" style="width:70px">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td colspan="4" class="text-center py-3 text-muted"><i class="fas fa-spinner fa-spin"></i></td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ── RIGHT: Document Masters ── -->
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Document Register</h6>
                        <button class="btn btn-sm btn-success" id="btnAddMaster">
                            <i class="fas fa-plus mr-1"></i> New Document
                        </button>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover mb-0" id="tblMasters">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Doc. No.</th>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>Owner</th>
                                        <th class="text-center">Active</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td colspan="6" class="text-center py-3 text-muted"><i class="fas fa-spinner fa-spin"></i></td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- DataTable pagination container -->
                    <div class="card-footer py-2 d-flex justify-content-between align-items-center" id="mastersPager">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ================================================================
    MODAL: Category Create / Edit
    ================================================================ -->
<div class="modal fade" id="modalCat" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalCatLabel"><i class="fas fa-tags mr-2"></i> Category</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="catId">
                <div class="form-group">
                    <label class="font-weight-bold small">Code <span class="text-danger">*</span>
                        <small class="text-muted font-weight-normal">(short identifier, e.g. SOP)</small>
                    </label>
                    <input type="text" class="form-control form-control-sm text-uppercase" id="fCatCode" maxlength="20">
                </div>
                <div class="form-group">
                    <label class="font-weight-bold small">Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-sm" id="fCatName" maxlength="100">
                </div>
                <div class="form-group">
                    <label class="font-weight-bold small">Description</label>
                    <textarea class="form-control form-control-sm" id="fCatDesc" rows="2"></textarea>
                </div>
                <div class="form-group">
                    <label class="font-weight-bold small">Status</label>
                    <select class="form-control form-control-sm" id="fCatActive">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary btn-sm" id="btnSaveCat">
                    <i class="fas fa-save mr-1"></i> Save Category
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ================================================================
    MODAL: Document Master Create / Edit (Structure menu)
    ================================================================ -->
<div class="modal fade" id="modalMaster" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document"> 
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalMasterLabel"><i class="fas fa-file-alt mr-2"></i> Document Record</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="mId">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold small">Doc. Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="mDocNumber" maxlength="50">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="font-weight-bold small">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" id="mTitle" maxlength="255">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold small">Category <span class="text-danger">*</span></label>
                            <select class="form-control form-control-sm" id="mCategory">
                                <option value="">-- Select --</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold small">Department</label>
                            <input type="text" class="form-control form-control-sm" id="mDepartment" maxlength="100">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold small">Process Owner</label>
                            <input type="text" class="form-control form-control-sm" id="mProcessOwner" maxlength="100">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="font-weight-bold small">Retention (Years)</label>
                            <input type="number" class="form-control form-control-sm" id="mRetention" value="3" min="1" max="99">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="font-weight-bold small">Active</label>
                            <select class="form-control form-control-sm" id="mIsActive">
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
                    <i class="fas fa-save mr-1"></i> Save
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

    // ──────────────────────────────────────────────
    // CATEGORIES
    // ──────────────────────────────────────────────
    function loadCategories() {
        $.getJSON(BASE + 'qms/ajax/cat/list', function (res) {
            const tbody = $('#tblCategories tbody').empty();
            if (!res.success || !res.data.length) {
                tbody.append('<tr><td colspan="4" class="text-center text-muted py-3">No categories found.</td></tr>');
                populateCategoryDropdown([]);
                return;
            }
            populateCategoryDropdown(res.data);
            res.data.forEach(function (c) {
                const badge = c.is_active == 1
                    ? '<span class="badge badge-success">Active</span>'
                    : '<span class="badge badge-secondary">Off</span>';
                tbody.append('<tr>' +
                    '<td><strong>' + esc(c.code) + '</strong></td>' +
                    '<td class="small">' + esc(c.name) + '</td>' +
                    '<td class="text-center">' + badge + '</td>' +
                    '<td class="text-center">' +
                        '<button class="btn btn-xs btn-info btnEditCat" data-id="' + c.id + '" title="Edit"><i class="fas fa-edit"></i></button>' +
                    '</td>' +
                '</tr>');
            });
        }).fail(function () { toastError('Could not load categories.'); });
    }

    function populateCategoryDropdown(cats) {
        const sel = $('#mCategory').empty().append('<option value="">-- Select --</option>');
        cats.forEach(function (c) {
            if (c.is_active == 1) {
                sel.append('<option value="' + c.id + '">' + esc(c.code) + ' – ' + esc(c.name) + '</option>');
            }
        });
    }

    loadCategories();

    // Add category
    $('#btnAddCat').on('click', function () {
        resetCatModal();
        $('#modalCatLabel').html('<i class="fas fa-tags mr-2"></i> New Category');
        $('#modalCat').modal('show');
    });

    // Edit category
    $(document).on('click', '.btnEditCat', function () {
        const id = $(this).data('id');
        $.getJSON(BASE + 'qms/ajax/cat/' + id, function (res) {
            if (!res.success) { return toastError(res.error); }
            const c = res.data;
            $('#catId').val(c.id);
            $('#fCatCode').val(c.code);
            $('#fCatName').val(c.name);
            $('#fCatDesc').val(c.description);
            $('#fCatActive').val(c.is_active);
            $('#modalCatLabel').html('<i class="fas fa-edit mr-2"></i> Edit Category');
            $('#modalCat').modal('show');
        }).fail(function () { toastError('Could not load category.'); });
    });

    // Save category
    $('#btnSaveCat').on('click', function () {
        const id = $('#catId').val();
        if (!$('#fCatCode').val().trim()) { return toastError('Code is required.'); }
        if (!$('#fCatName').val().trim()) { return toastError('Name is required.'); }

        const btn = $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Saving…');

        $.ajax({
            url     : BASE + 'qms/ajax/cat/save',
            type    : 'POST',
            data    : {
                id         : id,
                code       : $('#fCatCode').val(),
                name       : $('#fCatName').val(),
                description: $('#fCatDesc').val(),
                is_active  : $('#fCatActive').val(),
            },
            dataType: 'json',
        }).done(function (res) {
            if (res.success) {
                toastSuccess(id ? 'Category updated.' : 'Category created.');
                $('#modalCat').modal('hide');
                loadCategories();
                loadMasters();
            } else {
                toastError(res.error || 'Save failed.');
            }
        }).fail(function () {
            toastError('Request failed.');
        }).always(function () {
            btn.prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Save Category');
        });
    });

    // ──────────────────────────────────────────────
    // DOCUMENT MASTERS (simple paginated table)
    // ──────────────────────────────────────────────
    let mastersPage = 0;
    const mastersPerPage = 10;
    let mastersTotal = 0;

    function loadMasters() {
        $.ajax({
            url     : BASE + 'qms/ajax/doc/list',
            type    : 'POST',
            data    : { draw: 1, start: mastersPage * mastersPerPage, length: mastersPerPage },
            dataType: 'json',
        }).done(function (res) {
            mastersTotal = res.recordsTotal || 0;
            const tbody = $('#tblMasters tbody').empty();
            if (!res.data || !res.data.length) {
                tbody.append('<tr><td colspan="6" class="text-center py-3 text-muted">No documents found.</td></tr>');
                renderPager();
                return;
            }
            res.data.forEach(function (d) {
                const activeIcon = d.is_active == 1
                    ? '<i class="fas fa-check-circle text-success"></i>'
                    : '<i class="fas fa-times-circle text-danger"></i>';
                tbody.append('<tr>' +
                    '<td class="font-weight-bold small text-primary">' + esc(d.doc_number) + '</td>' +
                    '<td class="small">' + esc(d.title) + '</td>' +
                    '<td><span class="badge badge-secondary">' + esc(d.category_code) + '</span></td>' +
                    '<td class="small">' + esc(d.process_owner || '–') + '</td>' +
                    '<td class="text-center">' + activeIcon + '</td>' +
                    '<td class="text-center">' +
                        '<button class="btn btn-xs btn-info btnEditMaster" data-id="' + d.id + '" title="Edit"><i class="fas fa-edit"></i></button>' +
                    '</td>' +
                '</tr>');
            });
            renderPager();
        }).fail(function () { toastError('Could not load documents.'); });
    }

    function renderPager() {
        const totalPages = Math.ceil(mastersTotal / mastersPerPage);
        const pager = $('#mastersPager').empty();
        pager.append('<small class="text-muted">Showing ' + (mastersPage * mastersPerPage + 1) + '–' +
            Math.min((mastersPage + 1) * mastersPerPage, mastersTotal) + ' of ' + mastersTotal + '</small>');

        const btns = $('<div></div>');
        btns.append('<button class="btn btn-xs btn-outline-primary mr-1" id="btnPrevPage" ' + (mastersPage === 0 ? 'disabled' : '') + '><i class="fas fa-chevron-left"></i></button>');
        btns.append('<button class="btn btn-xs btn-outline-primary" id="btnNextPage" ' + (mastersPage >= totalPages - 1 ? 'disabled' : '') + '><i class="fas fa-chevron-right"></i></button>');
        pager.append(btns);
    }

    $(document).on('click', '#btnPrevPage', function () { mastersPage--; loadMasters(); });
    $(document).on('click', '#btnNextPage', function () { mastersPage++; loadMasters(); });

    loadMasters();

    // Add master
    $('#btnAddMaster').on('click', function () {
        resetMasterModal();
        $('#modalMasterLabel').html('<i class="fas fa-file-alt mr-2"></i> New Document Record');
        $('#modalMaster').modal('show');
    });

    // Edit master
    $(document).on('click', '.btnEditMaster', function () {
        const id = $(this).data('id');
        $.getJSON(BASE + 'qms/ajax/doc/master/' + id, function (res) {
            if (!res.success) { return toastError(res.error); }
            const d = res.data;
            $('#mId').val(d.id);
            $('#mDocNumber').val(d.doc_number);
            $('#mTitle').val(d.title);
            $('#mCategory').val(d.category_id);
            $('#mDepartment').val(d.department);
            $('#mProcessOwner').val(d.process_owner);
            $('#mRetention').val(d.retention_years);
            $('#mIsActive').val(d.is_active);
            $('#modalMasterLabel').html('<i class="fas fa-edit mr-2"></i> Edit Document Record');
            $('#modalMaster').modal('show');
        }).fail(function () { toastError('Could not load record.'); });
    });

    // Save master
    $('#btnSaveMaster').on('click', function () {
        const id = $('#mId').val();
        if (!$('#mDocNumber').val().trim()) { return toastError('Document number is required.'); }
        if (!$('#mTitle').val().trim())     { return toastError('Title is required.'); }
        if (!$('#mCategory').val())         { return toastError('Category is required.'); }

        const btn = $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Saving…');

        $.ajax({
            url     : BASE + 'qms/ajax/doc/master/save',
            type    : 'POST',
            data    : {
                id             : id,
                doc_number     : $('#mDocNumber').val(),
                title          : $('#mTitle').val(),
                category_id    : $('#mCategory').val(),
                department     : $('#mDepartment').val(),
                process_owner  : $('#mProcessOwner').val(),
                retention_years: $('#mRetention').val(),
                is_active      : $('#mIsActive').val(),
            },
            dataType: 'json',
        }).done(function (res) {
            if (res.success) {
                toastSuccess(id ? 'Document updated.' : 'Document created.');
                $('#modalMaster').modal('hide');
                loadMasters();
            } else {
                toastError(res.error || 'Save failed.');
            }
        }).fail(function () {
            toastError('Request failed.');
        }).always(function () {
            btn.prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Save');
        });
    });

    // ──────────────────────────────────────────────
    // Helpers
    // ──────────────────────────────────────────────
    function resetCatModal() {
        $('#catId').val('');
        $('#fCatCode, #fCatName, #fCatDesc').val('');
        $('#fCatActive').val(1);
    }

    function resetMasterModal() {
        $('#mId').val('');
        $('#mDocNumber, #mTitle, #mDepartment, #mProcessOwner').val('');
        $('#mCategory').val('');
        $('#mRetention').val(3);
        $('#mIsActive').val(1);
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
        if (window.toastr) { toastr.success(msg); } else { alert('✔ ' + msg); }
    }
    function toastError(msg) {
        if (window.toastr) { toastr.error(msg); } else { alert('✖ ' + msg); }
    }
});
</script>
