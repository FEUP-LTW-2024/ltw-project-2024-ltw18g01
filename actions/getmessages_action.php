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
$receiverId = $_GET['receiverId'];

$messages = Message::getConversation($db, (int)$senderId, (int)$receiverId);

$response = ['success' => true, 'messages' => []];
foreach ($messages as $message) {
    $response['messages'][] = [
        'messageId' => $message->messageId,
        'senderId' => $message->senderId,
        'receiverId' => $message->receiverId,
        'itemId' => $message->itemId,
        'message' => htmlspecialchars($message->message),
        'sentAt' => $message->sentAt,
        'isUserSender' => $message->senderId === $senderId
    ];
}

echo json_encode($response);
?>
