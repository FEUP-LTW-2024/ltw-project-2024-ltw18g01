<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../sessions/session.php');
  require_once(__DIR__ . '/../db/connection.db.php');
  require_once(__DIR__ . '/../db/user.class.php');
  require_once(__DIR__ . '/../db/subcategory.class.php');
  require_once(__DIR__ . '/../db/category.class.php');
  require_once(__DIR__ . '/../templates/common.tpl.php');


  $session = new Session();

  if (!$session->isLoggedIn()) die(header('Location: ../pages/index.php'));

  $db = databaseConnect();

  $user = User::getUser($db, $session->getId());
  if ($user->isAdmin == false) die(header('Location : ../pages/index.php'));
  $allusers = User::getAllUsers($db);
  $subcat = Subcategory::getAllSubcategories($db);
  $categories = Category::getCategories($db);
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
        <link rel="stylesheet" href="/css/listings.css">
        <link rel="stylesheet" href="/css/admin.css">

   </head>
   <body>
   <?php
        drawTopBar($session, $db);
        ?>
        <p class="user-profile">Admin menu</p>
        <p class="catch-phrase"> If you're reading this, you're an admin! </p>
        <div class="button-container">
          <button id="toggleBtn">Edit Users</button>
          <button id="toggleBtnCats">Edit Subcategories</button>
          <button id="toggleBtnAddCats">Add Subcategory</button>
        </div>
        <br><br>
        <section class="user" id="userSection">

            <br>
            <?php
            foreach ($allusers as $userr) { ?>
            <div id="item-card">
                <img class="user-img" src="<?php echo $userr->image_url; ?>">
                <p id="user-name"><?php echo "@" . $userr->username; ?></p>

                <div class="button-container">
                    <?php if ($userr->isAdmin) { ?>
                        <form method="POST" action="../actions/update_admin_action.php">
                            <input type="hidden" name="userId" value="<?php echo $userr->userId; ?>">
                            <button>Remove admin</button>
                        </form>
                    <?php } else { ?>
                        <form method="POST" action="../actions/update_admin_action.php">
                            <input type="hidden" name="userId" value="<?php echo $userr->userId; ?>">
                            <button>Add admin</button>
                        </form>
                    <?php } ?>

                    <form method="POST" action="../actions/ban_user_action.php">
                        <input type="hidden" name="userId" value="<?php echo $userr->userId; ?>">
                        <button>Ban user</button>
                    </form>
                </div>
            </div>
            <br>
            <br>

            <?php } ?>
        </section>
      
        <section class="user" id="subcategorySection">

            <br>
            <?php
            foreach ($subcat as $sub) { ?>
            
            <?php
            $corresponds = Category::getCategory($db, $sub['category']);
            ?>
            
            <div id="item-card">
            <p id="user-title"><?php echo $sub['name']?></p>
            <p id="user-name"><?php echo "(belongs to " . $corresponds->name .")";?></p>
            
            <form method="POST" action="../actions/remove_subcat_action.php">
              <input type="hidden" name="subcategoryId" value="<?php echo $sub['subcategoryId']; ?>">
              <button>Remove subcategory</button>
            </form>
            
          
            </div>
            

            <br>
            <br>

            <?php } ?>
        </section>

        <section class="user" id="addSubcategorySection">
            <p class="section-title">Choose a category</p>
            <form action="../actions/add_subcat_action.php" method="post" class="add">
              <div class="dropdown">
                  <select name="category" id="categoryDropdown" required>
                      <option value="">Select a category</option>
                      <?php
                      foreach($categories as $category) {
                          echo '<option value="' . $category['categoryId'] . '">' . $category['name'] . '</option>';
                      }
                      ?>
                  </select>
              </div>
              <p class="section-title">Write the new subcategory</p>
              <div class="form_rectangle">
                  <input id="input-login" type="text" name="subcategory" placeholder="Subcategory" required>
              </div>
              <button id="addcatbtn" type="submit">Add new subcategory</button>
            </form>
        </section>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var toggleBtn = document.getElementById("toggleBtn");
                var toggleBtnCats = document.getElementById("toggleBtnCats");
                var toggleBtnAddCats = document.getElementById("toggleBtnAddCats");
                var userSection = document.getElementById("userSection");
                var subcategorySection = document.getElementById("subcategorySection");
                var addSubcatSection = document.getElementById("addSubcategorySection");

                userSection.style.display = "none";
                subcategorySection.style.display = "none";
                addSubcatSection.style.display = "none";

                toggleBtn.addEventListener("click", function() {
                    if (userSection.style.display === "none") {
                        userSection.style.display = "block";
                    } else {
                        userSection.style.display = "none";
                    }
                });

                toggleBtnCats.addEventListener("click", function() {
                    if (subcategorySection.style.display === "none") {
                      subcategorySection.style.display = "block";
                    } else {
                      subcategorySection.style.display = "none";
                    }
                });

                toggleBtnAddCats.addEventListener("click",function() {
                  if (addSubcatSection.style.display === "none") {
                    addSubcatSection.style.display = "block";
                  } else {
                    addSubcatSection.style.display = "none";
                  }
                });
            });
        </script>
    </body> 
</html>