<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../sessions/session.php');
  $session = new Session();

  if (!$session->isLoggedIn()) die(header('Location: /'));

  require_once(__DIR__ . '/../db/connection.db.php');
  require_once(__DIR__ . '/../db/user.class.php');
  require_once(__DIR__ . '/../templates/common.tpl.php');
  require_once(__DIR__ . '/../templates/account.tpl.php');

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
        <link rel="stylesheet" href="/css/login_reg.css">
   </head>
   <body>
   <?php
        drawTopBar($session, $db);
        ?>
        <!-- Section of quotes-->
        <br><br>
        <section class="user">
            <p class="user-profile">Edit profile</p>
            <p class="catch-phrase">Adjust it to your liking.</p>
            <!--
            <img class="user-image" src=<?php echo $user->image_url;?>>
            -->
            <?php
            drawEditProfile($user, $db);
            ?>
        </section>
    </body> 
</html>
