<?php
header("Access-Control-Allow-Origin: *");

$config = require './config.php';
require_once  './functions.php';

try {
    $pdo = pdo_connect(
        $config['host'],
        $config['db'],
        $config['user'],
        $config['pass'],
        $config['charset'],
        $config['port']
    );

    $avg = $_POST['avg'];
    $min = $_POST['min'];
    $max = $_POST['max'];
    $end = $_POST['end'];
    $start = $_POST['start'];
    $time_spent = $_POST['time_spent'];
    $moda = $_POST['moda'];
    $moda_count = $_POST['moda_count'];
    $standard_deviation = $_POST['standard_deviation'];
    $lost_quotes = $_POST['lost_quotes'];
    $quotes_amount = $_POST['quotes_amount'];
    // todo: use named parameters

    $sql = "INSERT INTO statistics (
                   avg,
                   min,
                   max,
                   start,
                   end,
                   time_spent,
                   moda,
                   moda_count, 
                   standard_deviation,
                   lost_quotes,
                   quotes_amount
                   ) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$avg, $min, $max, $start, $end, $time_spent, $moda, $moda_count, $standard_deviation, $lost_quotes, $quotes_amount]);

} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}