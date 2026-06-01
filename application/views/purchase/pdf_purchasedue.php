<?php
$pdf = new \TCPDF();

$pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8');
$pdf->SetCreator('YourApp');
$pdf->SetTitle('Accounts Payable Due');
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetMargins(10, 10, 10);
$pdf->AddPage();

// ── Title ──────────────────────────────────────────────
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(0, 10, 'Accounts Payable Due', 0, 1, 'C');
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(0, 6, 'Up to: ' . date('d F Y', $end_date), 0, 1, 'C');
$pdf->Ln(4);

// ── Table Header ───────────────────────────────────────
$pdf->SetFillColor(41, 128, 185);
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFont('helvetica', 'B', 9);

$pdf->Cell(30, 8, 'Date',           1, 0, 'C', true);
$pdf->Cell(40, 8, 'Transaction ID', 1, 0, 'C', true);
$pdf->Cell(40, 8, 'Supplier',       1, 0, 'C', true);
$pdf->Cell(50, 8, 'Product',        1, 0, 'C', true);
$pdf->Cell(20, 8, 'Qty (kg)',       1, 0, 'C', true);
$pdf->Cell(20, 8, 'Qty (other)',    1, 0, 'C', true);
$pdf->Cell(30, 8, 'Price',          1, 0, 'C', true);
$pdf->Cell(47, 8, 'Subtotal',       1, 1, 'C', true);

// ── Running Totals ─────────────────────────────────────
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('helvetica', '', 8);

$fill           = false;
$grand_total    = 0;
$total_kg       = 0;
$total_other    = 0;
$current_tid    = null;
$tid_subtotal   = 0;

foreach ($rows as $i => $row) {
    $is_new_transaction = ($row['transaction_id'] !== $current_tid);
    $next_tid           = isset($rows[$i + 1]) ? $rows[$i + 1]['transaction_id'] : null;
    $is_last_in_group   = ($next_tid !== $row['transaction_id']);

    // ── Transaction group header ───────────────────────
    if ($is_new_transaction) {
        $current_tid  = $row['transaction_id'];
        $tid_subtotal = 0;

        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->SetFillColor(213, 232, 250);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(277, 6,
            $row['transaction_id'] . '   |   ' . $row['supplier_name'] . '   |   ' . date('d F Y', $row['date']),
            1, 1, 'L', true
        );
        $pdf->SetFont('helvetica', '', 8);
    }

    // ── Row ────────────────────────────────────────────
    $line_total = $row['incoming'] * $row['price'];
    $tid_subtotal  += $line_total;
    $grand_total   += $line_total;

    if ($row['unit_satuan'] == 'kg') {
        $total_kg    += $row['incoming'];
    } else {
        $total_other += $row['incoming'];
    }

    $pdf->SetFillColor(245, 250, 255);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(30, 6, date('d/m/Y', $row['date']),                         1, 0, 'L', $fill);
    $pdf->Cell(40, 6, $row['transaction_id'],                               1, 0, 'L', $fill);
    $pdf->Cell(40, 6, $row['supplier_name'],                                1, 0, 'L', $fill);
    $pdf->Cell(50, 6, $row['name'],                                         1, 0, 'L', $fill);
    $pdf->Cell(20, 6, $row['unit_satuan'] == 'kg'
                        ? number_format($row['incoming'], 2, ',', '.')
                        : '-',                                               1, 0, 'R', $fill);
    $pdf->Cell(20, 6, $row['unit_satuan'] != 'kg'
                        ? number_format($row['incoming'], 2, ',', '.')
                        : '-',                                               1, 0, 'R', $fill);
    $pdf->Cell(30, 6, number_format($row['price'], 2, ',', '.'),            1, 0, 'R', $fill);
    $pdf->Cell(47, 6, number_format($line_total, 2, ',', '.'),              1, 1, 'R', $fill);

    $fill = !$fill;

    // ── Transaction subtotal row ───────────────────────
    if ($is_last_in_group) {
        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->SetFillColor(190, 220, 245);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(230, 6, 'Subtotal — ' . $current_tid,   1, 0, 'R', true);
        $pdf->Cell(47,  6, number_format($tid_subtotal, 2, ',', '.'), 1, 1, 'R', true);
        $pdf->SetFont('helvetica', '', 8);
        $pdf->Ln(1);
    }
}

// ── Summary Footer ─────────────────────────────────────
$pdf->Ln(3);
$pdf->SetFont('helvetica', 'B', 9);
$pdf->SetFillColor(47, 128, 185);
$pdf->SetTextColor(255, 255, 255);

$pdf->Cell(230, 8, 'Total Qty (kg)',                            1, 0, 'R', true);
$pdf->Cell(47,  8, number_format($total_kg, 2, ',', '.'),       1, 1, 'L', true);
$pdf->Cell(230, 8, 'Total Qty (other unit)',                    1, 0, 'R', true);
$pdf->Cell(47,  8, number_format($total_other, 2, ',', '.'),    1, 1, 'L', true);

$pdf->SetFillColor(23, 97, 148);
$pdf->Cell(230, 8, 'GRAND TOTAL',                               1, 0, 'R', true);
$pdf->Cell(47,  8, number_format($grand_total, 2, ',', '.'),    1, 1, 'R', true);

// ── Output ─────────────────────────────────────────────
$pdf->Output('AccountsPayable_' . date('Ymd', $end_date) . '.pdf', 'I');