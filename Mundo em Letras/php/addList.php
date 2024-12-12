<?php
session_start();
require 'db_connect.php';

// Lista de tabelas permitidas (whitelist)
$allowedTables = ['wishlist', 'readLater', 'reading', 'completed'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_SESSION['uid']) {
        echo 'teste: '. $_POST['isbn13'];
        // Obter os dados do formulário
        $isbn13 = $conn->real_escape_string($_POST['isbn13']);
        $uid = $conn->real_escape_string($_POST['uid']);
        $listName = $conn->real_escape_string($_POST['list']);

        // Validar se os dados necessários foram enviados
        if ($isbn13 && $uid && $listName) {
            // Verificar se a tabela está na whitelist
            if (in_array($listName, $allowedTables)) {
                // Construir a query dinamicamente
                $sql = "INSERT INTO $listName (users_uid, cc_isbn13) VALUES ($uid, $isbn13)";

                try {
                    if ($conn->query($sql)) {
                        echo "Livro adicionado à lista $listName com sucesso!";
                        header('location: ../pages/catalog.php');
                    } else {
                        echo "Erro ao adicionar o livro à lista: " . $conn->error;
                    }
                } catch (Exception $e) {
                    echo "Erro: " . $e->getMessage();
                }
            } else {
                echo "Lista inválida.";
            }
        } else {
            echo "Dados inválidos.";
            echo $isbn13;
            echo $uid;
        }
    } else {
        header("location: ../pages/cadaster.php");
    }
} else {
    echo "Método inválido.";
}
?>