<?php 
  /* Tenta se conectar ao Banco de Dados */
  try {
    $pdo = new PDO("mysql:host=localhost;dbname=Biblioteca_virtual","root","");
    /* Adiciona as mensagens de erros */
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch(PDOException $e) {
    /* Mostra o erro caso não consiga se conectar */
    echo 'ERROR: ' . $e->getMessage();
  }

  /* Variável que armazena o endereço do site */
  $urlBase = 'http://localhost/Projeto-4-Bimestre/';
?>
