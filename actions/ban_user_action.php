<?php
declare(strict_types=1);

require_once(__DIR__ . '/../sessions/session.php');
$session = new Session();

if (!$session->isLoggedIn()) die(header('Location: /'));

require_once(__DIR__ . '/../db/connection.db.php');
require_once(__DIR__ . '/../db/user.class.php');

$db = databaseConnect();

$user = User::getUser($db, (int)$_POST['userId']);

$user->removeUser($db, (int)$_POST['userId']);

header('Location: ../pages/admin.php');
?>
