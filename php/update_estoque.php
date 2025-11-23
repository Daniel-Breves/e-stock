<?php
require_once 'shield.php';
include('conect.php');

$id_usuario = $_SESSION['usuario_id'];
$id_produto = $_POST['id_produto'];
$id_estoque = $_POST['id_estoque'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nm = $_POST["categoria"];
    $prc = $_POST["preco"];
    $qnt = $_POST["quanti"];
    $ent = $_POST["entrada"];
    $sai = $_POST["saida"];

    // Verifique se os dados estão preenchidos
    if (empty($id_usuario) || empty($nm)) {
        die("O estoque precisa ter um nome e um valor!");
    }

    // Query com WHERE e placeholders
    $sql = "UPDATE estoque SET categoria = ? WHERE id_estoque = ?";
    $stmt = $conexao->prepare($sql);

    if (!$stmt) {
        die("Erro ao preparar a query: " . $conexao->error);
    }

    // Bind dos parâmetros
    $stmt->bind_param("si", $nm, $id_estoque);

    // Executa a query preparada
    if ($stmt->execute()) {
        echo "<script>
            alert('Estoque atualizado com sucesso!');
        </script>";
            header("Location: estoque.php?id=$id_estoque");
    exit;
    } else {
echo "<script>
    alert('Erro ao atualizar estoque: " . addslashes($stmt->error) . "');
</script>";
    header("Location: estoque.php?id_estoque=$id_estoque");
    exit;

    }

    $stmt->close();
} else {
echo "<script>
    alert('Requisição inválida.');
    window.location.href = 'editar_produto.php?id_produto=$id_produto&id_estoque=$id_estoque&usuario_id=$id_usuario';
</script>";
}

?>