<?php
require_once 'shield.php';
include("conect.php");

$id_usuario = $_SESSION['usuario_id'];
$id_estoque = $_GET['id_estoque'];
$id_produto = $_GET['id_produto'];
$sql = "DELETE FROM produtos WHERE id_produto = $id_produto";

if ($conexao->query($sql) === TRUE) {
             header("Location: estoque.php?id=$id_estoque");
} else {
    echo "<script>
        alert('Erro ao excluir produto: " . addslashes($conexao->error) . "');
    </script>";
                header("Location: estoque.php?id=$id_estoque");
}
?>