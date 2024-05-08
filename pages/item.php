<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../sessions/session.php');
  require_once(__DIR__ . '/../db/connection.db.php');
  require_once(__DIR__ . '/../db/user.class.php');
  require_once(__DIR__ . '/../templates/common.tpl.php');

  $db = databaseConnect();
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
                        <img src= "/images/products/macintoshplus.jpg" alt="Item Picture">
                    </div>
                    <div class = "user-data">
                        <img class= "user-image" src= "/images/products/macintoshplus.jpg">
                        <div class ="user-info">
                            <p id = "username"> miguelmoita </p>
                            <p id = "sales-history"> 58 sales completed</p>
                            <img class = "star" src= "/images/starbox.png">
                            <p id = "star-score"> 4.91 </p>
                            <div class = "button"> 
                                <p id= "button-text"> Message seller </p>
                            </div>
                        </div>
                    </div>
                    <div class = "item-info"> 
                        <p id = "item-name"> Macintoshplus </p>
                        <p id = "item-description"> Bought this Macinto in 1998 but, as I recently need money, I'm selling this relic. The price is negotiable and, if you have any doubts message me! </p>
                        <p id  = "item-price" > 100,00€ </p>
                        <p id  = "shipping-price"> Estimated shipping cost: 29.99€ </p>
                        <div class = "button"> 
                            <p id = "button-text"> Buy now </p>
                        </div>
                         <div class = "button"> 
                            <p id = "button-text"> Request new price </p>
                        </div>
                    </div>
                </div>
            </div>          
        </section>
    </body>
</html>