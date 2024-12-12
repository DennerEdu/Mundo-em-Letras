<?php
// Conectar ao banco de dados
require 'db_connect.php';

// Verificar se o ID do item foi passado
if (isset($_GET['id'])) {
    $itemId = $_GET['id'];

    // Consulta SQL para obter os detalhes do item com base no ID
    $sql = "SELECT * FROM items WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $itemId); // Bind do parâmetro para evitar SQL Injection
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Buscar os dados do item
        $item = $result->fetch_assoc();
        echo json_encode($item); // Retornar os dados como JSON
    } else {
        echo json_encode(['error' => 'Item não encontrado']); // Retornar erro se o item não existir
    }

    // Fechar a conexão
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['error' => 'ID do item não fornecido']);
}
?>
