<?php
namespace App;
use DateTime;

require 'vendor/autoload.php';

// $cloth = new Clothing('M', 'bleu', 'short', 5, null, 1, 'short en COUIR', [], 10, 'Le short en COUIR véritable tout droit de Belgique', 50, new DateTime(), new DateTime());
// var_dump($cloth->create());

// $cloth = new Clothing();
// $cloth->findOneById(1)->removeStocks(20);

// $cloth->update();
// var_dump($cloth);

// $cloth = new Electronic('DELL', 300, null, 2, 'locomputa', [], 10, 'le locomputa', 50, new DateTime(), new DateTime());
// var_dump($cloth->create());

$cloth = new Electronic();
$cloth->findOneById(5);
$cloth->addStocks(10);
$cloth->removeStocks(5);
$cloth->update();
// $cloth->findOneById(6)->setName('supacomputa 3000X');
// $cloth->update();
// var_dump($cloth);

?>