<?php
/* Inicia a Sessão */
session_start();

/* Importa a configuração com o PDO */
require('conexao.php');   

$rootDir = $_SERVER["DOCUMENT_ROOT"] . '/Projeto-4-Bimestre/';
$uploaddir = $rootDir . 'tmp/img/';
if(isset($_POST['Cadastrar'])){
  /* pega os dados dos inputs */
  $nome = $_POST['Nome'];
  $sobrenome = $_POST['Sobrenome'];
  $usuario = $_POST['Usuario'];
  $email = $_POST['Email'];
  $senha = $_POST['Senha'];
  $senhar = $_POST['Senhar'];
  $tipo = $_POST['Tipo'];
  
  if ($nome == '' || empty($nome)) {
    $erro = 'É preciso adicionar o nome';
    print_r($_POST);
  } elseif ($sobrenome == '' || empty($sobrenome)) {
    $erro = 'É preciso adicionar o sobrnome';
    print_r($_POST);
  } elseif ($usuario == '' || empty($usuario)) {
    $erro = 'É preciso adicionar o nome do usuario';
    print_r($_POST);
  } elseif ($email == '' || empty($email)) {
    $erro = 'É preciso adicionar o email';
    print_r($_POST);
  } elseif ($tipo == '' || empty($tipo)) {
    $erro = 'É preciso selecionar o tipo de conta';
    print_r($_POST);
  } elseif ($senha == '' || empty($senha)) {
    $erro = 'É preciso adicionar a senha';
    print_r($_POST);
  } elseif ($senhar == '' || empty($senhar)) {
    $erro = 'É preciso adicionar a confirmação de senha';
    print_r($_POST);
  } elseif ($senha != $senhar) {
    $erro = 'As senhas devem ser iguais';
    print_r($_POST);
  } elseif (empty($_FILES['Imagem'])) {
    $erro = 'Adicione uma imagem para o livro';
  } else {
    // importa a biblioteca para manipulação de imagens
    require_once('../includes/canvas.php');
    $nomeImage = $_FILES['Imagem']['name'];
    $tmpImage = $_FILES['Imagem']['tmp_name'];
    $img = new canvas();
    $img->carrega($tmpImage)->redimensiona(200,200,'crop')->grava($nomeImage);

    $options = [8,];
    $hash = password_hash($senha, PASSWORD_BCRYPT, $options);

    $data = [$nome,$sobrenome,$usuario,$email,$tipo,$hash,$nomeImage];
    //--------------------------------------------------------------------------------------//
    //Precisa ser editado
    $reLivro = $pdo->prepare("INSERT INTO User (Nome_user,Sobrenome_user,User_user,Tipo_user,Email_user,Senha_user,Imagem_user) Value (?,?,?,?,?,?,?)");
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
  <title>Biblioteca Online - Cadastro de usuarios</title>
  <link rel="stylesheet" href="css/global.css">
  <link rel="stylesheet" href="css/login.css">
</head>
<body>
  
  <div class="wrapper">
    <img src="" alt="">
    <form action="" method="POST" autocomplete="off" enctype="multipart/form-data">
      <legend>Registrar</legend>
      <input type="text" name="Nome" placeholder="Seu nome" autocomplete="false">
      <input type="text" name="Sobrenome" placeholder="Seu sobrenome" autocomplete="false">
      <input type="text" name="Usuario" placeholder="Seu nome de usuario" autocomplete="false">
      <input type="email" name="Email" placeholder="Seu E-mail" autocomplete="false">
      <input type="password" name="Senha" placeholder="Sua senha" autocomplete="false">
      <input type="password" name="Senhar" placeholder="Confirmar senha" autocomplete="false"><br>
      <input type="radio" name="Tipo" value="admin">Admin<br>
      <input type="radio" name="Tipo" value="Escritor">Escritor<br>
      <input type="radio" name="Tipo" value="Leitor">Leitor<br>
      <input type="file" name="Imagem">
    <div class="erro">
      <?php 
        if(isset($erro)) 
          echo "<br><br>".$erro; 
      ?>
    </div>
    <button type="submit" name="Cadastrar">Cadastrar Usuario</button>
    </form>
    <br>
    <div>
    </div>
  </div>
</body>
</html>