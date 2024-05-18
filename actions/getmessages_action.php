<?php
require_once(__DIR__ . '/../db/connection.db.php');
require_once(__DIR__ . '/../db/message.class.php');
require_once(__DIR__ . '/../db/user.class.php');

$session = new Session();
$userId = $session->getId();

$db = databaseConnect();

try {
    $stmt = $db->prepare('
        SELECT i.itemId, i.title, i.image_url, 
               u1.username as senderName, u2.username as receiverName, 
               m.message, m.sentAt, 
               CASE 
                   WHEN u1.userId = :userId THEN u2.userId 
                   ELSE u1.userId 
               END as otherUserId,
               CASE 
                   WHEN u1.userId = :userId THEN u2.username 
                   ELSE u1.username 
               END as otherUsername
        FROM Message m
        JOIN (
            SELECT itemId, MAX(sentAt) as lastMessageTime
            FROM Message
            WHERE senderId = :userId OR receiverId = :userId
            GROUP BY itemId, 
                     CASE 
                         WHEN senderId = :userId THEN receiverId 
                         ELSE senderId 
                     END
        ) as subq ON m.itemId = subq.itemId AND m.sentAt = subq.lastMessageTime
        JOIN Item i ON i.itemId = m.itemId
        JOIN User u1 ON u1.userId = m.senderId
        JOIN User u2 ON u2.userId = m.receiverId
        WHERE m.senderId = :userId OR m.receiverId = :userId
        ORDER BY m.sentAt DESC
    ');
    $stmt->execute(['userId' => $userId]);
    $conversations = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['success' => true, 'conversations' => $conversations]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
