<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    // Redireciona para o login se não estiver logado
    header("Location: ../pages/login.html");
    exit;
}
?>