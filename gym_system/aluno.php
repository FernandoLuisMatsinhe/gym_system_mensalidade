<?php
// Inicia a sessão para verificar o login do usuário
session_start();

// Verifica se o usuário está logado, caso contrário redireciona para a página de login
if (!isset($_SESSION['cliente_id'])) {
    header("Location: autorizacao/login.php");
    exit();
}

// Verifica se o usuário logado é um aluno (role 'aluno') caso contrário redireciona para login
if (!isset($_SESSION['cliente_id']) || $_SESSION['role'] != 'aluno') {
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
    <!-- Link para o Bootstrap -->
    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/costum.css">

    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Link para o Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Função para adicionar efeito de carregamento (preloader)
        document.addEventListener("DOMContentLoaded", function() {
            setTimeout(() => {
                document.body.classList.add("loaded");
            }, 1000); // Tempo de exibição do preloader antes de sumir
        });
    </script>

</head>
<body>

<!-- Preloader (Carregando) -->
<div id="preloader">
    <img src="assets/img/Soufitness_logo.png" alt="Carregando...">
</div>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <img src="assets/img/Soufitness_logo.png" width="58" height="30" alt="Logo">
        </a>
        <a class="navbar-brand" href="#">SouFitness</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">Bem-vindo, <?php echo $_SESSION['nome']; ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="autorizacao/logout.php">Sair</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Conteúdo Principal -->
<div class="container mt-4">

<?php
$conn = new mysqli('localhost', 'root', '', 'gym_system');
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verifica se o usuário enviou um comentário
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comentario'], $_POST['galeria_id'])) {
    $comentario = $conn->real_escape_string($_POST['comentario']);
    $galeria_id = (int)$_POST['galeria_id'];

    $sql = "INSERT INTO comentarios (galeria_id, comentario) VALUES ('$galeria_id', '$comentario')";
    $conn->query($sql);
}

// Buscar imagens
$sql_top = "SELECT * FROM galeria WHERE tipo = 'top'";
$result_top = $conn->query($sql_top);

$sql_bottom = "SELECT * FROM galeria WHERE tipo = 'bottom'";
$result_bottom = $conn->query($sql_bottom);
?>

 <!-- Gallery Section -->
<div class="container my-5">
    <div class="row">
        <!-- Carrossel de Imagens de Cima -->
        <div class="col-md-12">
            <h3 class="text-center mb-4">Galeria de Fotos - Ginásio Fitness</h3>
            <div id="carouselTop" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php
                    // Buscar imagens
$sql_top = "SELECT * FROM galeria WHERE tipo = 'top'";
$result_top = $conn->query($sql_top);

// Verificar se a consulta foi bem-sucedida
if (!$result_top) {
    // Se a consulta falhou, exibe a mensagem de erro
    echo "Erro na consulta: " . $conn->error;
} else {
    // Caso contrário, continue com o processamento dos dados
    $active = true;
    $count = 0;
    echo '<div class="carousel-item ' . ($active ? 'active' : '') . '"><div class="row">';

    while ($row = $result_top->fetch_assoc()) {
        if ($count > 0 && $count % 4 == 0) {
            echo '</div></div>'; // Fecha a linha anterior
            echo '<div class="carousel-item"><div class="row">'; // Inicia um novo slide com 4 imagens
        }

        echo '<div class="col-md-3 mb-3 col-12">';
        echo '<div class="gallery-img" style="background-image: url(\'assets/img/gallery/' . $row['imagem'] . '\'); height: 200px; background-size: cover; background-position: center;"></div>';
        echo '<div class="d-flex flex-column align-items-center bg-dark p-2">';
        echo '<a href="assets/img/gallery/' . $row['imagem'] . '" download class="btn btn-danger btn-sm w-100">Baixar</a>';
        echo '<button class="btn btn-light btn-sm w-100 mt-1" onclick="mostrarFormularioComentario(' . $row['id'] . ')">Comentar</button>';
        echo '<div id="comentarios-' . $row['id'] . '" class="w-100 text-light">';

        // Buscar o comentário mais recente com nome do cliente
        $coment_sql = "SELECT c.comentario, c.data, cliente.nome FROM comentarios c INNER JOIN clientes clinte ON c.cliente_id = cli.id WHERE c.galeria_id = " . $row['id'] . " ORDER BY c.data DESC LIMIT 1";
        $coment_result = $conn->query($coment_sql);
        
        if (!$coment_result) {
            // Se a consulta de comentários falhou, exibe a mensagem de erro
            echo "Erro na consulta de comentários: " . $conn->error;
        } else {
            while ($coment = $coment_result->fetch_assoc()) {
                echo '<p class="comentario bg-secondary p-1 mt-1 rounded"><strong>' . htmlspecialchars($coment['nome']) . ':</strong> ' . htmlspecialchars($coment['comentario']) . ' - <small>' . $coment['data'] . '</small></p>';
            }
        }

        echo '</div></div></div>';
        $count++;
        $active = false;
    }

    echo '</div></div>'; // Fecha a última linha do carrossel
}
                    ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselTop" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselTop" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Formulário para Comentário -->
<div id="comentarioForm" class="hidden mt-3 text-center">
    <form method="post">
        <input type="hidden" name="galeria_id" id="galeria_id">
        <textarea name="comentario" class="form-control" placeholder="Escreva seu comentário..." required></textarea>
        <button type="submit" class="btn btn-danger btn-sm mt-2">Enviar</button>
    </form>
</div>

<script>
// Configuração para o carrossel
var myCarousel = document.getElementById('carouselTop');
var carousel = new bootstrap.Carousel(myCarousel, {
    interval: window.innerWidth <= 768 ? 2000 : false, // Troca de slide a cada 2 segundos para telas menores (celulares)
    ride: 'carousel'
});

function mostrarFormularioComentario(id) {
    document.getElementById("galeria_id").value = id;
    document.getElementById("comentarioForm").style.display = "block";
}
</script>


                        <!-- Chamada para Ação -->
                        <div class="col-md-12 my-5">
                            <div class="card p-4 text-center">
                                <h2 class="text-danger">Nossos Produtos</h2>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Imagem</th>
                                            <th>Produto</th>
                                            <th>Descrição</th>
                                            <th>Preço</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><img src="assets/img/produtos/produto1.png" alt="Whey Protein" style="width: 80px; height: auto;"></td>
                                            <td>Suplemento Whey</td>
                                            <td>Proteína isolada para ganho muscular</td>
                                            <td>R$ 150,00</td>
                                        </tr>
                                        <tr>
                                            <td>Luvas de Treino</td>
                                            <td>Protege as mãos e melhora o grip</td>
                                            <td>R$ 80,00</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <p>Entre em contato com a recepção para mais informações:</p>
                                <a href="https://wa.me/5511999999999" class="btn btn-success">Fale Conosco no WhatsApp</a>
                            </div>
                        </div>

                    </div>
</div>




    <!-- Funcionalidades da Academia -->
    <div class="container py-5">
        <h2 class="text-center text-white mb-4">Funcionalidades da Academia</h2>
        <div class="row textoVermelhoH2">
            <!-- Funcionalidade 1 - Cálculo de IMC -->
            <div class="col-12 col-md-4 mb-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h4 class="card-title textoVermelhoH2">Cálculo de IMC</h4>
                        <p class="card-text">Calcule seu índice de massa corporal e descubra sua categoria.</p>
                        <div class="form-group">
                            <input type="number" id="peso" class="form-control mb-2" placeholder="Peso (kg)">
                            <input type="number" id="altura" class="form-control mb-2" placeholder="Altura (m)" step="0.01">
                        </div>
                        <button class="btn btn-primary" onclick="calcularIMC()">Calcular IMC</button>
                        <p id="resultadoIMC" class="mt-3"></p>
                    </div>
                </div>
            </div>

            <!-- Funcionalidade 2 - Consulta de Pacotes -->
            <div class="col-12 col-md-4 mb-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h4 class="card-title textoVermelhoH2">Planos de Assinatura</h4>
                        <p class="card-text">Consulte nossos planos de mensalidade e benefícios.</p>
                        <button class="btn btn-primary" onclick="mostrarImagemPacote()">Ver Planos</button>
                    </div>
                </div>
            </div>

            <!-- Funcionalidade 3 - Agendar Aula -->
            <div class="col-12 col-md-4 mb-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h4 class="card-title textoVermelhoH2">Agendar Aula</h4>
                        <p class="card-text">Agende sua aula com nossos treinadores.</p>
                        <button class="btn btn-primary" onclick="window.location.href='agendar_aula.php'">Agendar Agora</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Aula Presença -->
    <div class="row">
        <div class="col-md-4 mb-4">
            <h5>Você participará da aula de hoje?</h5>
            <p id="datetime"></p>
            <button class="btn btn-success btn-sm" id="simBtn">Sim</button>
            <button class="btn btn-danger btn-sm" id="naoBtn">Não</button>
        </div>

        <div class="col-md-4 mb-4" id="mensagemDiv">
            <!-- Mensagem dinâmica será exibida aqui -->
        </div>

        <div class="col-md-4 mb-4 text-center">
            <canvas id="frequenciaChart" class="chart-container"></canvas>
        </div>
    </div>

    <!-- Detalhes adicionais -->
    <div class="row">
        <div class="col-md-4 mb-4">
            <h5>Quantas aulas você já fez este mês?</h5>
            <p id="aulasFeitas">0 aulas</p>
        </div>

        <div class="col-md-4 mb-4">
            <h5>Dicas para alcançar seus objetivos</h5>
            <ul id="dicasList">
                <li>Mantenha-se hidratado</li>
                <li>Faça alongamentos antes e depois da aula</li>
                <li>Mantenha um foco constante nas suas metas</li>
            </ul>
        </div>

        <div class="col-md-4 mb-4">
            <h5>Próxima Aula:</h5>
            <p id="proximaAula">15:00 - Aula de HIIT</p>
        </div>
    </div>

</div>

<!-- Footer -->
<footer class="bg-dark text-light py-4">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h5>Localização</h5>
                <p>Rua Exemplo, 123 - Centro<br>Cidade, Estado - CEP 00000-000</p>
                <div id="map" style="width:100%; height:200px;"></div>
            </div>
            <div class="col-md-4">
                <h5>Contato</h5>
                <p>Telefone: (11) 99999-9999</p>
                <p>Email: contato@ginasio.com</p>
                <a href="https://wa.me/5511999999999" class="btn btn-success btn-sm">WhatsApp</a>
            </div>
            <div class="col-md-4">
                <h5>Redes Sociais</h5>
                <a href="#" class="text-light me-3"><i class="fab fa-facebook fa-2x"></i></a>
                <a href="#" class="text-light me-3"><i class="fab fa-instagram fa-2x"></i></a>
                <a href="#" class="text-light me-3"><i class="fab fa-twitter fa-2x"></i></a>
            </div>
        </div>
    </div>
</footer>

<!-- Script para carregar o mapa -->
<script>
    function initMap() {
        var location = { lat: -23.55052, lng: -46.633308 };
        var map = new google.maps.Map(document.getElementById("map"), {
            zoom: 15,
            center: location
        });
        var marker = new google.maps.Marker({ position: location, map: map });
    }
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=SUA_CHAVE_API&callback=initMap"></script>
<script>
    // Atualiza a data e hora a cada segundo
    function updateDateTime() {
        const now = new Date();
        document.getElementById("datetime").innerText = now.toLocaleString();
    }
    setInterval(updateDateTime, 1000);
    updateDateTime();

    // Exibe a mensagem baseada na escolha do aluno
    document.getElementById("simBtn").addEventListener("click", function() {
        document.getElementById("mensagemDiv").innerHTML = `
            <p class="text-success"><strong>Excelente!</strong> Continue assim, você está indo muito bem!</p>
            <img src="assets/img/pessoa_feliz.jpg" alt="Pessoa feliz" class="img-fluid" />
        `;
    });

    document.getElementById("naoBtn").addEventListener("click", function() {
        document.getElementById("mensagemDiv").innerHTML = `
            <p class="text-danger"><strong>Vamos lá!</strong> Não desista, ainda há tempo para se juntar à aula e conquistar seus objetivos!</p>
            <p class="text-info">Próxima aula: 15:00 - Aula de HIIT</p>
            <img src="assets/img/coach1.jpg" alt="coach1" class="img-fluid" />
        `;
    });

    // Gráfico de Frequência
    const ctx = document.getElementById('frequenciaChart').getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Presenças', 'Faltas'],
            datasets: [{
                data: [80, 20], // Valores que serão puxados do banco de dados
                backgroundColor: ['#28a745', '#dc3545']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    // Função para calcular o IMC
    function calcularIMC() {
        let peso = parseFloat(document.getElementById('peso').value);
        let altura = parseFloat(document.getElementById('altura').value);

        if (peso > 0 && altura > 0) {
            let imc = (peso / (altura * altura)).toFixed(2);
            document.getElementById('resultadoIMC').innerText = 'Seu IMC é: ' + imc;

            // Exibindo a categoria do IMC
            let categoria = '';
            if (imc < 18.5) {
                categoria = 'Abaixo do peso';
            } else if (imc >= 18.5 && imc < 24.9) {
                categoria = 'Peso normal';
            } else if (imc >= 25 && imc < 29.9) {
                categoria = 'Sobrepeso';
            } else {
                categoria = 'Obesidade';
            }

            document.getElementById('resultadoIMC').innerText += '\nCategoria: ' + categoria;
        } else {
            document.getElementById('resultadoIMC').innerText = 'Preencha os campos corretamente!';
        }
    }

    // Função para mostrar o popup de pacotes
    function mostrarImagemPacote() {
        document.getElementById("popup").style.display = "flex";
    }

    // Função para fechar o popup
    function fecharPopup() {
        document.getElementById("popup").style.display = "none";
    }
</script>

</body>
</html>
