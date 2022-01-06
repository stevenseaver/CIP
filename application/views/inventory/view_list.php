<?php
$pdf = new \TCPDF();

// set document information
$pdf->SetCreator('comp');
$pdf->SetAuthor('CIP Information System');
$pdf->SetTitle('Inventory Asset List');
$pdf->SetSubject('Asset List');
$pdf->SetKeywords('asset, inventory, usage');

$pdf->AddPage('L', 'mm', 'A4');
$pdf->SetFont('', 'B', 14);
$pdf->Cell(277, 10, "Asset Inventory List", 0, 1, 'C');
$pdf->SetAutoPageBreak(true, 0);

// Add Header
$pdf->Ln(10);
$pdf->SetFont('', 'B', 12);
$pdf->Cell(10, 8, "No", 1, 0, 'C');
$pdf->Cell(40, 8, "Code", 1, 0, 'C');
$pdf->Cell(50, 8, "Asset Name", 1, 0, 'C');
$pdf->Cell(35, 8, "Date Acquired", 1, 0, 'C');
$pdf->Cell(40, 8, "Position", 1, 0, 'C');
$pdf->Cell(50, 8, "User", 1, 0, 'C');
$pdf->Cell(35, 8, "Value", 1, 0, 'C');
$pdf->Cell(20, 8, "Status", 1, 1, 'C');
$pdf->SetFont('', '', 12);
$inventory = $this->db->get('inventory_asset')->result();
//jooin database room and asset_inventory
$this->load->model('Inventory_model', 'inventory_id');
//get invt database
$data['inventory'] = $this->inventory_id->getRoomName();
$i = 0;
foreach ($inventory as $data) {
    $i++;
    $pdf->Cell(10, 8, $i, 1, 0, 'C');
    $pdf->Cell(40, 8, $data->code, 1, 0);
    $pdf->Cell(50, 8, $data->name, 1, 0);
    $pdf->Cell(35, 8, $data->date_in, 1, 0);
    $pdf->Cell(40, 8, $data->position, 1, 0);
    $pdf->Cell(50, 8, $data->user, 1, 0);
    $pdf->Cell(35, 8, $data->value, 1, 0);
    $pdf->Cell(20, 8, $data->status, 1, 1);
}
$pdf->SetFont('', 'B', 10);
$pdf->Cell(277, 10, "Computerized report are automatically validated.", 0, 1, 'L');
$pdf->Output('Laporan-Tcpdf-CodeIgniter.pdf');
