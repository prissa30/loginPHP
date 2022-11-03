<?php
// Precisamos usar sessões, então você deve sempre iniciar sessões usando o código abaixo.
session_start();
// Se o usuário não estiver logado redireciona para a página de login...
if (!isset($_SESSION['loggedin'])) {
	header('Location: login.html');
	exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link href="../css/estiloHome.css" rel="stylesheet">

  <title>Pagina principal</title>

</head>
<body>
  <!-- Cabeçalho 1 -->

  <div>
    <nav class="navbar navbar">
      <div class="container-fluid">
        <h2>MakeUP </h2>
        <p>Bem vindo, <?=$_SESSION['name']?>!!</p>
        <form class="d-flex">
       
           <a href="logout.php">
            <input class="btn btn-outline-success" type="button" value="Sair da conta" style="color: #fff; background:#e35688; border: none;font-weight: bold;">
           </a>
          
        </form>
      </div>
    </nav>

    <div>
  
      <!-- Pesquisa -->
      <div id="divBusca">
        <input type="text" id="txtBusca" placeholder="Buscar..."/>
        <button id="btnBusca">Buscar</button>
      </div>
      <!-- Fim Pesquisa -->


    </div>
  </div>
  <!-- nav começo -->
  <nav class="nav">
    <a href="/" class="nav-link">Inicio</a>
    <a href="/products/" class="nav-link">Produtos</a>
    <a href="/about/" class="nav-link">Lançamentos</a>
    <a href="/blog/" class="nav-link">SkinCare</a>
    <a href="/blog/" class="nav-link">Marcas</a>
  </nav>
 

<!-- Nav FIM -->

<!-- Carrousel inicio -->
<div class="container">
  <div class="carousel">
    <div class="carousel__face"><span>Super especial</span></div>
    <div class="carousel__face"><span>Promoção</span></div>
    <div class="carousel__face"><span>Produtos de Skincare</span></div>
    <div class="carousel__face"><span>Para você</span></div>
    <div class="carousel__face"><span>Ruby Rose</span></div>
    <div class="carousel__face"><span>Maquiagem</span></div>
    <div class="carousel__face"><span>Sombras</span></div>
    <div class="carousel__face"><span>Boca</span></div>
    <div class="carousel__face"><span>Pele</span></div>
  </div>
</div>

<!-- Carrousel Fim -->




</body>
</html>