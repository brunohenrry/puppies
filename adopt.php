<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pets_adocao";

// Cria conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_GET['id'];

// Consulta para obter os detalhes do animal
$sql = "SELECT * FROM animals WHERE id=$id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    
    // Consulta para obter o nome do usuário
    $userId = $row['user_id']; // Assumindo que user_id é o ID do usuário
    $userSql = "SELECT name FROM users WHERE id=$userId";
    $userResult = $conn->query($userSql);
    
    if ($userResult->num_rows > 0) {
        $userRow = $userResult->fetch_assoc();
        $userName = $userRow['name']; // Obter o nome do usuário
    } else {
        $userName = "Usuário desconhecido"; // Caso o usuário não seja encontrado
    }
} else {
    echo "Animal não encontrado.";
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Puppies</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- <link rel="manifest" href="site.webmanifest"> -->
    <link rel="shortcut icon" type="image/x-icon" href="img/service/service_icon_1.png">
    <!-- Place favicon.ico in the root directory -->

    <!-- CSS here -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/themify-icons.css">
    <link rel="stylesheet" href="css/nice-select.css">
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/gijgo.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/slicknav.css">
    <link rel="stylesheet" href="css/style.css">
    <!-- <link rel="stylesheet" href="css/responsive.css"> -->
    <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>
</head>
<style>
  :root {
    --purple: #ff3500;
    --yellow: #ffd033;
    --light-purple: #f3e6f5;
  }

  .breadcrumb {
    padding: 1rem 0;
    font-size: 0.9rem;
  }

  .breadcrumb a {
    color: var(--purple);
    text-decoration: none;
  }

  .animal-container {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    margin: 2rem 0;
    /* box-shadow: 0 2px 10px rgba(0,0,0,0.05); */
  }

  .animal-image-container {
    position: relative;
    padding: 1rem;
  }

  .animal-image {
    width: 100%;
    max-width: 100%;
    height: auto;
    border-radius: 15px;
  }

  .animal-header h1 {
    font-size: 2.5rem;
    color: var(--purple);
    margin-bottom: 1.5rem;
  }

  .animal-badges {
    background: var(--purple);
    color: white;
    padding: 1rem;
    border-radius: 10px;
    margin-bottom: 1.5rem;
  }

  .animal-badge {
    color: white;
    padding: 0.5rem 1rem;
    margin: 0.25rem 0;
    display: block;
    font-weight: bold;
    text-transform: uppercase;
  }

  .animal-info {
    padding: 1rem;
  }

  .animal-metadata {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    margin-bottom: 1rem;
  }

  .metadata-item {
    background: var(--light-purple);
    color: var(--purple);
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.9rem;
  }

  .location {
    margin: 1rem 0;
    color: var(--purple);
  }

  .animal-info-header {
    color: var(--purple);
    font-size: 1.5rem;
    margin: 2rem 0 1rem;
    font-weight: bold;
  }

  .adoption-criteria {
    margin: 1.5rem 0;
  }

  .criteria-item {
    margin: 0.5rem 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .criteria-item::before {
    content: "🐾";
    color: var(--purple);
  }

  .tags {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    margin: 1rem 0;
  }

  .tag {
    background: var(--light-purple);
    color: var(--purple);
    padding: 0.5rem 1rem;
    border-radius: 15px;
    font-size: 0.9rem;
  }

  .btn {
    display: inline-block;
    padding: 1rem 2rem;
    border-radius: 25px;
    text-decoration: none;
    text-align: center;
    font-weight: bold;
    transition: all 0.3s ease;
    margin: 0.5rem;
  }

  .btn-primary {
    background: var(--purple);
    color: white;
  }

  .btn-primary:hover {
    opacity: 0.9;
    transform: translateY(-2px);
  }

  .action-buttons {
    margin-top: 2rem;
    text-align: center;
  }

  .page-views {
    color: #666;
    font-size: 0.9rem;
    margin-top: 1rem;
    text-align: center;
  }

  @media (max-width: 768px) {
    .animal-image-container, .animal-info {
      padding: 0;
    }
  }
</style>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container">
        <div class="animal-container">
            <div class="row">
                <!-- Coluna da Imagem -->
                <div class="col-md-6">
                    <div class="animal-image-container">
                        <img src="<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>" class="animal-image">
                    </div>
                </div>

                <!-- Coluna das Informações -->
                <div class="col-md-6">
                    <div class="animal-info">
                        <div class="animal-header">
                            <h1><?php echo $row['name']; ?></h1>
                        </div>

                        <div class="animal-metadata">
                            <span class="metadata-item">
                                <i class="fa fa-paw"></i> <?php echo $row['species']; ?>
                            </span>
                            <span class="metadata-item">
                                <i class="fa fa-venus-mars"></i> <?php echo $row['sex']; ?>
                            </span>
                            <span class="metadata-item">
                                <i class="fa fa-heartbeat"></i> <?php echo $row['breed']; ?>
                            </span>
                        </div>

                        <div class="animal-badges">
                            <div class="animal-badge"><?php echo $row['age']; ?> ANO<?php echo $row['age'] > 1 ? 'S' : ''; ?></div>
                            <div class="animal-badge">CASTRAD<?php echo $row['sex'] == 'Fêmea' ? 'A' : 'O'; ?></div>
                            <div class="animal-badge">VERMIFUGAD<?php echo $row['sex'] == 'Fêmea' ? 'A' : 'O'; ?></div>
                            <div class="animal-badge">VACINAD<?php echo $row['sex'] == 'Fêmea' ? 'A' : 'O'; ?></div>
                        </div>

                        <div class="location">
                            📍 Está em <?php echo $row['location']; ?>
                        </div>
                        <div class="published-by">
                            <p>
                                🧑 Publicado por: <strong><?php echo $userName; ?></strong>
                            </p>
                        </div>

                        <div class="animal-description">
                            <h2 class="animal-info-header">Mais sobre <?php echo $row['name']; ?></h2>
                            <p><?php echo $row['description']; ?></p>
                        </div>

                        <div class="adoption-criteria">
                            <h2 class="animal-info-header">Critérios para adoção</h2>
                            <div class="criteria-item">Maior de 21 anos</div>
                            <div class="criteria-item">Obrigatório responder questionário e participar de entrevista</div>
                            <div class="criteria-item">IMPORTANTE: Processo somente por WhatsApp <?php echo $row['contact_info']; ?></div>
                            <div class="criteria-item">Adoção com Termo de Responsabilidade</div>
                            <div class="criteria-item">Se aplica taxa de adoção</div>
                            <div class="criteria-item">Apresentar Comprovante de endereço e documento de identidade</div>
                        </div>

                        <div class="tags">
                            <span class="tag">Dócil</span>
                            <span class="tag">Brincalhão</span>
                            <span class="tag">Castrado</span>
                            <span class="tag">Vacinado</span>
                            <span class="tag">Vermifugado</span>
                        </div>

                        <div class="action-buttons">
                            <a href="contact.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Quero adotar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="footer">
        <div class="footer_top">
            <div class="container">
                <div class="row">
                    <div class="col-xl-3 col-md-6 col-lg-3">
                        <div class="footer_widget">
                            <h3 class="footer_title">Contato</h3>
                            <ul class="address_line">
                                <li>+555 0000 565</li>
                                <li><a href="mailto:demomail@gmail.com">puppies@gmail.com</a></li>
                                <li>700, Green Lane, Barretos, SP</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 col-lg-3">
                        <div class="footer_widget">
                            <h3 class="footer_title">Nossos Serviços</h3>
                            <ul class="links">
                                <li><a href="#">Seguro para Animais de Estimação</a></li>
                                <li><a href="#">Cirurgias para Animais</a></li>
                                <li><a href="#">Adoção de Animais</a></li>
                                <li><a href="#">Seguro para Cães</a></li>
                                <li><a href="#">Seguro para Gatos</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 col-lg-3">
                        <div class="footer_widget">
                            <h3 class="footer_title">Links Rápidos</h3>
                            <ul class="links">
                                <li><a href="#">Sobre Nós</a></li>
                                <li><a href="#">Política de Privacidade</a></li>
                                <li><a href="#">Termos de Serviço</a></li>
                                <li><a href="#">Informações de Login</a></li>
                                <li><a href="#">Base de Conhecimento</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 col-lg-3">
                        <div class="footer_widget">
                            <div class="footer_logo">
                                <a href="#">
                                    <img src="img/logo_1.png" alt="Logo">
                                </a>
                            </div>
                            <p class="address_text">239 E 5th St, Barretos
                                BR 00000, SP
                            </p>
                            <div class="socail_links">
                                <ul>
                                    <li><a href="#"><i class="ti-facebook"></i></a></li>
                                    <li><a href="#"><i class="ti-pinterest"></i></a></li>
                                    <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                    <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="copy-right_text">
            <div class="container">
                <div class="bordered_1px"></div>
                <div class="row">
                    <div class="col-xl-12">
                        <p class="copy_right text-center">
                            Direitos Autorais &copy;
                            <script>
                                document.write(new Date().getFullYear());
                            </script> Todos os direitos reservados | Este template é feito com <i class="ti-heart" aria-hidden="true"></i> por <a href="https://UNIFEB.com" target="_blank">UNIFEB</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <script src="js/vendor/modernizr-3.5.0.min.js"></script>
    <script src="js/vendor/jquery-1.12.4.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/isotope.pkgd.min.js"></script>
    <script src="js/ajax-form.js"></script>
    <script src="js/waypoints.min.js"></script>
    <script src="js/jquery.counterup.min.js"></script>
    <script src="js/imagesloaded.pkgd.min.js"></script>
    <script src="js/scrollIt.js"></script>
    <script src="js/jquery.scrollUp.min.js"></script>
    <script src="js/wow.min.js"></script>
    <script src="js/nice-select.min.js"></script>
    <script src="js/jquery.slicknav.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/gijgo.min.js"></script>

    <!--contact js-->
    <script src="js/contact.js"></script>
    <script src="js/jquery.ajaxchimp.min.js"></script>
    <script src="js/jquery.form.js"></script>
    <script src="js/jquery.validate.min.js"></script>
    <script src="js/mail-script.js"></script>

    <script src="js/main.js"></script>
    <script>
        $('#datepicker').datepicker({
            iconsLibrary: 'fontawesome',
            disableDaysOfWeek: [0, 0],
            //     icons: {
            //      rightIcon: '<span class="fa fa-caret-down"></span>'
            //  }
        });
        $('#datepicker2').datepicker({
            iconsLibrary: 'fontawesome',
            icons: {
                rightIcon: '<span class="fa fa-caret-down"></span>'
            }

        });
        var timepicker = $('#timepicker').timepicker({
            format: 'HH.MM'
        });
    </script>
</body>

</html>