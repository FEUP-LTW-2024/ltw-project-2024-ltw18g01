<?php
declare(strict_types=1);

require_once(__DIR__ . '/../sessions/session.php');
require_once(__DIR__ . '/../db/connection.db.php');
require_once(__DIR__ . '/../db/message.class.php');
require_once(__DIR__ . '/../db/user.class.php');
require_once(__DIR__ . '/../templates/common.tpl.php');

$session = new Session();
if (!$session->isLoggedIn()) {
    header('Location: /pages/login.php');
    exit;
}

$db = databaseConnect();
$receiverId = isset($_GET['receiverId']) ? (int)$_GET['receiverId'] : null;
$itemId = isset($_GET['itemId']) ? (int)$_GET['itemId'] : null;

if ($receiverId) {
    $messages = Message::getConversation($db, $session->getId(), $receiverId);
    $users = User::getAllUsers($db);
} else {
    $messages = [];
    $users = [];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link rel="stylesheet" href="/css/chat.css">
    <script src="/js/chat.js" defer></script>
</head>
<body>
    <?php drawTopBar($session, $db); ?>
    <div class="chat-container">
        <div class="sidebar">
            <?php drawConversationsList($session->getId(), $db); ?>
        </div>
        <div class="chat-content">
            <?php if ($receiverId) { ?>
                <div class="messages" id="messages">
                    <?php drawMessages($messages, $session->getId(), $users); ?>
                </div>
                <div class="message-form">
                    <?php drawSendMessageForm($session->getId(), $users, $receiverId, $itemId); ?>
                </div>
            <?php } else { ?>
                <p>Select a conversation to start chatting.</p>
            <?php } ?>
        </div>
    </div>
</body>
</html>


<?php
function drawMessages(array $messages, int $userId, array $users) {
    foreach ($messages as $message) {
        $isUserSender = $message->senderId === $userId;
        $senderName = $isUserSender ? 'You' : $users[$message->senderId]->username;
        ?>
        <div class="message <?= $isUserSender ? 'sent' : 'received' ?>">
            <p><strong><?= htmlspecialchars((string)$senderName) ?>:</strong> <?= htmlspecialchars((string)$message->message) ?></p>
            <p><em><?= htmlspecialchars((string)$message->sentAt) ?></em></p>
        </div>
        <?php
    }
}

function drawSendMessageForm(int $userId, array $users, int $receiverId, int $itemId) {
    ?>
    <form id="send-message-form" action="../actions/sendmessage_action.php" method="POST">
        <input type="hidden" name="senderId" value="<?= $userId ?>">
        <input type="hidden" name="receiverId" value="<?= $receiverId ?>">
        <input type="hidden" name="itemId" value="<?= $itemId ?>">
        <label for="message">Message:</label>
        <textarea id="message" name="message" rows="4" cols="50" required></textarea>
        <button type="submit">Send</button>
    </form>
    <?php
}

function drawConversationsList($userId, $pdo) {
    try {
        $stmt = $pdo->prepare('
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

        foreach ($conversations as $conversation) {
            echo '<div class="conversation">';
            echo '<img src="' . htmlspecialchars((string)$conversation['image_url']) . '" alt="' . htmlspecialchars((string)$conversation['title']) . '" class="item-image">';
            echo '<h3>' . htmlspecialchars((string)$conversation['title']) . '</h3>';
            echo '<p>' . htmlspecialchars((string)$conversation['otherUsername']) . ': ' . htmlspecialchars((string)$conversation['message']) . '</p>';
            echo '<small>Sent at: ' . htmlspecialchars((string)$conversation['sentAt']) . '</small>';
            echo '<a href="chat.php?receiverId=' . htmlspecialchars((string)$conversation['otherUserId']) . '&itemId=' . htmlspecialchars((string)$conversation['itemId']) . '">Chat</a>';
            echo '</div>';
        }
    } catch (PDOException $e) {
        echo 'Error: ' . htmlspecialchars($e->getMessage());
    }
}
