<?php
$pdf = new \TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);

$pdf->SetCreator('CIP Information System');
$pdf->SetAuthor('CIP Information System');
$pdf->SetTitle('Inventory Asset List');
$pdf->SetSubject('Asset List');
$pdf->SetKeywords('asset, inventory, usage');

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->AddPage();
$pdf->SetAutoPageBreak(true, 15);
$pdf->SetMargins(10, 10, 10);

// ════════════════════════════════════════════════════════════════════════════
// TITLE BLOCK
// ════════════════════════════════════════════════════════════════════════════
$pdf->SetFillColor(30, 64, 120);
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(0, 12, 'ASSET INVENTORY LIST', 0, 1, 'C', true);

$pdf->SetFillColor(240, 245, 255);
$pdf->SetTextColor(80, 80, 80);
$pdf->SetFont('helvetica', '', 8);
$pdf->Cell(0, 6,
    'CIP Information System  |  Generated: ' . date('d F Y, H:i') . '  |  Computerized — automatically validated.',
    0, 1, 'C', true
);

$pdf->Ln(4);

// ════════════════════════════════════════════════════════════════════════════
// TABLE HEADER
// ════════════════════════════════════════════════════════════════════════════
$colW = [7, 26, 34, 22, 18, 34, 64, 28, 18, 16, 10];

$pdf->SetFillColor(30, 64, 120);
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFont('helvetica', 'B', 7);
$pdf->SetDrawColor(200, 210, 230);
$pdf->SetLineWidth(0.3);

$headers = ['No', 'Code', 'Asset Name', "Date\nAcquired", 'Position', 'User',
            'Specifications / Description', 'Value (IDR)', 'Status', 'QR', 'Cek'];

foreach ($headers as $k => $h) {
    $pdf->MultiCell($colW[$k], 9, $h, 1, 'C', true, 0);
}
$pdf->Ln();

// ════════════════════════════════════════════════════════════════════════════
// TABLE ROWS
// ════════════════════════════════════════════════════════════════════════════
$inventory = $this->db->get('inventory_asset')->result();

$pdf->SetFont('helvetica', '', 7);
$pdf->SetTextColor(40, 40, 40);

$grandTotal       = 0;
$totalActive      = 0;
$totalMaintenance = 0;
$totalActiveAndMaintenance = 0;
$i = 0;

foreach ($inventory as $data) {
    $i++;

    // Accumulate totals
    $grandTotal += $data->value;
    if (strtolower(trim($data->status)) === '1') {
        $totalActive += $data->value;
    }
    if (strtolower(trim($data->status)) === '2') {
        $totalMaintenance += $data->value;
    }
    if (in_array(strtolower(trim($data->status)), ['1', '2'])) {
        $totalActiveAndMaintenance += $data->value;
    }

    // Alternating row background
    if ($i % 2 === 0) {
        $pdf->SetFillColor(232, 240, 254);
    } else {
        $pdf->SetFillColor(255, 255, 255);
    }

    $rowH   = 14;
    $xStart = $pdf->GetX();
    $yStart = $pdf->GetY();

    if ($yStart + $rowH > ($pdf->getPageHeight() - 15)) {
        $pdf->AddPage();
        $yStart = $pdf->GetY();
        $xStart = $pdf->GetX();
    }

    $fill = true;

    $cell = function($w, $txt, $align = 'L') use ($pdf, $rowH, $fill) {
        $pdf->MultiCell($w, $rowH, $txt, 1, $align, $fill, 0, '', '', true,
                        0, false, true, $rowH, 'M');
    };

    $cell($colW[0], $i,                                           'C');
    $cell($colW[1], $data->code,                                  'L');
    $cell($colW[2], $data->name,                                  'L');
    $cell($colW[3], $data->date_in,                               'C');
    $cell($colW[4], $data->position,                              'C');
    $cell($colW[5], $data->user,                                  'L');
    $cell($colW[6], $data->spec,                                  'L');
    $cell($colW[7], number_format($data->value, 2, ',', '.'),     'R');

    // Status with colour
    $statusLower = strtolower(trim($data->status));
    if ($statusLower === 'active') {
        $pdf->SetTextColor(0, 153, 76);
    } elseif ($statusLower === 'maintenance') {
        $pdf->SetTextColor(200, 120, 0);
    } else {
        $pdf->SetTextColor(180, 60, 60);
    }
    $cell($colW[8], $data->status, 'C');
    $pdf->SetTextColor(40, 40, 40);

    // QR Code cell
    $qrX = $pdf->GetX();
    $qrY = $yStart;
    $pdf->Cell($colW[9], $rowH, '', 1, 0, 'C', $fill);

    $qrFile = APPPATH . '../asset/img/QRcode/' . $data->code . '.png';
    if (file_exists($qrFile)) {
        $imgSize = $rowH - 2;
        $imgX    = $qrX + ($colW[9] - $imgSize) / 2;
        $imgY    = $qrY + 1;
        $pdf->Image($qrFile, $imgX, $imgY, $imgSize, $imgSize, 'PNG');
    }

    $pdf->Cell($colW[10], $rowH, '', 1, 1, 'C', $fill);
}

// ════════════════════════════════════════════════════════════════════════════
// SUMMARY TOTALS BLOCK
// ════════════════════════════════════════════════════════════════════════════
$pdf->Ln(2);

// Column layout for summary: label col + value col, right-aligned to match table
$labelW = array_sum(array_slice($colW, 0, 7));  // same as data label area
$valueW = $colW[7];
$restW  = array_sum(array_slice($colW, 8));

// ── Row 1: Active only ───────────────────────────────────────────────────────
$pdf->SetFillColor(230, 247, 237);           // soft green tint
$pdf->SetTextColor(0, 120, 60);
$pdf->SetFont('helvetica', '', 7.5);
$pdf->Cell($labelW, 7,
    'Total Value — Active Assets',
    'LTB', 0, 'R', true
);
$pdf->SetFont('helvetica', 'B', 7.5);
$pdf->Cell($valueW, 7,
    number_format($totalActive, 2, ',', '.'),
    1, 0, 'R', true
);
$pdf->Cell($restW, 7, '', 'RTB', 1, 'C', true);

// ── Row 2: Active + Maintenance ──────────────────────────────────────────────
$pdf->SetFillColor(255, 248, 225);           // soft amber tint
$pdf->SetTextColor(160, 90, 0);
$pdf->SetFont('helvetica', '', 7.5);
$pdf->Cell($labelW, 7,
    'Total Value — Active + Maintenance Assets',
    'LTB', 0, 'R', true
);
$pdf->SetFont('helvetica', 'B', 7.5);
$pdf->Cell($valueW, 7,
    number_format($totalActiveAndMaintenance, 2, ',', '.'),
    1, 0, 'R', true
);
$pdf->Cell($restW, 7, '', 'RTB', 1, 'C', true);

// ── Row 3: Grand Total (all statuses) ────────────────────────────────────────
$pdf->SetFillColor(30, 64, 120);             // navy — matches header
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->Cell($labelW, 8,
    'GRAND TOTAL — All Assets',
    'LTB', 0, 'R', true
);
$pdf->Cell($valueW, 8,
    number_format($grandTotal, 2, ',', '.'),
    1, 0, 'R', true
);
$pdf->Cell($restW, 8, '', 'RTB', 1, 'C', true);

// ════════════════════════════════════════════════════════════════════════════
// FOOTER NOTE
// ════════════════════════════════════════════════════════════════════════════
$pdf->Ln(3);
$pdf->SetTextColor(120, 120, 120);
$pdf->SetFont('helvetica', 'I', 7);
$pdf->Cell(0, 6,
    '★ Computerized report — automatically validated. Unauthorized alteration is prohibited.',
    0, 1, 'L'
);

$pdf->Output('Laporan_Inventory.pdf', 'I');