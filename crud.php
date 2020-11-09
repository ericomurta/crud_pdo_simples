<?php
include "conexao.php";

//Verificar se os dados foram enviados via POST
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id = (isset($_POST["id"]) && $_POST["id"] != null) ? $_POST["id"] : "";
    $nome = (isset($_POST["nome"]) && $_POST["nome"] !=null) ? $_POST["nome"] : "";
    $email = (isset($_POST["email"]) && $_POST["email"] !=null) ? $_POST["email"] : "";
    $celular = (isset($_POST["celular"]) && $_POST["celular"] !=null) ? $_POST["celular"]: "";
}  else if (!isset($id)) {
    // Se não se não foi setado nenhum valor para variável $id
    $id = (isset($_GET["id"]) && $_GET["id"] != null) ? $_GET["id"] : "";
    $nome = NULL;
    $email = NULL;
    $celular = NULL;
}

//create e update
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" && $nome != "") {
    try {
        if ($id != "") {
            $stmt = $conexao->prepare("UPDATE contatos SET nome=?, email=?, celular=? WHERE id = ?");
            $stmt->bindParam(4, $id);
        } else {
            $stmt = $conexao->prepare("INSERT INTO contatos (nome, email, celular) VALUES (?, ?, ?)");
        }
        $stmt->bindParam(1, $nome);
        $stmt->bindParam(2, $email);
        $stmt->bindParam(3, $celular);

        if ($stmt->execute()) {
            if($stmt->rowcount() > 0) {
                echo "Dados Cadastrados com Sucesso";
                $id = NULL;
                $nome = NULL;
                $email = NULL;
                $celular = NULL;
            } else {
                echo "Erro ao tentar efetivar cadastro";
            }
        } else {
                throw new PDOException("Erro: Nao foi possivel executar a declaracao sql");
        }   
    }catch(PDOException $erro){
        echo "Erro: " . $erro->getMessage();
    }
}

//update
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $id != ""){
    try {
        $stmt = $conexao->prepare("SELECT * FROM contatos wHERE id=?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        if($stmt->execute()){
            $rs = $stmt->fetch(PDO::FETCH_OBJ);
            $id = $rs->id;
            $nome = $rs->nome;
            $email = $rs->email;
            $celular = $rs->celular;
        } else {
            throw new PDOException("Erro: Nao foi possivel executar a declaracao sql");
        }
    } catch(PDOException $erro) {
        echo "Erro: ".$erro->getMessage();
    }
}

//delete
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $id !="") {
    try {
        $stmt = $conexao->prepare("DELETE FROM contatos WHERE id = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        if ($stmt->execute()){
            echo "Registro foi Excluido com exito";
            $id = NULL;
        } else {
            throw new PDOException("Erro: Nao foi possivel executar a declaracao sql");   
        }
    } catch(PDOException $erro) {
        echo "Erro:" . $erro->getMessage();
    }
}