<?php
require './Database.php';
require './Category.php';
require './Product.php';
require './Clothing.php';
require './Electronic.php';

$pdo = Database::connect();

$stmt = $pdo->prepare('SELECT * FROM `product` WHERE `id` = :id');
$stmt->execute(['id' => 7]);
$result = $stmt->fetch();

$product = new Product($result['id'], $result['category_id'], $result['name'], explode(',', $result['photo']), $result['price'], $result['description'], $result['quantity'], new DateTime($result['createdAt']), new DateTime($result['updatedAt']));

?>