<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../sessions/session.php');
  require_once(__DIR__ . '/../db/connection.db.php');
  require_once(__DIR__ . '/../db/user.class.php');
  require_once(__DIR__ . '/../db/wishlist.class.php');
  require_once(__DIR__ . '/../templates/common.tpl.php');

  $db = databaseConnect();
  $session = new Session();
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

        <link rel="stylesheet" href="/css/login_reg.css">
        <link rel="stylesheet" href="/css/search.css">
        <link rel="stylesheet" href="/css/wishlist.css">
   </head>
    <body>
        <?php
        drawTopBar($session, $db);
        ?>

        <p id="username">Search</p>
            <div class="form_rectangle">
                <input id="search-data" type="text" name="search-data" placeholder="In need of something?">
            </div>
        
        <br>
        <script>
            const wishlistItemIds = <?php echo json_encode($wishlistItemIds); ?>;
        </script>

        <script src="../js/ajax_search.js" defer></script>

    </body>
</html>