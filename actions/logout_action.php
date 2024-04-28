<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../sessions/session.php');
  $session = new Session();
  $session->logout();
  header ('Location: /../pages/login.php');
?>