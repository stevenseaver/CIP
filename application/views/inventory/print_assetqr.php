<?php
/**
 * Inventory Asset Sticker Sheet
 * Layout  : A4 Portrait | 3 columns × 8 rows | 65 × 35 mm per sticker
 * Print on: Avery L7159 / equivalent 65×35 mm label sheets
 */

// ============================================================================
// CONFIGURATION
// ============================================================================

// Sticker dimensions (mm)
define('S_W',      65);   // sticker width
define('S_H',      35);   // sticker height
define('S_COLS',    3);   // stickers per row
define('S_ROWS',    8);   // rows per page

// Page margins — align with label sheet perforations
define('MARGIN_L',  7.5);
define('MARGIN_T', 10.5);
define('GAP_X',     2.5); // horizontal gap between stickers
define('GAP_Y',     0.0); // vertical gap between stickers

// Brand colours [R, G, B]
define('C_NAVY',  [30,  64,  120]);
define('C_WHITE', [255, 255, 255]);
define('C_LGRAY', [245, 246, 248]);
define('C_DTEXT', [35,  35,   35]);
define('C_MTEXT', [100, 100,  110]);
define('C_AMBER', [255, 200,    0]);

// ============================================================================
// PDF SETUP
// ============================================================================

$pdf = new \TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetCreator('CIP Information System');
$pdf->SetTitle('Asset Inventory Stickers');
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetAutoPageBreak(false);
$pdf->SetMargins(0, 0, 0);
$pdf->AddPage();

// ============================================================================
// DATA
// ============================================================================

$inventory = $this->db->get('inventory_asset')->result();

// ============================================================================
// STICKER RENDERING
// ============================================================================

$col = 0;
$row = 0;

foreach ($inventory as $data) {

    // ── Sticker origin (top-left corner) ─────────────────────────────────────
    $x = MARGIN_L + $col * (S_W + GAP_X);
    $y = MARGIN_T + $row * (S_H + GAP_Y);

    // ── Background card ───────────────────────────────────────────────────────
    $pdf->SetFillColor(...C_WHITE);
    $pdf->SetDrawColor(210, 215, 225);
    $pdf->SetLineWidth(0.3);
    $pdf->RoundedRect($x, $y, S_W, S_H, 1.5, '1111', 'DF');

    // ── Left accent bar ───────────────────────────────────────────────────────
    $pdf->SetFillColor(...C_NAVY);
    $pdf->Rect($x, $y, 3, S_H, 'F');

    // ── Header stripe ─────────────────────────────────────────────────────────
    $pdf->SetFillColor(...C_NAVY);
    $pdf->Rect($x + 3, $y, S_W - 3, 8, 'F');

    // Organisation name
    $pdf->SetFont('helvetica', 'B', 6);
    $pdf->SetTextColor(...C_WHITE);
    $pdf->SetXY($x + 4.5, $y + 1.2);
    $pdf->Cell(S_W - 30, 5.5, 'Stocky', 0, 0, 'L');

    // "ASSET TAG" badge
    $pdf->SetFillColor(...C_AMBER);
    $pdf->SetTextColor(...C_NAVY);
    $pdf->SetFont('helvetica', 'B', 5.5);
    $pdf->SetXY($x + S_W - 22, $y + 1.5);
    $pdf->Cell(18, 5, 'ASSET TAG', 1, 0, 'C', true);

    // ── QR Code ───────────────────────────────────────────────────────────────
    $qrSize = S_H - 8 - 3;                                    // fits between header & bottom padding
    $qrX    = $x + S_W - $qrSize - 2;
    $qrY    = $y + 9;
    $qrFile = APPPATH . '../asset/img/QRcode/' . $data->code . '.png';

    if (file_exists($qrFile)) {
        $pdf->SetFillColor(...C_LGRAY);
        $pdf->RoundedRect($qrX - 0.5, $qrY - 0.5, $qrSize + 1, $qrSize + 1, 1, '1111', 'F');
        $pdf->Image($qrFile, $qrX, $qrY, $qrSize, $qrSize, 'PNG');
    } else {
        $pdf->SetFillColor(...C_LGRAY);
        $pdf->SetDrawColor(200, 200, 200);
        $pdf->RoundedRect($qrX, $qrY, $qrSize, $qrSize, 1, '1111', 'DF');
        $pdf->SetTextColor(...C_MTEXT);
        $pdf->SetFont('helvetica', '', 5);
        $pdf->SetXY($qrX, $qrY + $qrSize / 2 - 2);
        $pdf->Cell($qrSize, 4, 'NO QR', 0, 0, 'C');
    }

    // ── Text block (left of QR) ───────────────────────────────────────────────
    $textW = S_W - $qrSize - 7;
    $textX = $x + 4.5;

    // Asset code — large & prominent
    $pdf->SetFont('helvetica', 'B', 8.5);
    $pdf->SetTextColor(...C_NAVY);
    $pdf->SetXY($textX, $y + 9.5);
    $pdf->Cell($textW, 5, $data->code, 0, 2, 'L');

    // Divider line
    $pdf->SetDrawColor(...C_NAVY);
    $pdf->SetLineWidth(0.4);
    $pdf->Line($textX, $pdf->GetY(), $textX + $textW, $pdf->GetY());
    $pdf->Ln(1);

    // Asset name (truncated)
    $name = mb_strlen($data->name) > 22
        ? mb_substr($data->name, 0, 21) . '…'
        : $data->name;

    $pdf->SetFont('helvetica', 'B', 6.5);
    $pdf->SetTextColor(...C_DTEXT);
    $pdf->SetX($textX);
    $pdf->Cell($textW, 4.5, $name, 0, 2, 'L');

    // User (truncated)
    $user = mb_strlen($data->user) > 24
        ? mb_substr($data->user, 0, 23) . '…'
        : $data->user;

    $pdf->SetFont('helvetica', '', 5.5);
    $pdf->SetTextColor(...C_MTEXT);

    $pdf->SetX($textX); $pdf->Cell($textW, 3.5, 'User: '     . $user,          0, 2, 'L');
    $pdf->SetX($textX); $pdf->Cell($textW, 3.5, 'Location: ' . $data->position, 0, 2, 'L');
    $pdf->SetX($textX); $pdf->Cell($textW, 3.5, 'Acquired: ' . $data->date_in,  0, 2, 'L');

    // ── Advance grid position ─────────────────────────────────────────────────
    $col++;

    if ($col >= S_COLS) {
        $col = 0;
        $row++;

        if ($row >= S_ROWS) {
            $row = 0;
            $pdf->AddPage();
        }
    }
}

// ============================================================================
// OUTPUT
// ============================================================================

$pdf->Output('Sticker_Inventory.pdf', 'I');