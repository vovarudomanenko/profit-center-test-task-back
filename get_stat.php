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

    $id = $_GET['id'];

    $sql = "SELECT * FROM statistics WHERE id=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $result = $stmt->fetch();
    echo json_encode($result);

} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}