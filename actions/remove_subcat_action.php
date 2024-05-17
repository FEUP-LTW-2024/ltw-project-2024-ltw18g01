<?php
declare(strict_types=1);

require_once(__DIR__ . '/../sessions/session.php');
$session = new Session();

if (!$session->isLoggedIn()) die(header('Location: /pages/login.php'));

require_once(__DIR__ . '/../db/connection.db.php');
require_once(__DIR__ . '/../db/subcategory.class.php');
require_once(__DIR__ . '/../db/item.class.php');

$db = databaseConnect();

Item::removeAllItemsSubcategory($db, (int)$_POST['subcategoryId']);
Subcategory::removeSubcategory($db, (int)$_POST['subcategoryId']);

header('Location: ../pages/admin.php');
?>
