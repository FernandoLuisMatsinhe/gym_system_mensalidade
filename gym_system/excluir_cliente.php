<?php
// Conexão com o banco
$conn = new mysqli("localhost", "root", "", "gym_system");
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Excluir cliente
$id = $_GET['id'];
$sql = "DELETE FROM clientes WHERE id = $id";
if ($conn->query($sql) === TRUE) {
    echo "Cliente excluído com sucesso!";
    header("Location: lista_clientes.php"); // Redireciona de volta para a lista
} else {
    echo "Erro ao excluir cliente: " . $conn->error;
}

$conn->close();
?>
