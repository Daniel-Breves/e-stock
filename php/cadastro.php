<?php
include("conect.php");

//pegando do formulario e jogando no banco

$nom = $_POST["name"];
$email = $_POST["email"];
$cpf = $_POST["cpf"];
$tel = $_POST["tel"];
$nc = $_POST["nome_c"];
$cep = $_POST["cep"];
$senha = $_POST["senha"];

//adicionando na tabela
$sql = "INSERT INTO usuarios (nome, email, cpf, telefone, nome_comercio, cep, senha)
        VALUES (?,?,?,?,?,?,?)";

if ($nom == "" || $email == "" || $cpf == "" || $tel == "" || $nc == "" || $cep == "" || $senha == "") {
    echo "<script>
        alert('Preencha todos os campos');
        window.location.href = '../paginas/gerenciar.html';
    </script>";
    exit;
}

//traz segurança evitando erros
$stmt = $conexao->prepare($sql);
$stmt->bind_param("sssssss",$nom, $email, $cpf, $tel, $nc, $cep, $senha);


if($stmt->execute()){
    header("Location: ../pages/login.html");
       
    } else {
        echo "<script>alert('Erro ao cadastrar: " . $stmt->error . "');</script>";
    }
    

    $stmt->close();
    $conexao->close();

?>