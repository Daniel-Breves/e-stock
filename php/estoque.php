<?php
require_once 'shield.php';
include("conect.php");

$id_usuario = $_SESSION['usuario_id'];
$id_estoque = $_GET['id'];

$sql = "SELECT * FROM estoque WHERE id_estoque = ? AND id_usuario = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("ii", $id_estoque, $id_usuario);
$stmt->execute();
$estoques = $stmt->get_result();
$estoque = $estoques->fetch_assoc();

$sql_two = "SELECT * FROM produtos WHERE id_estoque = ?";
$stmt_two = $conexao->prepare($sql_two);
$stmt_two->bind_param("i", $id_estoque);
$stmt_two->execute();
$produtos = $stmt_two->get_result();

$lista_produtos = [];
while ($row = $produtos->fetch_assoc()) {
    $lista_produtos[] = $row;
}

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
                <h1 class="text-5xl font-bold text-slate-800 text-shadow-lg"><?php echo htmlspecialchars($estoque['categoria']) ?></h1>
                <input class="bg-slate-200 shadow-xl outline-1 outline-gray-300 rounded-md w-70 h-10 text-center fixed ml-230" type="search" name="search" id="srch" placeholder="Search:">
            </section>
            </header>
    <section class="bg-blue-900 w-64 h-screen text-white fixed">
        <img class="w-30 ml-5" src="logo.png" alt="">
   <p class="text-xl font-bold ml-5 mt-5">Menu</p>
   <ul class="ml-5 mt-10 mr-5 flex flex-col gap-5">
    <li><a class="block hover:bg-blue-800 rounded p-2" href="#">Configurações</a></li>
    <li><a class="block hover:bg-blue-800 rounded p-2" href="perfil.php">Perfil</a></li>
    <li><a class="block hover:bg-blue-800 rounded p-2" href="../dashboard/dashboard.html">Dashboard</a></li>
    <li><a class="block hover:bg-blue-800 rounded p-2" href="#">Relatorio</a></li>
    <li><a class="block hover:bg-red-800 rounded p-2" href="#">Logout</a></li>
   </ul>
    </section>
    <main class="ml-64 p-6 flex flex-col">
                    <!--tabela do estoque-->
            <section class="shadow-xl bg-blue-950 text-white rounded-lg w-210 ml-10">
                <h1 class="text-white font-bold text-2xl ml-5">
                    Estoque atual
                </h1>
                <table class="w-200 h-25 text-sm ml-5 mt-5">
                    <thead class="text-left border-b border-slate-700">
                        <tr>
                            <th class="py-2">
                                id
                            </th>
                            <th class="py-2">
                                produto
                            </th>
                            <th class="py-2">
                                preço
                            </th>
                            <th class="py-2">
                                quantidade
                            </th>
                            <th class="py-2">
                                entradas
                            </th>
                            <th class="py-2">
                                saídas
                            </th>
                        </tr>
                    </thead>
                                    <?php foreach ($lista_produtos as $produto): ?>
                    <tbody>
                        <tr class="border-b border-slate-200">
                            <td class="py-2">
                                <?php echo htmlspecialchars($produto['id_produto']) ?>
                            </td>
                            <td class="py-2">
                                           <?php echo htmlspecialchars($produto['nome_produto']) ?>
                            </td>
                            <td class="py-2">
                                           <?php echo htmlspecialchars($produto['preco']) ?>
                            </td>
                            <td class="py-2">
                                           <?php echo htmlspecialchars($produto['quantidade']) ?>
                            </td>
                            <td class="py-2">
                                23
                            </td>
                            <td class="py-2">
                                21
                            </td>
                            <td>
<a class="text-blue-600 hover:underline" 
   href="editar_produto.php?id_produto=<?php echo $produto['id_produto']; ?>&id_estoque=<?php echo $produto['id_estoque']; ?>">
   Editar
</a>


                            <button class="text-red-500 hover:underline ml-2">Excluir</button>
                            </td>
                        </tr>
                    </tbody>
                        <?php endforeach; ?>
                </table>
            </section>
                        <!--adicionar produto-->
            <section class="flex flex-col gap-3 bg-blue-900 rounded-lg h-80 shadow-2xl mt-15">
                <h1 class="text-xl font-bold text-white mt-3 ml-3">Adicionar produto</h1>
                <form class="text-white text-base font-medium flex flex-col gap-8 ml-3" action="create_pr.php" method="post">
                       <input type="hidden" name="id_estoque" value="<?php echo $id_estoque; ?>">
                    <div class="flex flex-col mr-10">
                     <label for="categoria">nome:</label>
                     <input class="bg-blue-950 outline-0 rounded-lg h-10" type="text" name="nome" id="" placeholder="name:">
                    </div>
                <div class="flex flex-row gap-5 mr-10">
                        <div class="flex flex-col">
                    <label for="categoria">Preço:</label>
                     <input class="bg-blue-950 outline-0 rounded-lg w-125 h-10" type="number" name="prec" id="" placeholder="o,oo">
                        </div>
                                                <div class="flex flex-col">
                    <label for="categoria">Quantidade:</label>
                     <input class="bg-blue-950 outline-0 rounded-lg w-125 h-10" type="number" name="quant" id="" placeholder="0">
                        </div>
                </div>
                    <div>
                        <button class="bg-green-500 text-white rounded hover:bg-green-600 ml-3 w-20 h-10" type="submit" value="">adicionar</utton>
                    </div>
                </form>
            </section>
                    <!--colunas de produtos-->
                        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10 ml-10 mt-10">
         <?php foreach ($lista_produtos as $produto): ?>
      <div class="bg-blue-950 rounded-lg mt-10 w-80 h-60 hover:scale-110 delay-50 shadow-xl justify">
                <h1 class="flex text-3xl font-bold text-white justify-center"><?php echo htmlspecialchars($produto['nome_produto']) ?></h1>
            <div class="flex flex-col gap-3 mt-5">
                <h3 class="text-xl font-bold text-red-500 flex justify-center">
                    Preço: <?php echo htmlspecialchars($produto['preco']) ?>
                </h3>
                 <h3 class="text-xl font-bold text-yellow-500 flex justify-center">
                    Quantidade: <?php echo htmlspecialchars($produto['quantidade']) ?>
                </h3>
            </div>
            <div class="flex flex-row gap-3 justify-center">
                <button class="bg-green-500 hover:bg-green-600 rounded text-base font-bold text-white w-25 h-8 mt-8">
                    entrada
                </button>
                <button class="bg-red-500 hover:bg-red-600 rounded text-base font-bold text-white w-25 h-8 mt-8">
                    saida
                </button>
            </div>
          </div>
          <?php endforeach; ?>
            </section>
    </main>
</body>
</html>