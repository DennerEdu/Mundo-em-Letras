<?php
require 'db_connect.php';

// Configurar resposta padrão como JSON
header('Content-Type: application/json');

// Verificar se o 'isbn13' foi enviado via GET
if (isset($_GET['isbn13'])) {
    $isbn13 = $conn->real_escape_string($_GET['isbn13']); // Escapar para evitar SQL Injection

    // Consultar o banco de dados
    $sql = "SELECT * FROM catalogContent WHERE isbn13 = '$isbn13'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $book = $result->fetch_assoc(); // Obter o primeiro resultado
        echo json_encode([
            'status' => 'success',
            'book' => $book // Enviar dados do livro para o JavaScript
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Nenhum livro encontrado com esse ISBN.'
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'O valor ISBN13 não foi fornecido.'
    ]);
}

?>
