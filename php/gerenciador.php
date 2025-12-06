<?php
require_once 'shield.php';
include("conect.php");

$id_usuario = $_SESSION['usuario_id'];

// Consulta estoques do usuário
$sql = "SELECT * FROM estoque WHERE id_usuario = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$estoques = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciador</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-slate-100 flex flex-col">
            <header class="lg:ml-64 lg:p-6 ml-35 p-3">
            <section class="flex flex-row">
                <h1 class="text-5xl font-bold text-slate-800 text-shadow-lg">Gerenciador</h1>
            </section>
            </header>
    <section class="bg-white border-r-1 border-gray-50 w-64 h-screen text-white fixed shadow-lg  md:flex-row min-h-screen">
      <img class="w-30 ml-5" src="../images/logo.png" alt="" />
      <p class="text-xl font-bold ml-5 mt-5 text-sky-950">Menu</p>
      <ul class="ml-5 mt-10 mr-5 flex flex-col gap-5">
        <li>
          <a class="block hover:bg-gray-200 rounded p-2 text-blue-950 font-bold text-md" href="perfil.php">Perfil</a>
        </li>
                <li>
          <a class="block hover:bg-gray-200 rounded p-2 text-blue-950 font-bold text-md" href="dashboard.php"
            >Dashboard</a
          >
        </li>
        <li>
          <a
            class="block hover:bg-gray-200 rounded p-2 text-blue-950 font-bold text-md"
            href="gerenciador.php"
            >Gerenciador</a
          >
        </li>
        <li>
          <a class="block hover:bg-red-200 rounded p-2 text-blue-950 font-bold text-md" href="logout.php">Logout</a>
        </li>
      </ul>
    </section>
    <main class="ml-32 p-3 lg:ml-64 lg:p-6">
            <section class="flex flex-col gap-3 bg-white rounded-xl p-3 lg:p-6 ml-5 shadow-md border border-slate-200 lg:w-210 w-100">
                <h1 class="text-xl font-bold text-blue-950 mt-3 ml-3">Criar novo estoque</h1>
                <form class="text-white text-base font-medium flex flex-col gap-8 ml-3" action="gerar_estoque.php" method="post">
                    <div class="flex flex-col lg:mr-10 sm:mr-5 text-blue-950">
                     <label for="categoria">Categoria:</label>
                    </div>
                     <input class="bg-slate-100 outline-none rounded-lg lg:h-10 sm:h-5 border border-slate-300 lg:px-3 sm:px-1 text-blue-950" type="text" name="cat" id="cat" placeholder="name:">
                    <div>
                        <button class="bg-green-500 text-white rounded hover:bg-green-600 ml-3 w-20 h-10" type="submit">Gerar</button>
                    </div>
                </form>
            </section>
            <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10 ml-10 mt-10">
                <?php while ($estoque = $estoques->fetch_assoc()): ?>
        <div class="bg-white rounded-xl shadow-md p-5 border border-slate-200 hover:shadow-xl transition">
                <h1 class="text-4xl font-bold text-blue-950 text-center">  <?php echo htmlspecialchars($estoque['categoria']) ?></h1>
                <div class="flex flex-col gap-3 m-auto mt-5 justify-center text-center">
            <h3 class="text-xl font-bold text-red-500">
                   gastos: <?php echo htmlspecialchars($estoque['gastos_estoque']) ?>
                </h3>
                 <h3 class="text-xl font-bold text-yellow-500">
                    faturamento: <?php echo htmlspecialchars($estoque['faturamento_estoque']) ?>
                </h3>
                 <h3 class="text-xl font-bold text-green-500">
                   lucro: <?php echo htmlspecialchars($estoque['lucro_estoque']) ?>
                </h3>
                </div>
                <a href="estoque.php?id=<?= $estoque['id_estoque'] ?>">
                 <button class="bg-green-500 hover:bg-green-600 rounded text-base font-bold text-white w-25 h-8 flex justify-center m-auto mt-5">
                    ver mais
                </button>
                </a>
        </div>
                
        <?php endwhile; ?>
            </section>
    </main>
</body>
</html>