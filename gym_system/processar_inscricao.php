<?php
// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gym_system";  // Substitua pelo nome do seu banco de dados

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifique a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Captura os dados do formulário
$nome = $_POST['nome'];
$email = $_POST['email'];
$telefone = $_POST['telefone'];
$dataNascimento = $_POST['dataNascimento'];
$dataRegistro = $_POST['dataRegistro'];
$role = $_POST['role'];
$senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Criptografando a senha
$formaPagamento = $_POST['formaPagamento'];

// Preparar a consulta SQL para inserir os dados
$sql = "INSERT INTO clientes (nome, email, telefone, data_nascimento, data_registro, role, senha, forma_pagamento)
        VALUES ('$nome', '$email', '$telefone', '$dataNascimento', '$dataRegistro', '$role', '$senha', '$formaPagamento')";

if ($conn->query($sql) === TRUE) {
    // Sucesso ao inserir
    echo "Novo cliente cadastrado com sucesso!";
    header("Location: admin.php"); // Redireciona para a lista de clientes
} else {
    // Erro ao inserir
    echo "Erro: " . $sql . "<br>" . $conn->error;
}

// Fechar a conexão
$conn->close();
?>
