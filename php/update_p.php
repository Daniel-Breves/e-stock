<?php
require_once 'shield.php';
include('conect.php');


$id_usuario = $_SESSION['usuario_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nc = $_POST["nomec"];
    $desc = $_POST["dc"];
    $arquivo = $_FILES['foto'];


    // Verifique se os dados estão preenchidos
    if (empty($id_usuario) || empty($nc) || empty($desc)) {
        die("Dados incompletos.");
    }

    // Caminho padrão da imagem
    $caminhoFoto = null;

    // Se o usuário enviou uma imagem
    if ($arquivo['error'] === UPLOAD_ERR_OK) {
        $nomeTemporario = $arquivo['tmp_name'];
        $nomeOriginal = basename($arquivo['name']);
        $extensao = pathinfo($nomeOriginal, PATHINFO_EXTENSION);

        // Gera nome único
        $novoNome = uniqid('foto_', true) . '.' . $extensao;
        $destino = __DIR__ . '/../uploads/' . $novoNome;

        // Move o arquivo
        if (move_uploaded_file($nomeTemporario, $destino)) {
        $caminhoFoto = 'uploads/' . $novoNome;
        } else {
            die("Erro ao mover o arquivo.");
        }
    }


    // Query com WHERE e placeholders
if ($caminhoFoto) {
    $sql = "UPDATE usuarios SET foto = ?, nome_comercio = ?, descricao = ? WHERE id_usuario = ?";
    $stmt = $conexao->prepare($sql);
    if (!$stmt) {
        die("Erro ao preparar a query: " . $conexao->error);
    }
    $stmt->bind_param("ssss", $caminhoFoto, $nc, $desc, $id_usuario);
} else {
    $sql = "UPDATE usuarios SET nome_comercio = ?, descricao = ? WHERE id_usuario = ?";
    $stmt = $conexao->prepare($sql);
    if (!$stmt) {
        die("Erro ao preparar a query: " . $conexao->error);
    }
    $stmt->bind_param("sss", $nc, $desc, $id_usuario);
}

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