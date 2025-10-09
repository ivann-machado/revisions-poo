<?php
namespace App;
use DateTime;

require 'vendor/autoload.php';

$cloth = new Clothing('M', 'bleu', 'short', 5, null, 1, 'short en COUIR', [], 10, 'Le short en COUIR véritable tout droit de Belgique', 50, new DateTime(), new DateTime());
var_dump($cloth->create());

?>