<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gym_system";

//$servername = "fdb1029.awardspace.net";
//$username = "4606011_gym";
//$password = "Taekwondo1221!#";
//$dbname = "4606011_gym";

// Criando a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificando a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
} else {
    echo" Conexao bem sucedidaa!";
}
?>