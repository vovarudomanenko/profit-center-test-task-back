<?php
header("Content-Type: application/json");
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

    $offset = $_GET['offset'] ?? 0;
    $limit = $_GET['limit'] ?? 25;

    // todo: use only one statement
    $countStmt = $pdo->prepare("SELECT COUNT(*) AS total FROM statistics");
    $countStmt->execute();
    $countResult = $countStmt->fetch();

    $stmt = $pdo->prepare("SELECT * FROM statistics GROUP BY id ORDER BY `start_time` DESC LIMIT ? OFFSET ?");
    $stmt->execute([$limit, $offset]);
    $result = $stmt->fetchAll();
    echo json_encode([
        'records' => $result,
        'meta' => [
            'total' => $countResult['total'] ?? 0,
            'limit' => $limit,
            'offset' => $offset
        ]
    ]);

} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}