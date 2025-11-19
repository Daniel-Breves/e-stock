<?php
require_once 'shield.php';
include('conect.php');


$id_usuario = $_SESSION['usuario_id'];

$sql = "DELETE FROM usuarios WHERE id_usuario = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();

session_unset();      // Remove todas as variáveis da sessão
session_destroy();

header("Location: ../inicial.html");
exit;
?>