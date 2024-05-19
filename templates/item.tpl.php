<?php 
  declare(strict_types = 1); 

  require_once(__DIR__ . '/../db/item.class.php');
  require_once(__DIR__ . '/../db/category.class.php');
  require_once(__DIR__ . '/../sessions/session.php');

  $session = new Session();
?>

<?php function drawItemSlide(Item $item) { ?>
  <div class="image_display">
    <img src="<?=$item->image_url?>">
  </div>
<?php } ?>

<?php 
function drawEditItem(int $itemId, Item $item, User $user, PDO $db) {
?>  
        <form action="../actions/edit_item_action.php" method="post" class="edit_item" enctype="multipart/form-data">
        <section class="item_price">
            <p class="section-title">Price</p>
            <div class="form_rectangle">
                <input id="input-text" type="float" name="price" value="<?php echo $item->price; ?>" required>
            </div>
            <br>
            <div class="centered">
                <input type="checkbox" id="price_neg" name="price_neg" value="yes" <?php if ($item->negotiable) echo 'checked'; ?>>
                <label for="price_neg">Is it negotiable?</label><br>
            </div>
        </section>
        <input type="hidden" name="userId" value="<?php echo $user->userId; ?>">
        <input type="hidden" name="itemId" value="<?php echo $itemId; ?>">
        <br>
        <button type="submit">Update item</button>
    </form>
<?php 
} 
?>