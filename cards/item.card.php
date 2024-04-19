<?php 
  declare(strict_types = 1); 

  require_once(__DIR__ . '/../db/item.class.php');
?>

<?php 
function drawItemHomepage(Item $item) { ?>
    <div class="slide">
        <div class="image_display">
            <img src="<?php echo $item->image_url; ?>" alt="<?php echo $item->name; ?>">
            <h2><?php echo $item->name; ?></h2>
        </div>
    </div>
<?php } ?>
