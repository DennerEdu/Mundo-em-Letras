<?php
// Conexão com o banco de dados através de um PHP externo
include 'db_connect.php';

// Verifica se o método de requisição é POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtendo os dados do formulário
    $name = $_POST['name'];
    $email = $_POST['email'];
    $suggestion = $_POST['suggestion'];

    // Protegendo os dados para evitar SQL Injection
    $name = $conn->real_escape_string($name);
    $email = $conn->real_escape_string($email);
    $suggestion = $conn->real_escape_string($suggestion);

    // Gerando a inserção dos dados no banco de dados
    $sql = "INSERT INTO feedback (name, email, suggestion) VALUES ('$name', '$email', '$suggestion')";

    // Verificando se as informações foram enviadas ao banco de dados
    if ($conn->query($sql) === TRUE) {
        echo "Cadastro realizado com sucesso!";
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }

    // Fechando a conexão com o banco de dados
    $conn->close();
}
else {
    echo "Método de requisição inválido."
}
?>