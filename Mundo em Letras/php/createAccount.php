<?php
session_start();
require 'db_connect.php';

// Verificando o método de envio de formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obter dados do formulário
    $fullname = $conn->real_escape_string($_POST['fullname']);
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = sha1($_POST['password']);
    
    // Inserção dos dados do usuário no banco de dados
    $sql = "INSERT INTO users (username, email, password, fullname) VALUES ('$username', '$email', '$password', '$fullname')";

    // Verificando se as informações foram enviadas ao banco de dados
    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Conta criada com sucesso";
        header('Location: ../pages/cadaster.php');
    } else {
        $_SESSION['message'] = "Infelizmente não conseuimos criar sua conta! Tente novamente!";
        header('Location: ../pages/cadaster.php');
    }
}

// Fechando a conexão com o banco de dados
$conn->close();
?>