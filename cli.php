<?php
require __DIR__ . '/vendor/autoload.php';

$css = file_get_contents('php://stdin');

$minifier = new \MinThemAll\Minifier();
$minifier->add($css);
echo $minifier->minify();
