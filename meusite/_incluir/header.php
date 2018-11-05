
<?php 
//CONSULTA USUARIOS PARA ATUALIZAR FOTO 
    $user    = "SELECT foto, usuarioID, usuario, admin ";
    $user   .= "FROM usuarios ";
    $user   .= "WHERE usuarioID = {$_SESSION['user_id']} ";

    $consulta_foto_user = mysqli_query($conexao,$user);

    if (!$consulta_foto_user) {
        die("erro na consulta da foto do usuário");
    }

    $foto_user = mysqli_fetch_assoc($consulta_foto_user);
?>
<h1>Gerenciador <span style="color:dodgerblue">MRGeekTI</span></h1>
<div id="perfil">

    <img src="<?php echo $foto_user['foto'] ?>" alt="foto de perfil">

    <h3><span style="color:lime;">♠</span> <?php echo  ($foto_user['admin'] == 1 ) ? strtoupper($foto_user['usuario']) . " [ADMIN USER]" : strtoupper($foto_user['usuario']) . " [NORMAL USER]"?> </h3>

    <a href="alterar-usuario.php?usuario=<?php echo $foto_user['usuarioID'] ?>"><button class="botao-scale">Perfil</button></a>

    <a href="logout.php"><button class="botao-scale" style="background-color:red;">Sair</button></a>
</div>