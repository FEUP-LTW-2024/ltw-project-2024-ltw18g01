<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../sessions/session.php');
  $session = new Session();

  if (!$session->isLoggedIn()) die(header('Location: /'));

  require_once(__DIR__ . '/../db/connection.db.php');
  require_once(__DIR__ . '/../db/user.class.php');
  require_once(__DIR__ . '/../templates/common.tpl.php');

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
            <form action="../actions/edit_profile_action.php" method="post" class="profile">
                <p id="username">First name</p>
                <div class="form_rectangle">
                    <input id="input-login" type="text" name="firstName" value="<?=$user->firstName?>">
                </div>

                <p id="username">Last name</p>
                <div class="form_rectangle">
                    <input id="input-login" type="text" name="lastName" value="<?=$user->lastName?>">
                </div>

                <p id="username">Username</p>
                <div class="form_rectangle">
                    <input id="input-login" type="text" name="username" value="<?=$user->username?>">
                </div>

                <p id="username">Address</p>
                <div class="form_rectangle">
                    <input id="input-login" type="text" name="address" value="<?=$user->address?>">
                </div>

                <p id="username">City</p>
                <div class="form_rectangle">
                    <input id="input-login" type="text" name="city" value="<?=$user->city?>">
                </div>

                <p id="username">Country</p>
                <div class="form_rectangle">
                    <input id="input-login" type="text" name="country" value="<?=$user->country?>">
                </div>

                <p id="username">Postal code</p>
                <div class="form_rectangle">
                    <input id="input-login" type="text" name="postalCode" value="<?=$user->postalCode?>">
                </div>

                <p id="username">Phone number</p>
                <div class="form_rectangle">
                    <input id="input-login" type="text" name="phone" value="<?=$user->phone?>">
                </div>
                
                <button type="submit"  class="form_rectangle" id="form_button">Save</button>
            </form>
        </section>
    </body> 
</html>
