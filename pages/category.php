<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../sessions/session.php');
  require_once(__DIR__ . '/../db/connection.db.php');
  require_once(__DIR__ . '/../db/user.class.php');
  require_once(__DIR__ . '/../templates/common.tpl.php');
  require_once(__DIR__ . '/../templates/category.tpl.php');
  require_once(__DIR__ . '/../db/subcategory.class.php');
  $db = databaseConnect();

  // passar ID consoante o índice da navbar
  $subcats = Subcategory::getSubcategoriesFromCategory($db, (int)$_GET['category']);
  $curUser = (int)$session->getId();
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
        <link rel="stylesheet" href="/css/wishlist.css">
   </head>
    <body>
        <?php
        drawTopBar($session, $db);
        ?>
        <br> <br>
        <section>
            <header  id="sec-navbar-text" class="sec-navbar">
                <?php
                foreach ($subcats as $sub) { ?>
                    <a class= "subcategory" href=<?php echo "category.php?category=" . (int)$_GET['category'] . "&subcategory=" . $sub['subcategoryId']; ?>><?php echo $sub['name']; ?></a>
                <?php } ?>
                <a class="active" href =<?php echo "category.php?category=" . (int)$_GET['category'] . "&subcategory=all";?>>All</a>
            </header>
        </section>
        
        <br>

        <?php
        if ($_GET['subcategory'] == "all") {
            $cat = Category::getCategory($db, (int)$_GET['category']);
            if ($session->isLoggedIn()) {
                drawCategorySlide($cat, $db, $curUser);
            } else {
                drawCategorySlideGuest($cat, $db);                
            }

        } else {
            $subcat = Subcategory::getSubcategory($db, (int)$_GET['subcategory']);
            drawSubSlide($subcat, $db, $curUser);
        }
        ?>
    </body>
</html>
