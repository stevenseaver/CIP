<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Roll Verification — Plastik Rukun</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        body { background: #f4f6f9; font-family: Arial, sans-serif; }
        .verify-wrap { max-width: 480px; margin: 3rem auto; padding: 0 1rem; }
        .status-badge { display: inline-flex; align-items: center; gap: 6px; padding: 6px 16px; border-radius: 999px; font-size: 13px; font-weight: 600; }
        .badge-valid   { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .badge-invalid { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .badge-loading { background: #e9ecef; color: #6c757d; border: 1px solid #dee2e6; }
        .info-label { font-size: 12px; color: #6c757d; margin-bottom: 2px; }
        .info-value { font-size: 14px; font-weight: 600; color: #212529; }
        .info-value-accent { font-size: 15px; font-weight: 700; color: #0056b3; }
        .spinner-sm { width: 14px; height: 14px; border: 2px solid #ccc; border-top-color: #666; border-radius: 50%; animation: spin 0.7s linear infinite; display: inline-block; }
        @keyframes spin { to { transform: rotate(360deg); } }
    </style>
</head>
<body>
<div class="verify-wrap">
    <div class="text-center mb-4">
        <p class="text-muted mb-1" style="font-size:13px;">plastikrukun.com</p>
        <h5 class="font-weight-bold">Roll Verification</h5>
    </div>

    <div class="text-center mb-3">
        <span class="status-badge badge-loading" id="status-badge">
            <span class="spinner-sm"></span>&nbsp; Checking roll...
        </span>
    </div>

    <div id="result-area">
        <div class="card shadow-sm border-0">
            <div class="card-body text-center text-muted py-4">
                <p class="mb-0">Fetching roll data...</p>
            </div>
        </div>
    </div>
</div>

<script>
    const params = new URLSearchParams(window.location.search);
    const id     = params.get('id');
    const po     = params.get('po');

    function statusLabel(code) {
        const map = { '1': 'Pending', '2': 'In Progress', '3': 'QC Check', '4': 'Completed' };
        return map[String(code)] || 'Unknown';
    }

    function statusPill(code) {
        return code == 4
            ? '<span class="badge badge-success px-3 py-1">' + statusLabel(code) + '</span>'
            : '<span class="badge badge-warning px-3 py-1">' + statusLabel(code) + '</span>';
    }

    fetch('https://api.plastikrukun.com/verify-roll?id=' + encodeURIComponent(id) + '&po=' + encodeURIComponent(po))
        .then(r => r.json())
        .then(res => {
            const badge = document.getElementById('status-badge');
            const area  = document.getElementById('result-area');

            if (res.status === 'valid') {
                const d = res.data;
                badge.className = 'status-badge badge-valid';
                badge.innerHTML = '&#10003; Verified';

                area.innerHTML = `
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="border-bottom pb-3 mb-3">
                            <p class="info-label">Production order ref</p>
                            <p class="info-value">${d.po_id}</p>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <p class="info-label">Batch</p>
                                <p class="info-value">${d.batch}</p>
                            </div>
                            <div class="col-6 mb-3">
                                <p class="info-label">Item</p>
                                <p class="info-value">${d.name}</p>
                            </div>
                            <div class="col-6 mb-3">
                                <p class="info-label">Gramatur</p>
                                <p class="info-value">${d.gram} mic</p>
                            </div>
                            <div class="col-6 mb-3">
                                <p class="info-label">Gusset / Lipatan</p>
                                <p class="info-value">${d.guset}</p>
                            </div>
                            <div class="col-6 mb-3">
                                <p class="info-label">Net weight</p>
                                <p class="info-value-accent">${d.net_weight} kg</p>
                            </div>
                            <div class="col-6 mb-3">
                                <p class="info-label">Deskripsi</p>
                                <p class="info-value">${d.desc}</p>
                            </div>
                        </div>
                        <div class="border-top pt-3 d-flex justify-content-between align-items-center">
                            <div>
                                <p class="info-label mb-1">Status</p>
                                ${statusPill(d.status_code)}
                            </div>
                            <div class="text-right">
                                <p class="info-label mb-1">Tanggal produksi</p>
                                <p class="info-value" style="font-size:13px;">${d.created_at}</p>
                            </div>
                        </div>
                    </div>
                </div>`;

            } else {
                badge.className = 'status-badge badge-invalid';
                badge.innerHTML = '&#10007; Invalid Roll';

                area.innerHTML = `
                <div class="card shadow-sm border-danger border">
                    <div class="card-body text-center py-4">
                        <h1 class="text-danger mb-3">&#9888;</h1>
                        <p class="font-weight-bold mb-1">Roll not found</p>
                        <p class="text-muted mb-0" style="font-size:13px;">
                            ID <strong>${id}</strong> does not match any record. 
                            This label may be invalid or tampered.
                        </p>
                    </div>
                </div>`;
            }
        })
        .catch(() => {
            document.getElementById('status-badge').className = 'status-badge badge-invalid';
            document.getElementById('status-badge').innerHTML = '&#9888; Error';
            document.getElementById('result-area').innerHTML = `
                <div class="card border-warning shadow-sm">
                    <div class="card-body text-center py-4">
                        <p class="text-warning font-weight-bold mb-1">Connection error</p>
                        <p class="text-muted mb-0" style="font-size:13px;">Could not reach the verification server. Please try again.</p>
                    </div>
                </div>`;
        });
</script>
</body>
</html>