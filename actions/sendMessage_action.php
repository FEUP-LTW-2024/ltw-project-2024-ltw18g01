<?php
require_once(__DIR__ . '/../sessions/session.php');
require_once(__DIR__ . '/../db/connection.db.php');
require_once(__DIR__ . '/../db/message.class.php');

$session = new Session();
if (!$session->isLoggedIn()) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

$db = databaseConnect();
$senderId = $session->getId();
$receiverId = $_POST['receiverId'];
$itemId = $_POST['itemId'];
$message = $_POST['message'];

if (Message::sendMessage($db, (int)$senderId, (int)$receiverId, (int)$itemId, $message)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
?>
