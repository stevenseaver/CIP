<?php
$pdf = new \TCPDF();

// set document information
$pdf->SetCreator('comp');
$pdf->SetAuthor('CIP Information System');
$pdf->SetTitle('Production Report');
$pdf->SetSubject('Material List');
$pdf->SetKeywords('production, report, inventory');

$pdf->AddPage('P', 'mm', 'A4');
$pdf->SetFont('', 'B', 11);
$pdf->Cell(187, 10, "Production Report", 0, 1, 'C');
$pdf->SetAutoPageBreak(true, 0);

// Add Header
$pdf->SetFont('', '', 8);
$pdf->Cell(20, 2, 'Production ID', 0, 0, 'L');
$pdf->Cell(257, 2, $getID['transaction_id'], 0, 1, 'L');
$pdf->Cell(20, 2, 'Date', 0, 0, 'L');
$pdf->Cell(277, 2, date('d F Y H:i:s', $getID['date']), 0, 1, 'L');
$pdf->Cell(20, 2, 'Product', 0, 0, 'L');
$pdf->Cell(277, 2, $getID['product_name'], 0, 1, 'L');
$pdf->Cell(20, 2, 'Batch', 0, 0, 'L');
$pdf->Cell(277, 2, $getID['description'], 0, 1, 'L');

$pdf->Cell(8, 8, "No", 1, 0, 'C');
$pdf->Cell(60, 8, "Item", 1, 0, 'C');
$pdf->Cell(35, 8, "Amount", 1, 0, 'C');
$pdf->Cell(25, 8, "Price", 1, 0, 'C');
$pdf->Cell(25, 8, "Subtotal", 1, 0, 'C');
$pdf->Cell(20, 8, "Mix Amount", 1, 0, 'C');
$pdf->Cell(20, 8, "Formula", 1, 1, 'C');
$pdf->SetFont('', '', 8);

$i = 1;
$temp = 0;
$temp_weight = 0;
$total_value = 0;
$total_weight = 0;

foreach ($inventory_selected as $ms) {
    if ($ms['transaction_id'] != $po_id) {
        continue;
    } else {
    }
    $subtotal = $ms['outgoing'] * $ms['price'];
    $formula = $ms['outgoing']/($ms['item_desc']*10);
    $pdf->Cell(8, 7, $i, 1, 0, 'C');
    $pdf->Cell(60, 7, $ms['name'], 1, 0);
    $pdf->Cell(35, 7, number_format($ms['outgoing'], 2, ',', '.') .' ' . $ms['unit_satuan'], 1, 0);
    $pdf->Cell(25, 7, number_format($ms['price'], 2, ',', '.'), 1, 0);
    $pdf->Cell(25, 7, number_format($subtotal, 2, ',', '.'), 1, 0);
    $pdf->Cell(20, 7, $ms['item_desc'], 1, 0);
    $pdf->Cell(20, 7, $formula, 1, 1);

    $temp = $temp + $subtotal;  
    if($ms['unit_satuan'] == 'kg') {
        $temp_weight = $temp_weight + $ms['outgoing'];
    } else {
        
    }
    $i++;
}
$total_value = $temp;
$total_weight = $temp_weight;
$cogs = $total_value/$total_weight;

$pdf->Cell(193, 7, 'Total value : IDR ' . number_format($total_value, 2, ',', '.'), 1, 1);
$pdf->Cell(193, 7, 'Total weight : ' . number_format($total_weight, 2, ',', '.') . ' kg', 1, 1);
$pdf->Cell(193, 7, 'COGS : ' . number_format($cogs, 2, ',', '.') . ' kg', 1, 1);

$pdf->SetFont('', 'B', 8);
$pdf->Cell(277, 10, "Computerized report are automatically validated.", 0, 1, 'L');
$pdf->Output('Laporan_Inventory.pdf');
