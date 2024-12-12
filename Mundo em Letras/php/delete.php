<?php
session_start();
require 'db_connect.php';
$uid = $_SESSION['uid'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Consulta SQL para verificar usuário
    $sql = "SELECT * FROM users WHERE uid = '$uid'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $deleteSql = "DELETE FROM users WHERE uid = '$uid'";
        $deleteResult = $conn->query($deleteSql);

        if ($deleteResult) {
            // Login bem-sucedido
            unset($_SESSION['uid']);
            header('Location: ../pages/account.php');
            exit();
        } else {
            echo "falha ao apagar conta!" . $conn->error;
        }
    } else {
        // Usuário não encontrado
        echo "usuario não encontrado" . $conn->error;
    }
}
// Fechando a conexão com o banco de dados
$conn->close();
?>
