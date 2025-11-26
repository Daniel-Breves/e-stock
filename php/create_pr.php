<?php
require_once 'shield.php';
include("conect.php");

$id_estoque = $_POST["id_estoque"];

//pegando do formulario e jogando no banco

$nm = $_POST["nome"];
$ct = $_POST["custo"];
$price = $_POST["prec"];
$qt = $_POST["quant"];

//adicionando na tabela
$sql = "INSERT INTO produtos (nome_produto, custo, preco, quantidade, id_estoque) VALUES (?, ?, ?, ?, ?)";

if ($nm == "" || $ct == "" || $price == "" || $qt == "") {
    echo "<script>
        alert('Preencha todos os campos');
        window.location.href = 'estoque.php?id=$id_estoque';
    </script>";
    exit;
}

//traz segurança evitando erros
$stmt = $conexao->prepare($sql);
$stmt->bind_param("sddii", $nm, $ct, $price, $qt, $id_estoque);


if($stmt->execute()){
    header("Location: estoque.php?id=$id_estoque");
       
    } else {
        echo "<script>alert('Erro ao gerar: " . $stmt->error . "');</script>";
    }
    

    $stmt->close();
    $conexao->close();

?>