<?php
declare(strict_types=1);

session_start();

require_once(__DIR__ . '/../db/connection.db.php');
$db = databaseConnect();

require_once(__DIR__ . '/../db/message.class.php');
require_once(__DIR__ . '/../db/user.class.php');


$userId = $_SESSION['userId']; 

$selectedUserId = intval($_GET['userId']); 

$conversation = Message::getConversation($db, $userId, $selectedUserId);

$conversationText = '';

foreach ($conversation as $message) {
    // Verificar se a chave 'senderId' está definida na mensagem
    if (isset($message['senderId'])) {
        // Verificar se a mensagem foi enviada pelo user
        if ($message['senderId'] == $userId) {
            // Se sim, adicionar um prefixo para indicar que é uma mensagem do user
            $conversationText .= 'Você: ' . $message['message'] . "\n";
        } else {
            // Se não, adicionar o conteúdo da mensagem normalmente
            $conversationText .= $message['message'] . "\n";
        }
    } else {
        // Se a chave 'senderId' não estiver definida, adicionar apenas o conteúdo da mensagem
        $conversationText .= $message['message'] . "\n";
    }
}

echo $conversationText;
?>
