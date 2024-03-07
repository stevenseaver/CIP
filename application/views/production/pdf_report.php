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

//material
$pdf->SetFont('', 'B', 8);
$pdf->Cell(20, 10, 'Material Item', 0, 1, 'L');
$pdf->Cell(8, 8, "No", 1, 0, 'C');
$pdf->Cell(45, 8, "Item", 1, 0, 'C');
$pdf->Cell(30, 8, "Code", 1, 0, 'C');
$pdf->Cell(25, 8, "Amount", 1, 0, 'C');
$pdf->Cell(20, 8, "Price", 1, 0, 'C');
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
    $subtotal = $ms['outgoing'] * $ms['price'];
    $formula = $ms['outgoing']/($ms['item_desc']*10);
    $pdf->Cell(8, 7, $i, 1, 0, 'C');
    $pdf->Cell(45, 7, $ms['name'], 1, 0);
    $pdf->Cell(30, 7, $ms['code'], 1, 0);
    $pdf->Cell(25, 7, number_format($ms['outgoing'], 2, ',', '.') .' ' . $ms['unit_satuan'], 1, 0);
    $pdf->Cell(20, 7, number_format($ms['price'], 2, ',', '.'), 1, 0);
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

$pdf->Cell(128, 7, 'Total weight : ' . number_format($total_weight, 2, ',', '.') .' kg', 1, 0);
$pdf->Cell(65, 7, 'Total material value : IDR ' . number_format($total_value, 2, ',', '.') .' kg', 1, 1);
$pdf->Cell(193, 7, 'COGS : ' . number_format($cogs, 2, ',', '.') . '/kg', 1, 1);

//roll
$pdf->SetFont('', 'B', 8);
$pdf->Cell(20, 10, 'Roll Item', 0, 1, 'L');

$pdf->Cell(8, 8, "No", 1, 0, 'C');
$pdf->Cell(44, 8, "Item", 1, 0, 'C');
$pdf->Cell(18, 8, "Code", 1, 0, 'C');
$pdf->Cell(23, 8, "Grammature", 1, 0, 'C');
$pdf->Cell(15, 8, "Gusset", 1, 0, 'C');
$pdf->Cell(20, 8, "Amount", 1, 0, 'C');
$pdf->Cell(25, 8, "Batch", 1, 0, 'C');
$pdf->Cell(20, 8, "Roll Number", 1, 0, 'C');
$pdf->Cell(20, 8, "Status", 1, 1, 'C');
$pdf->SetFont('', '', 8);

$i = 1;
$temp = 0;
$temp_value = 0;
$waste_roll = 0;
$percent_waste = 0;
$depretiation = 0;
$percent_depretiation = 0;

foreach ($rollType as $ms) {
    $pdf->Cell(8, 7, $i, 1, 0, 'C');
    $pdf->Cell(44, 7, $ms['name'], 1, 0);
    $pdf->Cell(18, 7, $ms['code'], 1, 0);
    $pdf->Cell(23, 7, $ms['weight'], 1, 0);
    $pdf->Cell(15, 7, $ms['lipatan'], 1, 0);
    $pdf->Cell(20, 7, number_format($ms['incoming'], 2, ',', '.') . ' kg', 1, 0);
    $pdf->Cell(25, 7, $ms['batch'], 1, 0);
    $pdf->Cell(20, 7, $ms['transaction_desc'], 1, 0);

    if($ms['status'] != 9) { 
         $pdf->Cell(20, 7, 'Not yet cut', 1, 1);
    } else { 
         $pdf->Cell(20, 7, 'Already cut', 1, 1);
    } 
    $temp = $temp + $ms['incoming'];   

    $avalan = "avalan";
    $prongkolan = "prongkolan";

    $sim_av = similar_text($ms['transaction_desc'], $avalan, $percent_av);
    $sim_prong = similar_text($ms['transaction_desc'], $prongkolan, $percent_prong);

    if($percent_av > 50 or $percent_prong > 50){
        $waste_roll = $waste_roll + $ms['incoming'];
    };

    $i++;
}
$total_roll = $temp;
$waste = $total_roll-$total_weight;
$percent_roll = ($waste_roll/$total_roll) * 100;

$pdf->Cell(193, 7, 'Total roll weight : ' . number_format($total_roll, 2, ',', '.') .' kg', 1, 1);
$pdf->Cell(193, 7, 'Process Waste : ' . number_format($waste, 2, ',', '.') . ' kg. Positive value means expansion.', 1, 1);
$pdf->Cell(193, 7, 'Roll Waste : ' . number_format($waste_roll, 2, ',', '.') . ' kg or ' .  number_format($percent_roll, 2, ',', '.') .'%', 1, 1);
// $pdf->Cell(193, 7, 'Product waste : ' . number_format($aval_weight, 2, ',', '.') . ' kg or ' . number_format($aval_weight/$total_roll * 100, 2, ',', '.') .'%', 1, 1);

//GBJ
$pdf->SetFont('', 'B', 8);
$pdf->Cell(20, 10, 'Finished Goods Item', 0, 1, 'L');

$pdf->Cell(8, 8, "No", 1, 0, 'C');
$pdf->Cell(50, 8, "Item", 1, 0, 'C');
// $pdf->Cell(18, 8, "Code", 1, 0, 'C');
$pdf->Cell(9, 8, "Pcs", 1, 0, 'C');
$pdf->Cell(9, 8, "Pack", 1, 0, 'C');
$pdf->Cell(20, 8, "Amount", 1, 0, 'C');
$pdf->Cell(17, 8, "W/pack", 1, 0, 'C');
$pdf->Cell(17, 8, "Price", 1, 0, 'C');
$pdf->Cell(20, 8, "Subtotal", 1, 0, 'C');
$pdf->Cell(43, 8, "Batch/Pack No.", 1, 1, 'C');
$pdf->SetFont('', '', 8);

$i = 1;
$temp = 0;
$waste_roll = 0;
$waste_plong = 0;
$waste_other = 0;
$temp_total = 0;
$percent_waste = 0;
$plong_percent = 0;
$other_percent = 0;

foreach ($gbjItems as $ms) {
    $pdf->Cell(8, 7, $i, 1, 0, 'C');
    $pdf->Cell(50, 7, $ms['name'], 1, 0);
    // $pdf->Cell(18, 7, $ms['code'], 1, 0);
    $pdf->Cell(9, 7, $ms['pcsperpack'], 1, 0);
    $pdf->Cell(9, 7, $ms['packpersack'], 1, 0);
    if($ms['transaction_status'] != 2){   
        $pdf->Cell(20, 7, number_format($ms['incoming'], 2, ',', '.') . ' kg', 1, 0);
    } else {
        $pdf->Cell(20, 7, number_format($ms['incoming'], 2, ',', '.') . ' ' . $ms['unit_satuan'], 1, 0);
    };
    $weightPerPack = $ms['before_convert'] / $ms['incoming'];
    $subtotal = $ms['price'] * $ms['incoming'];
    $pdf->Cell(17, 7, number_format($weightPerPack, 3, ',', '.'), 1, 0);
    $pdf->Cell(17, 7, number_format($ms['price'], 2, ',', '.'), 1, 0);
    $pdf->Cell(20, 7, number_format($subtotal, 2, ',', '.'), 1, 0);
    $pdf->Cell(43, 7, $ms['batch'] . '/' . $ms['description'], 1, 1);
    
    $temp = $temp + $ms['before_convert'];
    $temp_total = $temp_total + $subtotal;

    $avalan = "roll";
    $avalan1 = "prongkolan roll";
    $plong = "plong";
    $sortir = "sortir";
    $alas = "alas";
    $tarik = "tarik";

    $sim_av = similar_text($ms['description'], $avalan, $percent_av);
    $sim_prong = similar_text($ms['description'], $avalan1, $percent_prong);
    $sim_plong = similar_text($ms['description'], $plong, $percent_plong);
    $sim_sortir = similar_text($ms['description'], $sortir, $percent_sortir);
    $sim_alas = similar_text($ms['description'], $alas, $percent_alas);
    $sim_tarik = similar_text($ms['description'], $tarik, $percent_tarik);

    if($percent_av > 60 or $percent_prong > 60){
        $waste_roll = $waste_roll + $ms['incoming'];
    } else if($percent_plong > 60){
        $waste_plong = $waste_plong + $ms['incoming'];
    } else if($percent_sortir > 50 or $percent_alas > 50 or $percent_tarik > 50){
        $waste_other = $waste_other + $ms['incoming'];
    };

    $i++;
}
$total_FG = $temp;
$grandTotal = $temp_total;
$waste = $total_FG-$total_weight;
if ($total_FG != 0){ 
    $percent_waste = ($waste_roll / $total_FG) * 100;
    $percent_plong = ($waste_plong / $total_FG) * 100;
    $percent_other = ($waste_other / $total_FG) * 100; 
    $pdf->Cell(96, 7, 'Total finished goods weight : ' . number_format($total_FG, 2, ',', '.') .' kg', 1, 0);
    $pdf->Cell(97, 7, 'Total finished goods value : IDR ' . number_format($grandTotal, 2, ',', '.') .' kg', 1, 1);
    $pdf->Cell(193, 7, 'Roll Waste : ' . number_format($waste_roll, 2, ',', '.') . ' kg or ' .  number_format($percent_waste, 2, ',', '.') . '%', 1, 1);
    $pdf->Cell(193, 7, 'Plong Waste : ' . number_format($waste_plong, 2, ',', '.') . ' kg or ' .  number_format($percent_plong, 2, ',', '.') . '%', 1, 1);
    $pdf->Cell(193, 7, 'Other Waste : ' . number_format($waste_other, 2, ',', '.') . ' kg or ' .  number_format($percent_other, 2, ',', '.') . '%. Max 5%.', 1, 1);
} else {
    $pdf->Cell(96, 7, 'Total finished goods weight : no data', 1, 0);
    $pdf->Cell(97, 7, 'Total finished goods value : IDR no data', 1, 1);
    $pdf->Cell(193, 7, 'Roll Waste : no data', 1, 1);
    $pdf->Cell(193, 7, 'Plong Waste : no data', 1, 1);
    $pdf->Cell(193, 7, 'Other Waste : no data', 1, 1);
}


$pdf->SetFont('', 'B', 8);
$pdf->Cell(277, 10, "Computerized report are automatically validated.", 0, 1, 'L');
$pdf->Output('Laporan_Inventory.pdf');
