<?php
    declare(strict_types=1);

    require_once(__DIR__ . '/../sessions/session.php');
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
    <?php drawTopBar($session, $db); ?>
        
        <section>
            <div class="login-text">
                <p id="First-text">Register to Techie</p>
                <p id="Second-text">Already have an account? Login <a href="login.php" class="register_button">here!</a></p>
            </div>
        </section>
        <section>
            <form method="post" action="/actions/register_action.php" enctype="multipart/form-data">
                <p id="username">First Name</p>
                <div class="form_rectangle">
                    <input id="input-login" type="text" name="firstName" required>
                </div>
                <p id="username">Last Name</p>
                <div class="form_rectangle">
                    <input id="input-login" type="text" name="lastName" required>
                </div>
                <p id="username">Username</p>
                <div class="form_rectangle">
                    <input id="input-login" type="text" name="username" required>
                </div>
                <p id="username">Address</p>
                <div class="form_rectangle">
                    <input id="input-login" type="text" name="address" required>
                </div>
                <p id="username">City</p>
                <div class="form_rectangle">
                    <input id="input-login" type="text" name="city" required>
                </div>
                <p id="username">Country</p>
                <div class="form_rectangle">
                    <input id="input-login" type="text" name="country" required>
                </div>
                <p id="username">Postal Code</p>
                <div class="form_rectangle">
                    <input id="input-login" type="text" name="postalCode" required>
                </div>
                <p id="username">Phone</p>
                <div class="form_rectangle">
                    <input id="input-login" type="text" name="phone" required>
                </div>
                <p id="username">Email</p>
                <div class="form_rectangle">
                    <input id="input-login" type="email" name="email" required>
                </div>
                <p id="username">Password</p>
                <div class="form_rectangle">
                    <input id="input-login" type="password" name="password" required>
                </div>
                <p id="username">Confirm password</p>
                <div class="form_rectangle">
                    <input id="input-login" type="password" name="password" required>
                </div>
                <p id="username">Picture</p>
                    <input name="image" type="file" id="fileInput" accept="image/*" required>
                <br>
                <br>
                <div>
                    <button type="submit" class="register-button">
                        <p id="register-button-text2">Register</p>
                    </button>
                </div>
                <br>
                <br>
                <br>
                <br>
            </form>
        </section>
    </body>
</html>
