<?php
// Conexão com o banco
$conn = new mysqli("localhost", "root", "", "gym_system");
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Buscar dados do cliente
$id = $_GET['id'];
$sql = "SELECT * FROM clientes WHERE id = $id";
$result = $conn->query($sql);
$cliente = $result->fetch_assoc();
?>

<!-- Formulário de Edição do Cliente -->
<div class="container mt-4">
    <h3 class="text-center">Editar Cliente</h3>
    <form action="processar_edicao.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $cliente['id']; ?>">
        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $cliente['nome']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo $cliente['email']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="telefone" class="form-label">Telefone</label>
            <input type="text" class="form-control" id="telefone" name="telefone" value="<?php echo $cliente['telefone']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="dataNascimento" class="form-label">Data de Nascimento</label>
            <input type="date" class="form-control" id="dataNascimento" name="dataNascimento" value="<?php echo $cliente['data_nascimento']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="dataRegistro" class="form-label">Data de Registro</label>
            <input type="date" class="form-control" id="dataRegistro" name="dataRegistro" value="<?php echo $cliente['data_registro']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select class="form-control" id="role" name="role">
                <option value="aluno" <?php if($cliente['role'] == 'aluno') echo 'selected'; ?>>Aluno</option>
                <option value="admin" <?php if($cliente['role'] == 'admin') echo 'selected'; ?>>Admin</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="senha" class="form-label">Senha</label>
            <input type="password" class="form-control" id="senha" name="senha" value="<?php echo $cliente['senha']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="formaPagamento" class="form-label">Forma de Pagamento</label>
            <select class="form-control" id="formaPagamento" name="formaPagamento">
                <option value="cash" <?php if($cliente['forma_pagamento'] == 'cash') echo 'selected'; ?>>Cash</option>
                <option value="banco" <?php if($cliente['forma_pagamento'] == 'banco') echo 'selected'; ?>>Banco</option>
            </select>
        </div>
        <button type="submit" class="btn btn-warning">Atualizar Cliente</button>
    </form>
</div>
