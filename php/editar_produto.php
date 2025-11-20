<?php
require_once 'shield.php';
include("conect.php");

$id_usuario = $_SESSION['usuario_id'];
$id_produto = $_GET['id_produto'];
$id_estoque = $_GET['id_estoque'];

$sql = "SELECT * FROM produtos WHERE id_produto = ? AND id_estoque = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("ii", $id_produto, $id_estoque);
$stmt->execute();
$produtos = $stmt->get_result();
$produto = $produtos->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dados</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  </head>
  <body class="bg-slate-100 flex justify-center">
    <form class="bg-white shadow-2xl rounded-xl w-150 h-180 mt-20 flex flex-col justify-center" id="form-dados" method="post" action="update_d.php">
        <h1 class="font-bold text-blue-700 text-4xl flex justify-center mt-5 mb-20">
            Dados pessoais
        </h1>
        <div class="ml-5 mr-5">
    <label class="ml-5 mr-5 text-lg font-semibold text-blue-950">Nome:</label><br>
    <input readonly class="border-1 rounded ml-5 mr-5 h-10 w-125" type="text" name="nome" value="<?php echo htmlspecialchars($produto['nome_produto']); ?>" required><br><br>
        </div>
        <div class="ml-5 mr-5">
    <label class="ml-5 mr-5 text-lg font-semibold text-blue-950">Preço:</label><br>
    <input class="border-1 rounded ml-5 mr-5 h-10 w-125" type="email" name="email" id="email" value="<?php echo htmlspecialchars($produto['preco']); ?>" required>
                   <span class="text-red-500 text-xs erro-msg" id="erro-email"></span><br><br>
        </div>
                <div class="ml-5 mr-5">
    <label class="ml-5 mr-5 text-lg font-semibold text-blue-950">Quantidade:</label><br>
    <input readonly class="border-1 rounded ml-5 mr-5 h-10 w-125" type="number" name="cpf" value="<?php echo htmlspecialchars($produto['quantidade']); ?>"
        </div>
        <div class="ml-5 mr-5">
    <label class=" mr-5 text-lg font-semibold text-blue-950">Entradas:</label><br>
    <input class="border-1 rounded mr-5 h-10 w-125" type="number" name="tel" id="tel" value="23" required>
                   <span class="text-red-500 text-xs erro-msg" id="erro-tel"></span><br><br>
        </div>
                <div class=" mr-5">
    <label class="ml-5 mr-5 text-lg font-semibold text-blue-950">Saídas:</label><br>
    <input class="border-1 rounded ml-5 mr-5 h-10 w-125" type="number" name="cep" id="cep" value="21" required>
                   <span class="text-red-500 text-xs erro-msg" id="erro-cep"></span><br><br>
        </div>
        <div class="ml-5">
    <button class="bg-blue-800 text-white shadow-xl rounded-lg hover:bg-blue-700 h-10 w-35" type="submit">Salvar Alterações</button>
            <a class="text-blue-700 font-medium hover:text-blue-800 ml-3" href="perfil.php">voltar</a>
        </div>
</form>
     <script src="../js/dados.js"></script>
  </body>
</html>