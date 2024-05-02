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
   </head>
    <body>
        <?php
        drawTopBar($session, $db);
        ?>
        <!-- Section of quotes-->
        <section>
            <div class="info-text">
                <p id="First-text">Fancy some pre-loved tech?</p>
                <p id="Second-text">Buy and sell at Techie. Zero fees*. Zero hassle.</p>
                <p id="disclaimer" >*Buyer pays for the shipping.</p>
            </div>
        </section>
        <!-- New Arrivals-->
        <section>
            <div class="displays">
                <p class="category">New arrivals</p>
                <p class="see_more">See more</p>
            </div>
            <div class="slide">
                <div class="image_display">
                    <img src="/images/products/macintoshplus.jpg">
                    <img src="/images/products/commodore64.jpg">
                    <img src="/images/products/ZXSpectrum48k.jpg">
                    <img src="/images/products/Maquinacanoneos.jpg">
                    <img src="/images/products/motorlineMC1.jpg">
                    <img src="/images/products/tecladogamer.jpg">
                    <img src="/images/products/GiraDiscosThorensTD125MKII.jpg">
                </div>
            </div>
        </section>
        <br>
        <br>
        <br>

         <!-- SEGA example-->
         <section>
            <div class="displays">
                <p class="category">SEGA - Consoles and videogames</p>
                <p class="see_more">See more</p>
            </div>
            <div class="slide">
                <div class="image_display">
                    <img src="/images/products/macintoshplus.jpg">
                    <img src="/images/products/commodore64.jpg">
                    <img src="/images/products/ZXSpectrum48k.jpg">
                    <img src="/images/products/Maquinacanoneos.jpg">
                    <img src="/images/products/motorlineMC1.jpg">
                    <img src="/images/products/tecladogamer.jpg">
                    <img src="/images/products/GiraDiscosThorensTD125MKII.jpg">
                </div> 
            </div>
        </section>
    </body>
</html>
