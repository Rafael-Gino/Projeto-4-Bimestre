<?php
/* Inicia a Sessão */
session_start();

/* Importa a configuração com o PDO */
require('conexao.php');
$rootDir = $_SERVER["DOCUMENT_ROOT"] . '/Projeto-4-Bimestre/';
$uploaddir = $rootDir . 'tmp/img/';

if(isset($_POST['Atualizar'])){
  /* pega os dados dos inputs */
  $nome = $_POST['Nome'];
  $autor = $_POST['Autor'];
  $editora = $_POST['Editora'];
  $genero = $_POST['Genero'];
  $descricao = $_POST['Descricao'];
  $idLivro = $_GET['id'];

  if ($nome == '' || empty($nome)) {
    $erro = 'É preciso adicionar o nome do livro';
  } elseif ($autor == '' || empty($autor)) {
    $erro = 'É preciso adicionar o nome do autor';
  } elseif ($editora == '' || empty($editora)) {
    $erro = 'É preciso adicionar o nome da editora';
  } elseif ($genero == '' || empty($genero)) {
    $erro = 'É preciso adicionar os gêneros da obra';
  } elseif ($descricao == '' || empty($descricao)) {
    $erro = 'É preciso adicionar a descrição do livro';
  } else {
  /* Organiza os dados que serão repassados para o BD  */
  $data = [$nome,$autor,$editora,$genero,$descricao];
  /* Prepara a query de atualização */
  $upLivro = $pdo->prepare("UPDATE Livro SET Nome_livro=?,Autor_livro=?,Editora_livro=?,Genero_livro=?,Descricao_livro=? WHERE ID_livro={$idLivro}" );
  /* Passa os dados e executa.  */
  $upLivro->execute($data);
  /* Se alguma linha foi afetada, o perfil foi atualizado.  */
  if($upLivro->rowCount() > 0){
    $mensagem="O livro foi atualizado.";
    } else {/* Se não, deu erro.*/
      $erro="Deu errado.";
    }  
  }
}

if(isset($_POST['upImage'])) {
  if(!empty($_FILES['avatar'])){

    // importa a biblioteca para manipulação de imagens
    require_once('../includes/canvas.php');
    $nomeImage = $_FILES['Imagem']['name'];
    $tmpImage = $_FILES['Imagem']['tmp_name'];
    $img = new canvas();
    $img->carrega($tmpImage)->redimensiona(200,200,'crop')->grava($nomeImage);

    $upImage = $pdo->query("UPDATE user SET avatar='$nomeImage' WHERE id_user=$idUser");

    /* Pega os dados do Usuário */
    $idUser = $_SESSION['usuario']['id'];
    /* Faz a busca no BD */
    $getUser = $pdo->query("SELECT * FROM user WHERE id_user = '$idUser' LIMIT 1");

    if ($getUser->rowCount() > 0) {
      /* Se tiver algum resultado pega os dados */
      $usuario = $getUser->fetchObject();
      $idUser = $usuario->id_user;
    }
    
  }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Biblioteca Online - Edição de Livros</title>
  <link rel="stylesheet" href="../css/global.css">
  <link rel="stylesheet" href="../css/livros.css">
</head>
<body>
  <?php
    /* Pega os dados do livro selecionado */
    $idLivro = $_GET['id'];
    /* Faz a busca no BD */
    $getLivro = $pdo->query("SELECT * FROM Livro WHERE ID_livro = '$idLivro' LIMIT 1");
    $livro = $getLivro->fetchObject();
  ?>
  <div id="Editar_livro" class="form-global form-livro">
  <form action="" method="post" enctype="multipart/form-data">
    <?php 
    // se não tem avatar ele pega a imagem padrão
    if(empty($usuario->avatar)) {
      $img = $urlBase.'tmp/img/default.png';
    }else{
      $img = $urlBase.'tmp/img/'.$usuario->avatar;
    }
    ?>
    <img src="<?=$img?>" alt="Avatar">
    <input type="file" name="avatar" id="avatar">
    <input type="submit" name="upImage" value="Atualizar">
  </form>  
  <?php
    echo $mensagem;
  ?>
  <form action="" method="POST" autocomplete="off">
      <legend>Editar livro</legend>
      <input type="text" name="Nome" placeholder="Nome livro" autocomplete="false" value="<?=$livro->Nome_livro?>">
      <input type="text" name="Autor" placeholder="Nome do autor" autocomplete="false" value="<?=$livro->Autor_livro?>">
      <input type="text" name="Editora" placeholder="Nome da Editora" autocomplete="false" value="<?=$livro->Editora_livro?>">
      <input type="text" name="Genero" placeholder="Gêneros do livro" autocomplete="false" value="<?=$livro->Genero_livro?>">
      <textarea name="Descricao" rows="5" cols="51" value="<?=$livro->Descricao_livro?>"></textarea>
    <div class="erro">
      <?php 
        if(isset($erro)) 
          echo $erro; 
      ?>
    </div>
      <button type="submit" name="Atualizar">Atualizar Livro</button>
  </form>
  </div>


</body>
</html>