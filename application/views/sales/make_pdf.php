<?php
$pdf = new \TCPDF();

// set document information
$pdf->SetCreator('comp');
$pdf->SetAuthor('CIP Information System');
$pdf->SetTitle('Invoice');
$pdf->SetSubject('Transaction Details');
$pdf->SetKeywords('invoice, sales, transaction');

$pdf->AddPage('L', 'mm', 'A5');
$pdf->SetFont('', 'B', 12);
$pdf->Cell(277, 10, "Invoice", 0, 1, 'C');
$pdf->SetAutoPageBreak(true, 0);

// Add Header
$pdf->Ln(10);
$pdf->SetFont('', 'B', 8);
$pdf->Cell(8, 8, "No", 1, 0, 'C');
$pdf->Cell(27, 8, "Ref", 1, 0, 'C');
$pdf->Cell(37, 8, "Date", 1, 0, 'C');
$pdf->Cell(40, 8, "Customer", 1, 0, 'C');
$pdf->Cell(105, 8, "Item", 1, 0, 'C');
$pdf->Cell(15, 8, "Qty", 1, 0, 'C');
$pdf->Cell(20, 8, "Price (IDR)", 1, 0, 'C');
$pdf->Cell(25, 8, "Subtotal (IDR)", 1, 1, 'C');
$pdf->SetFont('', '', 8);
//get cart database
// $this->load->model('Sales_model', 'custID');
// $dataCart = $this->custID->getCustomer();
$dataCart = $this->db->get_where('cart', ['ref' => $ref])->result();
$i = 0;
foreach ($dataCart as $data) {
    $i++;
    $pdf->Cell(8, 7, $i, 1, 0, 'C');
    $pdf->Cell(27, 7, $data->ref, 1, 0, 'C');
    $pdf->Cell(37, 7, date('d F Y H:i', $data->date), 1, 0, 'C');
    $pdf->Cell(40, 7, $cust_name, 1, 0, 'C');
    $pdf->Cell(105, 7, $data->item_name, 1, 0);
    $pdf->Cell(15, 7, $data->qty, 1, 0, 'C');
    $pdf->Cell(20, 7, $this->cart->format_number($data->price, '0', ',', '.'), 1, 0, 'C');
    $pdf->Cell(25, 7, $this->cart->format_number($data->subtotal, '0', ',', '.'), 1, 1, 'C');
}
$pdf->SetFont('', 'B', 8);
$pdf->Cell(277, 10, "Computerized report are automatically validated.", 0, 1, 'L');
$pdf->Output('Invoice.pdf');
