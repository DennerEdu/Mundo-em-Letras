<?php
require '../php/db_connect.php'; // Inclui a conexão com o banco de dados

// Configuração da API do Google Books
$apiKey = "AIzaSyBlMeRVsn5bZYaWlqfSPiKY9gVnrqVk6D0"; // Substitua pela sua API Key
$query = "woyaEAAAQBAJ"; // Termo de busca
$maxResults = 1; // Limite de 1 resultado
$url = "https://www.googleapis.com/books/v1/volumes?q=$query&maxResults=$maxResults&key=$apiKey";

$response = file_get_contents($url);
if ($response === FALSE) {
    die("Erro ao acessar a API do Google Books.");
}

$data = json_decode($response, true);

if (isset($data["items"])) {
    foreach ($data["items"] as $book) {
        $volumeInfo = $book["volumeInfo"];

        $isbn13 = null;
        if (isset($volumeInfo["industryIdentifiers"])) {
            foreach ($volumeInfo["industryIdentifiers"] as $identifier) {
                if ($identifier["type"] === "ISBN_13") {
                    $isbn13 = $identifier["identifier"];
                    break;
                }
            }
        }

        if (!$isbn13) {
            continue;
        }

        $name = $volumeInfo["title"] ?? "Título não disponível";
        $tinySynopsis = substr($volumeInfo["description"] ?? "Sinopse curta indisponível", 0, 255);
        $synopsis = $volumeInfo["description"] ?? "Sinopse indisponível";
        $author = isset($volumeInfo["authors"]) ? implode(", ", $volumeInfo["authors"]) : "Autor desconhecido";
        $publication = $volumeInfo["publishedDate"] ?? "0000-00-00";
        $publisher = $volumeInfo["publisher"] ?? "Editora desconhecida";
        $pageNumbers = $volumeInfo["pageCount"] ?? null;
        $indicativeRating = isset($volumeInfo["averageRating"]) ? (int)$volumeInfo["averageRating"] : 0;

        // Obter preço em BRL
        $price = 0.0;
        if (isset($book["saleInfo"]["listPrice"]) && $book["saleInfo"]["listPrice"]["currencyCode"] === "BRL") {
            $price = (float)$book["saleInfo"]["listPrice"]["amount"];
        }

        $smallThumbnail = $volumeInfo["imageLinks"]["smallThumbnail"] ?? null;
        $bookCover = $volumeInfo["imageLinks"]["thumbnail"] ?? null;

        $sql = "
            INSERT INTO catalogContent 
            (isbn13, name, tinySynopsis, synopsis, author, publication, publisher, pageNumbers, indicativeRating, price, smallThumbnail, bookCover)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ";

        try {
            $stmt = $conn->prepare($sql);
            $stmt->bind_param(
                'sssssssidsss',
                $isbn13,
                $name,
                $tinySynopsis,
                $synopsis,
                $author,
                $publication,
                $publisher,
                $pageNumbers,
                $indicativeRating,
                $price,
                $smallThumbnail,
                $bookCover
            );

            if ($stmt->execute()) {
                echo "Livro inserido: $name\n";
            } else {
                echo "Erro ao inserir livro $name: " . $stmt->error . "\n";
            }

            $stmt->close();
        } catch (Exception $e) {
            echo "Erro ao processar livro $name: " . $e->getMessage() . "\n";
        }
    }
} else {
    echo "Nenhum item encontrado na API.\n";
}

$conn->close();
?>