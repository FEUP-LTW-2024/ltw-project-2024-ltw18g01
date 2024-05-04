<?php 
  declare(strict_types = 1); 

  require_once(__DIR__ . '/../db/item.class.php');
?>

<?php 
function drawItemHomepage(Item $item) { ?>
    <div class="slide">
        <div class="image_display">
            <?php foreach ($items as $item) { ?>
                <img src="<?php echo $item['image_url']; ?>">
                <p><?php echo $item['description']; ?></p>
                <p class="price"><?php echo $item['price'] . "€"; ?></p> <!-- Added price class -->
            <?php } ?>
        </div>
    </div>
<?php } ?>
