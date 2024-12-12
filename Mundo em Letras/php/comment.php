<?php
session_start();
require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (isset($_SESSION['uid'])) {
        $comment = $conn->real_escape_string($_POST['comment']);
        $isbn13 = $conn->real_escape_string($_POST['isbn13']);
        $uid = $conn->real_escape_string($_SESSION['uid']); // Proteção adicional

        $sql = "INSERT INTO comments (users_uid, cc_isbn13, comment) VALUES ('$uid', '$isbn13', '$comment')";

        if ($conn->query($sql)) {
            echo "<h1>Comentário enviado com sucesso!</h1>";
        } else {
            echo '<h1>Erro: ' . $conn->error . "</h1>";
        }
    } else {
        header("Location: ../pages/cadaster.php");
        exit();
    }
} else {
    echo "<h1>Método inválido!</h1>";
}
?>
