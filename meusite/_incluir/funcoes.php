<?php

    function generateCode () {
        $characters = "1234567890ABCDEFGHIJKLMNOPQRSTUWXYZ";
        $lenght = 20;
        $code_char = rand();
        for ( $i = 0 ; $i < $lenght ; $i++ ) {
            $code_char .= substr($characters,rand(0,35),1);
        }
        date_default_timezone_set('America/Sao_Paulo');
        
        $date = getdate();
        
        $code = "photo_" . $date['year'] . "_" . $date['yday'] . $date['hours'] . $date['minutes'] . $date['seconds'];

        $finally_code = $code. "_" .$code_char;

        return $finally_code;
    }
    
//    function tirarAcentos($string){
//        return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$string);
//    }

    function getExtension ($extension) {
        return strrchr($extension,'.');
    }
    
    function publicarFoto ($arquivo) {
        $nome_tmp = $arquivo['tmp_name'];
        $nome_imagem = basename($arquivo['name']);
        $diretorio = "_images/publicadas/" . generateCode() . getExtension($nome_imagem);
        if( move_uploaded_file($nome_tmp,$diretorio) ) {
            return array("Imagem publicada com sucesso", $diretorio);
        } else {
            return array("Você não publicou imagem.", "_images/user_default.png");
        }
    }

    function erro ($erro) {
        $array_erro = array(
            UPLOAD_ERR_OK => "Imagem publicada.",
            UPLOAD_ERR_INI_SIZE => "O arquivo enviado excede o limite definido na diretiva upload_max_filesize do php.ini.",
            UPLOAD_ERR_FORM_SIZE => "O arquivo excede o limite definido de 600000 bytes",
            UPLOAD_ERR_PARTIAL => "O upload do arquivo foi feito parcialmente.",
            UPLOAD_ERR_NO_FILE => "Nenhum arquivo foi enviado.",
            UPLOAD_ERR_NO_TMP_DIR => "Pasta temporária ausente.",
            UPLOAD_ERR_CANT_WRITE => "Falha em escrever o arquivo em disco.",
            UPLOAD_ERR_EXTENSION => "Uma extensão do PHP interrompeu o upload do arquivo."
        ); 
        
        return $array_erro[$erro];
        
    }
    
?>