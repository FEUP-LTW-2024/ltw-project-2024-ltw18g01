<?php 
  declare(strict_types = 1); 

  require_once(__DIR__ . '/../db/item.class.php');
  require_once(__DIR__ . '/../db/category.class.php');
  require_once(__DIR__ . '/../db/user.class.php');
  require_once(__DIR__ . '/../db/wishlist.class.php');


  require_once(__DIR__ . '/../sessions/session.php');

  $db = databaseConnect();

?>

<?php
function drawCategorySlideHomePage(Category $cat, PDO $db, int $userId) {
    // Retrieve items for the given category
    $items = Category::getCategoryItems($db, $cat->id);
    $wishlistItemIds = Wishlist::getWishlistUserIDs($db, $userId);
    $count = 0;
?>  
        <div class="image_display">
            <?php foreach ($items as $item): ?>
                <?php if ($count >= 8) break; ?>
                <?php if (!$item['sold']): ?>
                    <?php $count++; ?>
                    <div class="image_wrapper">
                        <a href="/../pages/item.php?itemId=<?= $item['itemId'] ?>">
                            <img src="<?= $item['image_url'] ?>" alt="Item Image">
                        </a>
                        <p><?= $item['price'] . "€  | " . $item['likes'] . " likes"; ?></p>
                        
                        <form method="POST" action="/../actions/like_action.php">
                            <input type="hidden" name="itemId" value="<?= $item['itemId'] ?>">
                            <input type="hidden" name="userId" value="<?= $userId ?>">

                            <button class="<?= in_array($item['itemId'], $wishlistItemIds) ? 'liked' : '' ?>"></button>
                        </form>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

<?php 
}
?>



<?php
function drawCategorySlideGuestHomePage(Category $cat, PDO $db) {
    // Retrieve items for the given category
    $items = Category::getCategoryItems($db, $cat->id);
    $count = 0;
?>  
    <div class="image_display">
        <?php foreach ($items as $item) { ?>
            <?php
            if ($count >= 8) {
                break;
            }
            ?>
            <?php
            if ($item['sold'] == false) { ?>
            <?php $count++; ?>
            <div class="image_wrapper">
                <a href="/../pages/item.php?itemId=<?=$item['itemId']?>">
                <img src="<?php echo $item['image_url']; ?>">
                </a>
                <p><?php echo $item['price'] . "€  | " . $item['likes'] . " likes"; ?></p>
                
                <form method="POST" action="/../actions/like_action.php">
                    <input type="hidden" name="itemId" value="<?php echo $item['itemId']; ?>">
                    <button></button>
                </form>
                
                <!-- ajax ver.
              button class="like-button" data-user="<?php/* echo $session->getId(); */?>" data-item="<?php/* echo $wlitem['itemId']; */?>"></button>
                <script src="/../js/wishlist.js"></script>
                --->
            </div>
            <?php } ?>
        <?php } ?>
    </div>
<?php 
} 
?>


<?php
function drawCategorySlide(Category $cat, PDO $db, int $userId) {
    // Retrieve items for the given category
    $items = Category::getCategoryItems($db, $cat->id);
    $wishlistItemIds = Wishlist::getWishlistUserIDs($db, $userId);
?>  
    <div class="image_display">
        <?php

        foreach ($items as $item) { ?>
            <?php
            if ($item['sold'] == false) { ?>
            <div class="image_wrapper">
                <a href="/../pages/item.php?itemId=<?=$item['itemId']?>">
                <img src="<?php echo $item['image_url']; ?>">
                </a>
                <p><?php echo $item['price'] . "€  | " . $item['likes'] . " likes"; ?></p>
                
                <form method="POST" action="/../actions/like_action.php">
                    <input type="hidden" name="itemId" value="<?php echo $item['itemId']; ?>">
                    <input type="hidden" name="userId" value="<?php echo $userId; ?>">

                    <?php if (in_array($item['itemId'], $wishlistItemIds)) { ?>
                        <button id="liked"></button>
                    <?php } else { ?> 
                        <button></button>
                    <?php } ?>

                </form>
            </div>
            <?php } ?>
<?php 
    } 
}?>

<?php
function drawCategorySlideGuest(Category $cat, PDO $db) {
    // Retrieve items for the given category
    $items = Category::getCategoryItems($db, $cat->id);
?>  
    <div class="image_display">
        <?php


        foreach ($items as $item) { ?>
            <?php
            if ($item['sold'] == false) { ?>
            <div class="image_wrapper">
                <a href="/../pages/item.php?itemId=<?=$item['itemId']?>">
                <img src="<?php echo $item['image_url']; ?>">
                </a>
                <p><?php echo $item['price'] . "€  | " . $item['likes'] . " likes"; ?></p>
                
                <form method="POST" action="/../actions/like_action.php">
                    <input type="hidden" name="itemId" value="<?php echo $item['itemId']; ?>">
                    <button></button>
                </form>
            </div>
            <?php } ?>
<?php 
    } 
}?>


<?php
function drawSubSlide(Subcategory $cat, PDO $db, int $userId) {
    // Retrieve items for the given category
    $items = Subcategory::getSubcategoryItems($db, $cat->id);
    $wishlistItemIds = Wishlist::getWishlistUserIDs($db, $userId);
?>  
    <div class="image_display">
        <?php foreach ($items as $item) { ?>
            <?php
            if ($item['sold'] == false) { ?>
                <div class="image_wrapper">
                <a href="/../pages/item.php?itemId=<?=$item['itemId']?>">
                <img src="<?php echo $item['image_url']; ?>">
                </a>
                <p><?php echo $item['price'] . "€  | " . $item['likes'] . " likes"; ?></p>
                
                <form method="POST" action="/../actions/like_action.php">
                    <input type="hidden" name="itemId" value="<?php echo $item['itemId']; ?>">
                    <input type="hidden" name="userId" value="<?php echo $userId; ?>">

                    <?php if (in_array($item['itemId'], $wishlistItemIds)) { ?>
                        <button id="liked"></button>
                    <?php } else { ?> 
                        <button></button>
                    <?php } ?>
                </form>
                </div>
            <?php } ?>

        <?php } ?>
    </div>
<?php 
} 
?>

<?php
function drawSubSlideGuest(Subcategory $cat, PDO $db) {
    // Retrieve items for the given category
    $items = Subcategory::getSubcategoryItems($db, $cat->id);
?>  
    <div class="image_display">
        <?php foreach ($items as $item) { ?>
            <?php
            if ($item['sold'] == false) { ?>
                <div class="image_wrapper">
                <a href="/../pages/item.php?itemId=<?=$item['itemId']?>">
                <img src="<?php echo $item['image_url']; ?>">
                </a>
                <p><?php echo $item['price'] . "€  | " . $item['likes'] . " likes"; ?></p>
                
                <form method="POST" action="/../actions/like_action.php">
                    <input type="hidden" name="itemId" value="<?php echo $item['itemId']; ?>">
                    <button></button>
                </form>
                </div>
            <?php } ?>

        <?php } ?>
    </div>
<?php 
} 
?>