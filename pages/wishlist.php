<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../sessions/session.php');
  require_once(__DIR__ . '/../db/connection.db.php');
  require_once(__DIR__ . '/../db/user.class.php');
  require_once(__DIR__ . '/../db/wishlist.class.php');
  require_once(__DIR__ . '/../db/item.class.php');
  require_once(__DIR__ . '/../templates/common.tpl.php');

  $session = new Session();

  if (!$session->isLoggedIn()) die(header('Location: /pages/login.php'));

  $db = databaseConnect();

  $user = User::getUser($db, $session->getId());

  $wishlistItemIds = Wishlist::getWishlistUserIDs($db, $session->getId());
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

        <link rel="stylesheet" href="/css/listings.css">
        <link rel="stylesheet" href="/css/wishlist.css">
        <link rel="stylesheet" href="/css/account.css">
   </head>
    <body>
        <?php
        
        drawTopBar($session, $db);

        $wishlist = Wishlist::getWishlistUser($db, $session->getId());

        ?>
        
        <p class="user-profile">Wishlist</p>
        <p class="catch-phrase">Let your wishes be granted!</p>
        <div class="image_display">
        <?php


        foreach ($wishlist as $wlitem) { ?>
            <div class="image_wrapper">
                <a href="/../pages/item.php?itemId=<?=$wlitem['itemId']?>">
                <img src="<?php echo $wlitem['image_url']; ?>">
                <?php
                if ($wlitem['sold'] == true) { ?>
                    <div class="overlay">
                        <p>SOLD</p>
                    </div>
                <?php } ?>
                </a>
                <p><?php echo $wlitem['price'] . "€  | " . $wlitem['likes'] . " likes"; ?></p>
                
                <form method="POST" action="/../actions/like_action.php">
                    <input type="hidden" name="itemId" value="<?php echo $wlitem['itemId']; ?>">
                    <input type="hidden" name="userId" value="<?php echo $session->getId(); ?>">

                    <?php if (in_array($wlitem['itemId'], $wishlistItemIds)) { ?>
                        <button id="liked"></button>
                    <?php } else { ?> 
                        <button></button>
                    <?php } ?>

                </form>
                
                <!-- ajax ver.
                <button class="like-button" data-user="<?php/* echo $session->getId(); */?>" data-item="<?php/* echo $wlitem['itemId']; */?>"></button>
                <script src="/../js/wishlist.js"></script>
                --->
            </div>

        <?php } ?>
        
        </div>



    </body>
</html>