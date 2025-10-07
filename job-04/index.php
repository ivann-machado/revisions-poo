<?php
require './Category.php';
require './Product.php';

$dsn = "mysql:host=localhost;dbname=draft-shop;charset=utf8mb4";
$options = [
	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
	PDO::ATTR_EMULATE_PREPARES => false,
];
$pdo = new PDO($dsn, 'root', '', $options);

$stmt = $this->pdo->prepare('SELECT * FROM `product` WHERE `id` = :id');
$stmt->execute(['id' => 7]);
$result = $stmt->fetch();

$product = new Product($result['id'], $result['category_id'], $result['name'], $result['photo'], $result['price'], $result['description'], $result['quantity'], new DateTime($result['createdAt']), new DateTime($result['updatedAt']));

?>