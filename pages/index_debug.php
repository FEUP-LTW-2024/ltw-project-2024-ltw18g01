<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../db/connection.db.php');

  require_once(__DIR__ . '/../db/item.class.php');

  require_once(__DIR__ . '/../cards/item.card.php');

  $db = databaseConnect();

  $item = Item::getItem($db, intval($_GET['id']));

  drawItemHomepage($item);
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
    <header class="navbar" id="navbar-text">
        <a class="logo" href="index.php"><img src="/images/logo/logo_techie.png" alt="logo"></a>
        <a class="active desktop" href="index.php">Home</a>
        <a class="desktop" href="gaming.php">Gaming</a>
        <a class="desktop" href="pcs.php">PCs</a>
        <a class="desktop" href="mobile.php">Mobiles</a>
        <a class="desktop" href="tvs.php">TVs</a>
        <a class="desktop" href="music.php">Music</a>
        <a class="desktop" href="photo_video.php">Photo&Video</a>
        <a class="avatar" href="login.php"><img class="avatar" src="/images/guesticon.png" alt="guest"></a>
        <div class="mobile-menu">
            <button onclick="toggleDesktopMenu()"> 
                <img src="/images/icon-list.png" alt="Menu-Icon">
            </button>
            <div class="desktop-menu">
                <a class="desktop" href="index.php">Home</a>
                <a class="desktop" href="gaming.php">Gaming</a>
                <a class="desktop" href="pcs.php">PC's</a>
                <a class="desktop" href="mobile.php">Mobiles</a>
                <a class="desktop" href="tvs.php">TV's</a>
                <a class="desktop" href="music.php">Music</a>
            </div>
        </div>
        <div class="categories-navbar">
            <a class="desktop" href="index.php">Home</a>
            <a class="desktop" href="gaming.php">Gaming</a>
            <a class="desktop" href="pcs.php">PC's</a>
            <a class="desktop" href="mobile.php">Mobiles</a>
            <a class="desktop" href="tvs.php">TV's</a>
            <a class="desktop" href="music.php">Music</a>
        </div>
    </header>

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
