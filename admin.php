<?php
session_start();
require_once 'db.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Inicializa variáveis para armazenar os dados do formulário
$name = $species = $breed = $age = $sex = $description = $location = $contact_info = "";
$error_message = "";

// Processa o formulário ao ser enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $species = $_POST['species'];
    $breed = $_POST['breed'];
    $age = $_POST['age'];
    $sex = $_POST['sex'];
    $description = $_POST['description'];
    $location = $_POST['location'];
    $contact_info = $_POST['contact_info'];
    $user_id = $_SESSION['user_id']; // Pega o ID do usuário logado

    // Handle file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if file is an actual image or fake image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            // Check if file already exists
            if (!file_exists($target_file)) {
                // Check file size (5MB limit)
                if ($_FILES["image"]["size"] <= 5000000) {
                    // Allow certain file formats
                    if (in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
                        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                            $image = $target_file;

                            // Insere o animal na tabela com o user_id
                            $sql = "INSERT INTO animals (name, species, breed, age, sex, description, image, location, contact_info, user_id)
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("ssissssssi", $name, $species, $breed, $age, $sex, $description, $image, $location, $contact_info, $user_id);

                            if ($stmt->execute()) {
                                echo "<div class='alert alert-success' role='alert'>Novo animal adicionado com sucesso!</div>";
                                // Limpa os campos após sucesso
                                $name = $species = $breed = $age = $sex = $description = $location = $contact_info = "";
                            } else {
                                $error_message = "Erro: " . $sql . "<br>" . $conn->error;
                            }
                        } else {
                            $error_message = "Erro ao fazer o upload da imagem.";
                        }
                    } else {
                        $error_message = "Apenas arquivos JPG, JPEG, PNG e GIF são permitidos.";
                    }
                } else {
                    $error_message = "A imagem é muito grande.";
                }
            } else {
                $error_message = "O arquivo já existe.";
            }
        } else {
            $error_message = "O arquivo não é uma imagem.";
        }
    } else {
        $error_message = "Nenhuma imagem foi enviada ou ocorreu um erro no upload.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Admin</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- <link rel="manifest" href="site.webmanifest"> -->
    <link rel="shortcut icon" type="image/x-icon" href="img/service/service_icon_1.png">
    <!-- Place favicon.ico in the root directory -->

    <!-- CSS aqui -->
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

<body>

   <!-- Exemplo para admin.php -->
<?php
include('navbar.php');
?>


    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-8">
                <div class="section-top-border">
                    <h3 class="mb-30">Adicionar Novo Animal</h3>
                    <?php if ($error_message): ?>
                        <div class='alert alert-danger' role='alert'><?php echo $error_message; ?></div>
                    <?php endif; ?>
                    <form class="animal-form" method="post" action="admin.php" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="name">Nome:</label>
                            <input type="text" name="name" id="name" class="form-control" value="<?php echo htmlspecialchars($name); ?>">
                        </div>
                        <div class="form-group">
                            <label for="species">Espécie:</label>
                            <input type="text" name="species" id="species" class="form-control" value="<?php echo htmlspecialchars($species); ?>">
                        </div>
                        <div class="form-group">
                            <label for="breed">Raça:</label>
                            <input type="text" name="breed" id="breed" class="form-control" value="<?php echo htmlspecialchars($breed); ?>">
                        </div>
                        <div class="form-group">
                            <label for="age">Idade:</label>
                            <input type="number" name="age" id="age" class="form-control" value="<?php echo htmlspecialchars($age); ?>">
                        </div>
                        <div class="form-group">
                            <label for="sex">Sexo:</label>
                            <select name="sex" id="sex" class="form-control">
                                <option value="Masculino" <?php if ($sex == "Masculino") echo "selected"; ?>>Masculino</option>
                                <option value="Feminino" <?php if ($sex == "Feminino") echo "selected"; ?>>Feminino</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="description">Descrição:</label>
                            <textarea name="description" id="description" class="form-control"><?php echo htmlspecialchars($description); ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="image">Imagem:</label>
                            <input type="file" name="image" id="image" class="form-control-file">
                        </div>
                        <div class="form-group">
                            <label for="location">Localização:</label>
                            <input type="text" name="location" id="location" class="form-control" value="<?php echo htmlspecialchars($location); ?>">
                        </div>
                        <div class="form-group">
                            <label for="contact_info">Contato:</label>
                            <input type="text" name="contact_info" id="contact_info" class="form-control" value="<?php echo htmlspecialchars($contact_info); ?>">
                        </div>
                        <button type="submit" class="btn btn-primary">Adicionar Animal</button>
                    </form>
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
    <script src="js/slick.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>