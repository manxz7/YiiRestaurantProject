<?php

$dbHost = getenv('YII_DB_HOST') ?: 'localhost';
$dbPort = getenv('YII_DB_PORT') ?: '3306';
$dbName = getenv('YII_DB_NAME') ?: 'yii2_todo';
$dbUser = getenv('YII_DB_USER') ?: 'root';
$dbPassword = getenv('YII_DB_PASSWORD');

return [
    'class' => 'yii\db\Connection',
    'dsn' => "mysql:host={$dbHost};port={$dbPort};dbname={$dbName}",
    'username' => $dbUser,
    'password' => $dbPassword === false ? '' : $dbPassword,
    'charset' => 'utf8mb4',
];
