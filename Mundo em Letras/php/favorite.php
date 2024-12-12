<?php
session_start();
require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_SESSION['uid']) {
        // Obter os dados do formulário
        $isbn13 = $conn->real_escape_string($_POST['isbn13']);
        $uid = $conn->real_escape_string($_POST['uid']);

        // Validar se os dados necessários foram enviados
        if ($isbn13 && $uid) {
            try {

                $sql = "INSERT INTO favorite (users_uid, cc_isbn13) VALUES ($uid, $isbn13)";
                if($conn->query($sql)) {
                    echo "Livro adicionado aos favoritos com sucesso!";
                    header('location: ../pages/catalog.php');
                } else {
                    echo "Erro ao adicionar o livro aos favoritos: " . $conn->error;
                }
            } catch (Exception $e) {
                echo "Erro: " . $e->getMessage();
            }
        } else {
            echo "Dados inválidos.";
            echo $isbn13;
            echo $uid;
        }
    }
    else {
        header("location: ../pages/cadaster.php");
    }
} else {
    echo "Método inválido.";
}
?>
