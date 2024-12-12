<?php
require 'db_connect.php';

// Configurar resposta padrão como JSON
header('Content-Type: application/json');

// Verificar se o 'isbn13' foi enviado via GET
if (isset($_GET['isbn13'])) {
    $isbn13 = $conn->real_escape_string($_GET['isbn13']); // Escapar para evitar SQL Injection

    // Consultar os comentários do banco de dados
    $sql = "SELECT c.comment, u.username 
            FROM comments AS c
            INNER JOIN users AS u ON c.users_uid = u.uid
            WHERE c.cc_isbn13 = '$isbn13'";
    $result = $conn->query($sql);

    $comments = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $comments[] = $row;
        }
        echo json_encode([
            'status' => 'success',
            'comments' => $comments
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Nenhum comentário encontrado para este livro.'
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'O valor ISBN13 não foi fornecido.'
    ]);
}

?>
