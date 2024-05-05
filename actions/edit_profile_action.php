<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../sessions/session.php');
  $session = new Session();

  if (!$session->isLoggedIn()) die(header('Location: /'));

  require_once(__DIR__ . '/../db/connection.db.php');
  require_once(__DIR__ . '/../db/user.class.php');

  $db = databaseConnect();

  $user = User::getUser($db, $session->getId());

  if ($user) {
    $user->firstName = $_POST['firstName'];
    $user->lastName = $_POST['lastName'];
    $user->username = $_POST['username'];
    $user->address = $_POST['address'];
    $user->city = $_POST['city'];
    $user->country = $_POST['country'];
    $user->postalCode = $_POST['postalCode'];
    $user->phone = $_POST['phone'];
    
    $user->save($db);

    $session->setName($user->name());
  }

  header('Location: ../pages/account.php');
?>