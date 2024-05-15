<?php
declare(strict_types=1);

require_once(__DIR__ . '/../sessions/session.php');
$session = new Session();

if (!$session->isLoggedIn()) die(header('Location: /'));

require_once(__DIR__ . '/../db/connection.db.php');
require_once(__DIR__ . '/../db/user.class.php');
require_once(__DIR__ . '/../db/item.class.php');
require_once(__DIR__ . '/../db/wishlist.class.php');

$db = databaseConnect();

$user = User::getUser($db, $session->getId());
$item = Item::getItem($db, (int)$_POST['itemId']);
$wishlist = Wishlist::getWishlistUser($db, (int)$_POST['userId']);
$wishlistItemIds = Wishlist::getWishlistUserIDs($db, (int)$_POST['userId']);

if (in_array($item->id, $wishlistItemIds)) {
    Item::removeLike($db, $item->id, $user->userId);
} else {
    Item::addLike($db, $item->id, $user->userId);
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
?>
