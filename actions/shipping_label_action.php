<?php
declare(strict_types=1);

require_once(__DIR__ . '/../sessions/session.php');
$session = new Session();
if (!$session->isLoggedIn()) die(header('Location: /pages/login.php');

require_once(__DIR__ . '/../db/connection.db.php');
require_once(__DIR__ . '/../db/user.class.php');
require_once(__DIR__ . '/../db/item.class.php');

$db = databaseConnect();

$user = User::getUser($db, (int)$_POST['userId']);
$item = Item::getItem($db, (int)$_POST['itemId']);

/*
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

*/

?>
<!DOCTYPE html>
<html>
   <head>
   <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Libre+Barcode+39+Text&display=swap" rel="stylesheet">
        
        <title>Techie - Shipping label</title>

        <link rel="stylesheet" href="/css/shipping_label.css">
   </head>
    <body>
        <div id="titles">
            <p id="logo">Techie</p>
            <p id="text">>>SHIPPING LABEL<<</p>
            <p id="text"><?php echo "ORIGIN: " . strtoupper($user->country); ?></p>
            <p id="text"><?php echo $user->postalCode; ?></p>
        
        </div>
        <p id="notcover">Do not cover this box.</p>
        <div id="barc_box">
            <div id="barcode-wrapper">
            <p id="barcode"><?php echo "*TECHIE" . $user->userId . $_POST['itemId'] . "*";?></p>
            </div>
        </div>
        <p id="notcover">Cut across the line below and glue the upper part to your box.</p>
        <p id="line">-------------------------------------------------------------------------------------------------------------</p>
        
        <div id="ads">
            <p id="header">Fancy some pre-loved tech?</p>
            <p id="header2">Buy and sell at Techie. Zero fees*. Zero hassle.</p>
            <p id="disclaimer">*Buyer pays for the shipping.</p>
            <br>
            <p id="header">The buyer of your item has paid for this shipping label.</p>
            <p id="header">Print this label and take it to one of our partners.</p>
            <p id="header">They will hand it for you!</p>
        </div>
    </body>