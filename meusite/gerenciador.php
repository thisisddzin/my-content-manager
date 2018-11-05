<?php

    require_once("conexao/conexao.php");
    
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
  
    //CONSULTA DE TECNOLOGIAS

    $tecnologias = "SELECT * ";
    $tecnologias .= "FROM tecnologias ";

    $lista_tec = mysqli_query($conexao,$tecnologias);

    if ( !$lista_tec ) {
        die("ERRO AO SE CONECTAR COM BANCO");
    }
    
    
    //    echo $foto_user['foto'];

    //CONSULTAR USUÁRIOS PARA MOSTRAR NOS REGISTROS 

    $users_registrados  = "SELECT * ";
    $users_registrados .= "FROM usuarios ";

    $lista_users = mysqli_query($conexao,$users_registrados);

    if ( !$lista_users ) {
        die("ERRO AO SE CONECTAR COM BANCO DA LISTA DE USERS");
    }

    //CONSULTAR PRODUTOS PARA MOSTRALOS EM REGISTRO 

    $produtos_registrados  = "SELECT * ";
    $produtos_registrados .= "FROM produtos ";

    $lista_produtos = mysqli_query($conexao,$produtos_registrados);

    if (!$lista_produtos) {
        die("ERRO AO SE CONECTAR COM BANCO DA LISTA DE PRODUTOS");
    }

    date_default_timezone_set('America/Sao_Paulo');

    //CONSULTAR USUÁRIO PARA VERIFICAR ADMIN
    
    if ( isset($_POST['nomeproduto']) && $admin['admin'] == 1 ) {
        $nomeproduto = $_POST['nomeproduto'];
        $tipodeproduto = $_POST['secaoprodutos'];
        $descricaoproduto =  $_POST['descricaoproduto'];
        $datapublicacao = $datadecadastro     = date("d/m/y H:i:s"); 
        
        $erro_img = erro($_FILES['fotoproduto']['error']);

        $foto = publicarFoto($_FILES['fotoproduto']);
        
        $fotoproduto = $foto[1];

        if(isset($_POST['tecnologias'])) {
           $tecnologias = implode(', ',$_POST['tecnologias']);
        } else {
            $tecnologias = "";
        }
        
        if(isset($_POST['responsivo'])) {
            $responsivo = $_POST['responsivo'];
        } else {
            $responsivo = "";
        }
        $publicar_projeto   = "INSERT INTO produtos ";
        $publicar_projeto  .= "(tipodoproduto,tecnologiasproduto,nomeproduto,fotoproduto,descricaoproduto,responsivoproduto,datapublicacao) ";
        $publicar_projeto  .= "VALUES ";
        $publicar_projeto  .= "('$tipodeproduto','$tecnologias','$nomeproduto','$fotoproduto','$descricaoproduto','$responsivo','$datapublicacao')";
        
        $publicar = mysqli_query($conexao,$publicar_projeto);
        
        if ( !$publicar ) {
            die("PROBLEMA NO BANCO");
        } else {
            unset($_POST['nomeproduto']);
            header("Location:gerenciador.php");
            $mensagem = "Publicado com sucesso!";
        }
    } else if ($admin['admin'] == 0){
        $mensagem_unadmin = "Você não possui autorização para fazer isto.";
    }

    if (isset($_POST['nomeusuario']) && $admin['admin'] == 1 ) {
        
        $email              = $_POST['emailusuario'];
        $usuario            = $_POST['nomeusuario']);
        $senha              = $_POST['senhausuario'];
        
        $date = getdate();
        
        $datadecadastro     = date("d/m/y H:i:s"); 
        
        $admin              = $_POST['adminusuario'];
        
        $erro_img           = erro($_FILES['fotousuario']['error']);
        
        $foto               = publicarFoto($_FILES['fotousuario']);
        
        $fotouser           = $foto[1];
        
        $criar_user  = "INSERT INTO usuarios ";
        $criar_user .= "(email,usuario,senha,datadecadastro,admin,foto) ";
        $criar_user .= "VALUES ";
        $criar_user .= "('$email','$usuario','$senha','$datadecadastro',$admin,'$fotouser')";
        
        $inserir_user = mysqli_query($conexao,$criar_user);
        
        if ( !$inserir_user ) {
            die("Deu ruim no banco de dados");
        } else {
            unset($_POST['nomeusuario']);
            header("Location:gerenciador.php");
            $mensagem_user = "Criado com sucesso!";
        }
    } else if ($admin['admin'] == 0){
        $mensagem_unadmin = "Você não possui autorização para fazer isto.";
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Gerenciador - MRGeekTI</title>

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
        
<!--        CSS-->
<!--        <link href="_css/main-layout.css" type="text/css" rel="stylesheet">-->
        <link href="_css/layout-gerenciador.css" type="text/css" rel="stylesheet">
        
        
    </head>
    
    <body>
        
        <header> 
            <?php 
                include_once("_incluir/header.php");
            ?>
        </header>
        
        <main> 
            
        <div id="add_produto">
            <h3>Adicionar produto</h3>

            <form action="gerenciador.php" method="post" enctype="multipart/form-data">
                <select id="campo_produtos" name="secaoprodutos">
                    <option name="produtosback">Back-end</option>
                    <option name="produtosfront">Front-end</option>
                </select>

                <input type="text" name="nomeproduto" placeholder="Nome do Produto">
                <textarea type="textarea" name="descricaoproduto" placeholder="Descrição"></textarea>

                <input type="hidden" name="MAX_FILE_SIZE" value="60000000000">
                <input type="file" name="fotoproduto">

                <label for="campo_tecnologias">Tecnologias utilizadas: </label> <br>
                    <?php 
                        while ( $linha = mysqli_fetch_assoc($lista_tec) ) {
                    ?>
                    <input type="checkbox" name="tecnologias[]" id="campo_tecnologias" value="<?php echo $linha['nometecnologia'] ?>" /><?php echo $linha['nometecnologia'] ?>
                    <?php 
                        }
                    ?>
                <br>
                <label for="responsivo"  >Responsivo?</label>
                <input type="radio" checked name="responsivo" value="Sim">Sim
                <input type="radio" name="responsivo" value="Não">Não
                <input class="botao-scale" type="submit" value="Publicar">

                <span style="color:red"><?php
                if (isset($mensagem_unadmin)) {
                    echo $mensagem_unadmin;
                }
                ?></span>

            </form>

        </div>
            
        <div id="gestao_usuario">

            <h3>Cadastrar usuário</h3>

            <form method="post" action="gerenciador.php" enctype="multipart/form-data">
                <input type="text" name="nomeusuario"placeholder="Nome de Usuário">
                <input type="password" name="senhausuario" placeholder="Digite a senha">
                <input type="password" name="senhausuariorepete" placeholder="Digite a senha novamente">
                <input type="email" name="emailusuario" placeholder="Digite seu email">
                <input type="hidden" name="MAX_FILE_SIZE" value="60000000000">
                <input type="file" name="fotousuario">
                <label for="adminusuario">Administrador?</label>
                <input type="radio" name="adminusuario" value="1">Sim
                <input type="radio" name="adminusuario" checked value="0">Não
                <input class="botao-scale" type="submit" name="criar" value="Criar">

                <span style="color:red"><?php
                if (isset($mensagem_unadmin)) {
                    echo $mensagem_unadmin;
                }
                ?></span>

            </form>
        </div>
            
    </main>
        

    <div id="tabelas">
        
            <h3>Registro de Usuários</h3>
        
        <div class="tabela_usuarios">
          <table>
            <thead>
              <tr>
                <th>ID</th>
                <th>Foto</th>
                <th>Usuário</th>
                <th>E-mail</th>
                <th>Admin</th>
                <th>Criado em</th>
                <th colspan='2'>Alterações</th>
              </tr>
            </thead>
              
            <?php 
                while ( $linha_user = mysqli_fetch_assoc($lista_users) ) {
            ?>
              
            <tbody>
                <th><?php echo $linha_user['usuarioID'] ?></th>
                <th><img style="width:30px; margin-top:3px;border-radius:50%" src="<?php echo $linha_user['foto'] ?>" alt=""></th>
                <th><?php echo $linha_user['usuario'] ?></th>
                <th><?php echo $linha_user['email'] ?></th>
                <th><?php echo ($linha_user['admin'] == 1) ? "Sim" : "Não" ?></th>
                <th><?php echo $linha_user['datadecadastro'] ?></th>
                <th class="botao-scale" style="color:white; background-color:green; font-weight: 100; cursor:pointer"><a style="text-decoration:none; color:white" href="alterar-usuario.php?usuario=<?php echo $linha_user["usuarioID"] ?>">Editar</a></th>
                <th class="botao-scale" style="color:white; background-color:red; font-weight: 100; cursor:pointer"><a style="text-decoration:none; color:white" href="excluir-usuario.php?usuario=<?php echo $linha_user["usuarioID"] ?>">Excluir</a></th>
            </tbody>
        
            <?php 
                }
            ?>
              
            </table>
            <?php    if ($linha_user){
                        mysqli_free_result($linha_user); 
                    }
            ?>
        </div>
        <!-- /.box-body -->
        
        <h3>Registro de Produtos publicados</h3>
        
        <div class="tabela_produtos" >
          <table >
            <thead>
              <tr>
                <th>ID</th>
                <th>Tipo</th>
                <th>Produto</th>
                <th>Publicado em</th>
                <th colspan='2'>Alterações</th>
              </tr>
            </thead>
            
            <?php 
                while ( $linha_produto = mysqli_fetch_assoc($lista_produtos) ) {
            ?>
                
              <tbody>
                <th><?php echo $linha_produto['produtoID'] ?></th>
                <th><?php echo $linha_produto['tipodoproduto'] ?></th>
                <th><?php echo $linha_produto['nomeproduto'] ?></th>
                <th><?php echo $linha_produto['datapublicacao'] ?></th>
                  <th class="botao-scale" style="color:white; background-color:green; font-weight: 100; cursor:pointer"><a style="text-decoration:none; color:white" href="alterar-projeto.php?projeto=<?php echo $linha_produto["produtoID"] ?>">Editar</a></th>
                <th class="botao-scale" style="color:white; background-color:red; font-weight: 100; cursor:pointer"><a style="text-decoration:none; color:white" href="excluir-projeto.php?projeto=<?php echo $linha_produto["produtoID"] ?>">Excluir</a></th>
            </tbody>
              
              <?php 
                }
              ?>
              
          </table>
           <?php    if ($linha_produto){
                        mysqli_free_result($linha_produto); 
                    }
            ?>
        </div>
        <!-- /.box-body -->
        
    </div>

        
    <!--        DIREITOS-->
        <details class="credits">

            <summary>Copyright &copy; 2018</summary>

            <p>Developed by Adenilson Santos</p>

        </details>
        
    </body>

</html>

<?php 
    mysqli_close($conexao);
?>