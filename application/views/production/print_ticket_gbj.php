<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Label GBJ</title>
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
        var desc       = <?= json_encode($desc) ?>;
        var trans_id   = <?= json_encode($trans_id) ?>;
        var prod_id    = <?= json_encode($prod_id) ?>;
        var batch      = <?= json_encode($batch) ?>;
        var item       = <?= json_encode($item) ?>;
        var net_weight = <?= json_encode($net_weight) ?>;
        var amount     = <?= json_encode($amount) ?>;

        function parseDesc(desc) {
            var match = desc.match(/^(\d+)-(\d+)$/);
            if (match) {
                var start = parseInt(match[1]);
                var end   = parseInt(match[2]);
                return { start: start, end: end };
            }
            var single = parseInt(desc);
            if (!isNaN(single)) {
                return { start: single, end: single };
            }
            return { start: null, end: null };
        }

        function buildLabel(currentDesc, w, a) {
            return `
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-left">
                                <p class="label">Prod Order Ref :</p>
                                <p class="value">${prod_id}</p>
                                <p class="label">Batch :</p>
                                <p class="value">${batch}</p>
                                <p class="label">Item :</p>
                                <p class="value">${item}</p>
                            </div>
                            <div class="col-mid">
                                <p class="label-primary">Net Weight :</p>
                                <p class="value-primary">${w} kg</p>
                                <p class="label-primary">Pack Amount :</p>
                                <p class="value-primary">${a} pack</p>
                                <p class="label">Sack No. :</p>
                                <p class="value">${currentDesc}</p>
                            </div>
                            <div class="col-right">
                                <div class="desc-big">${currentDesc}</div>
                                <div class="qrcode"></div>
                                <p class="qr-label">Scan to verify</p>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }

        window.onload = function() {
            var parsed  = parseDesc(desc);
            var labels  = '';
            var qrTexts = [];

            if (parsed.start === null) {
                // Non-numeric — single label, no division needed
                labels += buildLabel(desc, net_weight, amount);
                // qrTexts.push(prod_id + ' | ' + batch + ' | ' + item + ' | ' + net_weight + 'kg | ' + amount + 'pack | ' + desc);
                qrTexts.push(`https://api.plastikrukun.com/api/verify_gbj?id=${encodeURIComponent(trans_id)}&po=${encodeURIComponent(prod_id)}`);
            } else {
                var count          = (parsed.end - parsed.start) + 1;
                var weight_each    = (parseFloat(net_weight) / count).toFixed(2);
                var amount_each    = (parseFloat(amount) / count).toFixed(2);

                for (var i = parsed.start; i <= parsed.end; i++) {
                    labels += buildLabel(i, weight_each, amount_each);
                    qrTexts.push(`https://api.plastikrukun.com/api/verify_gbj?id=${encodeURIComponent(trans_id)}&po=${encodeURIComponent(prod_id)}`);
                }
            }

            document.getElementById('labels-container').innerHTML = labels;

            var qrEls = document.querySelectorAll('.qrcode');
            qrEls.forEach(function(el, idx) {
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