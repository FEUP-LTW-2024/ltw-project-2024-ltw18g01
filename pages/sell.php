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
        <link rel="stylesheet" href="/css/sell.css">
   </head>
   <body>
   <?php
        drawTopBar($session, $db);
        ?>
        <!-- Section of quotes-->
        <br><br>
        <!--
        <section class="user">
            <p class="user-profile">User Profile</p>
            <p class="catch-phrase"> Your profile - make it your own! </p>
            <br>
            <img class="user-image" src=<?php // echo $user->image_url;?>>
            <p class = "name"><?php // echo $user->firstName . ' ' . $user->lastName; ?></p>
            <p class = "username"> &#64;<?php // echo $user->username;?></p>
            <div class= "containers">
                <a href="../pages/edit_account.php">
                    <div class="form-button">
                        <p id="form-button-text">Edit profile</p>            
                    </div>
                </a>
            
                <div class="form-button">            
                    <p id="form-button-text">My items</p>
                </div>
            </div>
            <form action="../actions/logout_action.php" method="post" class="logout">
                <button type="submit" class="form_button">Logout</button>
            </form>
        </section>
        -->
        <section class="sell_item">
            <p class="title">Sell an item at Techie</p>
            <p class="subtitle">Zero fees, zero hassle. All the money goes to you.</p>
        </section>
        <section class="item_pictures">
            <p class="section-title">Item pictures</p>
            <p class="section-subtitle">Maximum of 20 pictures. Be sure to include real pictures of the item.</p>
            <button>Upload</button>
        </section>
        <br>
        <br>
        <section class="name_desc">
            <p class="section-title">Title</p>
            <p class="section-title">Description</p>
        </section>


        <section class="category">
            <p class="section-title">Choose a category</p>
        </section>

        <section class="status">
            <p class="section-title">Condition</p>
            <input type="checkbox" id="verygood" name="status" value="Very Good">
            <label for="verygood">Very Good</label><br>
            <input type="checkbox" id="good" name="status" value="Good">
            <label for="good">Good</label><br>
            <input type="checkbox" id="decent" name="status" value="Decent">
            <label for="decent">Decent</label><br>
            <input type="checkbox" id="forparts" name="status" value="For parts">
            <label for="forparts">For parts</label><br>

            <script src="../js/checkbox.js"></script>
        </section>

        <section class="shipping">
            <p class="section-title">Shipping size</p>
            <input type="checkbox" id="small" name="shipping_size" value="Small">
            <label for="small">Small(<1kg)</label><br>
            <input type="checkbox" id="medium" name="shipping_size" value="Medium">
            <label for="medium">Medium(<5kg)</label><br>
            <input type="checkbox" id="large" name="shipping_size" value="Large">
            <label for="large">Large(+5kg)</label><br>

            <script src="../js/checkbox.js"></script>
        </section>

    </body> 
</html>
