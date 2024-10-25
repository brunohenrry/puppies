<?php
session_start(); // Inicia a sessão

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

// Verifica se o usuário está logado
$isLoggedIn = isset($_SESSION['user_id']); // Verifica se a variável de sessão 'user_id' está definida

$sql = "SELECT * FROM animals";
$result = $conn->query($sql);
?>

<!doctype html>
<html class="no-js" lang="zxx">

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<style>
    .favorite-button {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 10;
    }

    .heart-btn {
        background: none;
        border: none;
        cursor: pointer;
        padding: 10px;
        transition: all 0.3s ease;
    }

    .heart-btn i {
        font-size: 24px;
        color: #ccc;
        transition: all 0.3s ease;
    }

    .heart-btn.active i {
        color: #ff4d4d;
    }

    .single_service {
        position: relative;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.heart-btn').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const petId = this.dataset.petId;

                // Verifica se o usuário está logado
                if (!<?= isset($_SESSION['user_id']) ? 'true' : 'false' ?>) {
                    Swal.fire({
                        title: 'Oops!',
                        text: 'Você precisa estar logado para favoritar um pet!',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                // Verifica se o botão já está ativo
                if (this.classList.contains('active')) {
                    // Desfavoritar
                    fetch('unfavorite.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: `animal_id=${petId}`
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                this.classList.remove('active'); 
                                this.querySelector('i').style.color = ''; 
                            } else {
                                alert(data.message);
                            }
                        });
                } else {
                    // Favoritar
                    fetch('favorite.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: `animal_id=${petId}`
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                this.classList.add('active');
                                this.querySelector('i').style.color = 'red';
                            } else {
                                alert(data.message);
                            }
                        });
                }
            });
        });
    });
</script>




<body>
    <!--[if lte IE 9]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
        <![endif]-->

    <?php
    include('navbar.php');
    ?>

    <!-- slider_area_start -->
    <div class="slider_area">
        <div class="single_slider slider_bg_1 d-flex align-items-center">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5 col-md-6">
                        <div class="slider_text">
                            <h3>Encontre Seu Novo Melhor <br> <span> Amigo!</span></h3>
                            <p>Lorem ipsum dolor sit amet, consectetur <br> adipiscing elit, sed do eiusmod.</p>
                            <a href="contact.html" class="boxed-btn4">Contato</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dog_thumb d-none d-lg-block">
                <img src="img/banner/dog.png" alt="">
            </div>
        </div>
    </div>
    <!-- slider_area_end -->

    <!-- service_area_start  -->
    <div class="service_area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 col-md-10">
                    <div class="section_title text-center mb-95">
                        <h3>Pets Para Adoção</h3>
                        <p>Uma seleção especial de peludinhos que buscam um lar para chamar de seu.</p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <?php
                $contador = 0; // Inicializa o contador
                $favoritos = [];

                // Se o usuário estiver logado, busque os favoritos
                if (isset($_SESSION['user_id'])) {
                    $user_id = $_SESSION['user_id'];
                    $sql_favorites = "SELECT animal_id FROM favorites WHERE user_id = ?";
                    $stmt_favorites = $conn->prepare($sql_favorites);
                    $stmt_favorites->bind_param("i", $user_id);
                    $stmt_favorites->execute();
                    $result_favorites = $stmt_favorites->get_result();

                    while ($row = $result_favorites->fetch_assoc()) {
                        $favoritos[] = $row['animal_id'];
                    }

                    $stmt_favorites->close();
                }

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        if ($contador < 6) {
                            echo '<div class="col-lg-4 col-md-6">';
                            echo '<div class="single_service">';

                            // Adiciona o botão de favorito
                            echo '<div class="favorite-button">';
                            echo '<button class="heart-btn' . (in_array($row["id"], $favoritos) ? ' active' : '') . '" data-pet-id="' . $row["id"] . '">';
                            echo '<i class="fas fa-heart" style="color:' . (in_array($row["id"], $favoritos) ? 'red' : '#e5e7e9') . ';"></i>';
                            echo '</button>';
                            echo '</div>';

                            echo '<div class="service_thumb service_icon_bg_1 d-flex align-items-center justify-content-center">';
                            echo '<div class="service_icon">';
                            echo '<img src="' . $row["image"] . '" alt="">';
                            echo '</div>';
                            echo '</div>';
                            echo '<div class="service_content text-center">';
                            echo '<h3 class="nome-animal">' . $row["name"] . '</h3>';
                            echo '<p class="cidade">' . $row["location"] . '<span>📍</span></p>';
                            echo '<a href="adopt.php?id=' . $row["id"] . '" class="boxed-btn5">Quero Adotar </a>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                            $contador++;
                        }
                    }
                } else {
                    echo "Nenhum animal encontrado.";
                }
                $conn->close();
                ?>
            </div>
            <?php
            // Exibe o botão "Ver mais" apenas se houver mais pets
            if ($result->num_rows > 6) {
                echo '<div class="section_title text-center mb-95">';
                echo '<a href="todos_animais.php" class="boxed-btn5">Ver mais</a>';
                echo '</div>';
            }
            ?>
        </div>
    </div>


    <!-- service_area_end -->

    <!-- pet_care_area_start  -->
    <div class="pet_care_area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5 col-md-6">
                    <div class="pet_thumb">
                        <img src="img/about/pet_care.png" alt="">
                    </div>
                </div>
                <div class="col-lg-6 offset-lg-1 col-md-6">
                    <div class="pet_info">
                        <div class="section_title">
                            <h3><span>Milhares de patinhas estão </span> <br>
                                esperando por alguém como você</h3>
                            <p>Lorem ipsum dolor sit , consectetur adipiscing elit, sed do <br> iusmod tempor incididunt
                                ut labore et dolore magna aliqua. <br> Quis ipsum suspendisse ultrices gravida. Risus
                                commodo <br>
                                viverra maecenas accumsan.</p>
                            <a href="about.php" class="boxed-btn3">Sobre </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- pet_care_area_end  -->

    <!-- adapt_area_start  -->
    <div class="adapt_area">
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="col-lg-5">
                    <div class="adapt_help">
                        <div class="section_title">
                            <h3><span>Amigos encontraram lares</span>
                                amorosos até agora!</h3>
                            <p>Lorem ipsum dolor sit , consectetur adipiscing elit, sed do iusmod tempor incididunt ut
                                labore et dolore magna aliqua. Quis ipsum suspendisse ultrices.</p>
                            <a href="contact.php" class="boxed-btn3">Contato</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="adapt_about">
                        <div class="row align-items-center">
                            <div class="col-lg-6 col-md-6">
                                <div class="single_adapt text-center">
                                    <img src="img/adapt_icon/1.png" alt="">
                                    <div class="adapt_content">
                                        <h3 class="counter">452</h3>
                                        <p>Animais disponíveis</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="single_adapt text-center">
                                    <img src="img/adapt_icon/3.png" alt="">
                                    <div class="adapt_content">
                                        <h3><span class="counter">52</span>+</h3>
                                        <p>Animais Adotados</p>
                                    </div>
                                </div>
                                <div class="single_adapt text-center">
                                    <img src="img/adapt_icon/2.png" alt="">
                                    <div class="adapt_content">
                                        <h3><span class="counter">52</span>+</h3>
                                        <p>Animais disponíveis</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- adapt_area_end  -->

    <!-- testmonial_area_start  -->
    <div class="testmonial_area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="textmonial_active owl-carousel">
                        <div class="testmonial_wrap">
                            <div class="single_testmonial d-flex align-items-center">
                                <div class="test_thumb">
                                    <img src="img/testmonial/1.png" alt="">
                                </div>
                                <div class="test_content">
                                    <h4>Jhon Walker</h4>
                                    <span>Head of web design</span>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                        incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
                                        nostrud exerci.</p>
                                </div>
                            </div>
                        </div>
                        <div class="testmonial_wrap">
                            <div class="single_testmonial d-flex align-items-center">
                                <div class="test_thumb">
                                    <img src="img/testmonial/1.png" alt="">
                                </div>
                                <div class="test_content">
                                    <h4>Jhon Walker</h4>
                                    <span>Head of web design</span>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                        incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
                                        nostrud exerci.</p>
                                </div>
                            </div>
                        </div>
                        <div class="testmonial_wrap">
                            <div class="single_testmonial d-flex align-items-center">
                                <div class="test_thumb">
                                    <img src="img/testmonial/1.png" alt="">
                                </div>
                                <div class="test_content">
                                    <h4>Jhon Walker</h4>
                                    <span>Head of web design</span>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                        incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
                                        nostrud exerci.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- testmonial_area_end  -->

    <!-- team_area_start  -->
    <!-- team_area_start  -->

    <div class="contact_anipat anipat_bg_1">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="contact_text text-center">
                        <div class="section_title text-center">
                            <h3>Por que ir com Puppies?</h3>
                            <p>Porque sabemos que mesmo a melhor tecnologia é tão boa quanto as pessoas por trás dela.
                                Suporte técnico 24 horas por dia, 7 dias por semana.</p>
                        </div>
                        <div class="contact_btn d-flex align-items-center justify-content-center">
                            <a href="contact.html" class="boxed-btn4">Contate-nos</a>
                            <p>Or <a href="#"> +880 4664 216</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- footer_start  -->
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
                            </script> Todos os direitos reservados | Este template é feito com <i class="ti-heart"
                                aria-hidden="true"></i> por <a href="https://UNIFEB.com" target="_blank">UNIFEB</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- footer_end  -->


    <!-- JS here -->
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
<style>
    .service_area {
        padding: 120px 0;
        background: linear-gradient(to bottom, #fff9f9, #ffffff);
    }

    /* Título da seção */
    .section_title h3 {
        font-size: 42px;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 15px;
        text-transform: none;
        position: relative;
        display: inline-block;
    }

    .section_title h3:after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 3px;
        background: #ff6b6b;
        border-radius: 2px;
    }

    .section_title p {
        color: #7f8c8d;
        font-size: 18px;
        line-height: 1.6;
        margin-bottom: 40px;
    }

    /* Cards dos pets */
    .single_service {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        margin-bottom: 30px;
    }

    .single_service:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
    }

    /* Área da imagem */
    .service_thumb {
        position: relative;
        height: 280px;
        overflow: hidden;
        background: #f8f9fa;
    }

    .service_thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .single_service:hover .service_thumb img {
        transform: scale(1.05);
    }

    /* Conteúdo do card */
    .service_content {
        padding: 25px 20px;
        text-align: center;
    }

    .service_content h3 {
        font-size: 24px;
        color: #2c3e50;
        margin-bottom: 10px;
        font-weight: 600;
    }

    .service_content .cidade {
        color: #7f8c8d;
        font-size: 16px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
    }

    /* Botão de adoção */
    .boxed-btn5 {
        background: #ff3500;
        color: #fff;
        display: inline-block;
        padding: 12px 30px;
        border-radius: 30px;
        font-size: 16px;
        font-weight: 500;
        transition: all 0.3s ease;
        border: 2px solid #ff3500;
    }

    .boxed-btn5:hover {
        background: transparent;
        color: #ff3500;
    }

    /* Botão de favorito */
    .favorite-button {
        position: absolute;
        top: 15px;
        right: 15px;
        z-index: 10;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 50%;
        padding: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .heart-btn {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .heart-btn i {
        font-size: 20px;
        transition: all 0.3s ease;
    }

    .heart-btn:hover i {
        transform: scale(1.1);
    }

    /* Responsividade */
    @media (max-width: 768px) {
        .service_area {
            padding: 80px 0;
        }

        .section_title h3 {
            font-size: 32px;
        }

        .section_title p {
            font-size: 16px;
        }

        .service_thumb {
            height: 240px;
        }
    }
</style>