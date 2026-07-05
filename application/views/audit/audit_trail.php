    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
            <!-- Begin Page Content -->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg">
                        <div class="card shadow border-left-primary mb-4">
                            <div class="card-header py-2">
                                <h5 class="m-0 font-weight-bold text-primary">Audit</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="auditTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th>User ID</th>
                                                <th>Username</th>
                                                <th>Action</th>
                                                <th>Table Name</th>
                                                <th>Row Affected</th>
                                                <th>Reference</th>
                                                <th>IP Address</th>
                                                <th>Timestamps</th>
                                                <th class="text-center">Details</th>
                                            </tr>
                                        </thead>
                                        <tbody><!-- populated by DataTables via AJAX --></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- End of Main Content -->
    </div>
</div>

<!-- Details Modal: state_before / state_after are fetched on demand
     here, so the paginated list payload never has to carry that long
     text for every row on every page turn. -->
<div class="modal fade" id="auditDetailModal" tabindex="-1" role="dialog" aria-labelledby="auditDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="auditDetailModalLabel">Audit Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="auditDetailLoading" class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <dl class="row d-none" id="auditDetailBody">
                    <dt class="col-sm-3">Username</dt>
                    <dd class="col-sm-9" id="detailUsername"></dd>

                    <dt class="col-sm-3">Action</dt>
                    <dd class="col-sm-9" id="detailAction"></dd>

                    <dt class="col-sm-3">Table</dt>
                    <dd class="col-sm-9" id="detailTable"></dd>

                    <dt class="col-sm-3">Row Affected</dt>
                    <dd class="col-sm-9" id="detailRow"></dd>

                    <dt class="col-sm-3">Reference</dt>
                    <dd class="col-sm-9" id="detailReference"></dd>

                    <dt class="col-sm-3">State Before</dt>
                    <dd class="col-sm-9"><pre class="mb-0" id="detailStateBefore" style="white-space: pre-wrap; word-break: break-word;"></pre></dd>

                    <dt class="col-sm-3">State After</dt>
                    <dd class="col-sm-9"><pre class="mb-0" id="detailStateAfter" style="white-space: pre-wrap; word-break: break-word;"></pre></dd>

                    <dt class="col-sm-3">IP Address</dt>
                    <dd class="col-sm-9" id="detailIp"></dd>

                    <dt class="col-sm-3">Timestamp</dt>
                    <dd class="col-sm-9" id="detailCreatedAt"></dd>
                </dl>
                <div id="auditDetailError" class="alert alert-danger d-none" role="alert"></div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    var table = $('#auditTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '<?= base_url('audit/trailData') ?>',
            type: 'GET',
        },
        order: [[8, 'desc']], // Timestamps column, desc — matches created_at index
        pageLength: 25,
        lengthMenu: [10, 25, 50, 100],
        columns: [
            { data: 'no',           orderable: false },
            { data: 'user_id' },
            { data: 'username' },
            { data: 'action',       orderable: false },
            { data: 'table_name' },
            { data: 'row',          orderable: false },
            { data: 'reference',    orderable: false },
            { data: 'ip_address' },
            { data: 'created_at' },
            {
                data: 'id',
                orderable: false,
                searchable: false,
                render: function (id) {
                    return '<button type="button" class="btn btn-sm btn-outline-primary audit-view-btn" data-id="' + id + '">View</button>';
                }
            },
        ],
    });

    // Fetch and show full details only when the user asks for them.
    $('#auditTable tbody').on('click', '.audit-view-btn', function () {
        var id = $(this).data('id');

        $('#auditDetailBody').addClass('d-none');
        $('#auditDetailError').addClass('d-none');
        $('#auditDetailLoading').removeClass('d-none');
        $('#auditDetailModal').modal('show');

        $.ajax({
            url: '<?= base_url('audit/trailDetail') ?>/' + id,
            type: 'GET',
            dataType: 'json',
        }).done(function (resp) {
            var d = resp.data;
            $('#detailUsername').text(d.username);
            $('#detailAction').text(d.action);
            $('#detailTable').text(d.table_name);
            $('#detailRow').text(d.row);
            $('#detailReference').text(d.reference);
            $('#detailStateBefore').text(d.state_before);
            $('#detailStateAfter').text(d.state_after);
            $('#detailIp').text(d.ip_address);
            $('#detailCreatedAt').text(d.created_at);

            $('#auditDetailLoading').addClass('d-none');
            $('#auditDetailBody').removeClass('d-none');
        }).fail(function () {
            $('#auditDetailLoading').addClass('d-none');
            $('#auditDetailError').removeClass('d-none').text('Could not load this audit entry. Please try again.');
        });
    });
});
</script>
