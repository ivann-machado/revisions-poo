<?php
require './Database.php';
require './Category.php';
require './AbstractProduct.php';

$pdo = Database::connect();

$stmt = $pdo->prepare('SELECT * FROM `product` WHERE `id` = :id');
$stmt->execute(['id' => 7]);
$result = $stmt->fetch();

?>