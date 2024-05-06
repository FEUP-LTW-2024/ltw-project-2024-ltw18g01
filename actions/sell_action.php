<?php
// Include database connection
declare(strict_types = 1);

require_once(__DIR__ . '/../sessions/session.php');
$session = new Session();

if (!$session->isLoggedIn()) die(header('Location: /'));

require_once(__DIR__ . '/../db/connection.db.php');
require_once(__DIR__ . '/../db/user.class.php');
require_once(__DIR__ . '/../db/item.class.php');

$db = databaseConnect();

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $subcategory = $_POST['subcategory'];
    $status = $_POST['status'];
    $shipping_size = $_POST['shipping_size'];
    $price = $_POST['price'];
    $price_negotiable = isset($_POST['price_neg']) ? 1 : 0; // If checkbox is checked, set to 1, else 0.

    // Validate data (perform additional validation as needed)
    if (empty($title) || empty($description) || empty($category) || empty($subcategory) || empty($status) || empty($shipping_size) || empty($price)) {
        // Handle validation errors, redirect back to the form with an error message
        header("Location: ../sell_form.php?error=emptyfields");
        exit();
    } else {
        // Prepare SQL statement
        $sql = "INSERT INTO Item (title, description, category, subcategory, status, shipping_size, price, price_negotiable) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $db->prepare($sql);
        if (!$stmt) {
            // Handle SQL error
            header("Location: ../sell_form.php?error=sqlerror");
            exit();
        } else {
            // Bind parameters and execute the statement
            $stmt->bind_param("ssssssdi", $title, $description, $category, $subcategory, $status, $shipping_size, $price, $price_negotiable);
            if (!$stmt->execute()) {
                // Handle execution error
                header("Location: ../pages/sell.php");
                exit();
            } else {
                // Item added successfully
                header("Location: ../pages/index.php");
                exit();
            }
        }
    }
} else {
    // If the form was not submitted, redirect back to the form page
    header("Location: ../pages/sell.php");
    exit();
}
?>
