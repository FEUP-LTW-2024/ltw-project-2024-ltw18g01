<?php
    declare(strict_types=1);

    require_once(__DIR__ . '/../sessions/session.php');
    $session = new Session();

    require_once(__DIR__ . '/../db/connection.db.php');
    require_once(__DIR__ . '/../db/user.class.php');

    $db = databaseConnect();

    $user = User::getUserWithPassword($db, $_POST['email'], $_POST['password']);

    if ($user) {
        $session->setId($user->userId);
        $session->setName($user->name());
        $session->addMessage('success', 'Login successful.');
        header('Location: /../pages/index.php');
        exit;
    } else {
        $session->addMessage('error', 'Wrong password.');
        header ('Location: /../pages/login.php');
        exit;
    }


?>