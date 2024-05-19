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
function drawMessages(array $messages, int $userId, array $users) { ?>
    
    <?php
    foreach ($messages as $message) {
        $isUserSender = $message->senderId === $userId;
        $senderName = $isUserSender ? 'You' : $users[$message->senderId]->username;
        ?>
        <div class="message <?= $isUserSender ? 'sent' : 'received' ?>">
            <p class="sender-name"><strong><?= htmlspecialchars((string)$senderName) ?></strong></p>
            <p><?= $message->message ?></p> 
            <p class="message-time"><em><?= htmlspecialchars((string)$message->sentAt) ?></em></p>
        </div>
        <?php
    } ?>
<?php } ?>

<?php

function drawSendMessageForm(int $userId, array $users, int $receiverId, int $itemId) {
    ?>
    <form id="send-message-form" action="../actions/sendmessage_action.php" method="POST">
        <input type="hidden" name="senderId" value="<?= $userId ?>">
        <input type="hidden" name="receiverId" value="<?= $receiverId ?>">
        <input type="hidden" name="itemId" value="<?= $itemId ?>">
        <label for="message">Type here</label>
        <textarea id="message" name="message" rows="4" cols="50" required></textarea>
        <button type="submit">Send</button>
    </form>
    <?php
}

function drawConversationsList($userId, $pdo) {
    try {
        $stmt = $pdo->prepare('
            SELECT i.itemId, i.title, 
                   CASE WHEN u1.userId = :userId THEN u2.userId ELSE u1.userId END as otherUserId, 
                   CASE WHEN u1.userId = :userId THEN u2.username ELSE u1.username END as otherUsername,
                   CASE WHEN u1.userId = :userId THEN u2.image_url ELSE u1.image_url END as otherUserImage,
                   m.message, m.sentAt
            FROM Message m
            JOIN (
                SELECT itemId, 
                       CASE WHEN senderId = :userId THEN receiverId ELSE senderId END as otherUserId, 
                       MAX(sentAt) as lastMessageTime
                FROM Message
                WHERE senderId = :userId OR receiverId = :userId
                GROUP BY otherUserId
            ) as subq ON m.itemId = subq.itemId AND m.sentAt = subq.lastMessageTime 
                       AND ((m.senderId = :userId AND m.receiverId = subq.otherUserId) 
                       OR (m.receiverId = :userId AND m.senderId = subq.otherUserId))
            JOIN Item i ON i.itemId = m.itemId
            JOIN User u1 ON u1.userId = m.senderId
            JOIN User u2 ON u2.userId = m.receiverId
            WHERE m.senderId = :userId OR m.receiverId = :userId
            ORDER BY m.sentAt DESC
        ');

        $stmt->execute(['userId' => $userId]);
        $conversations = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($conversations as $conversation) {
            $message = htmlspecialchars((string)$conversation['message']);
            if (strlen($message) > 20) {
                $message = substr($message, 0, 20) . '...';
            }

            echo '<div class="conversation" data-item-id="' . htmlspecialchars((string)$conversation['itemId']) . '" data-other-user-id="' . htmlspecialchars((string)$conversation['otherUserId']) . '">';
            echo '<img src="' . htmlspecialchars((string)$conversation['otherUserImage']) . '" alt="' . htmlspecialchars((string)$conversation['otherUsername']) . '" class="otheruser-image">';
            ?><br><?php
            echo '<h3>' . htmlspecialchars((string)$conversation['otherUsername']) . '</h3>';
            echo '<p>' . $message . '</p>';
            echo '<small>Sent at: ' . htmlspecialchars((string)$conversation['sentAt']) . '</small>';
            echo '<a href="chat.php?receiverId=' . htmlspecialchars((string)$conversation['otherUserId']) . '&itemId=' . htmlspecialchars((string)$conversation['itemId']) . '">';
            echo '<img src="/images/others/send-message.png" alt="Send Message">';
            echo '</a>';
            echo '</div>';
        }
    } catch (PDOException $e) {
        echo 'Error: ' . htmlspecialchars($e->getMessage());
    }
}

?>
