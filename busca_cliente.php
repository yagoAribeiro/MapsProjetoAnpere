<?php

require_once('global.php');

$listar = new Categoria();
$lista = $listar->listarCategoria();

if (isset($_SESSION['login']) && isset($_SESSION['level'])) {
}

// PESQUISA 

$pdo = Connection::GET_PDO();
$conditions = '';
$have_condition = false;
$pesquisa = '';

//Criação e verificação de váriaveis

if (isset($_GET['category'])) {
    if ($_GET['category'] != "" && $_GET['category'] != "0") {
        $category = $_GET['category'];
        $temp = Connection::GET_PDO();
        $temp = $temp->prepare("SELECT nomeCategoria FROM tbcategoria WHERE idCategoria = $category");
        $temp->execute();
        $categoryName = $temp->fetch(PDO::FETCH_ASSOC);
        $pesquisa .= "(" . $categoryName['nomeCategoria'] . ") ";
    } else {
        $category = "0";
        $pesquisa .= "(Todas as categorias) ";
    }
} else {
    $category = "0";
    $pesquisa .= "(Todas as categorias) ";
}

if (isset($_GET['keyword'])) {
    if (trim($_GET['keyword']) != "") {
        $keyword = $_GET['keyword'];
        $pesquisa .= " $keyword ";
    } else {
        unset($_GET['keyword']);
    }
} else {
    unset($_GET['keyword']);
}

if (isset($_GET['endereco'])) {
    if (trim($_GET['endereco']) != "") {
        $endereco = $_GET['endereco'];
        $pesquisa .= " $endereco ";
    } else {
        unset($_GET['endereco']);
    }
} else {
    unset($_GET['endereco']);
}

//Rotina de pesquisa (implementação de String na query)

if (isset($_GET['category'])) {
    if ($_GET['category'] != "0") {
        $have_condition = true;
        $category = $_GET['category'];
        $conditions .= "idCategoria = $category ";
        if (isset($_GET['keyword']) || isset($_GET['endereco'])) {
            $conditions .= "AND";
        }
    }
}

if (isset($_GET['keyword'])) {
    $have_condition = true;
    $keyword = "%" . $_GET['keyword'] . "%";
    $conditions .= " nomeEmpresa LIKE '$keyword' OR emailEmpresa LIKE '$keyword' ";
    if (isset($_GET['endereco'])) {
        $conditions .= "AND";
    }
}
if (isset($_GET['endereco'])) {
    $have_condition = true;
    $endereco = str_replace("Rua", "", $_GET['endereco']);
    $endereco = str_replace("-", "", $endereco);
    $endereco = str_replace(",", "", $endereco);
    $endereco = str_replace(" ", "", $endereco);
    $endereco = "%" . trim($endereco) . "%";

    //print($endereco);
    $conditions .= " CONCAT(REPLACE(logradouroEmpresa,' ',''), REPLACE(bairroEmpresa,' ',''), REPLACE(cidadeEmpresa,' ', ''), REPLACE(estadoEmpresa,' ', '')) LIKE '$endereco' ";
}

//implementações de condições da query

$query = "SELECT * FROM tbempresa ";

if ($have_condition) {
    $query .= " WHERE ";
}

//Final da requisição, query pronta para envio

$pdo = $pdo->prepare($query . $conditions);
//print($query . $conditions);
$pdo->execute();
$result = $pdo->fetchAll(PDO::FETCH_ASSOC);

//print($continue);




//-------------------------------------------------//

?>



<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/boxicons@2.0.9/dist/boxicons.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="resources/css/index.css" media="screen">
    <link rel="stylesheet" href="resources/css/busca.css" media="screen">
    <link href="resources/images/LogoAnpere.png" rel="icon">


    <title>Anpere</title>
</head>

<body>

    <?php
    if (isset($_SESSION['level'])) {

        if ($_SESSION['level'] == 'adm') { ?>
            <div class="container_header_busca">
                <header>

                    <div class="logo">
                        <img src="./resources/images/LogoComNome.png" alt="Logo Anpere">
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
            <div class="container_header_busca">
                <header>

                    <div class="logo">
                        <img src="./resources/images/LogoComNome.png" alt="Logo Anpere">
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
            <div class="container_header_busca">
                <header>

                    <div class="logo">
                        <img src="./resources/images/LogoComNome.png" alt="Logo Anpere">
                    </div>

                    <div class="itens">
                        <ul>
                            <li><a href="perfilAreaRestrita.php?id=<?php echo ($_SESSION['idEmpresa']); ?>">Olá, Empresa</a></li>
                            <li><a href="../Session/destruirSessao.php?pagina=index.php">Log out</a></li>
                            <li><a class="empresa" href="perfilAreaRestrita.php">Perfil</a></li>
                        </ul>
                    </div>
                </header>
            </div>
        <?php } ?>

    <?php } else { ?>

        <div class="container_header_busca">
            <header>
                <div class="logo">
                    <img src="./resources/images/LogoComNome.png" alt="Logo Anpere">
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

    <div class="categorias">
  <br>

        <div class="icones">
        <a href="busca_cliente.php?category=4"><div class="ct"><img src="resources/images/auau.png"></div></a>
        <a href="busca_cliente.php?category=10"><div class="ct"><img src="resources/images/sofa.png"></div></a>
        <a href="busca_cliente.php?category=1"><div class="ct"><img src="resources/images/sedan.png"></div></a>
        <a href="busca_cliente.php?category=16"><div class="ct"><img src="resources/images/guitarra.png"></div></a>
        <a href="busca_cliente.php?category=9"><div class="ct"><img src="resources/images/cabide.png"></div></a>
        <a href="busca_cliente.php?category=6"><div class="ct"><img src="resources/images/brinquedo.png"></div></a>
        <a href="busca_cliente.php?category=2"><div class="ct"><img src="resources/images/chave-inglesa.png"></div></a>
        <a href="busca_cliente.php?category=18"><div class="ct"><img src="resources/images/estetoscopio.png"></div></a>
        <a href="busca_cliente.php?category=13"><div class="ct"><img src="resources/images/bla.png"></div></a>
        <a href="busca_cliente.php?keyword=&endereco="><div class="ct"><img src="resources/images/outros.jpg"></div></a>
      </div>
      <div class="icones">
        <div class="ct2"><label>Animais</label></div>
        <div class="ct2"><label>Moveis</label></div>
        <div class="ct2"><label>Auto peças</label></div>
        <div class="ct2"><label>Música</label></div>
        <div class="ct2"><label>Roupas</label></div>
        <div class="ct2"><label>Infantil</label></div>
        <div class="ct2"><label>Assistencia</label></div>
        <div class="ct2"><label>Saúde</label></div>
        <div class="ct2"><label>Esporte</label></div>
        <div class="ct2"><label>Outros</label></div>
      </div>
      <br>
</div>

    <div class="container-two">
        <form method="GET">
            <div class="main">
                <div class="dropdown">

                    <select name="category" id="category">
                        <option selected disabled>Selecionar categoria</option>
                        <option value="0">Todas</option>
                        <?php //Percorrendo o array
                        foreach ($lista as $linha) { ?>
                            <option value="<?php echo $linha['idCategoria'] ?>">
                                <?php echo $linha['nomeCategoria'] ?></option>
                        <?php }; ?>
                    </select>

                </div>

                <div class="search-box">
                    <div class="searchbar">
                        <i class="fas fa-search"></i>
                        <input name="keyword" id="keyword" type="text" placeholder="Use palavras-chave...">
                    </div>

                    <div class="location">
                        <div class="searchbar">
                            <i class="fas fa-map-marker-alt" _mstvisible="2"></i>
                            <input name="endereco" id="endereco" type="text" placeholder="Rua, bairro ou cidade...">
                        </div>

                    </div>

                    <div class="button">
                        <button type="submit">Procurar
                        </button>
                    </div>
                </div>

            </div>
        </form>
    </div>
    <center>

        <div class="container-fluid justify-content-center" style="width: 38rem !important;" id="content">
            <div class="container-tree">

                <div class="titulo">
                    <h3>Resultados da pesquisa por: <?php print($pesquisa); ?> ...</h3>
                    <?php
                    if ($pdo->rowCount() > 0) { ?>
                        <a id="map_span" class="map_span" onclick="initMap()" data-bs-toggle="collapse" href="#content_map" role="button" aria-expanded="false" aria-controls="content_map">
                            ver no mapa
                        </a>
                    <?php } ?>
                </div>
                <br><br>

                <div class="collapse" id="content_map" style="background-color:#C8D0E5;">
                    <center>


                        <div id="carouselExampleIndicators" class="carousel carousel-dark slide" data-bs-interval="false" data-interval="false" data-ride="carousel" style='border-width:2px; border-style: double; border-color:cornflowerblue; border-radius: 5px; background-color:#EBEEF7'>
                            <div class="carousel-inner">

                                <?php
                                $i = 0;
                                foreach ($result as $Result) {
                                    $perfilempresa = new PerfilEmpresa();
                                    $imagemPerfil = $perfilempresa->listarImagensIndex($Result['idEmpresa']);

                                    //criação de váriavel
                                    $url = "resources/images/upload/perfilEmpresa/" . $imagemPerfil['fotoperfilempresa'];
                                    $nome = $Result['nomeEmpresa'];
                                    $endereco = "Rua " . $Result['logradouroEmpresa'] . " - " . $Result['bairroEmpresa'] . ", " . $Result['estadoEmpresa'];
                                    $idEmpresa = $Result['idEmpresa'];

                                    //implementação do carrosel Bootstrap html

                                    //Definir se é o primeiro índice do carrosel
                                    if ($i == 0) {
                                        print("<div class='carousel-item active'>");
                                    } else {
                                        print("<div class='carousel-item'>");
                                    }

                                    print("<img src='" . $url . "' style='width:38rem !important; height:18rem;'>
                                        <br>
                                        <div>
                                            <h5>" . $nome . "</h5>
                                            <p>" . $endereco . "</p>
                                            <a class='btn btn-outline-primary' href='perfilEmpresa.php?id=" . $idEmpresa . "'>Mais</a>
                                        </div>
                                        </div>");




                                    $i++;
                                }

                                ?>

                                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev" onclick="arrow_left()" id="btn_left">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next" onclick="arrow_right()" id="btn_right">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>



                            </div>
                        </div>
                        <br>

                        <div class="container">
                            <div class="row" style="margin-top:2rem;">
                                <div class="col">
                                    <div class="d-flex justify-content-start">
                                        <i class="fas fa-map-marker-alt" style="position:relative; top: 0.6rem !important; right:0.65%;"></i>
                                        <input class="form-control me-2" id="pesquisaEndereco" type="search" placeholder="Encontrar endereço" aria-label="Search" style="width:40%;">
                                    </div>
                                </div>

                                <div class="col-md-auto">

                                    <input type="radio" class="btn-check" name="options" id="option1" autocomplete="off" onclick="draw_direction()">
                                    <label class="btn btn-outline-primary" for="option1"><img src="./resources/images/icon/bus.png" style="width:1.5rem; height:1.5rem;"></label>

                                    <input type="radio" class="btn-check" name="options" id="option2" autocomplete="off" onclick="draw_direction()" checked>
                                    <label class="btn btn-outline-primary" for="option2"><img src="./resources/images/icon/car.png" style="width:1.5rem; height:1.5rem;"></label>

                                    <input type="radio" class="btn-check" name="options" id="option3" autocomplete="off" onclick="draw_direction()">
                                    <label class="btn btn-outline-primary" for="option3"><img src="./resources/images/icon/walk.png" style="width:1.5rem; height:1.5rem;"></label>

                                    <input type="radio" class="btn-check" name="options" id="option4" autocomplete="off" onclick="draw_direction()">
                                    <label class="btn btn-outline-primary" for="option4"><img src="./resources/images/icon/bike.png" style="width:1.5rem; height:1.5rem;"></label>
                                </div>
                            </div>
                        </div>


                        <br>
                        <!-- mapa -->
                        <div id="map_draw" style="width: 80rem; height:38rem;">
                        </div>
                        <br><br>
                    </center>
                </div>


                <script src="./resources/js/maps.js"></script>
                <script async defer src="https://maps.googleapis.com/maps/api/js?key=#################&&libraries=places&v=beta"></script>


                <?php if ($pdo->rowCount() > 0) {
                } else {
                    print("<br><br><br><br><center><h2>Desculpe, não conseguimos encontrar nenhum resultado para sua pesquisa! :( <a href='javascript:history.back()'>voltar</a></h2></center>");
                } ?>

                <div class="main-two" id="card_content">
                    <?php

                    //laço para pegar o conteúdo do banco de dados e implementar html
                    foreach ($result as $Result) {
                        $perfilempresa = new PerfilEmpresa();
                        $imagemPerfil = $perfilempresa->listarImagensIndex($Result['idEmpresa']);
                        $url = "resources/images/upload/perfilEmpresa/" . $imagemPerfil['fotoperfilempresa'];
                    ?>
                        <script>
                            //implementando valores do banco de dados no objeto javascript para controle do carrosel
                            var empresaEndereco = {
                                id: "<?php print($Result['idEmpresa']) ?>",
                                estado: "<?php print($Result['estadoEmpresa']) ?>",
                                bairro: "<?php print($Result['bairroEmpresa']) ?>",
                                logradouro: "<?php print($Result['logradouroEmpresa']) ?>",
                                nome: "<?php print($Result['nomeEmpresa']) ?>"
                            };
                            setEndereco(empresaEndereco);
                        </script>
                        <div class="card">
                            <div class="image">
                                <img src="<?php echo ($url) ?>" alt="Habbib's estabelecimento">
                            </div>
                            <div class="texts">
                                <h3><?php echo $Result['nomeEmpresa']; ?></h3>
                                <p><?php echo ("Rua " . $Result['logradouroEmpresa'] . " - " . $Result['bairroEmpresa'] . ", " . $Result['estadoEmpresa']); ?></p>
                            </div>
                            <div class='estrelas'>
              <div class='rating rating2'><!--
              --><a href='#5' title='Give 5 stars'>★</a><!--
              --><a href='#4' title='Give 4 stars'>★</a><!--
              --><a href='#3' title='Give 3 stars'>★</a><!--
              --><a href='#2' title='Give 2 stars'>★</a><!--
              --><a href='#1' title='Give 1 star'>★</a>
            </div>
          </div>

          <div class="coment"><button onclick="abrir()">Ver comentários</button></div>
                            <div class="button">
                                <a href="perfilEmpresa.php?id=<?php echo $Result['idEmpresa']; ?>"><button>Mais</button></a>
                            </div>
                        </div>
                    <?php
                    }
                    ?>


                </div>
            </div>
    </center>
    <div class="container-five">
        <footer>
            <div class="footer-part1">
                <div class="menu">
                    <p>Menu</p>
                    <a href="Cadastro-Cliente.php">Crie sua conta</a>
                    <a href="Login-Client.php">Login</a>
                    <a href="index_empresa.php">Divulgar</a>
                </div>
                <div class="contato">
                    <p>Institucional</p>
                    <a href="http://sitesaturnooficial.atwebpages.com/">Quem somos</a>
                    <a href="#">Trabalhe conosco</a>
                    <a href="#">Suporte</a>
                </div>
                <div class="redes">
                    <p>Rede Sociais</p>
                    <a href="#"><img src="resources/images/icon/instagram-alt-logo-180.png"></a>
                    <a href="#"><img src="resources/images/icon/facebook-circle-logo-180.png"></a>
                    <a href="#"><img src="resources/images/icon/twitter-logo-180.png"></a>
                </div>
            </div>

        </footer>
        <div class="cop">
            <p>&copy;2021, Anpere - Rua Feliciano de Mendonça, 290 - Guaianazes, São Paulo - Todos os direitos reservados.</p>
        </div>
    </div>


</body>

</html>