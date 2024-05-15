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
function drawCategorySlide(Category $cat, PDO $db, int $userId) {
    // Retrieve items for the given category
    $items = Category::getCategoryItems($db, $cat->id);
    $wishlistItemIds = Wishlist::getWishlistUserIDs($db, $userId)
?>  
    <div class="image_display">
        <?php foreach ($items as $item) { ?>
            <div class="image_wrapper">
                <a href="/../pages/item.php?itemId=<?=$item['itemId']?>">
                <img src="<?php echo $item['image_url']; ?>">
                </a>
                <p><?php echo $item['price'] . "€  | " . $item['likes'] . " likes"; ?></p>
                
                <form method="POST" action="/../actions/like_action.php">
                    <input type="hidden" name="itemId" value="<?php echo $item['itemId']; ?>">

                    <?php if (in_array($item['itemId'], $wishlistItemIds)) { ?>
                        <button id="liked"></button>
                    <?php } else { ?> 
                        <button></button>
                    <?php } ?>
                </form>
                
                <!-- ajax ver.
                <button class="like-button" data-user="<?php/* echo $session->getId(); */?>" data-item="<?php/* echo $wlitem['itemId']; */?>"></button>
                <script src="/../js/wishlist.js"></script>
                --->
            </div>
        <?php } ?>
    </div>
<?php 
} 
?>
