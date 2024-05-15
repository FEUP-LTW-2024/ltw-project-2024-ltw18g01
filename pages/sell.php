<?php
declare(strict_types=1);

require_once(__DIR__ . '/../sessions/session.php');
$session = new Session();
  
if (!$session->isLoggedIn()) die(header('Location: /'));
  
require_once(__DIR__ . '/../db/connection.db.php');
require_once(__DIR__ . '/../db/user.class.php');
require_once(__DIR__ . '/../db/category.class.php');
require_once(__DIR__ . '/../db/subcategory.class.php');
require_once(__DIR__ . '/../templates/common.tpl.php');
  
$db = databaseConnect();
  
$user = User::getUser($db, $session->getId());
$categories = Category::getCategories($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sellerId = $user->userId; 
    $categoryId = $_POST['category'];
    $subcategoryId = $_POST['subcategory'];
    $title = $_POST['title']; 
    $price = $_POST['price'];
    $negotiable = isset($_POST['price_neg']) ? true : false; 
    $published = time(); 
    $tags = ''; 
    $state = $_POST['status']; 
    $description = $_POST['description'];
    $shippingSize = $_POST['shipping_size']; 

    switch ($shippingSize) {
        case 'Small':
            $shippingCost = 19.99;
            break;
        case 'Medium':
            $shippingCost = 29.99;
            break;
        case 'Large':
            $shippingCost = 49.99;
            break;
        default:
            $shippingCost = 0;
    }
    $likes = 0;
    $image_url = ''; 

    $newItem = new Item(0, $sellerId, $categoryId, $subcategoryId, $title, $price, $negotiable, $published, $tags, $state, $description, $shippingSize, $shippingCost, $likes, $image_url);

    $newItem->save($db);

    header('Location: ../actions/sell_action.php'); 
    exit;
}
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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <link rel="stylesheet" href="/css/index_style.css"> 
    <link rel="stylesheet" href="/css/sell.css">
</head>
<body>
    <?php
        drawTopBar($session, $db);
    ?>
    <br><br>

    <section class="sell_item">
        <p class="title">Sell an item at Techie</p>
        <p class="subtitle">Zero fees, zero hassle. All the money goes to you.</p>
    </section>
    <form action="../actions/sell_action.php" method="post" class="sell">
        <section class="item_pictures">
            <p class="section-title">Item pictures</p>
            <br>
            <input type="file" id="fileInput" accept="image/*">
            <br>
            <br>
            <button onclick="uploadImage()">Upload Image</button>
            <div id="imagePreview"></div>
        </section>
        <br>
        <br>
        <section class="name_desc">
            <p class="section-title">Title</p>
            <div class="form_rectangle">
                <input id="input-text" type="text" name="title" placeholder="Title">
            </div>
            <p class="section-title">Description</p>
            <div class="form_rectangle">
                <input id="input-text" type="text" name="description" placeholder="Description">
            </div>
        </section>

        <section class="category">
            <p class="section-title">Choose a category</p>
            <div class="dropdown">
                <select name="category" id="categoryDropdown">
                    <option value="">Select a category</option>
                    <?php
                    foreach($categories as $category) {
                        echo '<option value="' . $category['categoryId'] . '">' . $category['name'] . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="dropdown">
                <select name="subcategory" id="subcategoryDropdown">
                    <option value="">Select a subcategory</option>
                </select>
            </div>

            <script src="../js/cat_dropdown.js"></script>
        </section>
        <section class="status">
            <p class="section-title">Condition</p>
            <input type="hidden" name="status" id="status" value="">
            <input type="checkbox" id="verygood" value="Very Good">
            <label for="verygood">Very Good</label><br>
            <input type="checkbox" id="good" value="Good">
            <label for="good">Good</label><br>
            <input type="checkbox" id="decent" value="Decent">
            <label for="decent">Decent</label><br>
            <input type="checkbox" id="forparts" value="For parts">
            <label for="forparts">For parts</label><br>

            <script>
                var checkboxes = document.querySelectorAll('input[type="checkbox"]');
                checkboxes.forEach(function(checkbox) {
                    checkbox.addEventListener('change', function() {
                        var status = '';
                        checkboxes.forEach(function(cb) {
                            if (cb.checked) {
                                status = cb.value;
                            }
                        });
                        document.getElementById('status').value = status;
                    });
                });
            </script>
        </section>

        <section class="shipping">
            <p class="section-title">Shipping size</p>
            <input type="radio" id="small" name="shipping_size" value="Small">
            <label for="small">Small(<1kg)</label><br>
            <input type="radio" id="medium" name="shipping_size" value="Medium">
            <label for="medium">Medium(<5kg)</label><br>
            <input type="radio" id="large" name="shipping_size" value="Large">
            <label for="large">Large(+5kg)</label><br>
        </section>

        <section class="item_price">
            <p class="section-title">Price</p>
            <div class="form_rectangle">
                <input id="input-text" type="text" name="price" placeholder="Price">
            </div>
            <br>
            <div class="centered">
                <input type="checkbox" id="price_neg" name="price_neg" value="yes">
                <label for="price_neg">Is it negotiable?</label><br>
            </div>
        </section>

        <br>

        <button type="submit">List item</button>
    </form>
</body> 
</html>
