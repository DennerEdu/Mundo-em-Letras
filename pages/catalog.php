<?php
session_start();
require '../php/db_connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo</title>
    <link rel="stylesheet" href="../css/catalog.css">
    <script src="../js/catalog_carousel.js" defer></script>
    <script src="../js/headerScript.js" defer></script>
</head>
<body>
    <div class="container">
        <header>
            <div class="hnav">
                <span class="menu-icon" id="menu-icon" onclick="toggleMenu()">☰</span>
                <img src="../img/logo.svg" alt="logo">
            </div>
            <div class="menu-content" id="menu-content">
                <h2><a href="../index.html">Inicio</a></h2>
                <h2><a href="catalog.php">Catálogo</a></h2>
                <h2><a href="#">Cadastrar</a></h2>
            </div>
        </header>

        <div class="catalog-title">
            <h1>Catálogo</h1>
        </div>

        <?php
        $sql = "SELECT * FROM genres";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            foreach ($result as $genre) {
                ?>
                <div class="genre"><h2><?php echo $genre['genre']; ?></h2></div>
                <div class="catalog-container">
                    <div class="catalog">
                        <?php
                        $genreId = $genre['id'];
                        $sqlBooks = "SELECT c.* 
                                     FROM catalogContent c 
                                     INNER JOIN cc_genres cg 
                                     ON c.isbn13 = cg.cc_isbn13 
                                     WHERE cg.genres_id = $genreId";
                        $booksResult = $conn->query($sqlBooks);

                        if ($booksResult && $booksResult->num_rows > 0) {
                            foreach ($booksResult as $book) {
                                ?>
                                <div class="item">
                                    <img src="<?php echo $book['smallThumbnail'] !== 'null' ? $book['smallThumbnail'] : 'https://via.placeholder.com/150'; ?>" alt="">
                                    <h3><?php echo htmlspecialchars($book['name']); ?></h3>
                                    <p><?php echo htmlspecialchars($book['tinySynopsis']); ?></p>
                                </div>
                                <?php
                            } // Fim do foreach de livros
                        } else {
                            echo "<p>Nenhum registro encontrado para este gênero.</p>";
                        }
                        ?>
                    </div> <!-- Fim da div 'catalog' -->

                    <div class="nav prev" onclick="moveCarousel(-1)">&#10094;</div>
                    <div class="nav next" onclick="moveCarousel(1)">&#10095;</div>
                </div> <!-- Fim da div 'catalog-container' -->
                <?php
            } // Fim do foreach de gêneros
        } else {
            echo "<p>Nenhum gênero de livro encontrado.</p>";
        }
        ?>
    </div>
</body>
</html>
