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
        header('location:gerenciador.php');
    }

    $con_produto = mysqli_query($conexao,$consulta) or die(mysqli_error());

    $att_value = mysqli_fetch_assoc($con_produto);

    //DELETAR DO BANCO DE DADOS

    if (isset($_POST['usuarioID']) && $admin['admin'] == 1  ) {
        
        $prodID = $_POST['usuarioID'];
        
        $excluir  = "DELETE FROM usuarios WHERE usuarioID = {$prodID} ";
         
        $operacao_excluir = mysqli_query($conexao, $excluir);
        
        if (!$operacao_excluir) {
            die(mysqli_error($conexao));
        } else {
            header('location:gerenciador.php');
        }
        
    } else if ($admin['admin'] == 0){
        $mensagem_unadmin = "Você não possui autorização para fazer isto.";
    }


?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Excluir Projeto <?php echo $att_value['nomeproduto'] ?></title>
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
            
        #att_usuario {
            width: 80%;
            height: 100%;
            text-align: center;
            margin: 10px;padding: 10px;
        }

        #att_usuario form {
            background-color: white;
        }

        #att_usuario form input, #att_usuario form textarea {
            text-align: center;
            display: block;
            margin: 10px auto;
            padding: 10px;
            background-color: transparent;
            border-bottom-style: dashed;
            border-color: dodgerblue;
        }

        #att_usuario form textarea {
            min-height: 100px;
            min-width: 50%;
        }

        #att_usuario form input[type="checkbox"],#att_usuario form input[type="radio"] {
            display: inline;
            display: inline;
            margin: 2px;
            word-break: break-all;
            margin:  10px;
        }

        #att_usuario form input[type='submit']{
            background-color: red;
            border: none;
            color: white;
            width: 80%;
            box-shadow: 2px 2px 2px black;
            cursor: pointer;
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
            <div id="att_usuario">
                <h3 style="color:red"><b>Excluir</b> Usuário | ID: <?php echo $att_value['usuarioID'] ?></h3>

                <form action="excluir-usuario.php" method="post" enctype="multipart/form-data">
                    <h4>INFORMAÇÕES DO USUÁRIO</h4>
                    <label>Criado em:</label>
                    <p><?php echo $att_value['datadecadastro'] ?></p>
                    <ul style="list-style:none; line-height:35px; padding:0; font-size:30px">
                        <li><img style="width:100px; object-fit:cover" src="<?php echo $att_value['foto'] ?>"></li>
                        <li>Nome: <?php echo $att_value['usuario'] ?></li>
                        <li>E-mail: <?php echo $att_value['email'] ?></li>
                        <li>Admin: <?php echo $att_value['admin'] ?></li>
                        <li>Criado em: <?php echo $att_value['datadecadastro'] ?></li>
                    </ul>
                    <input type="hidden" name="usuarioID" value="<?php echo $att_value['usuarioID'] ?>">
                    <br>
                    <input class="botao-scale" type="submit" value="Confirmar Exclusão">

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