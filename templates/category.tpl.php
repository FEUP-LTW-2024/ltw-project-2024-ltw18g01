<?php 
  declare(strict_types = 1); 

  require_once(__DIR__ . '/../db/item.class.php');
  require_once(__DIR__ . '/../db/category.class.php');
  require_once(__DIR__ . '/../db/user.class.php');

  require_once(__DIR__ . '/../sessions/session.php');

  $db = databaseConnect();
?>

<?php 
function drawCategorySlide(Category $cat, PDO $db) {
    // Retrieve items for the given category
    $items = Category::getCategoryItems($db, $cat->id);
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
                    <button></button>
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
