<?php 

error_reporting(0);
$path = __DIR__ . '/visitors.txt';
$ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
$data = file_get_contents($path);

$exp = explode(',', $data);

echo "Visitors: " . (count($exp) - 1);