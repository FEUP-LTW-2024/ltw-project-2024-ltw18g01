<?php
declare(strict_types=1);

require_once(__DIR__ . '/../sessions/session.php');
$session = new Session();

if (!$session->isLoggedIn()) die(header('Location: /'));

require_once(__DIR__ . '/../db/connection.db.php');
require_once(__DIR__ . '/../db/user.class.php');
require_once(__DIR__ . '/../db/item.class.php');

// Obtém os dados do formulário
$sellerId = $session->getId();
$categoryId = isset($_POST['category']) ? (int)$_POST['category'] : 0; 
$subcategoryId = isset($_POST['subcategory']) ? (int)$_POST['subcategory'] : 0; 
$title = $_POST['title'] ?? '';
$price = isset($_POST['price']) ? (int)$_POST['price'] : 0; 
$negotiable = isset($_POST['price_neg']) && $_POST['price_neg'] === 'yes';
$state = $_POST['status'] ?? '';
$description = $_POST['description'] ?? '';
$shippingSize = $_POST['shipping_size'] ?? '';  
switch ($shippingSize) {
    case 'Small':
        $shippingCost = 19.99;
        break;
    case 'Medium':
        $shippingCost = 29.99;
        break;
    case 'Large':
        $shippingCost = 49.99;
        break;
    default:
        $shippingCost = 0;
}
$likes = 0;
$image_url = '';

if(isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    // File upload is successful, process the file
    $tmp_name = $_FILES['image']['tmp_name'];
    $name = basename($_FILES['image']['name']);
    $upload_dir = __DIR__ . '/../images/products/';
    $target_file = $upload_dir . $name;

    if(move_uploaded_file($tmp_name, $target_file)) {
        // File moved successfully
        $image_url = '/images/products/' . $name;
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


$db = databaseConnect();

$newItem = new Item($sellerId, $categoryId, $subcategoryId, $title, $price, $negotiable, time(), '', $state, $description, $shippingSize, $shippingCost, $likes, $image_url);

$newItem->save($db);

header('Location: /pages/item.php?itemId=' . $newItem->id);
exit;
?>
