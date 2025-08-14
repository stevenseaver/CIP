<?php
$pdf = new \TCPDF();

// set document information
$pdf->SetCreator($user_name);
$pdf->SetAuthor('CIP Information System');
$pdf->SetTitle('Return Order');
$pdf->SetSubject('Transaction Details');
$pdf->SetKeywords('invoice, sales, transaction');

$pdf->AddPage('P', 'mm', 'A4');
$pdf->SetFont('', 'B', 12);
$pdf->Cell(0, 7, "Plastik Daur Ulang", 0, 1, 'L');
$pdf->SetFont('', '', 8);
$pdf->Cell(0, 0, "Pergudangan dan Industri Sinar Gedangan A-20", 0, 1, 'L');
$pdf->Cell(0, 0, "Sidoarjo - Indonesia", 0, 1, 'L');
$pdf->Cell(0, 0, "NIB: 0220103452894", 0, 1, 'L');
$pdf->SetAutoPageBreak(true, 0);

$pdf->SetFont('', 'B', 20);
$pdf->Cell(0, 15, "Purchase Order Invoice", 0, 1, 'L');
$pdf->SetAutoPageBreak(true, 0);

//SUP NAME
$pdf->SetFont('', '', 12);
$pdf->Cell(25, 7, 'Supplier  ', 0, 0, 'L');
$pdf->SetFont('', 'B', 12);
$pdf->Cell(100, 7, $sup_name, 0, 1, 'L');
//INV
$pdf->SetFont('', '', 12);
$pdf->Cell(25, 7, 'PO No.', 0, 0, 'L');
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
$pdf->Cell(80, 9, "Item", 1, 0, 'C');
$pdf->Cell(30, 9, "Qty", 1, 0, 'C');
$pdf->Cell(30, 9, "Price (IDR)", 1, 0, 'C');
$pdf->Cell(40, 9, "Subtotal (IDR)", 1, 1, 'C');
$pdf->SetFont('', '', 12);
// get cart database
$dataPO = $this->db->get_where('stock_material', ['transaction_id' => $ref])->result();
$i = 0;
$temp = 0;
$total = 0;
$subtotal = 0;
$grandTotal = 0;
foreach ($dataPO as $data) {
    $i++;
    $pdf->Cell(10, 8, $i, 1, 0, 'C');
    $pdf->Cell(80, 8, $data->name, 1, 0);
    $pdf->Cell(30, 8, $data->incoming . ' Kg', 1, 0, 'C');
    $pdf->Cell(30, 8, $this->cart->format_number($data->price, '0', ',', '.'), 1, 0, 'C');
    $subtotal = $data->price * $data->incoming;
    $pdf->Cell(40, 8, $this->cart->format_number($subtotal, '0', ',', '.'), 1, 1, 'C');
    $temp = $temp + $subtotal;
}

$total = $temp;

$tax_array = $this->db->get_where('settings', ['parameter' => 'purchase_tax'])->row_array('value');
$purchase_tax = $tax_array['value'];

if ($data->tax == 1) {
    $tax = $purchase_tax; //tax percentage
} else if ($data->tax == 0) {
    $tax = 0;
}

$pdf->SetFont('', 'B', 12);
$pdf->Cell(150, 7, "Total", 1, 0, 'R');
$pdf->Cell(40, 7, $this->cart->format_number($total, '0', ',', '.'), 1, 1, 'C');
$pdf->SetFont('', 'B', 12);
$pdf->Cell(150, 7, "Tax : " . $tax . "%", 1, 0, 'R');

$taxValue = $total * ($tax / 100);
$pdf->Cell(40, 7, $this->cart->format_number($taxValue, '0', ',', '.'), 1, 1, 'C');

$grandTotal = $total + $taxValue;
$pdf->Cell(150, 7, "Grand Total", 1, 0, 'R');
$pdf->Cell(40, 7, $this->cart->format_number($grandTotal, '0', ',', '.'), 1, 1, 'C');

//ENGLISH TERMS AND CONDITIONS
$pdf->Cell(100, 0, "", 0, 1, 'L');
$pdf->SetFont('', 'BI', 8);
$pdf->Cell(100, 1, "Terms and Conditions", 0, 1, 'L');

$pdf->Cell(100, 1, "", 0, 1, 'L');
$pdf->SetFont('', 'I', 8);
$pdf->Cell(100, 5, "1. Computerized documents are automatically validated.", 0, 1, 'L');
$pdf->Cell(100, 5, "2. Order quantity is as stated in this document.", 0, 1, 'L');
$pdf->Cell(100, 5, "3. Any discrepancy between order quantity and actual arrived goods must not exceed 10% and will be adjusted to the purchase invoice.", 0, 1, 'L');
$pdf->Cell(100, 5, "4. Any discrepancy beyond 10% will be returned to supplier.", 0, 1, 'L');
$pdf->Cell(100, 5, "5. Discrepancy between sample and actual goods must be inside our Incoming QC standards. Any goods that do not meet IQC standard will be returned.", 0, 1, 'L');
$pdf->Cell(100, 5, "6. Please contact our purchasing division +62 813 3133 525 for any inquiries.", 0, 1, 'L');

//INDONESIA TERMS AND CONDITIONS
$pdf->Cell(100, 0, "", 0, 1, 'L');
$pdf->SetFont('', 'B', 8);
$pdf->Cell(100, 1, "Syarat dan Ketentuan", 0, 1, 'L');

$pdf->Cell(100, 1, "", 0, 1, 'L');
$pdf->SetFont('', '', 8);
$pdf->Cell(100, 5, "1. PO ini dikeluarkan komputer, tidak perlu tanda tangan.", 0, 1, 'L');
$pdf->Cell(100, 5, "2. Produk kami digaransi selama 10-hari mencakup pengerjaan las dan jumlah barang.", 0, 1, 'L');
$pdf->Cell(100, 5, "3. Perbedaan jumlah kuantitas order dan barang yang datang tidak boleh melebihi 10% dan akan disesuaikan pada nota pembelian.", 0, 1, 'L');
$pdf->Cell(100, 5, "4. Perbedaan kuantitas lebih dari 10% akan dikembalikan kepada supplier.", 0, 1, 'L');
$pdf->Cell(100, 5, "5. Kami akan mengganti barang dengan barang sejenis atau lebih mahal, atau mengembalikan uang anda sesuai hak prerogatif kami.", 0, 1, 'L');
$pdf->Cell(100, 5, "6. Hubungi divisi pembelian kami di +62 813 3133 525 jika ada pertanyaan.", 0, 1, 'L');
$pdf->Cell(100, 10, "Printed by " . $user_name . ' ' . date('d-m-Y h:m:s'), 0, 1, 'L');
$pdf->Output('Invoice.pdf');
