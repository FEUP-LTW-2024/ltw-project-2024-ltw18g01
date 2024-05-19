<?php
declare(strict_types=1);

require_once(__DIR__ . '/../db/connection.db.php');
require_once(__DIR__ . '/../db/message.class.php');
require_once(__DIR__ . '/../sessions/session.php');

$session = new Session();
if (!$session->isLoggedIn()) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

$db = databaseConnect();
$senderId = $session->getId();

$data = json_decode(file_get_contents('php://input'), true);

$receiverId = (int)$data['receiverId'];
$itemTitle = $data['itemTitle'];
$itemImageUrl = $data['itemImageUrl'];
$itemId = (int)$data['itemId'];
$messageText = $data['message'];

$message = new Message(null, $senderId, $receiverId, $itemId, $messageText, date('Y-m-d H:i:s'));

$messageId = $message->save($db);

if ($messageId) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to send message']);
}
?>
