<?php
require_once 'shield.php';
include("conect.php");

$id_estoque = $_GET["id_estoque"];
$id_produto = $_GET["id_produto"];
$tipo = $_GET["tipo"];
$qt_mov = 1;

$sql_select = "SELECT quantidade, entrada, saida FROM produtos WHERE id_produto = ? AND id_estoque = ?";
$stmt_select = $conexao->prepare($sql_select);
$stmt_select->bind_param("ii", $id_produto, $id_estoque);
$stmt_select->execute();
$produtos_result = $stmt_select->get_result();
$produto = $produtos_result->fetch_assoc();
$stmt_select->close();

if (!$produto) {
    die("Produto não encontrado.");
}

$qt = $produto["quantidade"];
$entradas = $produto["entrada"];
$saidas = $produto["saida"];

$new_qt = $qt;
$new_ent = $entradas;
$new_sai = $saidas;

if ($tipo == 'entrada') {
    $new_qt += $qt_mov;
    $new_ent += $qt_mov;
} elseif ($tipo == 'saida') {
    if ($qt >= $qt_mov) {
    $new_qt -= $qt_mov;
    $new_sai += $qt_mov;
    }
}else {
        echo "<script>alert('Estoque insuficiente!'); window.location.href='estoque.php?id=$id_estoque';</script>";
        exit;
    }

$sql_update = "UPDATE produtos SET quantidade = ?, entrada = ?, saida = ? WHERE id_produto = ? AND id_estoque = ?";
$stmt_update = $conexao->prepare($sql_update);
$stmt_update->bind_param("iiiii", $new_qt, $new_ent, $new_sai, $id_produto, $id_estoque);


if($stmt_update->execute()){
    header("Location: estoque.php?id=$id_estoque");
    exit;
       
    } else {
        echo "<script>alert('Erro atualizar estoque: " . $stmt->error . "');</script>";
    }
    

    $stmt_update->close();
    $conexao->close();

?>