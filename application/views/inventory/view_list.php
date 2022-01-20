<?php
$pdf = new \TCPDF();

// set document information
$pdf->SetCreator('comp');
$pdf->SetAuthor('CIP Information System');
$pdf->SetTitle('Inventory Asset List');
$pdf->SetSubject('Asset List');
$pdf->SetKeywords('asset, inventory, usage');

$pdf->AddPage('L', 'mm', 'A4');
$pdf->SetFont('', 'B', 12);
$pdf->Cell(277, 10, "Asset Inventory List", 0, 1, 'C');
$pdf->SetAutoPageBreak(true, 0);

// Add Header
$pdf->Ln(10);
$pdf->SetFont('', 'B', 8);
$pdf->Cell(8, 8, "No", 1, 0, 'C');
$pdf->Cell(27, 8, "Code", 1, 0, 'C');
$pdf->Cell(35, 8, "Asset Name", 1, 0, 'C');
$pdf->Cell(20, 8, "Date Acquired", 1, 0, 'C');
$pdf->Cell(15, 8, "Position", 1, 0, 'C');
$pdf->Cell(35, 8, "User", 1, 0, 'C');
$pdf->Cell(100, 8, "Specifications/Desc", 1, 0, 'C');
$pdf->Cell(15, 8, "Value", 1, 0, 'C');
$pdf->Cell(15, 8, "Status", 1, 0, 'C');
$pdf->Cell(8, 8, "Cek", 1, 1, 'C');
$pdf->SetFont('', '', 8);
$inventory = $this->db->get('inventory_asset')->result();
//jooin database room and asset_inventory
$this->load->model('Inventory_model', 'inventory_id');
//get invt database
$data['inventory'] = $this->inventory_id->getRoomName();
$i = 0;
foreach ($inventory as $data) {
    $i++;
    $pdf->Cell(8, 7, $i, 1, 0, 'C');
    $pdf->Cell(27, 7, $data->code, 1, 0);
    $pdf->Cell(35, 7, $data->name, 1, 0);
    $pdf->Cell(20, 7, $data->date_in, 1, 0);
    $pdf->Cell(15, 7, $data->position, 1, 0);
    $pdf->Cell(35, 7, $data->user, 1, 0);
    $pdf->Cell(100, 7, $data->spec, 1, 0);
    $pdf->Cell(15, 7, $data->value, 1, 0);
    $pdf->Cell(15, 7, $data->status, 1, 0);
    $pdf->Cell(8, 7, ' ', 1, 1);
}
$pdf->SetFont('', 'B', 8);
$pdf->Cell(277, 10, "Computerized report are automatically validated.", 0, 1, 'L');
$pdf->Output('Laporan_Inventory.pdf');
