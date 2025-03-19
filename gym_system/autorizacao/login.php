<!doctype html>
<html lang="en" data-bs-theme="auto">
  <head><script src="../assets/js/color-modes.js"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.122.0">
    <title>Login</title>


    <!-- CSS do Bootstrap (local) -->
    <link href="../assets\bootstrap\css\bootstrap.min.css" rel="stylesheet">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      .b-example-divider {
        width: 100%;
        height: 3rem;
        background-color: rgba(0, 0, 0, .1);
        border: solid rgba(0, 0, 0, .15);
        border-width: 1px 0;
        box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
      }

      .b-example-vr {
        flex-shrink: 0;
        width: 1.5rem;
        height: 100vh;
      }

      .bi {
        vertical-align: -.125em;
        fill: currentColor;
      }

      .nav-scroller {
        position: relative;
        z-index: 2;
        height: 2.75rem;
        overflow-y: hidden;
      }

      .nav-scroller .nav {
        display: flex;
        flex-wrap: nowrap;
        padding-bottom: 1rem;
        margin-top: -1px;
        overflow-x: auto;
        text-align: center;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
      }

      .btn-bd-primary {
        --bd-violet-bg: #712cf9;
        --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

        --bs-btn-font-weight: 600;
        --bs-btn-color: var(--bs-white);
        --bs-btn-bg: var(--bd-violet-bg);
        --bs-btn-border-color: var(--bd-violet-bg);
        --bs-btn-hover-color: var(--bs-white);
        --bs-btn-hover-bg: #6528e0;
        --bs-btn-hover-border-color: #6528e0;
        --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
        --bs-btn-active-color: var(--bs-btn-hover-color);
        --bs-btn-active-bg: #5a23c8;
        --bs-btn-active-border-color: #5a23c8;
      }

      .bd-mode-toggle {
        z-index: 1500;
      }

      .bd-mode-toggle .dropdown-menu .active .bi {
        display: block !important;
      }
    </style>

    
    <!-- Custom styles for this template -->
    <link href="../assets/bootstrap/css/sign-in.css" rel="stylesheet">
  </head>
  <body class="d-flex align-items-center py-4 bg-body-tertiary bg_login">
  
      <?php
      session_start(); // Inicia a sessão
      require_once '../db.php'; // Inclui o arquivo de conexão com o banco de dados

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
          $email = $_POST['email'];
          $senha = $_POST['senha'];

          // Verifica se o cliente está cadastrado na tabela 'clientes' e se a senha está correta
          $stmt = $conn->prepare("SELECT * FROM clientes WHERE email = ?");
          $stmt->bind_param("s", $email); // Bind do parâmetro
          $stmt->execute();
          $result = $stmt->get_result();
          $cliente = $result->fetch_assoc(); // Obtém o cliente
          if ($cliente) {
            echo "Cliente encontrado: " . $cliente['email']; // Verifique se o cliente está sendo retornado corretamente
        } else {
            echo "Cliente não encontrado!";
        }
   
          if ($cliente && password_verify($senha, $cliente['senha'])) {
              // Cliente encontrado e senha correta, armazena as informações na sessão
              $_SESSION['cliente_id'] = $cliente['id'];
              $_SESSION['nome'] = $cliente['nome'];
              $_SESSION['role'] = $cliente['role']; // 'admin' ou 'aluno'

              // Redireciona para a tela correspondente ao tipo de usuário
              if ($cliente['role'] == 'admin') {
                  // Se for admin, redireciona para a página de admin
                  header("Location: ../admin.php");
              } else {
                  // Se for aluno, redireciona para a página de aluno
                  header("Location: ../aluno.php");
              }
              exit();
          } else {
              $erro = "E-mail ou senha inválidos!";
          }
      }
      ?>
    
    <main class="form-signin w-100 m-auto">
      <form method="POST">
        <img class="mb-4" src="../assets/img/Soufitness_logo.png" alt="" width="300" height="90">
        <h1 class="h3 mb-3 fw-normal">Iniciar cessão</h1>

        <div class="form-floating">
          <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com" required>
          <label for="floatingInput">Email</label>
        </div>
        <div class="form-floating">
          <input type="password" name="senha" class="form-control" id="floatingPassword" placeholder="Password">
          <label for="floatingPassword">Password</label>
        </div>

        <div class="form-check text-start my-3">
        <p> Não tem uma conta? <a class="btn-getstarted" href="registo.php"><strong style="color: red;">Registar</strong></a> </p>
        </div>
        <button class="btn btn-danger w-100 py-2" type="submit">Iniciar cessão</button>
        <p class="mt-5 mb-3 text-body-secondary">&copy; 2025</p>
      </form>
      <?php if (isset($erro)) { echo "<p>$erro</p>"; } ?>
      
    </main>

    <!-- JavaScript do Bootstrap (local) -->
    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>

    </body>
</html>
