<?php
declare(strict_types=1);

require_once(__DIR__ . '/../db/connection.db.php');
require_once(__DIR__ . '/../db/user.class.php');

$firstName = $_POST['firstName'] ?? '';
$lastName = $_POST['lastName'] ?? '';
$username = $_POST['username'] ?? '';
$address = $_POST['address'] ?? '';
$city = $_POST['city'] ?? '';
$country = $_POST['country'] ?? '';
$postalCode = $_POST['postalCode'] ?? '';
$phone = $_POST['phone'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$image_url = '';

if(isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    // File upload is successful, process the file
    $tmp_name = $_FILES['image']['tmp_name'];
    $name = basename($_FILES['image']['name']);
    $upload_dir = __DIR__ . '/../images/users/';
    $target_file = $upload_dir . $name;

    if(move_uploaded_file($tmp_name, $target_file)) {
        // File moved successfully
        $image_url = '/images/users/' . $name;
    } else {
        // Error moving file
        echo "Erro ao mover o arquivo.";
    }
} elseif(isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
    // File upload failed, display specific error message
    switch($_FILES['image']['error']) {
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            echo "O arquivo enviado é muito grande.";
            break;
        case UPLOAD_ERR_PARTIAL:
            echo "O arquivo foi apenas parcialmente carregado.";
            break;
        case UPLOAD_ERR_NO_FILE:
            echo "Nenhum arquivo foi enviado.";
            break;
        case UPLOAD_ERR_NO_TMP_DIR:
            echo "Faltando uma pasta temporária.";
            break;
        case UPLOAD_ERR_CANT_WRITE:
            echo "Falha ao gravar o arquivo no disco.";
            break;
        case UPLOAD_ERR_EXTENSION:
            echo "Uma extensão do PHP interrompeu o upload do arquivo.";
            break;
        default:
            echo "Erro desconhecido ao carregar o arquivo.";
            break;
    }
}

$user = new User(
    0,
    $firstName,
    $lastName,
    $username,
    $address,
    $city,
    $country,
    $postalCode,
    $phone,
    $email,
    $password,
    $image_url
);

$db = databaseConnect();

$user->save($db);

header('Location: /pages/login.php');
exit;
?>
