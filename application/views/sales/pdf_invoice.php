<?php
$pdf = new \TCPDF();

// set document information
$pdf->SetCreator('comp');
$pdf->SetAuthor('CIP Information System');
$pdf->SetTitle('Invoice');
$pdf->SetSubject('Transaction Details');
$pdf->SetKeywords('invoice, sales, transaction');

$pdf->AddPage('L', 'mm', 'A4');
$pdf->SetFont('', 'B', 20);
$pdf->Cell(0, 15, "Invoice", 0, 1, 'L');
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
$pdf->Cell(125, 9, "Item", 1, 0, 'C');
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
    $pdf->Cell(125, 8, $data->item_name, 1, 0);
    if ($data->prod_cat == 6) {
        $pdf->Cell(30, 8, $data->qty . ' Kg', 1, 0, 'C');
    } else {
        $pdf->Cell(30, 8, $data->qty . ' Pack', 1, 0, 'C');
    }
    $pdf->Cell(30, 8, $this->cart->format_number($data->price, '0', ',', '.'), 1, 0, 'C');
    $pdf->Cell(40, 8, $this->cart->format_number($data->subtotal, '0', ',', '.'), 1, 1, 'C');
    $temp = $temp + $data->subtotal;
}

$total = $temp;
$tax = 0; //tax percentage

$pdf->SetFont('', 'B', 12);
$pdf->Cell(195, 7, "Total", 1, 0, 'R');
$pdf->Cell(40, 7, $this->cart->format_number($total, '0', ',', '.'), 1, 1, 'C');
$pdf->SetFont('', 'B', 12);
$pdf->Cell(195, 7, "Tax : " . $tax . "%", 1, 0, 'R');

$taxValue = $total * ($tax / 100);
$pdf->Cell(40, 7, $this->cart->format_number($taxValue, '0', ',', '.'), 1, 1, 'C');

$grandTotal = $total + $taxValue;
$pdf->Cell(195, 7, "Total", 1, 0, 'R');
$pdf->Cell(40, 7, $this->cart->format_number($grandTotal, '0', ',', '.'), 1, 1, 'C');

//ENGLISH TERMS AND CONDITIONS
$pdf->Cell(277, 0, "", 0, 1, 'L');
$pdf->SetFont('', 'BI', 8);
$pdf->Cell(277, 1, "Terms and Conditions", 0, 1, 'L');

$pdf->Cell(277, 1, "", 0, 1, 'L');
$pdf->SetFont('', 'I', 8);
$pdf->Cell(277, 5, "1. Computerized report are automatically validated.", 0, 1, 'L');
$pdf->Cell(277, 5, "2. Our products are guaranteed with limited 10-days warranty covering sealing craftmanship and quantity.", 0, 1, 'L');
$pdf->Cell(277, 5, "3. By using our services, software, or making any transactions, you have agreed upon our terms and conditions.", 0, 1, 'L');
$pdf->Cell(277, 5, "4. Any warranty claim outside the warranty time-frame are not our liability.", 0, 1, 'L');
$pdf->Cell(277, 5, "5. We will replace the item with similar or more expensive products or refund your money according to our prerogative rights. ", 0, 1, 'L');
$pdf->Cell(277, 5, "6. Any price discrepancy between goods being replaced and the replacement, or any delivery fees must be beared by the customer.", 0, 1, 'L');
$pdf->Cell(277, 5, "7. Please contact our customer serivce +62 822 3205 7755 for any inquiries.", 0, 1, 'L');

//INDONESIA TERMS AND CONDITIONS
$pdf->Cell(277, 0, "", 0, 1, 'L');
$pdf->SetFont('', 'B', 8);
$pdf->Cell(277, 1, "Syarat dan Ketentuan", 0, 1, 'L');

$pdf->Cell(277, 1, "", 0, 1, 'L');
$pdf->SetFont('', '', 8);
$pdf->Cell(277, 5, "1. Nota ini dikeluarkan komputer, tidak perlu tanda tangan.", 0, 1, 'L');
$pdf->Cell(277, 5, "2. Produk kami digaransi selama 10-hari mencakup pengerjaan las dan jumlah barang.", 0, 1, 'L');
$pdf->Cell(277, 5, "3. Dengan menggunakan layanan, perangkat lunak, ataupun melakukan transaksi dengan kami, Anda telah menyetujui syarat dan ketetentuan yang berlaku.", 0, 1, 'L');
$pdf->Cell(277, 5, "4. Klaim garansi diluar waktu garansi bukan tanggung jawab kami.", 0, 1, 'L');
$pdf->Cell(277, 5, "5. Kami akan mengganti barang dengan barang sejenis atau lebih mahal, atau mengembalikan uang anda sesuai hak prerogatif kami.", 0, 1, 'L');
$pdf->Cell(277, 5, "6. Perbedaan harga antara barang yang diganti dengan barang pengganti, atau biaya pengiriman yang timbul harus dibayarkan oleh pelanggan.", 0, 1, 'L');
$pdf->Cell(277, 5, "7. Hubungi layanan pelanggan kami di +62 822 3205 7755 jika ada pertanyaan.", 0, 1, 'L');
$pdf->Output('Invoice.pdf');
