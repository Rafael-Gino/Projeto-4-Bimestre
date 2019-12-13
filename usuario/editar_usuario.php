<?php

$rootDir = $_SERVER["DOCUMENT_ROOT"] . '/hotel-lite/';
$uploaddir = $rootDir . 'tmp/avatars/';

/* Importa o cabeçalho */
require('../cabecalho.php');

// Edição de imagem de avatar
if(isset($_POST['upAvatar'])) {
  if(!empty($_FILES['avatar'])){

    // importa a biblioteca para manipulação de imagens
    require_once('../includes/canvas.php');
    $nomeImage = $_FILES['avatar']['name'];
    $tmpImage = $_FILES['avatar']['tmp_name'];
    
    $img = new canvas();
    $img->carrega($_FILES['avatar']['tmp_name'])
    ->redimensiona(200,200,'crop')
    ->grava($uploaddir.$nomeImage);

    $upAvatar = $pdo->query("UPDATE user SET avatar='$nomeImage' WHERE id_user=$idUser");

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
<title>Hotel Maré - Editar Usuário</title>
</head>
<body>
<?php
/* Importa o Rodapé */
require('../menu-topo.php');
?>

<div class="wrapper">
  <?php
  /* Importa a SideBar */
  require('../sidebar.php');
  ?>
  <!-- Conteúdo da Página -->
  <div class="content">
  
  <!-- O conteúdo principal -->
  <div id="main">

  <?php
  
  ?>
<!-- Enviando uma imagem para o servidor -->
  <form action="" method="post" enctype="multipart/form-data">
    <?php 
    // se não tem avatar ele pega a imagem padrão
    if(empty($usuario->avatar)) {
      $img = $urlBase.'tmp/avatars/default.png';
    }else{
      $img = $urlBase.'tmp/avatars/'.$usuario->avatar;
    }
    ?>
    <img src="<?=$img?>" alt="Avatar">
    <input type="file" name="avatar" id="avatar">
    <input type="submit" name="upAvatar" value="Atualizar">
  </form>
<!-- fim do envio -->

  <?php
 /* Algum infeliz clicou no botão e foi passado os valores do formulário */
 if(isset($_POST['pronto'])){

    $nome = $_POST['nome'];
    $sobrenome = $_POST['sobrenome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $nova = $_POST['nova'];
    $conf = $_POST['confirmacao'];

    if($nome == '' || empty($sobrenome)) {
      $erro = 'Nome e Sobrenome devem ser informados';
    }elseif(empty($email)) {
      $erro = 'O E-mail deve ser informado';
    }elseif(!empty($nova) && ($nova != $conf) && !empty($senha)) {
      $erro = 'A nova senha deve ser confirmada';
    }else {

    /* Criptografa a senha com o Hash */  
    $options = [
      'cost' => 8,
    ];
    $hash =password_hash($nova, PASSWORD_BCRYPT, $options);

    /* Organiza os dados que serão repassados para o BD  */
    $data = [$nome,$sobrenome,$email,$hash];

    /* Prepara a query de atualização */
    $upUser = $pdo->prepare("UPDATE user SET name = ?,lastname = ?,email = ?,password=? WHERE id_user = {$usuario->id_user}" );

    /* Passa os dados e executa.  */
    $upUser->execute($data);

      /* Se alguma linha foi afetada, o perfil foi atualizado.  */
      if($upUser->rowCount() > 0){
        $mensagem="Seu perfil foi atualizado.";

      /* Pega os dados do Usuário */
      $idUser = $_SESSION['usuario']['id'];
      /* Faz a busca no BD */
      $getUser = $pdo->query("SELECT * FROM user WHERE id_user = '$idUser' LIMIT 1");
      $usuario = $getUser->fetchObject();

      } else{/* Se não, deu erro.*/
        $erro="Deu errado.";
      }  
    }
 }
  ?>
  <?php
  if(isset($erro)) {
    echo "<h3>Erro: ". $erro . "</h3>";
  }elseif(isset($mensagem)) {
    echo "<h3>Wow: ". $mensagem . "</h3>";
  }
  ?>
  <form action="" method="post" class="form">

  <input type="text" name="nome" placeholder="Seu nome" value="<?=$usuario->name?>">
  <input type="text" name="sobrenome" placeholder="Seu sobrenome" value="<?=$usuario->lastname?>">
  <input type="email" name="email" placeholder="Seu E-mail" value="<?=$usuario->email?>">

  <hr>

  <input type="password" name="senha" placeholder="Sua senha antiga">
  <input type="password" name="nova" placeholder="Sua nova senha">
  <input type="password" name="confirmacao" placeholder="Confirme sua senha">

  <button type="submit" name="pronto">Atualizar</button>

  </form>

  </div>

  <?php
  /* Importa o Rodapé */
  require('../rodape.php');
  ?>
  </div>

</div>

<?php
/* Importa os Scripts JS */
require('../scripts.php');
?>
</body>
</html>