<?php
declare(strict_types=1);

require_once(__DIR__ . '/../sessions/session.php');
$session = new Session();

if (!$session->isLoggedIn()) header('Location: /../pages/login.php');

require_once(__DIR__ . '/../db/connection.db.php');
require_once(__DIR__ . '/../db/user.class.php');
require_once(__DIR__ . '/../db/item.class.php');
require_once(__DIR__ . '/../db/wishlist.class.php');

$db = databaseConnect();

$user = User::getUser($db, $session->getId());
$item = Item::getItem($db, (int)$_POST['itemId']);
$wishlist = Wishlist::getWishlistUser($db, (int)$_POST['userId']);
$wishlistItemIds = Wishlist::getWishlistUserIDs($db, (int)$_POST['userId']);

if (in_array((int)$_POST['itemId'], $wishlistItemIds)) {
    Item::removeLike($db, (int)$_POST['itemId'], $session->getId());
} else {
    Item::addLike($db, (int)$_POST['itemId'], $session->getId());
}

if (strpos($_SERVER['HTTP_REFERER'], '/../pages/search.php') !== false) {
    $currentURL = $_SERVER['REQUEST_URI'];
    header('Location: ' . $currentURL);
    exit; // Make sure to exit after sending the header
} else {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}





?>
