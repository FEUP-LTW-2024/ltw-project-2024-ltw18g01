<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../sessions/session.php');
  require_once(__DIR__ . '/../db/connection.db.php');
  require_once(__DIR__ . '/../db/user.class.php');
  require_once(__DIR__ . '/../templates/common.tpl.php');


  $session = new Session();

  if (!$session->isLoggedIn()) die(header('Location: ../pages/index.php'));

  $db = databaseConnect();

  $user = User::getUser($db, $session->getId());
  if ($user->isAdmin == false) die(header('Location : ../pages/index.php'));
  $allusers = User::getAllUsers($db);
?>


<!DOCTYPE html>
<html>
   <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <title>Techie</title>

        <link rel="stylesheet" href="/css/index_style.css"> 
        <link rel="stylesheet" href="/css/account.css">
        <link rel="stylesheet" href="/css/listings.css">
        <link rel="stylesheet" href="/css/admin.css">

   </head>
   <body>
   <?php
        drawTopBar($session, $db);
        ?>
        <!-- Section of quotes-->
        <br><br>
        <section class="user">
            <p class="user-profile">Admin menu</p>
            <p class="catch-phrase"> If you're reading this, you're an admin! </p>
            <br>
            <?php
            foreach ($allusers as $userr) { ?>

            <div id="item-card">
            <img class="user-img" src="<?php echo $userr->image_url; ?>">
            <p id="user-title"><?php echo $userr->firstName . " " . $userr->lastName; ?></p>
            <p id="user-name"><?php echo "@" .$userr->username; ?></p>

            <?php
            if ($userr->isAdmin) { ?>
              <form method="POST" action="../actions/update_admin_action.php">
                <input type="hidden" name="userId" value="<?php echo $userr->userId; ?>">
                <button>Remove admin</button>
              </form>
            <?php } ?>

            <?php
            if ($userr->isAdmin == false) { ?>
              <form method="POST" action="../actions/update_admin_action.php">
                <input type="hidden" name="userId" value="<?php echo $userr->userId; ?>">
                <button>Add admin</button>
              </form>
            <?php } ?>
            

            </div>

            <br>
            <br>

            <?php } ?>
        </section>
    </body> 
</html>
