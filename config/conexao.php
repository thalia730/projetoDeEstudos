<?php

$host = 'localhost';
$db = 'db_estudos';
$user = 'root';
$password = '';
$charset = 'utf8mb4';

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {

    $conexao = new PDO(
        "mysql:host=$host;dbname=$db;charset=$charset",
        $user,
        $password,
        $options
    );

} catch (PDOException $e) {

    die("Erro na conexão: " . $e->getMessage());

}