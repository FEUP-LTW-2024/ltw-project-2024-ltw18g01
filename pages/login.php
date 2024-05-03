<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../sessions/session.php');
  $session = new Session();

  require_once(__DIR__ . '/../db/connection.db.php');
  require_once(__DIR__ . '/../db/user.class.php');
  require_once(__DIR__ . '/../templates/common.tpl.php');

  $db = databaseConnect();
?>

<!DOCTYPE html>
<html>
   <head>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
        
        <title>Techie</title>

        <link rel="stylesheet" href="/css/index_style.css">
        <link rel="stylesheet" href="/css/login_reg.css"> 
   </head>
    <body>
    <?php
        drawTopBar($session, $db);
        ?>
        <!-- Section of quotes-->
        <section>
            <div class="login-text">
                <p id="First-text">Login to Techie</p>
                <p id="Second-text">New to Techie? Register your account <a href="register.php" class="register_button">here!</a></p>
            </div>
        </section>

        <section>
            <form action="../actions/login_action.php" method="post" class="login">
                <p id="username">Username</p>
                <div class="form_rectangle">
                    <input id="input-login" type="email" name="email" placeholder="email">
                </div>
                <p id="username">Password</p>
                <div class="form_rectangle">
                    <input id="input-login" type="password" name="password" placeholder="password">
                </div>

                <button type="submit"  class="form_rectangle" id="form_button">Login</button>
            </form>
        </section>
    </body>
</html>
