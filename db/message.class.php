<?php

declare(strict_types=1);

class Message {
    public ?int $messageId;
    public int $senderId;
    public int $receiverId;
    public int $itemId;
    public string $message;
    public string $sentAt;

    public function __construct(?int $messageId, int $senderId, int $receiverId, int $itemId, string $message, string $sentAt) {
        $this->messageId = $messageId;
        $this->senderId = $senderId;
        $this->receiverId = $receiverId;
        $this->itemId = $itemId;
        $this->message = $message;
        $this->sentAt = $sentAt;
    }

    public function save(PDO $db): ?int {
        if ($this->messageId === null) {
            $stmt = $db->prepare('INSERT INTO Message (senderId, receiverId, itemId, message, sentAt) VALUES (?, ?, ?, ?, ?)');
            $stmt->execute([$this->senderId, $this->receiverId, $this->itemId, $this->message, $this->sentAt]);
            $this->messageId = (int) $db->lastInsertId();
        } else {
            $stmt = $db->prepare('UPDATE Message SET senderId = ?, receiverId = ?, itemId = ?, message = ?, sentAt = ? WHERE messageId = ?');
            $stmt->execute([$this->senderId, $this->receiverId, $this->itemId, $this->message, $this->sentAt, $this->messageId]);
        }
        return $this->messageId;
    }

    public static function getReceivedMessages(PDO $pdo, int $receiverId): array {
        $stmt = $pdo->prepare('SELECT * FROM Message WHERE receiverId = ?');
        $stmt->execute([$receiverId]);
        $rows = $stmt->fetchAll();

        $messages = [];
        foreach ($rows as $row) {
            if (isset($row['messageId'], $row['senderId'], $row['receiverId'], $row['itemId'], $row['message'], $row['sentAt'])) {
                $messages[] = new self(
                    $row['messageId'], 
                    $row['senderId'], 
                    $row['receiverId'], 
                    $row['itemId'], 
                    $row['message'], 
                    $row['sentAt']
                );
            } else {
                error_log('Missing required message data: ' . json_encode($row));
            }
        }
        return $messages;
    }

    public static function sendMessage(PDO $pdo, int $senderId, int $receiverId, int $itemId, string $message): bool {
        $stmt = $pdo->prepare('
            INSERT INTO Message (senderId, receiverId, itemId, message, sentAt)
            VALUES (?, ?, ?, ?, datetime("now"))
        ');
        if (!$stmt) {
            error_log('Failed to prepare statement: ' . implode(" ", $pdo->errorInfo()));
            return false;
        }
        $result = $stmt->execute([$senderId, $receiverId, $itemId, $message]);
        if (!$result) {
            error_log('Failed to execute statement: ' . implode(" ", $stmt->errorInfo()));
        }
        return $result;
    }

    static function getReceiverId(PDO $db, int $userId): ?int {
        $stmt = $db->prepare('
            SELECT receiverId
            FROM Message
            WHERE senderId = ?
            LIMIT 1
        ');

        $stmt->execute([$userId]);
        $receiver = $stmt->fetch(PDO::FETCH_ASSOC);

        return $receiver ? (int)$receiver['receiverId'] : null;
    }
    public static function getConversation(PDO $pdo, int $userId1, int $userId2): array {
        $stmt = $pdo->prepare('
            SELECT * FROM Message 
            WHERE (senderId = ? AND receiverId = ?) OR (senderId = ? AND receiverId = ?)
            ORDER BY sentAt
        ');
        $stmt->execute([$userId1, $userId2, $userId2, $userId1]);
        $rows = $stmt->fetchAll();

        $messages = [];
        foreach ($rows as $row) {
            if (isset($row['messageId'], $row['senderId'], $row['receiverId'], $row['itemId'], $row['message'], $row['sentAt'])) {
                $messages[] = new self(
                    $row['messageId'], 
                    $row['senderId'], 
                    $row['receiverId'], 
                    $row['itemId'], 
                    $row['message'], 
                    $row['sentAt']
                );
            } else {
                error_log('Missing required message data: ' . json_encode($row));
            }
        }
        return $messages;
    }
}
?>