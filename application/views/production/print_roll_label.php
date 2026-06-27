<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Label Roll</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        @page {
            size: 100mm 80mm;
            margin: 3mm;
        }

        body {
            width: 100mm;
            font-family: Arial, sans-serif;
            font-size: 10px;
            padding: 3mm;
            background: #fff;
        }

        .card {
            border: 1px solid #dee2e6;
            border-radius: 6px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .card-body {
            padding: 4mm;
        }

        .row {
            display: flex;
            flex-direction: row;
            gap: 2mm;
        }

        .col-left  { flex: 5; }
        .col-mid   { flex: 5; }
        .col-right { flex: 3; display: flex; flex-direction: column; align-items: center; justify-content: center; }

        p.label {
            margin: 0;
            color: #555;
            font-size: 8px;
        }

        p.value {
            color: #000;
            font-weight: bold;
            font-size: 10px;
            margin-bottom: 2mm;
        }

        p.value-primary {
            color: #000;
            font-weight: bold;
            font-size: 10px;
            margin-bottom: 2mm;
        }

        p.label-primary { 
            margin: 0; 
            color: #4e73df; 
            font-size: 8px; 
        }

        .desc-big {
            font-size: 18px;
            font-weight: bold;
            color: #000;
            text-align: center;
            margin-bottom: 2mm;
        }

        #qrcode img, #qrcode canvas {
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
    <div class="card">
        <div class="card-body">
            <div class="row">
                <!-- LEFT -->
                <div class="col-left">
                    <p class="label">Prod Order Ref :</p>
                    <p class="value"><?= htmlspecialchars($po_id) ?></p>

                    <p class="label">Batch :</p>
                    <p class="value"><?= htmlspecialchars($batch) ?></p>

                    <p class="label">Item :</p>
                    <p class="value"><?= htmlspecialchars($name) ?></p>

                    <p class="label">Code :</p>
                    <p class="value"><?= htmlspecialchars($code) ?></p>
                </div>

                <!-- MID -->
                <div class="col-mid">
                    <p class="label">Gramatur :</p>
                    <p class="value"><?= htmlspecialchars($gram) ?></p>

                    <p class="label">Gusset / Lipatan :</p>
                    <p class="value"><?= htmlspecialchars($guset) ?></p>

                    <p class="label-primary">Net Amount :</p>
                    <p class="value-primary"><?= htmlspecialchars($amount) ?> kg</p>

                    <p class="label">Nomor roll :</p>
                    <p class="value"><?= htmlspecialchars($desc) ?></p>
                </div>

                <!-- RIGHT: desc big + QR -->
                <div class="col-right">
                    <div class="desc-big"><?= htmlspecialchars($desc) ?></div>
                    <div id="qrcode"></div>
                    <p class="qr-label">Scan to verify</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        var rollId  = <?= json_encode($id) ?>;
        var poId    = <?= json_encode($po_id) ?>;
        var apiUrl  = 'https://api.plastikrukun.com/api/verify_roll?id=' + encodeURIComponent(rollId) + '&po=' + encodeURIComponent(poId);

        new QRCode(document.getElementById('qrcode'), {
            text: apiUrl,
            width: 83,   // ~22mm at 96dpi
            height: 83,
            colorDark: '#000000',
            colorLight: '#ffffff',
            correctLevel: QRCode.CorrectLevel.M
        });

        // Auto print once QR is rendered
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 600);
        };
    </script>
</body>
</html>