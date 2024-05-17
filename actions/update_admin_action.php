<?php
declare(strict_types=1);

require_once(__DIR__ . '/../sessions/session.php');
$session = new Session();

if (!$session->isLoggedIn()) die(header('Location: /pages/login.php'));

require_once(__DIR__ . '/../db/connection.db.php');
require_once(__DIR__ . '/../db/user.class.php');

$db = databaseConnect();

$user = User::getUser($db, (int)$_POST['userId']);
if ($user) {
    
    if ($user->isAdmin) {
        $var = 0;
    } else {
        $var = 1;
    }
    $user->updateUserStatus($db, (int)$_POST['userId'], $var);
}

header('Location: ../pages/admin.php');
?>
