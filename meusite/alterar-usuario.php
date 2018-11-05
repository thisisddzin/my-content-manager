<?php require_once("conexao/conexao.php"); ?>
<?php

    require_once("_incluir/funcoes.php");

    session_start();

    if ( !isset($_SESSION['user_id']) )  {
        header('location:login.php');
    }  

    $ver_admin  = "SELECT admin ";
    $ver_admin .= "FROM usuarios ";
    $ver_admin .= "WHERE usuarioID = {$_SESSION['user_id']}";

    $consultar_admin = mysqli_query($conexao,$ver_admin);

    if (!$consultar_admin) {
        die("PROBLEMA NO BANCO DE DADOS AO CONSULTAR ADMIN". mysqli_error($conexao));
    }

    $admin = mysqli_fetch_assoc($consultar_admin);  

    //CONSULTANDO BANCO DO ID SELECIONADO
     
    $consulta  = "SELECT * ";
    $consulta .= "FROM usuarios ";
    if ( isset($_GET['usuario']) ) {  
        $id = $_GET['usuario'];
        $consulta .= "WHERE usuarioID = {$id} ";
    } else {
        header("location:gerenciador.php");
    }
    
    $con_user = mysqli_query($conexao,$consulta) or die(mysqli_error($conexao));

    $att_value = mysqli_fetch_assoc($con_user);

    //FAZER UPDATE NO BANCO

    if (isset($_POST['usuario']) && $admin['admin'] == 1 ) {
        $consulta  = "SELECT * ";
        $consulta .= "FROM usuarios ";
        $consulta .= "WHERE usuarioID = {$_POST['usuarioID']} ";
        
        $con_user = mysqli_query($conexao,$consulta) or die(mysqli_error($conexao));

        $att_value = mysqli_fetch_assoc($con_user);
        
        $usuario = $_POST['usuario'];
        $email = $_POST['email'];
        if (!empty($_POST['senha'])) {
            $senha =  $_POST['senha'];
        } else {
            $senha = $att_value['senha'];
        }
        $admin = $_POST['admin'];
        $usuarioID = $_POST['usuarioID'];
        
        $erro_img = erro($_FILES['foto']['error']);
        
        if ($erro_img == "Nenhum arquivo foi enviado.") {
            $foto_user = $att_value['foto'];
        } else {
            $foto = publicarFoto($_FILES['foto']);
        
            $foto_user = $foto[1];
        }
        
        $get_values  = "UPDATE usuarios ";
        $get_values .= "SET ";
        $get_values .= "usuario = '{$usuario}', ";
        $get_values .= "email = '{$email}', ";
        $get_values .= "senha =  '{$senha}', ";
        $get_values .= "foto = '{$foto_user}', ";
        $get_values .= "admin = '{$admin}' ";
        $get_values .= "WHERE usuarioID = {$usuarioID} ";
        
        $operacao_alterar = mysqli_query($conexao, $get_values);
        
        if (!$operacao_alterar) {
            die(mysqli_error($conexao));
        } else {
            header("location:gerenciador.php");
        }
        
    } else if ($admin['admin'] == 0){
        $mensagem_unadmin = "Você não possui autorização para fazer isto.";
    }

?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Alterar Usuário <?php echo $att_value['usuario'] ?></title>
        <!--        CARACTERES-->
        <meta charset="utf-8">
        
<!--        COMPATIBILIDADE-->
        <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
        
<!--        RESPONVISO-->
        <meta name="viewport" content="width=device-width, user-scalable = no">
        
<!--        METATAGS-->
        <meta name="author" content="Adenilson Santos">
        <meta name="application-name" content="Gerenciador MRGeekTI">
        
<!--        ICONE-->
        <link href="_images/icones/icon.ico.png" rel="shortcut icon" href="_images/icones/icon.ico.png">
        
<!--        FONTES-->
        <link href="https://fonts.googleapis.com/css?family=Shadows+Into+Light" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=K2D" rel="stylesheet">
        
        <!-- estilo -->
<!--
        <link href="_css/estilo.css" rel="stylesheet">
        <link href="_css/alteracao.css" rel="stylesheet">
-->
        
        <style>
        body {
            font-family: 'K2D', sans-serif;
            padding: 0;
            margin: 0;
        }

        /*
            background:linear-gradient(123deg,rgba(0,0,0,0.95),#00CED1);
            background-size: 400% 400%;
            animation:  backgroundgradient 10s ease infinite;
        */


        @keyframes backgroundgradient {

            0% { background-position: 0% 50% }
            50% { background-position: 100% 50% }
            100% { background-position: 0% 50% }

        }

        header {
            width: 100%;
            margin: 0 auto;
            height: 220px;
            text-align: center;
        }


        header #perfil {
        /*    float: right;*/
        }
        header img {
            width: 50px;
            border-radius: 50%;
            border: groove 2px dodgerblue;

        }

        header h3 {
            color: indigo;
        }

        header #perfil button {
            background-color: dodgerblue;
            color: white;   
            padding: 5px 10px;
            border: groove dodgerblue 1px;
            cursor: pointer;
            display: inline-block;
        }

        .botao-scale:hover {
            transform: scale(1.1);
        }
            
        main {
            display: flex;
            align-items: center;
            justify-content: center;
        }
            
        #gestao_usuario {
            height: 100%;
            margin: 10px;padding: 10px;
            width: 80%;
            text-align: center;
        }
            
        #gestao_usuario form label {
            display: block;
        }

        #gestao_usuario form input, #gestao_usuario form textarea {
            text-align: center;
            display: block;
            margin: 10px auto;
            padding: 10px;
            background-color: transparent;
            border-bottom-style: dashed;
            border-color: dodgerblue;
            border-radius: 30px;
        }

        #gestao_usuario form textarea {
            min-height: 100px;
            min-width: 50%;
        }
            
        #gestao_usuario form input[type="checkbox"],#gestao_usuario form input[type="radio"] {
            display: inline;
            display: inline;
            margin: 2px;
            word-break: break-all;
            margin:  10px;
        }

        #gestao_usuario form input[type='submit']{
            background-color: limegreen;
            border: none;
            color: white;
            width: 80%;
            box-shadow: 2px 2px 2px black;
            cursor: pointer;
        }
            
            #gestao_usuario form{
                display: inline;
                
            }

        details {
            width: 100%;
            text-align: center;
            cursor: pointer;
            margin: 20px 0;
        }
            
        </style>
    </head>

    <body>
        
        <header> 
            <?php 
                include_once("_incluir/header.php");
            ?>
        </header>
        
        <main>  
            <div id="gestao_usuario">

            <h3>Alterar Usuário <?php echo $att_value['usuarioID'] ?></h3>

            <form method="post" action="alterar-usuario.php" enctype="multipart/form-data">
                <label>Criado em:</label>
                <p><?php echo $att_value['datadecadastro'] ?></p>
                <label for="usuario">Nome:</label>
                <input type="text" id="usuario" name="usuario" value="<?php echo $att_value['usuario'] ?>">
                <label for="email">E-mail:</label>
                <input type="email" name="email" id="email" value="<?php echo $att_value['email'] ?>">
                <label for="senha">Nova senha:</label>
                <input type="password" name="senha" id="senha" >
                <input type="hidden" name="MAX_FILE_SIZE" value="60000000000"><input type="hidden" name="usuarioID" value="<?php echo $att_value['usuarioID'] ?>">
                <label for="foto">Foto: </label><img style="width:100px" src="<?php echo $att_value['foto'] ?>" >
                <input type="file" name="foto" id="foto">
                <label for="admin">Administrador?
                <input type="radio" name="admin" <?php echo ($att_value['admin'] == 1 ) ? "checked" : ""  ?> value="1">Sim
                <input type="radio" name="admin" <?php echo ($att_value['admin'] == 0 ) ? "checked" : ""  ?> value="0">Não</label>
                <input class="botao-scale" type="submit" name="criar" value="Confirmar Alteração">

                <span style="color:red"><?php
                if (isset($mensagem_unadmin)) {
                    echo $mensagem_unadmin;
                }
                ?></span>

            </form>
        </div>

        </main>
        <!--        DIREITOS-->
        <details class="credits">

            <summary>Copyright &copy; 2018</summary>

            <p>Developed by Adenilson Santos</p>

        </details>

    </body>
</html>

<?php
    // Fechar conexao
    mysqli_close($conexao);
?>