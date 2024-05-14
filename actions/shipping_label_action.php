<?php
declare(strict_types=1);

require("../utils/fpdf/fpdf.php");
require_once(__DIR__ . '/../sessions/session.php');
$session = new Session();

if (!$session->isLoggedIn()) die(header('Location: /'));

require_once(__DIR__ . '/../db/connection.db.php');
require_once(__DIR__ . '/../db/user.class.php');
require_once(__DIR__ . '/../db/item.class.php');

$db = databaseConnect();

$user = User::getUser($db, (int)$_POST['userId']);

$pdf = new FPDF();

$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 20);

$pdf->Cell(0, 20, ">TECHIE SHIPPING LABEL<", 0, 1, 'C');

$pdf->Cell(0, 20, $user->postalCode . " - ". strtoupper($user->city), 0, 1, 'C');

$pdf->Rect(85, 50, 40, 20);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Text(92, 53, "Do not cover this box.");
$pdf->SetFont('Arial', 'B', 45);
$pdf->Text(87, 65, "||||||||");

$pdf->SetFont('Arial', 'B', 7);
$pdf->Line(15, 90, 195, 90);
$pdf->Text(75, 93, "Cut by the line and glue the upper part to your shipping box.");

$pdf->SetFont('Arial', 'B', 20);

$pdf->Cell(0, 120, "Item sold: " . $_POST['title'], 0, 1, 'C');
$pdf->Output();

?>
