<?php
/* Inicia a Sessão */
session_start();

/* Importa a configuração com o PDO */
require('php/conexao.php');

/* Verifica se o formulário foi enviado */
if(isset($_POST['entrar'])){
  /* pega os dados dos inputs */
  $email = $_POST['email'];
  $password = $_POST['password'];

  /* Valida os campos */
  if (empty($email)) {
    $erro = "É preciso informar o e-mail.";

  } elseif(empty($password)) {
    $erro = "É preciso informar a senha.";

  } else {
    /* Busca no BD se existe esse e-mail e senha */
    $getUser = $pdo->query("SELECT * FROM User WHERE Email_user = '$email' LIMIT 1");

    if ($getUser->rowCount() > 0) {
      /* Se tiver algum resultado pega os dados */
      $usuario = $getUser->fetchObject();
      /* Pega o hash do Banco de Dados */
      $hash = $usuario->Senha_user;

      /* Verifica se a senha está correta */
      if(password_verify($password, $hash)) {

        /* Armazena os dados do usuário no Array da $_SESSION */
        $_SESSION['usuario'] = array(
        "id" => $usuario->ID_user,
        "email" => $usuario->Email_user,
        "name" => $usuario->Nome_user,
        "Usuario"=> $usuario->User_user,
        "avatar"=> $usuario->Imagem_user,
        );

        /* Direciona para a página inicial */
        header("Location: index.php");
      } else {
        $erro = "Não foi possivel realizar o login! Senha inconsistente com a do banco de dados";
      }
    } else {
      $erro = "Não foi possivel realizar o login! Email inexistente no banco de dados";
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
  <title>Biblioteca virtual - Login</title>
  <link rel="stylesheet" href="css/global.css">
  <link rel="stylesheet" href="css/login.css">
</head>
<body>
  
  <div class="wrapper">
    <img src="imagens/logo.svg" alt="Logo Hotel Maré">
    <form action="" method="POST" autocomplete="off">
      <legend>Entrar</legend>
      <input type="email" name="email" placeholder="Seu E-mail" autocomplete="false">
      <input type="password" name="password" placeholder="Sua senha" autocomplete="false">
      <div class="erro">
      <?php 
        if(isset($erro)) 
          echo $erro; 
      ?>
    </div>
      <button type="submit" name="entrar">Entrar</button>
    </form> 
    <a href="recuperar-senha.php">Esqueci minha senha</a>
  </div>
</body>
</html>