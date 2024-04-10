<?php
$pdf = new \TCPDF();

// set document information
$pdf->SetCreator($user_name);
$pdf->SetAuthor('CIP Information System');
$pdf->SetTitle('Transaction Info');
$pdf->SetSubject('Transaction Details');
$pdf->SetKeywords('invoice, sales, transaction');

$pdf->AddPage('P', 'mm', 'A4');
$pdf->SetFont('', 'B', 12);
$pdf->Cell(0, 7, "Stocky", 0, 1, 'L');
$pdf->SetFont('', '', 8);
$pdf->Cell(0, 0, "Pergudangan dan Industri Sinar Gedangan A-20", 0, 1, 'L');
$pdf->Cell(0, 0, "Sidoarjo - Indonesia", 0, 1, 'L');
$pdf->SetAutoPageBreak(true, 0);

$pdf->SetFont('', 'B', 20);
$pdf->Cell(0, 15, "Transaction Info", 0, 1, 'L');
$pdf->SetAutoPageBreak(true, 0);

//CUST NAME
$pdf->SetFont('', '', 12);
$pdf->Cell(25, 7, 'Customer  ', 0, 0, 'L');
$pdf->SetFont('', 'B', 12);
$pdf->Cell(100, 7, $cust_name, 0, 1, 'L');
//INV
$pdf->SetFont('', '', 12);
$pdf->Cell(25, 7, 'Invoice No.', 0, 0, 'L');
$pdf->SetFont('', 'B', 12);
$pdf->Cell(100, 7, $ref, 0, 1, 'L');
//DATE
$pdf->SetFont('', '', 12);
$pdf->Cell(25, 7, 'Date  ', 0, 0, 'L');
$pdf->SetFont('', 'B', 12);
$pdf->Cell(100, 7, date('d F Y H:i', $date), 0, 1, 'L');

// Add Header
$pdf->Ln(7);
$pdf->SetFont('', 'B', 12);
$pdf->Cell(10, 9, "No", 1, 0, 'C');
$pdf->Cell(85, 9, "Item", 1, 0, 'C');
$pdf->Cell(30, 9, "Qty", 1, 0, 'C');
$pdf->Cell(30, 9, "Price (IDR)", 1, 0, 'C');
$pdf->Cell(40, 9, "Subtotal (IDR)", 1, 1, 'C');
$pdf->SetFont('', '', 12);
//get cart database
$dataCart = $this->db->get_where('cart', ['ref' => $ref])->result();
$i = 0;
$temp = 0;
$total = 0;
$grandTotal = 0;
foreach ($dataCart as $data) {
    $i++;
    $pdf->Cell(10, 8, $i, 1, 0, 'C');
    $pdf->Cell(85, 8, $data->item_name, 1, 0);
    $pdf->Cell(30, 8, $data->qty . ' ' . $data->unit, 1, 0, 'C');
    $pdf->Cell(30, 8, $this->cart->format_number($data->price, '0', ',', '.'), 1, 0, 'C');
    $pdf->Cell(40, 8, $this->cart->format_number($data->subtotal, '0', ',', '.'), 1, 1, 'C');
    $temp = $temp + $data->subtotal;
}

$total = $temp;
$tax_array = $this->db->get_where('settings', ['parameter' => 'sales_tax'])->row_array('value');
$sales_tax = $tax_array['value'];

$pdf->SetFont('', 'B', 12);
$pdf->Cell(155, 7, "Total", 1, 0, 'R');
$pdf->Cell(40, 7, $this->cart->format_number($total, '0', ',', '.'), 1, 1, 'C');
$pdf->SetFont('', 'B', 12);
$pdf->Cell(155, 7, "Tax : " . $sales_tax . "%", 1, 0, 'R');

$taxValue = $total * ($sales_tax / 100);
$pdf->Cell(40, 7, $this->cart->format_number($taxValue, '0', ',', '.'), 1, 1, 'C');

$grandTotal = $total + $taxValue;
$pdf->Cell(155, 7, "Grand Total", 1, 0, 'R');
$pdf->Cell(40, 7, $this->cart->format_number($grandTotal, '0', ',', '.'), 1, 1, 'C');

$pdf->Cell(100, 10, "Printed by " . $user_name . ' ' . date('d-m-Y h:m:s') . ' No Signature required', 0, 1, 'L');
$pdf->Output('DO-'. $ref. '.pdf');
