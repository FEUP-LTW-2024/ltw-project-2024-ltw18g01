<?php 
  declare(strict_types = 1); 

  require_once(__DIR__ . '/../db/item.class.php');
  require_once(__DIR__ . '/../utils/session.php');
  $session = new Session();
?>

<?php function drawItemSlide(Item $item) { ?>
  <div class="image_display">
    <img src="<?=$item->image_url?>">
  </div>
<?php } ?>