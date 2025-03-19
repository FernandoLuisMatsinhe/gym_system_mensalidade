<?php
session_start(); // Inicia a sessão
require_once 'db.php'; // Inclui o arquivo de conexão com o banco de dados

// Captura os dados do formulário
$id = $_POST['id'];
$nome = $_POST['nome'];
$email = $_POST['email'];
$telefone = $_POST['telefone'];
$dataNascimento = $_POST['dataNascimento'];
$dataRegistro = $_POST['dataRegistro'];
$role = $_POST['role'];
$senha = $_POST['senha'] ? password_hash($_POST['senha'], PASSWORD_DEFAULT) : null; // Se a senha não for vazia, criptografa
$formaPagamento = $_POST['formaPagamento'];

// Atualiza a consulta SQL para editar os dados do cliente
$sql = "UPDATE clientes SET
            nome = '$nome',
            email = '$email',
            telefone = '$telefone',
            data_nascimento = '$dataNascimento',
            data_registro = '$dataRegistro',
            role = '$role',
            forma_pagamento = '$formaPagamento'";

if ($senha) {
    $sql .= ", senha = '$senha'"; // Atualiza a senha apenas se o campo senha não for vazio
}

$sql .= " WHERE id = $id"; // Filtra o cliente com o ID especificado

if ($conn->query($sql) === TRUE) {
    // Sucesso ao atualizar
    echo "Cliente atualizado com sucesso!";
    header("Location: admin.php"); // Redireciona para a lista de clientes
} else {
    // Erro ao atualizar
    echo "Erro: " . $sql . "<br>" . $conn->error;
}

// Fechar a conexão
$conn->close();
?>
