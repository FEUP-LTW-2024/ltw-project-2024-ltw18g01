<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../sessions/session.php');
  $session = new Session();

  if (!$session->isLoggedIn()) die(header('Location: /'));

  require_once(__DIR__ . '/../db/connection.db.php');
  require_once(__DIR__ . '/../db/user.class.php');

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
   </head>
   <body>
        <header  id="navbar-text" class="navbar">
            <img class="logo" src="/images/logo/logo_techie.png" alt="logo" /> 
            <a class="active" href="index.php">Home</a>
            <a href="gaming.php">Gaming</a>
            <a href="pcs.php">PCs</a>
            <a href="mobile.php">Mobiles</a>
            <a href="tvs.php">TVs</a>
            <a href="music.php">Music</a>
            <a href="photo_video.php">Photo&Video</a>
            <a class="avatar" href="login.php"> <img class="avatar" src="/images/guesticon.png" alt="guest"/></a>
        </header>
        <br><br>
        <section class="user">
            <p class="user-profile">User Profile</p>
            <p class="catch-phrase"> Your profile - make it your own! </p>
            <br>
            <img class="user-image" src="/images/users/rodrigo.jpeg">
            <p class = "name"> Rodrigo de Sousa </p>
            <p class = "username"> &#64;rodrigodesousa.pt </p>
            <div class= "containers">
                <div class="form-button">
                    <p id="form-button-text">Edit profile</p>            
                </div>            
                <div class="form-button">            
                    <p id="form-button-text">My items</p>
                </div>
            </div> 
        </section>
    </body> 
</html>
