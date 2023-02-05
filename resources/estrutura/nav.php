<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/boxicons@2.0.9/dist/boxicons.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/index.css" media="screen">

    <title></title>
</head>

<body>
    <!-- ESSE ARQUIVO É UMA ESTRUTURA DE NAV GLOBAL
NESSE ARQUIVO ESTÁ SENDO VERIFICADO O NIVEL DE ACESSO DO LOGIN PARA ASSIM APRESENTAR SUA NAV EXCLUSIVA-->
    <?php
    if (isset($_SESSION['level'])) {

        if ($_SESSION['level'] == 'adm') { ?>
            <div class="container">
                <header>

                    <div class="logo">
                        <img src="../resources/images/LogoComNome.png" alt="Logo Anpere">
                    </div>

                    <div class="itens">
                        <ul>
                        <li><a style="color: #407cee" href="#">Olá, Adm</a></li>
                            <li><a href="../../../Anpere/AreaRestrita-Cliente/indexAreaRestrita.php">Cliente</a></li>
                            <li><a href="../../../Anpere/AreaRestrita-Empresa/indexAreaRestrita.php">Empresa</a></li>
                            <li><a class="empresa" href="../../../Anpere/AreaRestrita-adm/indexAreaRestrita.php">Administrador</a></li>
                        </ul>
                    </div>
                </header>
            </div>

        <?php } else if ($_SESSION['level'] == 'cliente') { ?>
            <div class="container">
                <header>

                    <div class="logo">
                        <img src="../resources/images/LogoComNome.png" alt="Logo Anpere">
                    </div>

                    <div class="itens">
                        <ul>
                            <li><a href="#">Olá, Cliente</a></li>
                            <li><a href="../Session/destruirSessao.php?pagina=index.php">Log out</a></li>
                            <li><a class="empresa" href="../index_empresa.php">Divulgar</a></li>
                        </ul>
                    </div>
                </header>
            </div>
        <?php } else if ($_SESSION['level'] == 'empresa') { ?>
            <div class="container">
                <header>

                    <div class="logo">
                        <img src="../resources/images/LogoComNome.png" alt="Logo Anpere">
                    </div>

                    <div class="itens">
                        <ul>
                            <li><a href="perfilAreaRestrita.php?id=<?php echo ($_SESSION['idEmpresa']);?>">Olá, Empresa</a></li>
                            <li><a href="../Session/destruirSessao.php?pagina=index.php">Log out</a></li>
                            <li><a class="empresa" href="perfilAreaRestrita.php">Perfil</a></li>
                        </ul>
                    </div>
                </header>
            </div>
        <?php } ?>

    <?php } else { ?>

        <div class="container">
            <header>
                <div class="logo">
                    <img src="../resources/images/LogoAnpere.png" alt="Logo Anpere">
                </div>
                <div class="itens">
                    <ul>
                        <li><a href="Cadastro-Cliente.php">Crie sua conta</a></li>
                        <li><a href="Login-Client.php">Login</a></li>
                        <li><a class="empresa" href="index_empresa.php">Divulgar</a></li>
                    </ul>
                </div>
            </header>
        </div>

    <?php } ?>
</body>

</html>