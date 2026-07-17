<?php
// Normalize input: bulk print passes $items (array of arrays).
// Single-row print (existing flow) passes individual vars — wrap them into the same shape.
if (!isset($items) || !is_array($items)) {
    $items = [[
        'id'     => $id,
        'po_id'  => $po_id,
        'batch'  => $batch,
        'name'   => $name,
        'code'   => $code,
        'gram'   => $gram,
        'guset'  => $guset,
        'amount' => $amount,
        'desc'   => $desc,
    ]];
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Label Roll</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        @page {
            size: 80mm 50mm;
            margin: 3mm;
        }

        body {
            width: 80mm;
            font-family: Arial, sans-serif;
            font-size: 10px;
            background: #fff;
        }

        .page {
            padding: 3mm;
            page-break-after: always;
        }
        .page:last-child {
            page-break-after: auto;
        }

        .card {
            border: 1px solid #dee2e6;
            border-radius: 6px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .card-body { padding: 4mm; }

        .row {
            display: flex;
            flex-direction: row;
            gap: 2mm;
        }

        .col-left  { flex: 5; }
        .col-mid   { flex: 5; }
        .col-right { flex: 3; display: flex; flex-direction: column; align-items: center; justify-content: center; }

        p.label, p.label-primary {
            margin: 0;
            font-size: 8px;
        }
        p.label { color: #555; }
        p.label-primary { color: #4e73df; }

        p.value, p.value-primary {
            color: #000;
            font-weight: bold;
            font-size: 10px;
            margin-bottom: 2mm;
        }

        .desc-big {
            font-size: 18px;
            font-weight: bold;
            color: #000;
            text-align: center;
            margin-bottom: 2mm;
        }

        .qrcode-box img, .qrcode-box canvas {
            width: 22mm !important;
            height: 22mm !important;
        }

        .qr-label {
            font-size: 7px;
            color: #777;
            text-align: center;
            margin-top: 1mm;
        }

        @media print {
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }
    </style>
</head>
<body>
    <?php foreach ($items as $idx => $it) : ?>
    <div class="page">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-left">
                        <p class="label">Prod Order Ref :</p>
                        <p class="value"><?= htmlspecialchars($it['po_id']) ?></p>

                        <p class="label">Batch :</p>
                        <p class="value"><?= htmlspecialchars($it['batch']) ?></p>

                        <p class="label">Item :</p>
                        <p class="value"><?= htmlspecialchars($it['name']) ?></p>

                        <p class="label">Code :</p>
                        <p class="value"><?= htmlspecialchars($it['code']) ?></p>
                    </div>

                    <div class="col-mid">
                        <p class="label">Gramatur :</p>
                        <p class="value"><?= htmlspecialchars($it['gram']) ?></p>

                        <p class="label">Gusset / Lipatan :</p>
                        <p class="value"><?= htmlspecialchars($it['guset']) ?></p>

                        <p class="label-primary">Net Amount :</p>
                        <p class="value-primary"><?= htmlspecialchars($it['amount']) ?> kg</p>

                        <p class="label">Nomor roll :</p>
                        <p class="value"><?= htmlspecialchars($it['desc']) ?></p>
                    </div>

                    <div class="col-right">
                        <div class="desc-big"><?= htmlspecialchars($it['desc']) ?></div>
                        <div class="qrcode-box" id="qrcode-<?= $idx ?>"></div>
                        <p class="qr-label">Scan to verify</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>

    <script>
        var items = <?= json_encode($items) ?>;

        items.forEach(function (it, idx) {
            var qrContent = encodeURIComponent(it.id) + '&' + encodeURIComponent(it.po_id) + '&' + encodeURIComponent(it.code);
            new QRCode(document.getElementById('qrcode-' + idx), {
                text: qrContent,
                width: 83,
                height: 83,
                colorDark: '#000000',
                colorLight: '#ffffff',
                correctLevel: QRCode.CorrectLevel.M
            });
        });

        // Auto print once all QR codes are rendered — scale the wait with item count
        window.onload = function () {
            var delay = Math.min(600 + items.length * 60, 3000);
            setTimeout(function () {
                window.print();
            }, delay);
        };
    </script>
</body>
</html>