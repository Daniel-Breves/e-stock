<?php
require_once 'shield.php';
include('conect.php');

$id_usuario = $_SESSION['usuario_id'];
$usuario = [];

$sql = "SELECT nome, email, telefone, criado_em, nome_comercio, descricao FROM usuarios WHERE id_usuario = ?";
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
    <title>Editar perfil</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  </head>
  <body class="bg-slate-100 flex justify-center">
    <form enctype="multipart/form-data class="bg-white shadow-2xl rounded-xl w-150 h-150 mt-25 flex flex-col gap-5 justify-center" method="post" action="update_p.php">
        <h1 class="font-bold text-blue-700 text-4xl flex justify-center">
            Editar perfil
        </h1>
        <div class="ml-5 mr-5">
          <label class="ml-5 mr-5 text-lg font-semibold text-blue-950" for="foto">Foto:</label>
          <input
            type="file"
            name="foto"
            class="mt-3 bg-white rounded p-2 shadow"
            accept="image/*"
          />
        </div>
        <div class="ml-5 mr-5">
    <label class="ml-5 mr-5 text-lg font-semibold text-blue-950">Nome do comercio:</label><br>
    <input class="border-1 rounded ml-5 mr-5 h-10 w-125" type="text" name="nomec" value="<?php echo htmlspecialchars($usuario['nome_comercio']); ?>" required><br><br>
        </div>
        <div class=" ml-5 mr-5">
            <label class="ml-5 mr-5 text-lg font-semibold text-blue-950">Descrição:</label><br>
    <input class="border-1 rounded h-50 ml-5 mr-5 w-130" type="text" name="dc" value="<?php echo htmlspecialchars($usuario['descricao']); ?>" required><br><br>
        </div>
    <button class="bg-blue-800 text-white shadow-xl rounded-lg hover:bg-blue-700 h-15 w-35 ml-10" type="submit">Salvar Alterações</button>
</form>
  </body>
</html>