<?php
require_once 'shield.php';
include('conect.php');

session_start();
$id_usuario = $_SESSION['usuario_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nc = $_POST["nomec"];
    $desc = $_POST["dc"];

    // Verifique se os dados estão preenchidos
    if (empty($id_usuario) || empty($nc) || empty($desc)) {
        die("Dados incompletos.");
    }

    // Query com WHERE e placeholders
    $sql = "UPDATE usuarios SET nome_comercio = ?, descricao = ? WHERE id_usuario = ?";
    $stmt = $conexao->prepare($sql);

    if (!$stmt) {
        die("Erro ao preparar a query: " . $conexao->error);
    }

    // Bind dos parâmetros
    $stmt->bind_param("sss", $nc, $desc, $id_usuario);

    // Executa a query preparada
    if ($stmt->execute()) {
        echo "<script>
            alert('Perfil atualizado com sucesso!');
            window.location.href = 'perfil.php';
        </script>";
    } else {
        echo "<script>
            alert('Erro ao atualizar perfil: " . addslashes($stmt->error) . "');
            window.location.href = 'editar_p.php';
        </script>";
    }

    $stmt->close();
} else {
    echo "<script>
        alert('Requisição inválida.');
        window.location.href = 'editar_p.php';
    </script>";
}
?>