<?php
namespace App;


require 'vendor/autoload.php';

$pdo = Database::connect();

var_dump($pdo);

?>