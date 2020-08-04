<?php

    $host = 'localhost';
    $dbname = 'teste_multiplier';
    $user = 'root';
    $password = '';
    
    $conexaoMysql = mysqli_connect($host,$user,$password,$dbname);
    
    if(!$conexaoMysql){
        die("Não foi possível se conectar com o banco de dados");
    }
    //echo "Conectado com sucesso";