<?php
/* Inicia a Sessão */
session_start();

/* Importa a configuração com o PDO */
require('../php/conexao.php');

$rootDir = $_SERVER["DOCUMENT_ROOT"] . '/Projeto-4-Bimestre/';
$uploaddir = $rootDir . "tmp/img/";
if(isset($_POST['Cadastrar'])){
  /* pega os dados dos inputs */
  $nome = $_POST['Nome'];
  $autor = $_POST['Autor'];
  $editora = $_POST['Editora'];
  $genero = $_POST['Genero'];
  $descricao = $_POST['Descricao'];
  
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
  } elseif (empty($_FILES['Imagem'])) {
    $erro = 'Adicione uma imagem para o livro';
  } else {

    // importa a biblioteca para manipulação de imagens
    require_once('../includes/canvas.php');
    $nomeImage = $_FILES['Imagem']['name'];
    $tmpImage = $_FILES['Imagem']['tmp_name'];
    $img = new canvas();
    $img->carrega($tmpImage)->redimensiona(200,200,'crop')->grava($nomeImage);

    $data = [$nome,$autor,$editora,$genero,$descricao,$nomeImage];

    //--------------------------------------------------------------------------------------//
    //Precisa ser editado
    $reLivro = $pdo->prepare("INSERT INTO Livro (Nome_livro,Autor_livro,Editora_livro,Genero_livro,Descricao_livro,Imagem_livro) Value (?,?,?,?,?,?)");
    $reLivro->execute($data);
    
    if($reLivro->rowCount() > 0){
      $mensagem="Cadastro feito com sucesso";
    } else{/* Se não, deu erro.*/
      $erro="Deu errado.";
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
  <title>Biblioteca Online - Cadastro de Livros</title>
  <link rel="stylesheet" href="../css/global.css">
  <link rel="stylesheet" href="../css/livros.css">
</head>
<body>
  <div id="Cadastra_livro" class="form-global form-livro">
    <form action="" method="POST" autocomplete="off" enctype="multipart/form-data">
      <legend>Cadastrar livro</legend>
      <input type="text" name="Nome" placeholder="Nome livro" autocomplete="false">
      <input type="text" name="Autor" placeholder="Nome do autor" autocomplete="false">
      <input type="text" name="Editora" placeholder="Nome da Editora" autocomplete="false">
      <input type="text" name="Genero" placeholder="Gêneros do livro" autocomplete="false">
      <textarea type="text" name="Descricao" placeholder="Descrição do livro" autocomplete="false"></textarea>
      <img src="<?=$urlBase.'tmp/img/default.jpg.png'?>" alt="Imagem Livro">
      <input type="file" name="Imagem">
      <br>
      <div class="erro">
      <?php 
        if(isset($erro)) 
          echo $erro; 
      ?>
      </div>
      <button type="submit" name="Cadastrar">Cadastrar Livro</button>
    </form>
    <div>
      <?php
        if(isset($mensagem)){
          echo $mensagem;
        }
      ?>
    </div>
  </div>
</body>
</html>