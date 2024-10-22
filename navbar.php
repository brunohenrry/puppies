<?php session_start(); ?>
<header>
    <div class="header-area ">
        <div id="sticky-header" class="main-header-area">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-3 col-lg-3">
                        <div class="logo">
                            <a href="index.php">
                                <img src="img/logo_1.png" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-9 col-lg-9">
                        <div class="main-menu d-none d-lg-block">
                            <nav>
                                <ul id="navigation">
                                    <li><a href="index.php">Home</a></li>
                                    <li><a href="about.php">Sobre</a></li>
                                    <li><a href="todos_animais.php">Todos Animais</a></li>
                                    <li><a href="service.php">Serviços</a></li>
                                    <li><a href="contato.php">Contato</a></li>

                                    <?php if(isset($_SESSION['user_id'])): ?>
                                        <li>
                                            <a href="#" id="user-icon">
                                                <img src="img/user.png" alt="User" class="user-icon">
                                            </a>
                                            <ul class="submenu">
                                                <li><a href="user_profile.php">Perfil</a></li>
                                                <li><a href="list_animals.php">Gerenciar Animais</a></li>
                                                <li><a href="logout.php">Logout</a></li>
                                            </ul>
                                        </li>
                                    <?php else: ?>
                                        <li><a href="login.php">Entrar</a></li>
                                    <?php endif; ?>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mobile_menu d-block d-lg-none"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
