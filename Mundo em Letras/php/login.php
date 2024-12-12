<?php
session_start();
require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obter dados do formulário
    $username = $conn->real_escape_string($_POST['username']);
    $password = sha1($_POST['password']);

    // Consulta SQL para verificar usuário
    $sql = "SELECT * FROM users WHERE username = '$username' OR email = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verificar a senha
        if ($password == $user['password']) {
            // Login bem-sucedido
            $_SESSION['uid'] = $user['uid'];
            header('Location: ../pages/account.php');
            exit();
        } else {
            // Senha incorreta
            $_SESSION['message'] = "Senha incorreta!";
            header('Location: ../pages/cadaster.php');
            exit();
        }
    } else {
        // Usuário não encontrado
        $_SESSION['message'] = "Usuário não encontrado!";
        header('Location: ../pages/cadaster.php');
        exit();
    }
}
// Fechando a conexão com o banco de dados
$conn->close();
?>
