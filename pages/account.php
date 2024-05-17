<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../sessions/session.php');
  require_once(__DIR__ . '/../db/connection.db.php');
  require_once(__DIR__ . '/../db/user.class.php');
  require_once(__DIR__ . '/../templates/common.tpl.php');


  $session = new Session();

  if (!$session->isLoggedIn()) die(header('Location: /pages/login.php'));

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
   <?php
        drawTopBar($session, $db);
        ?>
        <!-- Section of quotes-->
        <br><br>
        <section class="user">
            <p class="user-profile">User Profile</p>
            <p class="catch-phrase"> Your profile - make it your own! </p>
            <br>
            <img class="user-image" src=<?php echo $user->image_url;?>>
            <p class = "name"><?php echo $user->firstName . ' ' . $user->lastName; ?></p>
            <p class = "username"> &#64;<?php echo $user->username;?></p>
            <div class= "containers">
                <a href="../pages/edit_account.php">
                    <div class="form-button">
                        <p id="form-button-text">Edit profile</p>            
                    </div>
                </a>
                <a href="../pages/listings.php">
                    <div class="form-button">            
                        <p id="form-button-text">My items</p>
                    </div>
                </a>
                <?php
                if ($user->isAdmin) { ?>
                    <a href="../pages/admin.php">
                    <div class="form-button">            
                        <p id="form-button-text">Admin menu</p>
                    </div>
                    </a>
                <?php } ?>

            </div>
            <form action="../actions/logout_action.php" method="post" class="logout">
                <button type="submit" class="logout-button">Logout</button>
            </form>
        </section>
    </body> 
</html>
