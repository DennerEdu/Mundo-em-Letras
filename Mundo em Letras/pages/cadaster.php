<?php
session_start();
if (isset($_SESSION['uid'])) {
    header('Location: ../pages/account.php');
    exit();
}
$error = isset($_SESSION['message']) ? $_SESSION['message'] : '';
unset($_SESSION['message']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mundo em Letras</title>
    <link rel="stylesheet" href="../css/cadaster.css">
    <script src="../js/headerScript.js" defer></script>
    <script src="../js/cadaster.js" defer></script>
</head>
<body>
    <div class="container">
        <header>
            <div class='nav'>
                <span class="menu-icon" id="menu-icon" onclick="toggleMenu()">☰</span>
                <img src="../img/logo.svg" alt="logo">
            </div>
            <div class="menu-content" id="menu-content">
                <h2><a href="../index.php">Inicio</a></h2>
                <h2><a href="../pages/catalog.php">Catálogo</a></h2>
                <h2><a href="cadaster.php">Cadastrar</a></h2>
            </div>
        </header>

        <!-- Exibir mensagem de erro se houver -->
        <?php if (!empty($error)){ ?>
                <div class="error-message">
                    <p><?= htmlspecialchars($error) ?></p>
                </div>
        <?php } // Fim da verificação de erros ?>

        <div class="login-container">
            <div class="form-container">
                <h2 id="form-title">Login</h2>
                <form action="../php/login.php" method="POST" id="form">
                    <label for="username">Usuário</label>
                    <input type="text" id="username" name="username" placeholder="Nome de usuário ou email" required>
                    <label for="password">Senha</label>
                    <input type="password" id="password" name="password" placeholder="Senha" required>
                    <button type="submit">Entrar</button>
                </form>
                <button id="toggle-btn">Ir para Cadastro</button>
            </div>
        </div>

        <footer>
            <div class="terms"><p>©Todos os direitos reservados</p></div>
        </footer>
    </div>
</body>
</html>
