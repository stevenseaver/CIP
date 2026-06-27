<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Label Item</title>
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

        .card-body { padding: 4mm; }

        .row {
            display: flex;
            flex-direction: row;
            gap: 2mm;
        }

        .col-left  { flex: 5; }
        .col-mid   { flex: 5; }
        .col-right { flex: 3; display: flex; flex-direction: column; align-items: center; justify-content: center; }

        p.label         { margin: 0; color: #555; font-size: 8px; }
        p.label-primary { margin: 0; color: #4e73df; font-size: 8px; }
        p.value         { color: #000; font-weight: bold; font-size: 10px; margin-bottom: 2mm; }
        p.value-primary { color: #000; font-weight: bold; font-size: 10px; margin-bottom: 2mm; }

        .desc-big {
            font-size: 18px;
            font-weight: bold;
            color: #000;
            text-align: center;
            margin-bottom: 2mm;
        }

        .qrcode img, .qrcode canvas {
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
            .card { page-break-after: always; }
            .card:last-child { page-break-after: avoid; }
        }
    </style>
</head>
<body>
    <div id="labels-container"></div>

    <script>
        // Declare all variables once, globally
        var po_id  = <?= json_encode($po_id) ?>;
        var name   = <?= json_encode($name) ?>;
        var code   = <?= json_encode($code) ?>;
        var amount = <?= json_encode($amount) ?>;
        var price  = <?= json_encode($price) ?>;
        var desc   = <?= json_encode($desc) ?>;
        var unit_satuan   = <?= json_encode($unit_satuan) ?>;
        var count  = 1; // global so buildLabel can access it

        function buildLabel(i, a) {
            return `
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-left">
                                <p class="label">PO Ref :</p>
                                <p class="value">${po_id}</p>
                                <p class="label">Item :</p>
                                <p class="value">${name}</p>
                                <p class="label">Code :</p>
                                <p class="value">${code}</p>
                                </div>
                                <div class="col-mid">
                                <p class="label">Price :</p>
                                <p class="value">IDR ${parseFloat(price).toLocaleString('id-ID', {minimumFractionDigits:2})}</p>
                                <p class="label-primary">Amount :</p>
                                <p class="value-primary">${a} ${unit_satuan}</p>
                                <p class="label">Sack/Karung :</p>
                                <p class="value">${i} of ${count}</p>
                            </div>
                            <div class="col-right">
                                <div class="desc-big">${i}</div>
                                <div class="qrcode"></div>
                                <p class="qr-label">Scan to verify</p>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }

        window.onload = function() {
            count = parseInt(desc);
            if (isNaN(count) || count < 1) count = 1;

            var amount_each = (parseFloat(amount) / count).toFixed(2);
            var labels  = '';
            var qrTexts = [];

            for (var i = 1; i <= count; i++) {
                labels += buildLabel(i, amount_each);
                qrTexts.push(code);
                // qrTexts.push(po_id + ' | ' + name + ' | ' + amount_each + ' unit | ' + i + ' of ' + count);
            }

            document.getElementById('labels-container').innerHTML = labels;

            document.querySelectorAll('.qrcode').forEach(function(el, idx) {
                new QRCode(el, {
                    text: qrTexts[idx],
                    width: 83,
                    height: 83,
                    colorDark: '#000000',
                    colorLight: '#ffffff',
                    correctLevel: QRCode.CorrectLevel.M
                });
            });

            setTimeout(function() { window.print(); }, 600);
        };
    </script>
</body>
</html>