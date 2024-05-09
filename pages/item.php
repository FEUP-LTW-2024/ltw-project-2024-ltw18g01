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
            <div class = "background">
                <div class ="grid-container">
                    <div class = "item-picture">
                        <img src=<?=$item -> image_url ?> ">
                    </div>
                    <div class = "user-data">
                        <img class= "user-image" src= "/images/products/macintoshplus.jpg">
                        <div class ="sales-info">
                            <div class ="user-info">
                                <p id = "username"> <?=$seller -> username?>  </p>
                                <p id = "sales-history"> <?=$seller -> salesNumber?> sales completed</p>
                            </div>
                            <img class = "star" src= "/images/others/starbox.png">
                            <p id = "star-score"> <?=$seller -> userRating?> </p>
                            <div class = "button-message-seller"> 
                                <p id= "button-text"> Message seller </p>
                            </div>
                        </div>
                    </div>
                    <div class = "item-info"> 
                        <p id = "item-name"> <?=$item -> title ?></p>
                        <p id = "item-description"> <?=$item -> description ?>  </p>
                        <p id  = "item-price" > <?=$item -> price ?> </p>
                        <p id  = "shipping-price"> Estimated shipping cost: <?=$item -> shippingSize ?></p>
                        <div class= "containers">
                            <div class = "button-buy-now"> 
                                <p id = "button-text"> Buy now </p>
                            </div>
                            <div class = "button-request-new-price"> 
                                <p id = "button-text"> Request new price </p>
                            </div>
                        </div>    
                    </div>
                </div>
            </div>          
        </section>
    </body>
</html>