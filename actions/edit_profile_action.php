<?php
declare(strict_types=1);

require_once(__DIR__ . '/../sessions/session.php');
$session = new Session();

if (!$session->isLoggedIn()) die(header('Location: /'));

require_once(__DIR__ . '/../db/connection.db.php');
require_once(__DIR__ . '/../db/user.class.php');

$uploadDir = __DIR__ . '/../images/users/';
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true); 
}

$db = databaseConnect();

$user = User::getUser($db, $session->getId());

if ($user) {
    $user->firstName = $_POST['firstName'];
    $user->lastName = $_POST['lastName'];
    $user->username = $_POST['username'];
    $user->address = $_POST['address'];
    $user->city = $_POST['city'];
    $user->country = $_POST['country'];
    $user->postalCode = $_POST['postalCode'];
    $user->phone = $_POST['phone'];

    if ($_FILES['profileImage']['error'] === UPLOAD_ERR_OK) {
        // Move o arquivo de imagem para o diretório que queremos
        $targetDir = __DIR__ . '/../images/users/';

        // Obtém o nome do arquivo atual
        $currentFileName = basename($user->image_url);
        
        $currentFileExtension = pathinfo($currentFileName, PATHINFO_EXTENSION);

        $newFileName = $currentFileName;
        $targetFile = $targetDir . $newFileName;

        if (!move_uploaded_file($_FILES['profileImage']['tmp_name'], $targetFile)) {
            die('Erro ao fazer upload do arquivo.');
        }

        $user->image_url = $newFileName;
    }

    $user->save($db);

    $session->setName($user->name());
}

header('Location: ../pages/account.php');
?>
