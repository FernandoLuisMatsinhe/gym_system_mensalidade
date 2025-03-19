<?php
session_start();

// Verifica se o usuário está logado e caso nao manda para tela de login
if(!isset($_SESSION['cliente_id'])){
    header ("Location: autorizacao/login.php");
    exit();

}

// Verifica se o usuário está logado e é um administrador
if (!isset($_SESSION['cliente_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

$nome = $_SESSION['nome'];
$titulo = "Painel do Administrador";
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo; ?></title>
    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">
      <img src="assets/img/Soufitness_logo.png" width="58" height="30" alt="Logo" class="d-inline-block align-text-top">
      <strong><?php echo $titulo ?></strong>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        
        <!-- Menu para Admin -->
        <?php if ($_SESSION['role'] == 'admin'): ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownAdmin" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fas fa-cogs"></i> Administração
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdownAdmin">
              <li><a class="dropdown-item" href="admin_dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
              <li><a class="dropdown-item" href="alunos.php"><i class="fas fa-users"></i> Alunos</a></li>
              <li><a class="dropdown-item" href="pagamentos.php"><i class="fas fa-credit-card"></i> Pagamentos</a></li>
              <li><a class="dropdown-item" href="notificacoes.php"><i class="fas fa-bell"></i> Notificações</a></li>
              <li><a class="dropdown-item" href="relatorios.php"><i class="fas fa-chart-line"></i> Relatórios</a></li>
            </ul>
          </li>
        <?php endif; ?>

        <!-- Menu para Aluno -->
        <?php if ($_SESSION['role'] == 'aluno'): ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownAluno" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fas fa-user"></i> Aluno
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdownAluno">
              <li><a class="dropdown-item" href="minha_conta.php"><i class="fas fa-user"></i> Minha Conta</a></li>
              <li><a class="dropdown-item" href="mensalidade.php"><i class="fas fa-money-bill-wave"></i> Mensalidade</a></li>
              <li><a class="dropdown-item" href="notificacoes.php"><i class="fas fa-bell"></i> Notificações</a></li>
              <li><a class="dropdown-item" href="suporte.php"><i class="fas fa-headset"></i> Suporte</a></li>
            </ul>
          </li>
        <?php endif; ?>

        <!-- Nome do Usuário -->
        <li class="nav-item">
          <a class="nav-link text-white" href="perfil.php"><i class="fas fa-user-circle"></i> <?php echo $_SESSION['nome']; ?></a>
        </li>

        <!-- Logout -->
        <li class="nav-item">
          <a class="nav-link" href="autorizacao/logout.php"><i class="fas fa-sign-out-alt"></i> Sair</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Incluindo Font Awesome para os ícones -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <div class="container mt-4" >

        <!-- Slideshow responsivo -->
        <div id="carouselExample" class="carousel slide mb-4" data-bs-ride="carousel">
            <div class="carousel-inner text-center">
                <div class="carousel-item active">
                    <img src="assets/img/1.jpeg" class="d-block mx-auto img-fluid" style="max-height: 350px;" alt="Academia 1">
                </div>
                <div class="carousel-item">
                    <img src="assets/img/2.jpeg" class="d-block mx-auto img-fluid" style="max-height: 350px;" alt="Academia 2">
                </div>
                <div class="carousel-item">
                    <img src="assets/img/3.jpeg" class="d-block mx-auto img-fluid" style="max-height: 350px;" alt="Academia 3">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
            </button>
        </div>

    </div>


    <div class="container mt-4">

    <!-- Formulário de Inscrição do Cliente -->
    <div id="inscricaoCliente" class="container mt-4">
        <h3 class="text-center">Inscrição de Cliente</h3>
        <form action="processar_inscricao.php" method="POST">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome do cliente" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Email do cliente" required>
            </div>
            <div class="mb-3">
                <label for="telefone" class="form-label">Telefone</label>
                <input type="text" class="form-control" id="telefone" name="telefone" placeholder="Telefone do cliente" required>
            </div>
            <div class="mb-3">
                <label for="dataNascimento" class="form-label">Data de Nascimento</label>
                <input type="date" class="form-control" id="dataNascimento" name="dataNascimento" required>
            </div>
            <div class="mb-3">
                <label for="dataRegistro" class="form-label">Data de Registro</label>
                <input type="date" class="form-control" id="dataRegistro" name="dataRegistro" required>
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select class="form-control" id="role" name="role">
                    <option value="aluno">Aluno</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="senha" class="form-label">Senha</label>
                <input type="password" class="form-control" id="senha" name="senha" placeholder="Senha do cliente" required>
            </div>
            <div class="mb-3">
                <label for="formaPagamento" class="form-label">Forma de Pagamento</label>
                <select class="form-control" id="formaPagamento" name="formaPagamento">
                    <option value="cash">Cash</option>
                    <option value="banco">Banco</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar Cliente</button>
        </form>
    </div>

    <div class="container mt-4">
    <!-- Botões de navegação -->
    <div class="d-flex justify-content-center mb-4">
        <button class="btn btn-primary mx-2" id="btnGerenciarClientes">Gerenciar Clientes</button>
        <button class="btn btn-primary mx-2" id="btnResumoFinanceiro">Resumo Financeiro</button>
    </div>

    <!-- Gerenciar Clientes -->
    <div id="gerenciarClientes" class="container mt-4">
        <h3 class="text-center">Clientes Cadastrados</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Email</th>
                    <th scope="col">Telefone</th>
                    <th scope="col">Data Nascimento</th>
                    <th scope="col">Data Registro</th>
                    <th scope="col">Role</th>
                    <th scope="col">Forma de Pagamento</th>
                    <th scope="col">Dias para Expirar</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Conectar ao banco de dados
                $conn = new mysqli("localhost", "root", "", "gym_system");
                if ($conn->connect_error) {
                    die("Conexão falhou: " . $conn->connect_error);
                }

                // Buscar clientes
                $sql = "SELECT * FROM clientes";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        // Calcular dias restantes para expiração
                        $data_registro = new DateTime($row['data_registro']);
                        $data_vencimento = $data_registro->modify('+30 days');
                        $hoje = new DateTime();
                        $intervalo = $hoje->diff($data_vencimento);
                        $dias_restantes = $intervalo->days;

                        // Exibir dados na tabela
                        echo "<tr>
                                <td>" . $row['id'] . "</td>
                                <td>" . $row['nome'] . "</td>
                                <td>" . $row['email'] . "</td>
                                <td>" . $row['telefone'] . "</td>
                                <td>" . $row['data_nascimento'] . "</td>
                                <td>" . $row['data_registro'] . "</td>
                                <td>" . $row['role'] . "</td>
                                <td>" . $row['forma_pagamento'] . "</td>
                                <td>" . $dias_restantes . " dias</td>
                                <td>
                                    <a href='editar_cliente.php?id=" . $row['id'] . "' class='btn btn-warning'>Editar</a>
                                    <a href='excluir_cliente.php?id=" . $row['id'] . "' class='btn btn-danger' onclick='return confirm(\"Tem certeza que deseja excluir?\")'>Excluir</a>
                                    <a href='enviar_sms.php?id=" . $row['id'] . "' class='btn btn-info'>Enviar SMS</a>
                                </td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='10' class='text-center'>Nenhum cliente cadastrado.</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <!-- Resumo Financeiro -->
    <div id="resumoFinanceiro" class="container mt-4 d-none">
        <h3 class="text-center">Resumo Financeiro</h3>
        <div class="row">
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Número de Inscritos</h5>
                        <p id="numInscritos">45</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Subtotal</h5>
                        <p id="subtotal">R$ 4.500,00</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Total Mensal</h5>
                        <p id="totalMensal">R$ 12.000,00</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>

<script>
// Alternar entre Gerenciar Clientes e Resumo Financeiro
document.getElementById('btnGerenciarClientes').addEventListener('click', function() {
    document.getElementById('gerenciarClientes').classList.remove('d-none');
    document.getElementById('resumoFinanceiro').classList.add('d-none');
});

document.getElementById('btnResumoFinanceiro').addEventListener('click', function() {
    document.getElementById('resumoFinanceiro').classList.remove('d-none');
    document.getElementById('gerenciarClientes').classList.add('d-none');
});
</script>>


    <footer class="text-body-secondary py-5">
      <div class="container">
        <p class="float-end mb-1">
          <a href="#">Voltar para cima</a>
        </p>
        <p class="mb-1">Construido por &copy; Fernando Luis Matsinhe!</p>
      </div>
    </footer>


    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
</html>
