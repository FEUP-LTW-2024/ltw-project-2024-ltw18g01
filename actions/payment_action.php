<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../sessions/session.php');
  $session = new Session();

  require_once(__DIR__ . '/../db/connection.db.php');
  require_once(__DIR__ . '/../db/item.class.php');
  require_once(__DIR__ . '/../db/user.class.php');

  $db = databaseConnect();
  Item::updateSold($db, (int)$_GET['itemId']);
  $user = User::getUser($db, $session->getId());
  $item = Item::getItem($db, (int)$_GET['itemId']);
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
            <p id="text">>>RECEIPT<<</p>
            <p id="text"><?php echo $item->title; ?></p>
        </div>
        <div id="ads">
            <p id="header"><?php echo "Total cost: ". $item->price + $item->shippingCost . "€*"; ?></p>
            <p id="header2">Paid with bank card.</p>
            <p id="header2"><?php echo $user->name(); ?></p>
            <p id="header2"><?php echo $user->address . ", " . $user->city . ", " . $user->country; ?></p>
            <p id="disclaimer">*You paid for a shipping label.</p>
            <br>
            <p id="header2">This receipt is your payment proof. Save it to avoid any possible problems.</p>
            <p id="header">Thank you for shopping at Techie and helping with a more sustainable world!</p>
        </div>
        

    </body>