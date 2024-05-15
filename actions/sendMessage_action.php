
<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../db/connection.db.php');
require_once(__DIR__ . '/../db/user.class.php');
require_once(__DIR__ . '/../db/message.class.php');

$db = databaseConnect();

// Verificar se os dados do formulário foram submetidos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar se todos os campos do formulário estão definidos
    if (isset($_POST['senderId'], $_POST['receiverId'], $_POST['message'])) {
        // Obter os dados do formulário
        $senderId = $_POST['senderId'];
        $receiverId = $_POST['receiverId'];
        $message = $_POST['message'];
        // Definir a data e hora atual
        $sentAt = date('Y-m-d H:i:s');

        // Tentar salvar a mensagem no banco de dados
        try {
            // Chamar o método sendMessage da classe Message para salvar a mensagem
            Message::sendMessage($messageid, $senderId, $receiverId, $message, $sentAt);
            echo "Mensagem enviada com sucesso!";
        } catch (PDOException $e) {
            echo "Erro ao enviar a mensagem: " . $e->getMessage();
        }
    } else {
        echo "Todos os campos do formulário são obrigatórios!";
    }
} else {
    header("Location: sendMessages.php");
    exit;
}


header('Location: /pages/login.php');
exit;
?>

