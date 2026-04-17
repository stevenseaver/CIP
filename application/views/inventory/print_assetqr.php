<?php
/**
 * Inventory Asset Sticker Sheet
 * Layout  : A4 Portrait | 3 columns × 8 rows | 65 × 35 mm per sticker
 * Print on: Avery L7159 / equivalent 65×35 mm label sheets
 * Design  : Minimalist Modern — slate header, hairline border, clean type
 */

// ============================================================================
// CONFIGURATION
// ============================================================================

define('S_W',      65);
define('S_H',      35);
define('S_COLS',    3);
define('S_ROWS',    8);

define('MARGIN_L',  7.5);
define('MARGIN_T', 10.5);
define('GAP_X',     2.5);
define('GAP_Y',     0.0);

// Palette — minimalist modern
define('C_SLATE',   [32,  66,  146]);   // #204292 — header bg
define('C_WHITE',   [255, 255, 255]);
define('C_SURFACE', [248, 250, 252]);  // #F8FAFC — body bg
define('C_BORDER',  [226, 232, 240]);  // #E2E8F0 — card border
define('C_INK',     [15,  23,  42]);   // primary text
define('C_MUTED',   [100, 116, 139]);  // #64748B — secondary text
define('C_AMBER',   [245, 158,  11]);  // #F59E0B — badge accent

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

$inventory = $this->db->get_where('inventory_asset', ['status' => 1])->result();

// ============================================================================
// HELPERS
// ============================================================================

/**
 * Draw a hairline rounded rectangle (border only, no fill).
 */
function cardBorder(\TCPDF $pdf, float $x, float $y, float $w, float $h): void
{
    $pdf->SetDrawColor(...C_BORDER);
    $pdf->SetLineWidth(0.25);
    $pdf->RoundedRect($x, $y, $w, $h, 1.8, '1111', 'D');
}

/**
 * Truncate a UTF-8 string to $max characters, appending '…' if cut.
 */
function truncate(string $s, int $max): string
{
    return mb_strlen($s) > $max ? mb_substr($s, 0, $max - 1) . '…' : $s;
}

// ============================================================================
// STICKER RENDERING
// ============================================================================

$col = 0;
$row = 0;

foreach ($inventory as $data) {

    $x = MARGIN_L + $col * (S_W + GAP_X);
    $y = MARGIN_T + $row * (S_H + GAP_Y);

    // ── 1. Card surface ───────────────────────────────────────────────────────
    $pdf->SetFillColor(...C_SURFACE);
    $pdf->SetDrawColor(...C_BORDER);
    $pdf->SetLineWidth(0.25);
    $pdf->RoundedRect($x, $y, S_W, S_H, 1.8, '1111', 'DF');

    // ── 2. Slate header bar ───────────────────────────────────────────────────
    $headerH = 7.5;
    $pdf->SetFillColor(...C_SLATE);
    // Manually clip top corners to match card radius; draw as plain rect then
    // overdraw the bottom edge with surface colour to fake the rounded top.
    $pdf->RoundedRect($x, $y, S_W, $headerH + 1, 1.8, '1100', 'F'); // top-rounded
    $pdf->SetFillColor(...C_SLATE);
    $pdf->Rect($x, $y + $headerH - 1, S_W, 2, 'F');                  // bottom fill-flush

    // Brand name — left-aligned
    $pdf->SetFont('helvetica', 'B', 6.5);
    $pdf->SetTextColor(...C_WHITE);
    $pdf->SetXY($x + 3.5, $y + 1.5);
    $pdf->Cell(30, 4.5, 'Stocky', 0, 0, 'L');

    // "ASSET TAG" amber pill — right side
    $badgeW = 17;
    $badgeX = $x + S_W - $badgeW - 2.5;
    $badgeY = $y + 1.8;
    $pdf->SetFillColor(...C_AMBER);
    $pdf->RoundedRect($badgeX, $badgeY, $badgeW, 4, 1, '1111', 'F');
    $pdf->SetFont('helvetica', 'B', 5);
    $pdf->SetTextColor(...C_SLATE);
    $pdf->SetXY($badgeX, $badgeY + 0.2);
    $pdf->Cell($badgeW, 3.8, 'ASSET TAG', 0, 0, 'C');

    // ── 3. Body layout ────────────────────────────────────────────────────────
    $bodyY  = $y + $headerH + 1;          // top of content area
    $qrSize = S_H - $headerH - 5;         // QR box size (square)
    $qrX    = $x + S_W - $qrSize - 2.5;
    $qrY    = $y + $headerH + 2;
    $textX  = $x + 3.5;
    $textW  = $qrX - $textX - 2;

    // ── 4. QR code or placeholder ─────────────────────────────────────────────
    $qrFile = APPPATH . '../asset/img/QRCode/' . $data->code . '.png';

    if (file_exists($qrFile)) {
        // Subtle surface background behind QR
        $pdf->SetFillColor(...C_WHITE);
        $pdf->SetDrawColor(...C_BORDER);
        $pdf->SetLineWidth(0.2);
        $pdf->RoundedRect($qrX - 0.5, $qrY - 0.5, $qrSize + 1, $qrSize + 1, 1.2, '1111', 'DF');
        $pdf->Image($qrFile, $qrX, $qrY, $qrSize, $qrSize, 'PNG');
    } else {
        $pdf->SetFillColor(...C_WHITE);
        $pdf->SetDrawColor(...C_BORDER);
        $pdf->SetLineWidth(0.2);
        $pdf->RoundedRect($qrX, $qrY, $qrSize, $qrSize, 1.2, '1111', 'DF');
        $pdf->SetTextColor(...C_MUTED);
        $pdf->SetFont('helvetica', '', 4.5);
        $pdf->SetXY($qrX, $qrY + $qrSize / 2 - 2);
        $pdf->Cell($qrSize, 4, 'NO QR', 0, 0, 'C');
    }

    // ── 5. Asset code ─────────────────────────────────────────────────────────
    $pdf->SetFont('helvetica', 'B', 8);
    $pdf->SetTextColor(...C_INK);
    $pdf->SetXY($textX, $bodyY + 0.5);
    $pdf->Cell($textW, 5, $data->code, 0, 2, 'L');

    // Hairline divider
    $divY = $pdf->GetY() + 0.5;
    $pdf->SetDrawColor(...C_BORDER);
    $pdf->SetLineWidth(0.2);
    $pdf->Line($textX, $divY, $textX + $textW, $divY);
    $pdf->SetY($divY + 1.5);

    // ── 6. Asset name ─────────────────────────────────────────────────────────
    $pdf->SetFont('helvetica', 'B', 6.5);
    $pdf->SetTextColor(...C_INK);
    $pdf->SetX($textX);
    $pdf->Cell($textW, 4, truncate($data->name, 22), 0, 2, 'L');

    // ── 7. Meta fields ────────────────────────────────────────────────────────
    $pdf->SetFont('helvetica', '', 5.2);
    $pdf->SetTextColor(...C_MUTED);

    $fields = [
        'User'     => truncate($data->user,     24),
        'Location' => truncate($data->position, 24),
        'Acquired' => $data->date_in,
    ];

    foreach ($fields as $label => $value) {
        $pdf->SetX($textX);
        $lineY = $pdf->GetY();

        // Label in slightly darker tone
        $pdf->SetFont('helvetica', 'B', 5.2);
        $pdf->SetTextColor(...C_MUTED);
        $pdf->SetXY($textX, $lineY);
        $labelW = 13;
        $pdf->Cell($labelW, 3.2, $label . ':', 0, 0, 'L');

        // Value
        $pdf->SetFont('helvetica', '', 5.2);
        $pdf->SetTextColor(...C_INK);
        $pdf->SetXY($textX + $labelW, $lineY);
        $pdf->Cell($textW - $labelW, 3.2, $value, 0, 2, 'L');
    }

    // ── 8. Advance grid ───────────────────────────────────────────────────────
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