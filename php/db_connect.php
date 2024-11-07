<?php
// Dados para a conexão com o banco de dados
$server = 'localhost';
$user = '';
$password = '';
$db = '';

// Gerando a conexão com o banco de dados
$conn = new mysqli($server, $user, $password, $db);

// Verificando se foi feita a conexão com o banco de dados
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

?>