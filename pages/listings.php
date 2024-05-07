<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../sessions/session.php');
  require_once(__DIR__ . '/../db/connection.db.php');
  require_once(__DIR__ . '/../db/user.class.php');
  require_once(__DIR__ . '/../db/item.class.php');
  require_once(__DIR__ . '/../templates/common.tpl.php');


  $session = new Session();

  if (!$session->isLoggedIn()) die(header('Location: /'));

  $db = databaseConnect();

  $user = User::getUser($db, $session->getId());
?>


<!DOCTYPE html>
<html>
   <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
        
        <title>Techie</title>

        <link rel="stylesheet" href="/css/index_style.css"> 
        <link rel="stylesheet" href="/css/account.css">
        <link rel="stylesheet" href="/css/listings.css">
   </head>
   <body>
   <?php
        drawTopBar($session, $db);
        ?>
        <!-- Section of quotes-->
        <p class="user-profile">My items</p>
        <p class="catch-phrase">Your place for sales and purchases!</p>
        <br>
        <section class="items">
            <div id="item-card">
                <img src="../images/products/commodore64.jpg"></img>
                <div id="item-things">
                    <p id="item-title">Playstation 5</p>
                    <br>
                    <p id="item-status">Listed successfully.</p>
                    <br>
                    <p id="item-price">100,00€</p>
                </div>
                <div id="item-user-status">
                    <p id="item-user-status-text">SOLD</p>
                </div>
            </div>
        </section>
    </body> 
</html>
