<?php
session_start();

// Verifica se o usuário está logado e caso nao manda para tela de login

if(!isset($_SESSION['cliente_id'])){
    header ("Location: autorizacao/login.php");
    exit();

}

// Verifica se o usuário está logado e é um aluno
if (!isset($_SESSION['cliente_id']) || $_SESSION['role'] != 'aluno') {
    echo "nao logou";
    header("Location: login.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Aluno</title>
    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>

</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">
      <img src="assets/img/Soufitness_logo.png" width="58" height="30" alt="Logo" class="d-inline-block align-text-top">
      <strong> <a class="nav-link text-white" href="perfil.php"><i class="fas fa-user-circle"></i> Bem-Vindo <?php echo $_SESSION['nome']; ?></a> </strong>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        
        <!-- Menu para Admin -->
        <?php if ($_SESSION['role'] == 'aluno'): ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownAdmin" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fas fa-cogs"></i> Aluno
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


<!-- Funcionalidades -->
<div class="row g-4">
    <div class="col-md-6 col-lg-4">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Cálculo de IMC</h5>
                <p>Insira seu peso e altura para calcular o IMC.</p>
                <input type="number" id="peso" placeholder="Peso (kg)" class="form-control mb-2">
                <input type="number" id="altura" placeholder="Altura (m)" class="form-control mb-2">
                <button class="btn btn-primary" onclick="calcularIMC()">Calcular</button>
                <p class="mt-3" id="resultadoIMC"></p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-4">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Controle de Mensalidades</h5>
                <p>Veja o status das mensalidades e notificações.</p>
                <a href="mensalidades.php" class="btn btn-warning">Acessar</a>
            </div>
        </div>
    </div>
</div>
</div>

    <script>
        function calcularIMC() {
            var peso = document.getElementById('peso').value;
            var altura = document.getElementById('altura').value;
            var imc = (peso / (altura * altura)).toFixed(2);
            document.getElementById('resultadoIMC').innerText = 'Seu IMC é ' + imc;
        }
    </script>

<footer class="text-body-secondary py-5">
      <div class="container">
        <p class="float-end mb-1">
          <a href="#">Voltar para cima</a>
        </p>
        <p class="mb-1">Construido por &copy; Fernando Luis Matsinhe!</p>
      </div>
    </footer>
</body>
</html>
