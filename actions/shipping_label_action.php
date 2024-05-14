<?php
declare(strict_types=1);

require("../utils/fpdf/fpdf.php");
require_once(__DIR__ . '/../sessions/session.php');
$session = new Session();

if (!$session->isLoggedIn()) die(header('Location: /'));

require_once(__DIR__ . '/../db/connection.db.php');
require_once(__DIR__ . '/../db/user.class.php');

$db = databaseConnect();

$user = User::getUser($db, (int)$_POST['userId']);

$pdf = new FPDF();

$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 18);

$pdf->Cell(60, 20, $user->username);
$pdf->Cell(60, 20, "Consegui uma etiqueta de envio!");

$pdf->Output();
?>
