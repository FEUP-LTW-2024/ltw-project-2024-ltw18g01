<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../sessions/session.php');
$session = new Session();

if (!$session->isLoggedIn()) die(header('Location: /'));

require_once(__DIR__ . '/../db/connection.db.php');
require_once(__DIR__ . '/../db/user.class.php');
require_once(__DIR__ . '/../db/item.class.php');

$db = databaseConnect();

$user = User::getUser($db, $session->getId());

if ($user) {
    // Retrieve form data
    $itemId = (int)uniqid();
    $seller = $user->userId;
    $category = $_POST['category'];
    $subcategory = $_POST['subcategory'];
    $title = $_POST['title'];
    $price = $_POST['price'];
    $negotiable = isset($_POST['price_neg']) ? 1 : 0;
    $published = time(); // unix
    $tags = "newitem,publishedbyyou"; // PLACEHOLDER
    $state = $_POST['status'];
    $description = $_POST['description'];
    $shippingSize = $_POST['shipping_size'];
    $image_url = "https://nayemdevs.com/wp-content/uploads/2020/03/default-product-image.png";

    if (empty($category) || empty($subcategory) || empty($shippingSize)) {
        header("Location: ../pages/sell.php?error=missingdata");
        exit();
    }

    $sql = "INSERT INTO Item (itemId, seller, category, subcategory, title, price, negotiable, published, tags, state, description, shippingSize, image_url) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $db->prepare($sql);
    if (!$stmt) {
        // Handle SQL error
        header("Location: ../sell.php?error=missingdata");
        if (isset($_GET['error'])) {
            echo "Error: " . $_GET['error'];
        }
        exit();
    } else {
        $parameters = array($itemId, $seller, $category, $subcategory, $title, $price, $negotiable, $published, $tags, $state, $description, $shippingSize, $image_url);
        if (!$stmt->execute($parameters)) {
            header("Location: ../pages/sell.php");
            exit();
        } else {
            header("Location: ../pages/index.php");
            exit();
        }
    }

} else {
    header("Location: ../pages/sell.php");
    exit();
}
?>