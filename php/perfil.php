<?php
require_once 'shield.php';
include('conect.php');

$id_usuario = $_SESSION['usuario_id'];
$usuario = [];

$sql = "SELECT nome, email, telefone, criado_em, nome_comercio, descricao, foto FROM usuarios WHERE id_usuario = ?";
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
    <title><?php echo htmlspecialchars($usuario['nome']); ?></title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  </head>
  <body class="bg-slate-100 flex">
    <section class="bg-blue-900 w-64 h-screen text-white fixed">
      <img class="w-30 ml-5" src="../images/logo.png" alt="" />
      <p class="text-xl font-bold ml-5 mt-5">Menu</p>
      <ul class="ml-5 mt-10 mr-5 flex flex-col gap-5">
        <li>
          <a class="block hover:bg-blue-800 rounded p-2" href="#"
            >Configurações</a
          >
        </li>
        <li>
          <a class="block hover:bg-blue-800 rounded p-2" href="../pages/dashboard/dashboard.html"
            >Dashboard</a
          >
        </li>
        <li>
          <a
            class="block hover:bg-blue-800 rounded p-2"
            href="gerenciador.php"
            >Gerenciador</a
          >
        </li>
        <li>
          <a class="block hover:bg-blue-800 rounded p-2" href="#">Relatorio</a>
        </li>
        <li>
          <a class="block hover:bg-red-800 rounded p-2" href="logout.php">Logout</a>
        </li>
      </ul>
    </section>
    <main class="ml-64 p-6">
      <section class=" flex flex-row gap-5">
        <div class="flex flex-col items-center">
  <img
  src="<?php echo '/e-stock/' . ($usuario['foto'] ?? 'images/default.jpeg'); ?>"
  class="w-40 h-40 rounded-full bg-gray-700 shadow-md mb-5"
/>
        </div>
        <h1 class="text-5xl text-slate-900 font-bold mt-15"><?php echo htmlspecialchars($usuario['nome']); ?></h1>
        <a href="dados.php">
           <button class="ml-40 mt-15 bg-gray-200 hover:bg-gray-300 shadow-2xl w-30 h-10 rounded-lg mt-5 border-1 border-gray-400">
            dados
         </button>
        </a>
      </section>
      <section>
        <h2 class="text-3xl text-slate-900 font-bold mt-5">- <?php echo htmlspecialchars($usuario['nome_comercio']); ?></h2>
        <h3 class="mt-5">
 <?php echo htmlspecialchars($usuario['descricao']); ?>
</h3>
        <a href="editar_p.php">
          <button class="bg-gray-200 hover:bg-gray-300 shadow-2xl w-30 h-10 rounded-lg mt-5 border-1 border-gray-400">
            editar perfil
         </button>
        </a>
        <form action="delete_account.php" method="POST">
    <input type="hidden" name="confirm" value="yes">
    <button class="text-blue-500 hover:text-red-600 font-medium" type="submit" class="botao-excluir">
        Excluir minha conta
    </button>
</form>
      </section>
    </main>
  </body>
</html>