<?php
require_once 'shield.php';
include("conect.php");

$id_usuario = $_SESSION['usuario_id'];

//pegando do formulario e jogando no banco

$ct = $_POST["cat"];

//adicionando na tabela
$sql = "INSERT INTO estoque (categoria, id_usuario) VALUES (?, ?)";

if ($ct == "") {
    echo "<script>
        alert('Preencha todos os campos');
        window.location.href = '../paginas/gerenciar.html';
    </script>";
    exit;
}

//traz segurança evitando erros
$stmt = $conexao->prepare($sql);
$stmt->bind_param("si", $ct, $id_usuario);


if($stmt->execute()){
    header("Location: gerenciador.php");
       
    } else {
        echo "<script>alert('Erro ao gerar: " . $stmt->error . "');</script>";
    }
    

    $stmt->close();
    $conexao->close();

?>