<?php
require_once 'shield.php';
include('conect.php');

$id_usuario = $_SESSION['usuario_id'];
$usuario = [];

$sql = "SELECT nome, email, cpf, cep, telefone, criado_em, nome_comercio, descricao FROM usuarios WHERE id_usuario = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("s", $id_usuario);
$stmt->execute();
$resultado = $stmt->get_result();

$usuario = $resultado->fetch_assoc();

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
    <input readonly class="border-1 rounded ml-5 mr-5 h-10 w-125" type="text" name="nome" value="<?php echo htmlspecialchars($usuario['nome']); ?>" required><br><br>
        </div>
        <div class="ml-5 mr-5">
    <label class="ml-5 mr-5 text-lg font-semibold text-blue-950">Email:</label><br>
    <input class="border-1 rounded ml-5 mr-5 h-10 w-125" type="email" name="email" id="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" required>
                   <span class="text-red-500 text-xs erro-msg" id="erro-email"></span><br><br>
        </div>
                <div class="ml-5 mr-5">
    <label class="ml-5 mr-5 text-lg font-semibold text-blue-950">Cpf:</label><br>
    <input readonly class="border-1 rounded ml-5 mr-5 h-10 w-125" type="number" name="cpf" value="<?php echo htmlspecialchars($usuario['cpf']); ?>" required><br><br>
        </div>
        <div class="ml-5 mr-5">
    <label class="ml-5 mr-5 text-lg font-semibold text-blue-950">Telefone:</label><br>
    <input class="border-1 rounded ml-5 mr-5 h-10 w-125" type="number" name="tel" id="tel" value="<?php echo htmlspecialchars($usuario['telefone']); ?>" required>
                   <span class="text-red-500 text-xs erro-msg" id="erro-tel"></span><br><br>
        </div>
                <div class="ml-5 mr-5">
    <label class="ml-5 mr-5 text-lg font-semibold text-blue-950">Cep:</label><br>
    <input class="border-1 rounded ml-5 mr-5 h-10 w-125" type="number" name="cep" id="cep" value="<?php echo htmlspecialchars($usuario['cep']); ?>" required>
                   <span class="text-red-500 text-xs erro-msg" id="erro-cep"></span><br><br>
        </div>
        <div class="ml-10">
    <button class="bg-blue-800 text-white shadow-xl rounded-lg hover:bg-blue-700 h-10 w-35" type="submit">Salvar Alterações</button>
            <a class="text-blue-700 font-medium hover:text-blue-800 ml-3" href="perfil.php">voltar</a>
        </div>
</form>
     <script src="../js/dados.js"></script>
  </body>
</html>