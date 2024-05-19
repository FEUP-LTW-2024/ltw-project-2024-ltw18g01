<?php
declare(strict_types=1);

require_once(__DIR__ . '/../sessions/session.php');
$session = new Session();

if (!$session->isLoggedIn()) header('Location: /../pages/login.php');

require_once(__DIR__ . '/../db/connection.db.php');
require_once(__DIR__ . '/../db/user.class.php');
require_once(__DIR__ . '/../db/item.class.php');
require_once(__DIR__ . '/../db/subcategory.class.php');

$db = databaseConnect();
$existence = Subcategory::checkSubcategoryExistence($db, $_POST['subcategory']);

if (!$existence) {
    $subcat = new Subcategory($_POST['subcategory'], (int)$_POST['category']);
    $subcat->save($db);
}

header('Location: /../pages/admin.php');
?>
