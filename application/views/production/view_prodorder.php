<?php
$pdf = new \TCPDF();

// set document information
$pdf->SetCreator('comp');
$pdf->SetAuthor('CIP Information System');
$pdf->SetTitle('Production Order');
$pdf->SetSubject('PO List');
$pdf->SetKeywords('production','order','material');

$pdf->AddPage('L', 'mm', 'A5');
$pdf->SetFont('', 'B', 14);
$pdf->Cell(275, 10, "Production Order", 0, 1, 'C');
$pdf->SetAutoPageBreak(true, 0);

//PROD-ID
$pdf->SetFont('', '', 12);
$pdf->Cell(35, 7, 'Transaction ID', 0, 0, 'L');
$pdf->SetFont('', 'B', 12);
$pdf->Cell(100, 7, $ref, 0, 1, 'L');
//DATE
$pdf->SetFont('', '', 12);
$pdf->Cell(35, 7, 'Date', 0, 0, 'L');
$pdf->SetFont('', 'B', 12);
$pdf->Cell(100, 7, date('d F Y H:i:s', $date), 0, 1, 'L');
//Batch
$pdf->SetFont('', '', 12);
$pdf->Cell(35, 7, 'Batch', 0, 0, 'L');
$pdf->SetFont('', 'B', 12);
$pdf->Cell(100, 7, $batch, 0, 1, 'L');

$temp = 0;
$temp2 = 0;

// Add Header
$pdf->Ln(10);
$pdf->SetFont('', 'B', 8);
$pdf->Cell(8, 8, "No", 1, 0, 'C');
$pdf->Cell(125, 8, "Item", 1, 0, 'C');
$pdf->Cell(55, 8, "Amount Used", 1, 0, 'C');
$pdf->Cell(20, 8, "Price (IDR)", 1, 0, 'C');
$pdf->Cell(20, 8, "Subtotal", 1, 0, 'C');
$pdf->Cell(20, 8, "Mix Amount", 1, 0, 'C');
$pdf->Cell(25, 8, "Formula", 1, 1, 'C');
$pdf->SetFont('', '', 10);
$order = $this->db->get_where('stock_material', ['transaction_id' => $ref])->result();
$i = 0;
foreach ($order as $data) {
    $i++;
    $pdf->Cell(8, 7, $i, 1, 0, 'C');
    $pdf->Cell(125, 7, $data->name, 1, 0);
    $pdf->Cell(55, 7, $data->outgoing . ' ' . $data->unit_satuan, 1, 0);
    $pdf->Cell(20, 7, number_format($data->price, 0, ',', '.'), 1, 0);
    $subtotal = $data->outgoing * $data->price;
    $formula = $data->outgoing/($data->item_desc*10);
    $pdf->Cell(20, 7, number_format($subtotal, 0, ',', '.'), 1, 0);
    $pdf->Cell(20, 7, $data->item_desc, 1, 0);
    $pdf->Cell(25, 7, $formula, 1, 1);

    $temp = $temp + $subtotal; 
    $temp2 = $temp2 + $data->outgoing;
}

$total = $temp;
$hpp = $total/$temp2;

$pdf->Cell(208, 8, "Grand Total Value Rp.", 1, 0, 'R');
$pdf->Cell(20, 8, number_format($total, 0, ',', '.'), 1, 0, 'C');
$pdf->Cell(20, 8, "HPP Rp.", 1, 0, 'C');
$pdf->Cell(25, 8, number_format($hpp, 2, ',', '.') . '/kg', 1, 1, 'C');

$pdf->SetFont('', 'B', 8);
$pdf->Cell(277, 10, "Computerized report are automatically validated.", 0, 1, 'L');
$pdf->Output('Laporan_Inventory.pdf');
