<?php
include("conect.php");
session_start();

$nom = $_POST["nome"];
$email = $_POST["email"];
$senha = $_POST["senha"];

if ($nom == "" || $email == "" || $senha == "") {
    echo "<script>
        alert('Preencha todos os campos');
        window.location.href = '../pages/login.html';
    </script>";
    exit;
}

$sql = "SELECT * FROM usuarios WHERE nome = ? AND email = ? AND senha = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("sss", $nom, $email, $senha);
$stmt->execute();
$resultado = $stmt->get_result();

// Verifica se encontrou algum usuário
if ($resultado && $resultado->num_rows > 0) {
    $usuario = $resultado->fetch_assoc(); //  define $usuario corretamente
    $_SESSION['usuario_id'] = $usuario['id_usuario']; //  salva ID na sessão

    header("Location: ../pages/dashboard/dashboard.html");
    exit;
} else {
    echo "<script>
        alert('Login inválido. Verifique seus dados.');
        window.location.href = '../pages/login.html';
    </script>";
}
?>