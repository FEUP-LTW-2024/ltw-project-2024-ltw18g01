<?php

declare(strict_types = 1);

require_once(__DIR__ . '/../sessions/session.php');
$session = new Session();
if (!$session->isLoggedIn()) die(header('Location: /'));

require_once(__DIR__ . '/../db/connection.db.php');
$db = databaseConnect();

require_once(__DIR__ . '/../db/user.class.php');
require_once(__DIR__ . '/../db/message.class.php');

// Obter o ID do user 
$userId = $session->getId();

$availableUsers = Message::getAllMessagesWithUser($db, $userId);

$usersJson = json_encode($availableUsers);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Escolher Usuário para Conversar</title>
    <link rel="stylesheet" href="/css/index_style.css"> 
    <link rel="stylesheet" href="/css/chat.css">
</head>
<body>
    <h1>Escolher Usuário para Conversar</h1>
    <select id="selectUser">
    <!-- Preencher o select com os users disponíveis -->
   
            <?php foreach ($availableUsers as $user): ?>
            <?php
            // Obter os detalhes do outro user
            $otherUser = User::getUser($db, $user->senderId == $userId ? $user->receiverId : $user->senderId);

            // Exibir o nome do outro user
            $userName = $otherUser ? $otherUser->firstName : 'Usuário Desconhecido';

            ?>
            <option value="<?php echo $otherUser->userId; ?>"><?php echo $userName; ?></option>
        <?php endforeach; ?>
</select>
    
    <div id="conversation"></div>

    <button onclick="startConversation()">Iniciar Conversa</button>
    <script src="/js/chat.js"></script>

    <script>
        loadConversationOnUserSelect();
    </script>
</body>
</html>

