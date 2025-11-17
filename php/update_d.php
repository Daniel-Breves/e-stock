<?php
require_once 'shield.php';
include('conect.php');

session_start();
$id_usuario = $_SESSION['usuario_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $em = $_POST["email"];
    $tel = $_POST["tel"];
    $cep = $_POST["cep"];

    // Verifique se os dados estão preenchidos
    if (empty($id_usuario) || empty($em) || empty($tel) || empty($cep)) {
        die("Dados incompletos.");
    }

    // Query com WHERE e placeholders
    $sql = "UPDATE usuarios SET email = ?, telefone = ?, cep = ? WHERE id_usuario = ?";
    $stmt = $conexao->prepare($sql);

    if (!$stmt) {
        die("Erro ao preparar a query: " . $conexao->error);
    }

    // Bind dos parâmetros
    $stmt->bind_param("ssss", $em, $tel, $cep, $id_usuario);

    // Executa a query preparada
    if ($stmt->execute()) {
        echo "<script>
            alert('Dados atualizados com sucesso!');
            window.location.href = 'perfil.php';
        </script>";
    } else {
        echo "<script>
            alert('Erro ao atualizar dados: " . addslashes($stmt->error) . "');
            window.location.href = 'dados.php';
        </script>";
    }

    $stmt->close();
} else {
    echo "<script>
        alert('Requisição inválida.');
        window.location.href = 'dados.php';
    </script>";
}
?>