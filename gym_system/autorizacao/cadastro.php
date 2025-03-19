<?php 
session_start();
include('../db.php'); // Conexão com o banco

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recebe os dados do formulário
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $data_nascimento = $_POST['data_nascimento'];
    $role = $_POST['role'];
    $senha = $_POST['senha'];

    // Verifica se o e-mail já está cadastrado
    $check_sql = "SELECT id FROM clientes WHERE email = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        echo "<div class='alert alert-danger'>Erro: Este e-mail já está cadastrado!</div>";
    } else {
        // Criptografa a senha antes de armazená-la
        $senha_criptografada = password_hash($senha, PASSWORD_DEFAULT);

        // Insere o novo cliente
        $sql = "INSERT INTO clientes (nome, email, telefone, data_nascimento, role, senha)
                VALUES (?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Erro ao preparar a query: " . $conn->error);
        }

        $stmt->bind_param("ssssss", $nome, $email, $telefone, $data_nascimento, $role, $senha_criptografada);

        if ($stmt->execute()) {
            $_SESSION['cliente_id'] = $stmt->insert_id;
            $_SESSION['nome'] = $nome;
            $_SESSION['role'] = $role;

            // Redireciona conforme o tipo de usuário
            if ($role == 'admin') {
                header("Location: ../admin.php");
            } else {
                header("Location: ../aluno.php");
            }
            exit();
        } else {
            echo "<div class='alert alert-danger'>Erro ao cadastrar: " . $stmt->error . "</div>";
        }

        $stmt->close();
    }

    $check_stmt->close();
}

$conn->close();
?>
