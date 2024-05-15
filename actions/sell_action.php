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
$image_url = ''; // Você pode adicionar a lógica para lidar com o upload de imagem aqui

// Validação dos dados (pode ser implementada conforme necessário)

// Conexão com o banco de dados
$db = databaseConnect();

// Cria uma nova instância do Item
$newItem = new Item(0, $sellerId, $categoryId, $subcategoryId, $title, $price, $negotiable, time(), '', $state, $description, $shippingSize, 0, $likes, $image_url);

// Salva o novo item no banco de dados
$newItem->save($db);

// Redireciona para a página de item criado
header('Location: /pages/item.php?itemId=' . $newItem->itemId);
exit;
?>
