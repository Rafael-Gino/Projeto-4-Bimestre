<?php
/* Inicia a sessão */
session_start();

/* Importa a conexão */
require('conexao.php');

if(!isset($_SESSION['usuario'])){
  /* Direciona para a página de Login */
  header("Location:$urlBase"."login.php");
}else{
  /* Pega os dados do Usuário */
  $idUser = $_SESSION['usuario']['id'];
  /* Faz a busca no BD */
  $getUser = $pdo->query("SELECT * FROM User WHERE ID_user = '$idUser' LIMIT 1");

  if ($getUser->rowCount() > 0) {
    /* Se tiver algum resultado pega os dados */
    $usuario = $getUser->fetchObject();
    $idUser = $usuario->ID_user;
  }else {
    /* Direciona para a página de Login */
    header("Location:$urlBase"."login.php");
  }
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">

<!-- Importa o CSS do Painel -->
<link rel="stylesheet" href="<?=$urlBase?>css/global.css">
<link rel="stylesheet" href="<?=$urlBase?>css/dashboard.css">
<!-- Importa a Font de Icones -->
<link rel="stylesheet" href="<?=$urlBase?>css/all.css">