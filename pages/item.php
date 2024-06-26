<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../sessions/session.php');
  require_once(__DIR__ . '/../db/connection.db.php');
  require_once(__DIR__ . '/../db/user.class.php');
  require_once(__DIR__ . '/../db/item.class.php');
  require_once(__DIR__ . '/../templates/common.tpl.php');

  $db = databaseConnect();
  $itemId = (int)$_GET['itemId']; 
  $item = Item::getItem($db,$itemId);
  $seller = User::getUser($db,$item -> seller);
  if ($session->isLoggedIn()) {
    $user = User::getUser($db, $session->getId());
    $isAdmin = $user->isAdmin;
  } else {
    $isAdmin = false;
  }
  $curUser = (int)$session->getId();
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
        <link rel="stylesheet" href="/css/item.css"> 
   </head>
    <body>
        <?php
         drawTopBar($session, $db);
        ?>      
        <br>
        <section>
        <?php 
            drawItems($item, $seller, $itemId, $isAdmin, $curUser);
        ?>
        </section>
    </body>
</html>