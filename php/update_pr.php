<?php
require_once 'shield.php';
include('conect.php');

$id_usuario = $_SESSION['usuario_id'];
$id_produto = $_POST['id_produto'];
$id_estoque = $_POST['id_estoque'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nm = $_POST["nome"];
    $ct = $_POST["custo"];
    $prc = $_POST["preco"];
    $qnt = $_POST["quanti"];
    $ent = $_POST["entrada"];
    $sai = $_POST["saida"];

    // Verifique se os dados estão preenchidos
    if (empty($id_usuario) || empty($nm) || empty($prc)) {
        die("O produto precisa ter um nome e um valor!");
    }

    // Query com WHERE e placeholders
    $sql = "UPDATE produtos SET nome_produto = ?, custo = ?, preco = ?, quantidade = ?, entrada = ?, saida = ? WHERE id_produto = ?";
    $stmt = $conexao->prepare($sql);

    if (!$stmt) {
        die("Erro ao preparar a query: " . $conexao->error);
    }

    // Bind dos parâmetros
    $stmt->bind_param("sddiiii", $nm, $ct, $prc, $qnt, $ent, $sai, $id_produto);

    // Executa a query preparada
    if ($stmt->execute()) {
        echo "<script>
            alert('Produto atualizado com sucesso!');
        </script>";
            header("Location: estoque.php?id=$id_estoque");
    exit;
    } else {
echo "<script>
    alert('Erro ao atualizar produto: " . addslashes($stmt->error) . "');
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