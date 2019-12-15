<div class="menu-topo">
  <a href="<?=$urlBase?>">
    <img src="<?=$urlBase?>imagens/logo.svg" alt="Logo">
  </a>
  <div class="user">
    <a href="#" class="dropdown-user" id="menu-user">
      <?php
      // se não tem avatar ele pega a imagem padrão
      if(empty($usuario->avatar)) {
        $img = $urlBase.'tmp/img/default.png';
      }else{
        $img = $urlBase.'tmp/img/'.$usuario->avatar;
      }
      ?>
      <img src="<?=$img?>" alt="Avatar">
      <span><?=$usuario->name?></span>
    </a>
    <ul class="dropdown-menu">
      <li>
        <a href="<?=$urlBase?>usuario/editar_usuario.php"><i class="fas fa-user-edit"></i> Editar Perfil</a>
      </li>
      <li>
        <a href="<?=$urlBase?>logout.php"><i class="fas fa-sign-out-alt"></i> Sair</a>
      </li>
    </ul>
  </div>
</div>