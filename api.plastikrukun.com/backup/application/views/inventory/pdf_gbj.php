<?php
$pdf = new \TCPDF();

// set document information
$pdf->SetCreator('comp');
$pdf->SetAuthor('CIP Information System');
$pdf->SetTitle('Finished Goods Inventory');
$pdf->SetSubject('Finished Goods Item List');
$pdf->SetKeywords('finished, inventory, usage');

$pdf->AddPage('L', 'mm', 'A4');
$pdf->SetFont('', 'B', 12);
$pdf->Cell(277, 10, "Finished Goods Inventory", 0, 1, 'C');
$pdf->SetAutoPageBreak(true, 0);

// Add Header
$pdf->Ln(10);
$pdf->SetFont('', 'B', 8);
$pdf->Cell(8, 8, "No", 1, 0, 'C');
$pdf->Cell(68, 8, "Item", 1, 0, 'C');
$pdf->Cell(45, 8, "Code", 1, 0, 'C');
$pdf->Cell(17, 8, "Pcs/pack", 1, 0, 'C');
$pdf->Cell(17, 8, "Pack/sack", 1, 0, 'C');
$pdf->Cell(30, 8, "Category", 1, 0, 'C');
$pdf->Cell(20, 8, "Stock", 1, 0, 'C');
$pdf->Cell(20, 8, "Price", 1, 0, 'C');
$pdf->Cell(25, 8, "Value", 1, 0, 'C');
$pdf->Cell(15, 8, "Real", 1, 0, 'C');
$pdf->Cell(15, 8, "Delta", 1, 1, 'C');
$pdf->SetFont('', '', 8);

// //jooin database room and asset_inventory
// $this->load->model('Inventory_model', 'inventory_id');
// //get invt database
// $data['inventory'] = $this->inventory_id->getRoomName();
$i = 1;
$temp1 = 0;
$temp2 = 0;
$total_value = 0;
$total_weight = 0;

foreach ($finishedStock as $data) {
    $subtotal = $data['price'] * $data['in_stock'];
    $pdf->Cell(8, 7, $i, 1, 0, 'C');
    $pdf->Cell(68, 7, $data['name'], 1, 0);
    $pdf->Cell(45, 7, $data['code'], 1, 0);
    $pdf->Cell(17, 7, $data['pcsperpack'], 1, 0);
    $pdf->Cell(17, 7, $data['packpersack'], 1, 0);
    $pdf->Cell(30, 7, $data['title'], 1, 0);
    $pdf->Cell(20, 7, number_format($data['in_stock'], 2, ',', '.'), 1, 0);
    $pdf->Cell(20, 7, number_format($data['price'], 2, ',', '.'), 1, 0);
    $pdf->Cell(25, 7, number_format($subtotal, 2, ',', '.'), 1, 0);
    $pdf->Cell(15, 7, ' ', 1, 0);
    $pdf->Cell(15, 7, ' ', 1, 1);

    $temp1 = $temp1 + $data['in_stock'];
    $temp2 = $temp2 + $subtotal;
    $i++;
}
$total_value = $temp2;
$total_weight = $temp1;

$pdf->Cell(280, 7, 'Total value : IDR ' . number_format($total_value, 2, ',', '.'), 1, 1);
$pdf->Cell(280, 7, 'Total weight : ' . number_format($total_weight, 2, ',', '.') . ' kg', 1, 1);

$pdf->SetFont('', 'B', 8);
$pdf->Cell(277, 10, "Computerized report are automatically validated.", 0, 1, 'L');
$pdf->Output('Laporan_Inventory.pdf');
