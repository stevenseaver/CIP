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
        .info-label { font-size: 12px; color: #6c757d; margin-bottom: 2px; }
        .info-value { font-size: 14px; font-weight: 600; color: #212529; margin-bottom: 0; }
        .info-value-accent { font-size: 15px; font-weight: 700; color: #0056b3; margin-bottom: 0; }
    </style>
</head>
<body>
<div class="verify-wrap">

    <div class="text-center mb-4">
        <p class="text-muted mb-1" style="font-size:13px;">plastikrukun.com</p>
        <h5 class="font-weight-bold">Roll Verification</h5>
    </div>

    <?php if ($error === 'missing'): ?>

        <div class="alert alert-warning text-center">
            <strong>Invalid link.</strong> Missing roll ID or PO parameter.
        </div>

    <?php elseif ($error === '429TMR'): ?>

        <div class="alert alert-warning text-center">
            <strong>Invalid link.</strong> Too much request!
        </div>

    <?php elseif ($error === 'not_found'): ?>

        <div class="text-center mb-3">
            <span class="badge badge-danger px-3 py-2" style="font-size:14px;">
                &#10007; Invalid Roll
            </span>
        </div>
        <div class="card border-danger shadow-sm">
            <div class="card-body text-center py-4">
                <h1 class="text-danger mb-3">&#9888;</h1>
                <p class="font-weight-bold mb-1">Roll not found</p>
                <p class="text-muted mb-0" style="font-size:13px;">
                    This label does not match any record.<br>
                    It may be invalid or tampered.
                </p>
            </div>
        </div>

    <?php else: ?>

         <?php
            $status_map = ['3' => 'Roll produced', '9' => 'Roll Cut'];
            $status_label = isset($status_map[$roll['status']]) ? $status_map[$roll['status']] : 'Unknown';
            $status_class = $roll['status'] == 9 ? 'badge-success' : 'badge-warning';
        ?>

        <div class="text-center mb-3">
            <span class="badge badge-success px-3 py-2" style="font-size:14px;">
                &#10003; Verified
            </span>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">

                <div class="border-bottom pb-3 mb-3">
                    <p class="info-label">Production Order Ref</p>
                    <p class="info-value"><?= htmlspecialchars($roll['transaction_id']) ?></p>
                </div>

                <div class="row">
                    <div class="col-6 mb-3">
                        <p class="info-label">Batch</p>
                        <p class="info-value"><?= htmlspecialchars($roll['batch']) ?></p>
                    </div>
                    <div class="col-6 mb-3">
                        <p class="info-label">Item</p>
                        <p class="info-value"><?= htmlspecialchars($roll['name']) ?></p>
                    </div>
                    <div class="col-6 mb-3">
                        <p class="info-label">Gramatur</p>
                        <p class="info-value"><?= htmlspecialchars($roll['weight']) ?> mic</p>
                    </div>
                    <div class="col-6 mb-3">
                        <p class="info-label">Gusset / Lipatan</p>
                        <p class="info-value"><?= htmlspecialchars($roll['lipatan']) ?></p>
                    </div>
                    <div class="col-6 mb-3">
                        <p class="info-label">Net Weight</p>
                        <p class="info-value-accent"><?= htmlspecialchars($roll['incoming']) ?> kg</p>
                    </div>
                    <div class="col-6 mb-3">
                        <p class="info-label">Deskripsi</p>
                        <p class="info-value"><?= htmlspecialchars($roll['transaction_desc']) ?></p>
                    </div>
                </div>

                <div class="border-top pt-3 d-flex justify-content-between align-items-center">
                    <div>
                        <p class="info-label mb-1">Status</p>
                        <span class="badge <?= $status_class ?> px-3 py-1"><?= $status_label ?></span>
                    </div>
                    <div class="text-right">
                        <p class="info-label mb-1">Tanggal Produksi</p>
                        <p class="info-value" style="font-size:13px;"><?= date('d F Y H:i:s', $roll['date']) ?></p>
                    </div>
                </div>

            </div>
        </div>

    <?php endif; ?>

</div>
</body>
</html>