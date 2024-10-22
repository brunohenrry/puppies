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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $species = $_POST['species'];
    $breed = $_POST['breed'];
    $age = $_POST['age'];
    $sex = $_POST['sex'];
    $description = $_POST['description'];
    $location = $_POST['location'];
    $contact_info = $_POST['contact_info'];

    // Preparar e executar a query usando prepared statements
    $stmt = $conn->prepare("UPDATE animals SET name=?, species=?, breed=?, age=?, sex=?, description=?, location=?, contact_info=? WHERE id=?");
    $stmt->bind_param("sssiisssi", $name, $species, $breed, $age, $sex, $description, $location, $contact_info, $id);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success' role='alert'>Animal atualizado com sucesso!</div>";
    } else {
        echo "<div class='alert alert-danger' role='alert'>Erro ao atualizar o animal.</div>";
    }
}

// Consulta para obter os dados do animal específico
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    $id = $_GET['id'];
    $sql = "SELECT * FROM animals WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $animal = $result->fetch_assoc();
}

// Fechamento da conexão ao banco de dados
$conn->close();
?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Editar Animal</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" type="image/x-icon" href="img/service/service_icon_1.png">
    <!-- CSS aqui -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/themify-icons.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!-- Conteúdo HTML e Formulário de Edição -->
    <?php include 'navbar.php'; ?>  


    <div class="container mt-5">
        <h3 class="text-center mb-4">Editar Animal</h3>
        <form method="post" action="edit_animal.php">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($animal['id']); ?>">
            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($animal['name']); ?>">
            </div>
            <div class="form-group">
                <label for="species">Espécie</label>
                <input type="text" class="form-control" id="species" name="species" value="<?php echo htmlspecialchars($animal['species']); ?>">
            </div>
            <div class="form-group">
                <label for="breed">Raça</label>
                <input type="text" class="form-control" id="breed" name="breed" value="<?php echo htmlspecialchars($animal['breed']); ?>">
            </div>
            <div class="form-group">
                <label for="age">Idade</label>
                <input type="number" class="form-control" id="age" name="age" value="<?php echo htmlspecialchars($animal['age']); ?>">
            </div>
            
            <div class="form-group">
                <label for="description">Descrição</label>
                <textarea class="form-control" id="description" name="description" rows="3"><?php echo htmlspecialchars($animal['description']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="location">Localização</label>
                <input type="text" class="form-control" id="location" name="location" value="<?php echo htmlspecialchars($animal['location']); ?>">
            </div>
            <div class="form-group">
                <label for="contact_info">Contato</label>
                <input type="text" class="form-control" id="contact_info" name="contact_info" value="<?php echo htmlspecialchars($animal['contact_info']); ?>">
            </div>
            <button type="submit" class="btn btn-primary">Atualizar Animal</button>
        </form>
    </div>

    <!-- Rodapé e Scripts JS -->
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

    <!-- JS aqui -->
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
    <script src="js/slick.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>