<?php 
    require_once("conexao/conexao.php");
?>

<?php 
    session_start();

    unset($_SESSION['user_id']);    
    header('location:login.php');
?>