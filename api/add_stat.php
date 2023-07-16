<?php
header("Access-Control-Allow-Origin: *");

$config = require './../config.php';
require_once  './../functions.php';

try {
    $pdo = pdo_connect(
        $config['host'],
        $config['db'],
        $config['user'],
        $config['pass'],
        $config['charset'],
        $config['port']
    );

    $parameters = [
        ':avg'                  => $_POST['avg'],
        ':min_value'            => $_POST['min_value'],
        ':max_value'            => $_POST['max_value'],
        ':start_time'           => $_POST['start_time'],
        ':end_time'             => $_POST['end_time'],
        ':time_spent'           => $_POST['time_spent'],
        ':mode'                 => $_POST['mode'],
        ':mode_count'           => $_POST['mode_count'],
        ':standard_deviation'   => $_POST['standard_deviation'],
        ':lost_quotes'          => $_POST['lost_quotes'],
        ':quotes_count'         => $_POST['quotes_count']
    ];

    $sql = "INSERT INTO statistics (
                   avg,
                   min_value,
                   max_value,
                   start_time,
                   end_time,
                   time_spent,
                   mode,
                   mode_count, 
                   standard_deviation,
                   lost_quotes,
                   quotes_count
                   ) VALUES (
                             :avg,
                             :min_value,
                             :max_value,
                             :start_time,
                             :end_time,
                             :time_spent,
                             :mode,
                             :mode_count,
                             :standard_deviation,
                             :lost_quotes,
                             :quotes_count
                             )";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($parameters);

} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}