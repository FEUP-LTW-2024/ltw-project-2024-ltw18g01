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

$image_url = '/images/others/guesticon.png';

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
