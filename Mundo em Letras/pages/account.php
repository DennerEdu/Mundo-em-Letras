<?php
require '../php/db_connect.php';
session_start();
if (!isset($_SESSION['uid'])) {
    header('Location: ../pages/cadaster.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    session_destroy();
    header("location: ../index.php");
    exit();
}

$uid = $_SESSION['uid'];
$sql = "SELECT * FROM users WHERE uid = ('$uid')";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $username = $user['username'];
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conta</title>
    <link rel="stylesheet" href="../css/account.css">
    <script src="../js/headerScript.js" defer></script>
    <script src="../js/booksCarousel.js" defer></script>
    <script src="../js/accountModal.js" defer></script>
</head>
<body>
    <div class="container">
        <header>
            <div class='hnav'>
                <span class="menu-icon" id="menu-icon" onclick="toggleMenu()">☰</span>
                <img src="../img/logo.svg" alt="logo">
            </div>
            <div class="menu-content" id="menu-content">
                <h2><a href="../index.php">Inicio</a></h2>
                <h2><a href="../pages/catalog.php">Catálogo</a></h2>
                <form action="" method="POST">
                    <button type="submit"><h2>Sair</h2></button>
                </form>
            </div>
        </header>

        <div class="user">
            <?php echo "<h1>Bem vindo, " . htmlspecialchars($username) . "!</h1>" ?>
        </div>

        <div class="lists">
            <!-- Carrossel Favoritos -->
            <div class="carousel-section">
                <h2>Favoritos</h2>
                <div class="catalog-container">
                    <div class="catalog" id="favoritesCarousel">
                        <?php
                        // Consulta para buscar livros favoritos do usuário
                        $sqlFavorites = "SELECT c.* FROM favorite f 
                        INNER JOIN catalogContent c ON f.cc_isbn13 = c.isbn13 
                        WHERE f.users_uid = '$uid'";
                        $resultFavorites = $conn->query($sqlFavorites);

                        if ($resultFavorites && $resultFavorites->num_rows > 0) {
                            foreach ($resultFavorites as $book) {
                                ?>
                                <div class="item" onclick="openModal(<?=$book['isbn13']?>)">
                                    <img src="<?php echo $book['smallThumbnail'] ?? 'https://via.placeholder.com/150'; ?>" alt="">
                                    <h3><?php echo htmlspecialchars($book['name']); ?></h3>
                                    <p><?php echo htmlspecialchars($book['tinySynopsis']); ?></p>
                                </div>
                                <?php
                            }
                        } else {
                            echo "<p>Nenhum livro encontrado nos favoritos.</p>";
                        }
                        ?>
                    </div>
                    <div class="nav prev" onclick="moveCarousel(-1, 'favoritesCarousel')">&#10094;</div>
                    <div class="nav next" onclick="moveCarousel(1, 'favoritesCarousel')">&#10095;</div>
                </div>
            </div>

            <!-- Carrossel Wishlist -->
            <div class="carousel-section">
                <h2>Wishlist</h2>
                <div class="catalog-container">
                    <div class="catalog" id="wishlistCarousel">
                        <?php
                        $sqlWishlist = "SELECT c.* FROM wishlist w 
                        INNER JOIN catalogContent c ON w.cc_isbn13 = c.isbn13 
                        WHERE w.users_uid = '$uid'";
                        $resultWishlist = $conn->query($sqlWishlist);
                        if ($resultWishlist && $resultWishlist->num_rows > 0) {
                            foreach ($resultWishlist as $book) {
                                ?>
                                <div class="item" onclick="openModal(<?=$book['isbn13']?>)">
                                    <img src="<?php echo $book['smallThumbnail'] ?? 'https://via.placeholder.com/150'; ?>" alt="">
                                    <h3><?php echo htmlspecialchars($book['name']); ?></h3>
                                    <p><?php echo htmlspecialchars($book['tinySynopsis']); ?></p>
                                </div>
                                <?php
                            }
                        } else {
                            echo "<p>Nenhum item na wishlist.</p>";
                        }
                        ?>
                    </div>
                    <div class="nav prev" onclick="moveCarousel(-1, 'wishlistCarousel')">&#10094;</div>
                    <div class="nav next" onclick="moveCarousel(1, 'wishlistCarousel')">&#10095;</div>
                </div>
            </div>

            <!-- Carrossel Read Later -->
            <div class="carousel-section">
                <h2>Ler mais tarde</h2>
                <div class="catalog-container">
                    <div class="catalog" id="readLaterCarousel">
                        <?php
                        $sqlReadLater = "SELECT c.* FROM readLater r 
                        INNER JOIN catalogContent c ON r.cc_isbn13 = c.isbn13 
                        WHERE r.users_uid = '$uid'";
                        $resultReadLater = $conn->query($sqlReadLater);
                        if ($resultReadLater && $resultReadLater->num_rows > 0) {
                            foreach ($resultReadLater as $book) {
                                ?>
                                <div class="item" onclick="openModal(<?=$book['isbn13']?>)">
                                    <img src="<?php echo $book['smallThumbnail'] ?? 'https://via.placeholder.com/150'; ?>" alt="">
                                    <h3><?php echo htmlspecialchars($book['name']); ?></h3>
                                    <p><?php echo htmlspecialchars($book['tinySynopsis']); ?></p>
                                </div>
                                <?php
                            }
                        } else {
                            echo "<p>Nenhum item para leitura posterior.</p>";
                        }
                        ?>
                    </div>
                    <div class="nav prev" onclick="moveCarousel(-1, 'readLaterCarousel')">&#10094;</div>
                    <div class="nav next" onclick="moveCarousel(1, 'readLaterCarousel')">&#10095;</div>
                </div>
            </div>

            <!-- Carrossel Reading -->
            <div class="carousel-section">
                <h2>Lendo Agora</h2>
                <div class="catalog-container">
                    <div class="catalog" id="readingCarousel">
                        <?php
                        $sqlReading = "SELECT c.* FROM reading r 
                        INNER JOIN catalogContent c ON r.cc_isbn13 = c.isbn13 
                        WHERE r.users_uid = '$uid'";
                        $resultReading = $conn->query($sqlReading);
                        if ($resultReading && $resultReading->num_rows > 0) {
                            foreach ($resultReading as $book) {
                                ?>
                                <div class="item" onclick="openModal(<?=$book['isbn13']?>)">
                                    <img src="<?php echo $book['smallThumbnail'] ?? 'https://via.placeholder.com/150'; ?>" alt="">
                                    <h3><?php echo htmlspecialchars($book['name']); ?></h3>
                                    <p><?php echo htmlspecialchars($book['tinySynopsis']); ?></p>
                                </div>
                                <?php
                            }
                        } else {
                            echo "<p>Nenhum livro sendo lido atualmente.</p>";
                        }
                        ?>
                    </div>
                    <div class="nav prev" onclick="moveCarousel(-1, 'readingCarousel')">&#10094;</div>
                    <div class="nav next" onclick="moveCarousel(1, 'readingCarousel')">&#10095;</div>
                </div>
            </div>

            <!-- Seção Concluídos -->
            <div class="carousel-section">
                <h2>Concluídos</h2>
                <div class="catalog-container">
                    <div class="catalog" id="completedCarousel">
                        <?php
                        $sqlCompleted = "SELECT c.* FROM completed cmp 
                        INNER JOIN catalogContent c ON cmp.cc_isbn13 = c.isbn13 
                        WHERE cmp.users_uid = '$uid'";
                        $resultCompleted = $conn->query($sqlCompleted);
                        if ($resultCompleted && $resultCompleted->num_rows > 0) {
                            foreach ($resultCompleted as $book) {
                                ?>
                                <div class="item" onclick="openModal(<?=$book['isbn13']?>)">
                                    <img src="<?php echo $book['smallThumbnail'] ?? 'https://via.placeholder.com/150'; ?>" alt="">
                                    <h3><?php echo htmlspecialchars($book['name']); ?></h3>
                                    <p><?php echo htmlspecialchars($book['tinySynopsis']); ?></p>
                                </div>
                                <?php
                            }
                        } else {
                            echo "<p>Nenhum livro concluído encontrado.</p>";
                        }
                        ?>
                    </div>
                    <div class="nav prev" onclick="moveCarousel(-1, 'completedCarousel')">&#10094;</div>
                    <div class="nav next" onclick="moveCarousel(1, 'completedCarousel')">&#10095;</div>
                </div>
            </div>

        </div> <!-- Fim da div 'lists' -->
        
        <!-- Estrutura do Modal (inicialmente invisível) -->
        <div class="modal" id="modal">
        <div class="modal-content">
            <!-- Botão para fechar modal -->
            <span class="close-btn" onclick="closeModal()">&times;</span>
            
            <!-- 1ª Parte: Nome do livro e capa no centro, seguido da sinopse -->
            <div class="book-main-info">
                <h2 id="modalTitle">Título do Livro</h2>
                <img src="" alt="Capa do livro" id="modalBookCover">
                <p id="modalDescription">Sinopse do livro aqui...</p>
            </div>
            
            <!-- 2ª Parte: Informações do autor -->
            <div class="author-section">
                <h3>Informações do Autor:</h3>
                <table>
                    <tr>
                    <td><strong>Autor(a):</strong></td>
                    <td id="modalAuthor">Nome do Autor</td>
                    </tr>
                </table>
            </div>
            
            <!-- Informações de Publicação em forma de tabela -->
            <div class="publicationSection">
                <h3>Informações de Publicação:</h3>
                <table>
                    <tr>
                    <td><strong>Editora:</strong></td>
                    <td id="modalPublisher">Nome da Editora</td>
                    </tr>
                    <tr>
                    <td><strong>Ano de Publicação:</strong></td>
                    <td id="modalYear">ano de publicação</td>
                    </tr>
                </table>
            </div>

            <!-- Outras Informações em forma de tabela -->
            <div class="otherInfoSection">
                <h3>Outras Informações:</h3>
                <table>
                    <tr>
                    <td><strong>Número de páginas:</strong></td>
                    <td id="modalPages">Número de páginas</td>
                    </tr>
                    <tr>
                    <td><strong>Preço:</strong></td>
                    <td>R$ <span id="modalPrice"></span></td>
                    </tr>
                    <tr>
                    <td><strong>Classificação Indicativa:</strong></td>
                    <td id="modalRating">classificação Indicativa</td>
                    </tr>
                </table>
            </div>
            
            <!-- 5ª Parte: Comentários -->
            <div class="comments-section">
            <h3>Comentários</h3>
            <div class="comments-container">
                <div id="userComments">
                    <!-- Aqui aparecerão os comentários do usuários referentes a tal livro -->
                </div>
                <form action="../php/comment.php" method="POST">
                    <input type="hidden" name="isbn13" id="hiddenIsbn13" value="">            
                    <input type="text" name="comment" id="comment" placeholder="Escreva seu comentário aqui...">
                    <button type="submit">Enviar Comentário</button>
                </form>
            </div>
        </div>
        </div> <!-- Fim da div "modal-content" -->
        </div> <!-- Fim da div "modal" -->

        <form action="../php/delete.php" class="deleteAccount" method="POST">
            <button type="submit" id="deleteAccount">Excluir Conta</button>
        </form>

        <footer>
            <div class="terms"><p>©Todos os direitos reservados</p></div>
        </footer>
    </div>
</body>
</html>
