<?php
declare(strict_types=1);

require_once(__DIR__ . '/../sessions/session.php');
$session = new Session();

if (!$session->isLoggedIn()) die(header('Location: /pages/login.php'));

require_once(__DIR__ . '/../db/connection.db.php');
require_once(__DIR__ . '/../db/item.class.php');

$db = databaseConnect();

$item = Item::getItem($db, (int)$_POST['itemId']);
$item->removeItem($db, (int)$_POST['itemId']);

header('Location: ../pages/index.php');
?>
