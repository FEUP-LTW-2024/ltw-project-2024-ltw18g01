<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../sessions/session.php');
  $session = new Session();

  require_once(__DIR__ . '/../db/connection.db.php');
  require_once(__DIR__ . '/../db/item.class.php');

  $db = databaseConnect();

  $items = Item::searchItems($db, $_GET['search'], 8);

  echo json_encode($items);
?>