<?php
require_once(__DIR__ . '/../db/connection.db.php');
require_once(__DIR__ . '/../db/message.class.php');

$db = databaseConnect();

$senderId = (int)$_POST['senderId'];
$receiverId = (int)$_POST['receiverId'];
$itemId = (int)$_POST['itemId'];
$messageText = $_POST['message'];
$sentAt = date('Y-m-d H:i:s');

$message = new Message(null, $senderId, $receiverId, $itemId, $messageText, $sentAt);
$messageId = $message->save($db);

if ($messageId) {
    // Fetch updated conversation list
    $stmt = $db->prepare('
        SELECT i.itemId, i.title as itemTitle, i.image_url as itemImageUrl,
               m.message, m.sentAt, 
               CASE 
                   WHEN m.senderId = :userId THEN m.receiverId 
                   ELSE m.senderId 
               END as otherUserId,
               CASE 
                   WHEN m.senderId = :userId THEN u2.username 
                   ELSE u1.username 
               END as senderUsername
        FROM Message m
        JOIN Item i ON m.itemId = i.itemId
        JOIN User u1 ON m.senderId = u1.userId
        JOIN User u2 ON m.receiverId = u2.userId
        WHERE m.itemId = :itemId AND (m.senderId = :userId OR m.receiverId = :userId)
        ORDER BY m.sentAt DESC
        LIMIT 1
    ');
    $stmt->execute(['userId' => $senderId, 'itemId' => $itemId]);
    $conversations = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'message' => [
            'messageId' => $messageId,
            'senderId' => $senderId,
            'message' => $messageText,
            'sentAt' => $sentAt,
            'isUserSender' => true
        ],
        'conversations' => $conversations
    ]);
} else {
    echo json_encode(['success' => false]);
}


?>