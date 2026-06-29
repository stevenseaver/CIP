<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Finished Goods Verification — Plastik Rukun</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        body { background: #f4f6f9; font-family: Arial, sans-serif; }
        .verify-wrap { max-width: 480px; margin: 2rem auto; padding: 0 1rem; }
        .field-label { font-size: 11px; color: #6c757d; margin-bottom: 2px; }
        .field-value { font-size: 14px; font-weight: 600; color: #212529; margin-bottom: 0; }
        .field-value-accent { font-size: 15px; font-weight: 700; color: #0056b3; margin-bottom: 0; }
    </style>
</head>
<body>
<div class="verify-wrap">

    <div class="text-center mb-4">
        <p class="text-muted mb-1" style="font-size:12px;">plastikrukun.com</p>
        <h5 class="font-weight-bold mb-0">Finished goods verification</h5>
    </div>

    <?php if ($error === 'missing'): ?>

        <div class="alert alert-warning text-center">
            <strong>Invalid link.</strong> Missing roll ID or PO parameter.
        </div>

    <?php elseif ($error === '429TMR'): ?>

        <div class="alert alert-warning text-center">
            Too many requests. Please try again shortly.
        </div>

    <?php elseif ($error === 'not_found'): ?>

        <div class="alert alert-danger text-center">
            <strong>Invalid roll.</strong><br>
            <small>This label doesn't match any record. It may be invalid or tampered.</small>
        </div>

    <?php else:
        $status_map = [
            '1' => ['label' => 'Weighted / not yet converted', 'class' => 'badge-primary'],
            '2' => ['label' => 'Converted to pack',           'class' => 'badge-success'],
        ];
        $status = $status_map[$gbj['transaction_status']] ?? ['label' => 'Unknown', 'class' => 'badge-secondary'];

        $raw = $gbj['description'];
        if (strpos($raw, '-') !== false) {
            [$start, $end] = explode('-', $raw);
            $sack_amount = (int)$end - (int)$start + 1;
        } else {
            $sack_amount = 1;
        }
        $net_weight = $gbj['before_convert'] / $sack_amount;
    ?>

        <div class="mb-3 text-center">
            <span class="badge badge-success px-3 py-2" style="font-size:13px;">&#10003; Verified</span>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">

                <p class="field-label">Production order ref</p>
                <p class="field-value mb-3"><?= htmlspecialchars($gbj['transaction_id']) ?></p>

                <hr class="my-3">

                <div class="row">
                    <div class="col-6 mb-3">
                        <p class="field-label">Item</p>
                        <p class="field-value"><?= htmlspecialchars($gbj['name']) ?></p>
                    </div>
                    <div class="col-6 mb-3">
                        <p class="field-label">Code</p>
                        <p class="field-value"><?= htmlspecialchars($gbj['code']) ?></p>
                    </div>
                    <div class="col-6 mb-3">
                        <p class="field-label">Batch</p>
                        <p class="field-value"><?= htmlspecialchars($gbj['batch']) ?></p>
                    </div>
                    <div class="col-6 mb-3">
                        <p class="field-label">Part of batched sack</p>
                        <p class="field-value"><?= htmlspecialchars($gbj['description']) ?></p>
                    </div>
                    <div class="col-6 mb-3">
                        <p class="field-label">Total Batch weight</p>
                        <p class="field-value"><?= htmlspecialchars($gbj['before_convert']) ?> kg</p>
                    </div>
                    <div class="col-6 mb-3">
                        <p class="field-label">Average weight/sack</p>
                        <p class="field-value-accent"><?= number_format($net_weight, 2) ?> kg</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6 mb-3">
                        <p class="field-label">Amount Produced</p>
                        <p class="field-value"><?= htmlspecialchars($gbj['incoming']) ?></p>
                    </div>
                    <div class="col-6 mb-3">
                        <p class="field-label">Unit of measurements</p>
                        <p class="field-value"><?= htmlspecialchars($gbj['unit_satuan']) ?></p>
                    </div>
                </div>

                <hr class="my-3">

                <p class="field-label">Picture (if exist)</p>
                <p class="field-value mb-3" style="font-size:13px;font-weight:400;color:#495057;">
                    <img class="img-fluid rounded" src="<?= 'https://plastikrukun.com/' . htmlspecialchars($gbj['picture']) ?>" alt="Product Image" style="width: 15rem;"><?= htmlspecialchars($gbj['picture'])?>
                </p>

                <hr class="my-3">

                <div class="d-flex justify-content-between align-items-end">
                    <div>
                        <p class="field-label mb-1">Status</p>
                        <span class="badge <?= $status['class'] ?> px-3 py-1"><?= $status['label'] ?></span>
                    </div>
                    <div class="text-right">
                        <p class="field-label mb-1">Production date</p>
                        <p class="field-value" style="font-size:13px;"><?= date('d F Y', $gbj['date']) ?></p>
                    </div>
                </div>

            </div>
        </div>

    <?php endif; ?>

</div>
</body>
</html>