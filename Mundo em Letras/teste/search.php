<?php
require '../php/db_connect.php'; // Inclui a conexão com o banco de dados

// Consulta SQL para trazer os livros com seus gêneros
$sql = "
    SELECT 
        c.name AS book_name, 
        c.isbn13 AS isbn13, 
        g.genre AS genre 
    FROM 
        catalogContent c
    INNER JOIN 
        cc_genres cg ON c.isbn13 = cg.cc_isbn13
    INNER JOIN 
        genres g ON cg.genres_id = g.id
    ORDER BY 
        c.name, g.genre
";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Itera sobre os resultados e exibe o nome do livro, ISBN e gêneros associados
    foreach ($result as $row) {
        echo "Nome: " . $row["book_name"] . " - ISBN13: " . $row["isbn13"] . " - Gênero: " . $row["genre"] . "<br>";
    }
} else {
    echo "Nenhum registro encontrado.";
}
?>
