<?php
declare(strict_types = 1);

class Message {
    public int $messageId;
    public int $senderId;
    public int $receiverId;
    public string $message;
    public string $sentAt;

    public function __construct(int $messageId, int $senderId, int $receiverId, string $message, string $sentAt) {
        $this->messageId = $messageId;
        $this->senderId = $senderId;
        $this->receiverId = $receiverId;
        $this->message = $message;
        $this->sentAt = $sentAt;
    }

    public function save(PDO $db) {
        $stmt = $db->prepare('
            INSERT INTO Message (senderId, receiverId, message, sentAt)
            VALUES (?, ?, ?, ?)
        ');

        $stmt->execute(array(
            $this->senderId,
            $this->receiverId,
            $this->message,
            $this->sentAt
        ));
    }

    public static function getAllMessagesWithUser(PDO $db, int $userId) : array {
        $stmt = $db->prepare('
            SELECT *
            FROM Message 
            WHERE senderId = ? OR receiverId = ?
            ORDER BY sentAt DESC
        ');
    
        $stmt->execute(array($userId, $userId));
    
        $messages = $stmt->fetchAll();
        $result = [];
    
        foreach ($messages as $msg) {
            $result[] = new Message(
                $msg['messageId'],
                $msg['senderId'],
                $msg['receiverId'],
                $msg['message'],
                $msg['sentAt']
            );
        }
    
        return $result;
    }
    
    public static function getMessagesBetweenUsers(PDO $db, int $user1Id, int $user2Id) : array {
        $stmt = $db->prepare('
            SELECT *
            FROM Message 
            WHERE (senderId = ? AND receiverId = ?) OR (senderId = ? AND receiverId = ?)
            ORDER BY sentAt DESC
        ');
    
        $stmt->execute(array($user1Id, $user2Id, $user2Id, $user1Id));
    
        $messages = $stmt->fetchAll();
        $result = [];
    
        foreach ($messages as $msg) {
            $result[] = new Message(
                $msg['messageId'],
                $msg['senderId'],
                $msg['receiverId'],
                $msg['message'],
                $msg['sentAt']
            );
        }
    
        return $result;
    }
    

    public static function sendMessage(PDO $db, int $senderId, int $receiverId, string $message, string $sentAt) {
        $newMessage = new Message(null, $senderId, $receiverId, $message, $sentAt);
        $newMessage->save($db);
    }

    public static function getConversation(PDO $db, int $userId, int $selectedUserId): array {
    // Consulta SQL para recuperar apenas as mensagens trocadas entre os usuários
    $query = "SELECT message FROM Message WHERE (senderId = :userId AND receiverId = :selectedUserId) OR (senderId = :selectedUserId AND receiverId = :userId)";
    
    // Preparar e executar a consulta SQL
    $statement = $db->prepare($query);
    $statement->execute(['userId' => $userId, 'selectedUserId' => $selectedUserId]);
    
    // Obter as mensagens como um array associativo
    $conversation = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $conversation;
}
}
?>