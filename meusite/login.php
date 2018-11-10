<?php 

    require_once("conexao/conexao.php");

    session_start();

    if(mysqli_connect_errno()) {
        die("ERRO NA CONEXÃO COM O SERVIDOR! " . mysqli_connect_errno());
    }

    $erro= 0;
    
    if ( isset($_POST['login']) ) {
        $consulta_usuario  = "SELECT * ";
        $consulta_usuario .= "FROM usuarios ";
        $consulta_usuario .= "WHERE usuario = '{$_POST['usuario']}' and senha = '{$_POST['senha']}' ";
        
        $acesso = mysqli_query($conexao,$consulta_usuario);
        
        if (!$acesso) {
            die("ERRO NO ACESSO AO BANCO DE DADOS");
        }
        
        $verificado = mysqli_fetch_assoc($acesso);
        
        if ( empty($verificado) ) {
            $mensagem = "Seu login ou senha está incorreto, tente novamente." ;    
        } else {
            $_SESSION['user_id'] = $verificado['usuarioID'];
        }
    
    }
    
    if (isset($_SESSION['user_id'])) {
        $consulta_usuario  = "SELECT * ";
        $consulta_usuario .= "FROM usuarios ";
        $consulta_usuario .= "WHERE usuarioID = {$_SESSION['user_id']} ";
        
        $acesso = mysqli_query($conexao,$consulta_usuario);
        
        if (!$acesso) {
            die("ERRO NO ACESSO AO BANCO DE DADOS");
        }
        
        $verificado = mysqli_fetch_assoc($acesso);
        
         $mensagem = "Logado com sucesso, bem-vindo " . $verificado['usuario'] . ".";
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Login - MRGeekTI</title>

<!--        CARACTERES-->
        <meta charset="utf-8">
        
<!--        COMPATIBILIDADE-->
        <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
        
<!--        RESPONVISO-->
        <meta name="viewport" content="width=device-width, user-scalable = no">
        
<!--        METATAGS-->
        <meta name="author" content="Adenilson Santos">
        <meta name="application-name" content="Tela de Login MRGeekTI">
        <meta name="description" content="Tela de Login MRGeekTI">
        <meta name="keywords" content="Login Mrgeekti, Login Adenilson Santos">
        
<!--        ICONE-->
        <link href="_images/icones/icon.ico.png" rel="shortcut icon" href="_images/icones/icon.ico.png">
        
<!--        FONTES-->
        <link href="https://fonts.googleapis.com/css?family=Shadows+Into+Light" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=K2D" rel="stylesheet">
        
<!--        CSS-->
<!--        <link href="_css/main-layout.css" type="text/css" rel="stylesheet">-->

        <style>
            
            body {
                margin: 0; padding: 0;  
                text-align: center;
                font-family: 'K2D', sans-serif;

            }
            
            header {
                text-align: center;
                margin: 0 auto;
                position: absolute;
                top: 10%;
                width: 100%;
                font-weight: 100;
            }
            
            header h1 {
                font-size: 40px;
            }
            
            section {
                width: 100%;
                display: flex;
                align-content: center;
                align-items: center;
                justify-content: center
            }
            
            form {
                clear: both;
                width: 100%;
                margin-top: 30px;
            }
            
            form input {
                margin: 10px;
                padding: 10px;
                border: none;
                border-bottom-style:ridge;
                border-color: dodgerblue;
            }
            
            form input[type="submit"] {
                border: none;
                background-color: dodgerblue;
                color: white;
            }
            
            .botao-scale:hover {
                transform: scale(1.1);
                cursor: pointer;
            }
            
            .logado  {
                width: 100%;clear: both;
            }
            
            .logado input {
                border: none;
                background-color: dodgerblue;
                padding: 10px;
                color: white;
                cursor: pointer;
            }
            
            details {
                cursor: pointer;
                width: 100%;
            }
            
            @media only screen and (max-width:340px) {
                header { top: 5% }
            }
            
        </style>
        
        
        
    </head>
    
    <body>
        
        <header> 
            <h1>Tela de Login <span style="color:dodgerblue">MRGeekTI</span></h1>
        </header>
           
        <section>
            <form action="login.php" method="post" >
            <?php 
            if (!isset($_SESSION['user_id'])) {
            ?>
                <div class="naologado">
                    <input type="text" placeholder="Usuário" name="usuario">
                    <input type="password" placeholder="Senha" name="senha">
                    <input class="botao-scale" type="submit" name="login" value="Login">
                </div>

                <br>
                <details>

                    <summary>Copyright &copy; 2018</summary>

                    <p>Developed by Adenilson Santos</p>

                </details>
                <?php if (isset($mensagem)) { 
                
                ?>
                
                <p style="color:white; padding:5px; background-color:red">
                <?php 
                    }
                  
                ?>
            <?php 
                echo (isset($mensagem)) ? $mensagem : "";
               } else {
                ?> </p>
                <h3 style="color:green"><?php echo (isset($_SESSION['user_id'])) ? $mensagem : "" ?></h3>
                <div class="logado">
                    <a href="gerenciador.php"> <input type="button" name="entrargerencia" value="Gerenciador"></a>
                    <a href="logout.php"> <input type="button" name="sair" value="Sair"></a>
                </div>

                <br>
                <details>

                    <summary>Copyright &copy; 2018</summary>

                    <p>Developed by Adenilson Santos</p>

                </details>
            </form>
        </section>
        <?php 
        }
        ?> 
            
        
<!--        JAVA SCRIPT-->
        

<!--        <script src="_js/jquery-3.3.1.min.js"></script>-->
        
        <script>
            
            document.querySelector("section").style.height = (window.innerHeight+30) +"px";
            
            document.querySelector("input[name='usuario']").focus();
            
        </script>
        
    </body>

</html>

<?php 
    mysqli_close($conexao);
?>