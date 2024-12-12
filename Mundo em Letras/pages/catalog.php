<?php
session_start();
require '../php/db_connect.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo</title>
    <link rel="stylesheet" href="../css/catalog.css">
    <script src="../js/booksCarousel.js" defer></script>
    <script src="../js/headerScript.js" defer></script>
    <script src="../js/modal.js" defer></script>
</head>
<body>
    <div class="container">
        <header>
            <div class="hnav">
                <span class="menu-icon" id="menu-icon" onclick="toggleMenu()">☰</span>
                <img src="../img/logo.svg" alt="logo">
            </div>
            <div class="menu-content" id="menu-content">
                <h2><a href="../index.php">Inicio</a></h2>
                <h2><a href="catalog.php">Catálogo</a></h2>
                <?php
                if (!isset($_SESSION['uid'])) {
                ?>
                    <h2><a href="../pages/cadaster.php">Cadastrar</a></h2>
                <?php
                } // Fim da verificação da variável de sessão
                else {
                ?>
                    <h2><a href="../pages/account.php">Conta</a></h2>
                <?php
                }
                ?>
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
                                    <div class="item" onclick="openModal(<?=$book['isbn13']?>)">
                                        <img src="<?php echo $book['smallThumbnail'] !== 'null' ? $book['smallThumbnail'] : 'https://via.placeholder.com/150'; ?>" alt="">
                                        <h3><?php echo htmlspecialchars($book['name']); ?></h3>
                                        <p><?php echo htmlspecialchars($book['tinySynopsis']); ?></p>
                                    </div> <!-- Fim da div "item" -->
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

    <!-- Estrutura do Modal (inicialmente invisível) -->
    <div class="modal" id="modal" isbn13="">
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

        <!-- 5ª Parte: Botões -->
        <div class="button-section">
            <form action="../php/favorite.php" method="POST">
                <!-- Campo oculto para enviar o ISBN -->
                <input type="hidden" name="isbn13" id="hiddenIsbn13" value="">            
                <!-- Campo oculto para enviar o UID -->
                <?php
                if (isset($_SESSION['uid'])) {
                    ?>
                    <input type="hidden" name="uid" value="<?= $_SESSION['uid'] ?>">
                    <?php
                } else {
                    ?>
                    <input type="hidden" name="uid" value="">
                    <?php
                }
                ?>
                <button type="submit">Adicionar aos Favoritos</button>
            </form>
            <form action="../php/addList.php" method="POST">
            <!-- Campo oculto para enviar o ISBN -->
            <input type="hidden" name="isbn13" id="hiddenIsbn13_2" value="">    
            <!-- Campo oculto para enviar o UID -->
            <?php
                if (isset($_SESSION['uid'])) {
                    ?>
                    <input type="hidden" name="uid" value="<?= $_SESSION['uid'] ?>">
                    <?php
                } else {
                    ?>
                    <input type="hidden" name="uid" value="">
                    <?php
                }
                ?>

            <!-- Campo de seleção para o usuário escolher a lista -->
            <label for="list">Escolha a lista que deseja adicionar o livro:</label>
            <select name="list" id="list">
                <option value="wishlist">Lista de desejos</option>
                <option value="readLater">Ler mais tarde</option>
                <option value="reading">Lendo Agora</option>
                <option value="completed">Concluídos</option>
            </select>

            <!-- Botão de envio -->
            <button type="submit">Adicionar à Lista</button>
        </form>

        </div>
        
        <!-- 6ª Parte: Comentários -->
        <div class="comments-section">
            <h3>Comentários</h3>
            <div class="comments-container">
                <div id="userComments">
                    <!-- Aqui aparecerão os comentários do usuários referentes a tal livro -->
                </div>
                <form action="../php/comment.php" method="POST">
                    <input type="hidden" name="isbn13" id="hiddenIsbn13_3" value="">            
                    <input type="text" name="comment" id="comment" placeholder="Escreva seu comentário aqui...">
                    <button type="submit">Enviar Comentário</button>
                </form>
            </div>
        </div>
    </div> <!-- Fim da div "modal-content" -->
    </div> <!-- Fim da div "modal" -->

        <footer>
            <div class="terms"><p>©Todos os direitos reservados</p></div>
        </footer>


    </div> <!-- Fim da div "container" -->
</body>
</html>