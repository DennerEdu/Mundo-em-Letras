<?php
// Conectar ao banco de dados
require '../php/db_connect.php';

if (isset($_GET['isbn13'])) {
    $isbn13 = $_GET['isbn13'];

    // Consulta SQL para pegar os detalhes do livro
    $sql = "SELECT * FROM catalogContent WHERE isbn13 = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $isbn13);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Pegar os dados do livro
        $book = $result->fetch_assoc();
        echo json_encode($book); // Retornar os dados como JSON
    } else {
        echo json_encode(['error' => 'Livro não encontrado.']);
    }

    // Fechar a conexão
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['error' => 'ISBN13 não fornecido.']);
}
?>
