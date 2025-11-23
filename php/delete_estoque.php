<?php
require_once 'shield.php';
include("conect.php");

$id_usuario = $_SESSION['usuario_id'];
$id_estoque = $_GET['id'];
$sql = "DELETE FROM estoque WHERE id_estoque = $id_estoque";

if ($conexao->query($sql) === TRUE) {
             header("Location: gerenciador.php");
} else {
    echo "<script>
        alert('Erro ao excluir produto: " . addslashes($conexao->error) . "');
    </script>";
                header("Location: gerenciador.php");
}
?>