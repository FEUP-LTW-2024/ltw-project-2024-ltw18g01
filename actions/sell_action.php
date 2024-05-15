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
$categoryId = $_POST['category'] ?? '';
$subcategoryId = $_POST['subcategory'] ?? '';
$title = $_POST['title'] ?? '';
$price = $_POST['price'] ?? '';
$negotiable = isset($_POST['price_neg']) ? 1 : 0;
$state = $_POST['status'] ?? '';
$description = $_POST['description'] ?? '';
$shippingSize = $_POST['shipping_size'] ?? '';
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
