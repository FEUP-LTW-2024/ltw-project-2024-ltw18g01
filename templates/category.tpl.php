<?php 
  declare(strict_types = 1); 

  require_once(__DIR__ . '/../db/item.class.php');
  require_once(__DIR__ . '/../db/category.class.php');

  require_once(__DIR__ . '/../sessions/session.php');
?>

<?php 
function drawCategorySlide(Category $cat, PDO $db) {
    // Retrieve items for the given category
    $items = Category::getCategoryItems($db, $cat->id);
?>  
    <div class="image_display">
        <?php foreach ($items as $item) { ?>
            <img src="<?php echo $item['image_url']; ?>">
        <?php } ?>
    </div>
<?php 
} 
?>
