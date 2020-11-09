<?php

const host = 'localhost';
const dbname = 'crud';
const user = 'root';
const senha = 'camelo170591';

try {
    $conexao = new PDO('mysql: host='.host.'; dbname='.dbname.'', user, senha, [PDO::MYSQL_ATTR_INIT_COMMAND =>  "SET NAMES 'UTF8'"]);
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conexao->exec("set names utf8"); 
} catch(PDOException $erro) {
    echo "Erro na conexao:" .$erro->getMessage(); 
}


