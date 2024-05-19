<?php
require_once(__DIR__ . '/../db/connection.db.php');
require_once(__DIR__ . '/../db/message.class.php');

$db = databaseConnect();

$senderId = (int)$_POST['senderId'];
$receiverId = (int)$_POST['receiverId'];
$itemId = (int)$_POST['itemId'];
$messageText = $_POST['message'];
$sentAt = date('Y-m-d H:i:s');

$stmt = $db->prepare('SELECT * FROM Message WHERE senderId = ? AND receiverId = ? AND itemId = ?');
$stmt->execute([$senderId, $receiverId, $itemId]);
$existingConversation = $stmt->fetch();

if (!$existingConversation) {
    $message = new Message(null, $senderId, $receiverId, $itemId, $messageText, $sentAt);
} else {
    $message = new Message($existingConversation['messageId'], $senderId, $receiverId, $itemId, $messageText, $sentAt);
}

$messageId = $message->save($db);

if ($messageId) {
    echo json_encode([
        'success' => true,
        'message' => [
            'messageId' => $messageId,
            'senderId' => $senderId,
            'message' => $messageText,
            'sentAt' => $sentAt,
            'isUserSender' => true
        ]
    ]);
} else {
    echo json_encode(['success' => false]);
}
?>
