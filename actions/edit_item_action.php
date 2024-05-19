<?php
declare(strict_types=1);

require_once(__DIR__ . '/../sessions/session.php');
$session = new Session();

if (!$session->isLoggedIn()) die(header('Location: /pages/login.php'));

require_once(__DIR__ . '/../db/connection.db.php');
require_once(__DIR__ . '/../db/user.class.php');
require_once(__DIR__ . '/../db/item.class.php');

$db = databaseConnect();

$item = Item::getItem($db, (int)$_POST['itemId']);

$negotiable = isset($_POST['price_neg']) && $_POST['price_neg'] === 'yes';

if ($item->seller == (int)$_POST['userId']) {
    $item->updatePrice($db, (float)$_POST['price'], (int)$_POST['itemId']);
    $item->updateNegotiable($db, (bool)$negotiable, (int)$_POST['itemId']);
}

header('Location: ../pages/listings.php');
?>
