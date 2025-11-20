<?php
require_once 'shield.php';
include("conect.php");

$id_usuario = $_SESSION['usuario_id'];

// Consulta estoques do usuário
$sql = "SELECT id_estoque, categoria FROM estoque WHERE id_usuario = ?";
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
            <header class="ml-64 p-6">
            <section class="flex flex-row gap-150">
                <h1 class="text-5xl font-bold text-slate-800 text-shadow-lg">Gerenciador</h1>
                <input class="bg-slate-200 shadow-xl outline-1 outline-gray-300 rounded-md w-70 h-10 text-center fixed ml-230" type="search" name="search" id="srch" placeholder="Search:">
            </section>
            </header>
    <section class="bg-blue-800 w-64 h-screen text-white fixed shadow-lg">
        <img class="w-30 ml-5" src="logo.png" alt="">
   <p class="text-xl font-bold ml-5 mt-5">Menu</p>
   <ul class="ml-5 mt-10 mr-5 flex flex-col gap-5">
    <li><a class="block hover:bg-blue-900 rounded p-2" href="#">Configurações</a></li>
    <li><a class="block hover:bg-blue-900 rounded p-2" href="perfil.php">Perfil</a></li>
    <li><a class="block hover:bg-blue-900 rounded p-2" href="../pages/dashboard/dashboard.html">Dashboard</a></li>
    <li><a class="block hover:bg-blue-900 rounded p-2" href="#">Relatorio</a></li>
    <li><a class="block hover:bg-red-900 rounded p-2" href="#">Logout</a></li>
   </ul>
    </section>
    <main class="ml-64 p-6">
            <section class="flex flex-col gap-3 bg-white rounded-xl p-6 shadow-md border border-slate-200 w-210">
                <h1 class="text-xl font-bold text-blue-950 mt-3 ml-3">Criar novo estoque</h1>
                <form class="text-white text-base font-medium flex flex-col gap-8 ml-3" action="gerar_estoque.php" method="post">
                    <div class="flex flex-col mr-10 text-blue-950">
                     <label for="categoria">Categoria:</label>
                    </div>
                     <input class="bg-slate-100 outline-none rounded-lg h-10 border border-slate-300 px-3 text-blue-950" type="text" name="cat" id="cat" placeholder="name:">
                    <div>
                        <button class="bg-green-500 text-white rounded hover:bg-green-600 ml-3 w-20 h-10" type="submit">Gerar</button>
                    </div>
                </form>
            </section>
            <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10 ml-10 mt-10">
                <?php while ($estoque = $estoques->fetch_assoc()): ?>
        <div class="bg-white rounded-xl shadow-md p-5 border border-slate-200 hover:shadow-xl transition">
                <h1 class="text-4xl font-bold text-blue-950 ml-25">  <?php echo htmlspecialchars($estoque['categoria']) ?></h1>
                <div class="flex flex-col gap-3 m-auto ml-25 mt-5">
            <h3 class="text-xl font-bold text-red-500">
                    produto 1
                </h3>
                 <h3 class="text-xl font-bold text-yellow-500">
                    produto 2
                </h3>
                 <h3 class="text-xl font-bold text-green-500">
                    produto 3
                </h3>
                </div>
                <a href="estoque.php?id=<?= $estoque['id_estoque'] ?>">
                 <button class="bg-green-500 hover:bg-green-600 rounded text-base font-bold text-white w-25 h-8 ml-25 mt-8">
                    ver mais
                </button>
                </a>
        </div>
                
        <?php endwhile; ?>
            </section>
    </main>
</body>
</html>