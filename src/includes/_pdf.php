<?php
require_once ("_db.php");
require('fpdf181/fpdf.php');
date_default_timezone_set('america/sao_paulo');
header ('Content-type: text/html; charset=ISO-8859-1');

$type_export = $_GET['type'];
$room_export = $_GET['room'];

if (!isset($type_export)) $type_export = 1;
if (!isset($room_export)) $room_export = null;

class PDF extends FPDF
{
    function Footer()
    {
        $this->SetFont('Arial', 'I', 8);
        $this->SetY(-15);
        $this->Cell(140,5,utf8_decode('Página ').$this->PageNo().' / {nb}',0,0,'L');
        $this->Cell(140,5,date('d/m/Y | G:i') ,0,1,'R');
        
    }
}
$session_query = "SELECT * FROM places";
$session_result = mysqli_query($db, $session_query);

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true, 20);
$pdf->SetTopMargin(15);
$pdf->SetLeftMargin(8);
$pdf->SetRightMargin(8);

while ($row_session = mysqli_fetch_assoc($session_result)) {
    $session_p = $row_session['id_place'];
    $session_name = $row_session['name_place'];

    $product_query = "SELECT * FROM item WHERE id_place = $session_p AND id_status != 0";

    if ($type_export == 2) {
        if ($session_p !== $room_export) continue;
        $product_query = "SELECT * FROM item WHERE id_place = $room_export AND id_status != 0";
    }
    if ($type_export == 3) {
        $product_query = "SELECT * FROM item WHERE id_place = $session_p AND id_status = 0";
    }
    
    $product_result = mysqli_query($db, $product_query);

    if (mysqli_num_rows($product_result) == 0 && $type_export == 3) continue;
  
    $pdf->AddPage("L");

    $resp_query = "SELECT * FROM users WHERE active_user = 1 LIMIT 1";
    $resp_result = mysqli_query($db, $resp_query);
    $resp_name = mysqli_fetch_assoc($resp_result)['name_user'];

    $pdf->Image('../assets/pdf/logo.png', 75, 15, 60);
            
    $pdf->SetFont('Arial','',11);  
    $pdf->Text(170,22, utf8_decode("CNPJ: 07.954.514/0158-23"));

    $pdf->SetFont('Arial','',11);  
    $pdf->Text(170,26, "INEP: 23085592");

    $pdf->SetFont('Arial','B',12);

    $mid_x = $pdf->GetPageWidth() / 2;
    $text = utf8_decode('INVENTÁRIO SINTÉTICO DE BENS MÓVEIS - ' . ($type_export == 3 ? 'INSENSÍVEIS' : 'SERVÍVEIS'));
    $pdf->Text($mid_x - ($pdf->GetStringWidth($text) / 2),55, $text);

    $pdf->Ln(52);

    $pdf->SetFont('Arial', 'B', 11);

    $mid_x = $pdf->GetPageWidth() / 2;
    $text = utf8_decode('AMBIENTE - ' . mb_strtoupper($session_name, 'UTF-8'));
    $pdf->Text($mid_x - ($pdf->GetStringWidth($text) / 2),65, $text);

    $pdf->SetFillColor(0, 0, 0);
    $pdf->SetDrawColor(0, 0, 0);
    $pdf->SetTextColor(255, 255, 255);

    $pdf->Ln(4);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(30, 7, utf8_decode('TOMBAMENTO'), 1, 0, 'C', 1);
    $pdf->Cell(150, 7, utf8_decode('ESPECIFICAÇÃO DETALHADA'), 1, 0, 'C', 1);
    $pdf->Cell(30, 7, utf8_decode('AQUISIÇÃO EM'), 1, 0, 'C', 1);
    $pdf->Cell(30, 7, utf8_decode('VALOR'), 1, 0, 'C', 1);
    $pdf->Cell(40, 7, utf8_decode('CONSERVAÇÃO'), 1, 0, 'C', 1);

    $pdf->Ln(7);
    $pdf->SetFont('Arial', '', 10);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetDrawColor(65, 61, 61);
    $bgColor = true;

    if (mysqli_num_rows($product_result) == 0) {
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Cell(30 + 150 + 30 + 30 + 40, 10, utf8_decode('SEM ITENS'), 1, 1, 'C', 1);
    } else {
        while ($row = mysqli_fetch_assoc($product_result)) {
            $id_status = $row['id_status'];
            $status_query = "SELECT * FROM status WHERE id_status = $id_status";
            $status_data = mysqli_fetch_assoc(mysqli_query($db, $status_query));
            $status_name = $status_data['name_status'];

            $pdf->SetFillColor($bgColor ? 255 : 231, $bgColor ? 255 : 231, $bgColor ? 255 : 231);

            $tomb_item = $row["ci_item"];

            if ($tomb_item == null) $tomb_item = "S/T";

            $pdf->Cell(30, 10, $tomb_item, 1, 0, 'C', 1);

            $desc_item = mb_strtoupper($row['name_item'], 'UTF-8') . ($row['about_item'] != "" ? " - " . mb_strtoupper($row['about_item'], 'UTF-8') : "");

            $pdf->Cell(150, 10, utf8_decode($desc_item), 1, 0, 'L', 1);
            $pdf->Cell(30, 10, utf8_decode($row['got_item']), 1, 0, 'C', 1);
            $actual_date = date('Y-m-d');

            $pdf->Cell(30, 10, utf8_decode($row['price_item']), 1, 0, 'C', 1);

            $pdf->SetTextColor(0, 0, 0);

            $pdf->Cell(40, 10, utf8_decode($status_name), 1, 0, 'C', 1);
            $pdf->Ln();

            $bgColor = !$bgColor;
        }
    }
}

$filename = "Tomb_MM_" . date("d.m.Y") . ".pdf";
$pdf->Output($filename, "I");

/* header("Location: ../views/index.php"); */
?>