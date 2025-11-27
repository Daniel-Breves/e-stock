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
    $saidas = (float)$row['saida'];
    $preco = (float)$row['preco'];
    $entradas = (float)$row['entrada'];
    $custo = (float)$row['custo'];

    $row['lucro'] = ($saidas * $preco) - ($entradas * $custo);


    $lista_produtos[] = $row;
}

//$lucro = ($lista_produtos['saida']*$lista_produtos['preco']) - ($lista_produtos['entrada']*$lista_produtos['custo']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciador</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<!-- modal -->
<div id="modalEditarEstoque" 
     class="fixed inset-0 bg-black/50 flex items-center justify-center hidden">
    
    <div class="bg-white w-96 p-6 rounded-xl shadow-xl">
        <h2 class="text-2xl font-bold text-slate-800 mb-4">Editar Estoque</h2>

        <form action="update_estoque.php" method="POST" class="flex flex-col gap-4">
            
            <input type="hidden" name="id_estoque" value="<?php echo $id_estoque; ?>">

            <label class="text-blue-950 font-semibold">Nome do estoque:</label>
            <input 
                type="text" 
                name="categoria" 
                value="<?php echo htmlspecialchars($estoque['categoria']) ?>"
                class="bg-slate-100 border border-slate-300 rounded-lg px-3 h-10"
            >

            <button 
                class="bg-green-600 hover:bg-green-700 text-white rounded-lg h-10 font-bold">
                Salvar alterações
            </button>
        </form>

        <button id="fecharModal" 
                class="mt-4 text-red-600 font-bold hover:underline">
            Cancelar
        </button>
    </div>
</div>
<body class="bg-slate-100 flex flex-col">
            <header class="ml-64 p-6">
            <section class="flex flex-row gap-50">
                <h1 class="text-5xl font-bold text-slate-800 text-shadow-lg"><?php echo htmlspecialchars($estoque['categoria']) ?></h1>
                <div>
<button id="btnEditarEstoque" 
class="bg-blue-500 text-white font-bold rounded hover:bg-blue-600 ml-3 w-35 h-10">
    editar estoque
</button>

            <a href="delete_estoque.php?id=<?php echo $estoque['id_estoque']; ?>">
                <button class="bg-red-500 text-white font-bold rounded hover:bg-red-600 ml-3 w-35 h-10">excluir estoque</button>
            </a>
                </div>
                <input class="bg-slate-200 shadow-xl outline-1 outline-gray-300 rounded-md w-70 h-10 text-center fixed ml-230" type="search" name="search" id="srch" placeholder="Search:">
            </section>
            </header>
    <section class="bg-blue-800 w-64 h-screen text-white fixed shadow-lg">
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
            <section class="shadow-lg bg-white text-slate-800 rounded-xl p-5 w-210 ml-10">
                <h1 class="font-bold text-2xl ml-5">
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
                            <th>
                                custo
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
                            <th class="py-2">
                                lucro
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
                                           <?php echo htmlspecialchars($produto['custo']) ?>
                            </td>
                            <td class="py-2">
                                           <?php echo htmlspecialchars($produto['preco']) ?>
                            </td>
                            <td class="py-2">
                                           <?php echo htmlspecialchars($produto['quantidade']) ?>
                            </td>
                            <td class="py-2">
                                 <?php echo htmlspecialchars($produto['entrada']) ?>
                            </td>
                            <td class="py-2">
                                 <?php echo htmlspecialchars($produto['saida']) ?>
                            </td>
                            <td class="py-2 font-bold <?php echo $produto['lucro'] >= 0 ? 'text-green-600' : 'text-red-600'; ?>">
                                     <?php echo htmlspecialchars($produto['lucro']) ?>
                            </td>
                            <td>
<a class="text-blue-600 hover:underline" 
   href="editar_produto.php?id_produto=<?php echo $produto['id_produto']; ?>&id_estoque=<?php echo $produto['id_estoque']; ?>">
   Editar
</a>
<a href="delete_pr.php?id_produto=<?php echo $produto['id_produto']; ?>&id_estoque=<?php echo $produto['id_estoque']; ?>">
     <button class="text-red-500 hover:underline ml-2">Excluir</button>
</a>
                            </td>
                        </tr>
                    </tbody>
                        <?php endforeach; ?>
                </table>
            </section>
                        <!--adicionar produto-->
            <section class="flex flex-col gap-3 bg-white rounded-xl p-6 shadow-md border border-slate-200 w-275 mt-5">
                <h1 class="text-xl font-bold text-blue-950 mt-3 ml-3">Adicionar produto</h1>
                <form class="text-white text-base font-medium flex flex-col gap-8 ml-3" action="create_pr.php" method="post">
                       <input type="hidden" name="id_estoque" value="<?php echo $id_estoque; ?>">
                       <div class="flex flex-row">
                        <div class="flex flex-col mr-10">
                     <label class="text-blue-950" for="categoria">nome:</label>
                     <input class="bg-slate-100 outline-none rounded-lg h-10 border border-slate-300 w-125 px-3 text-blue-950" type="text" name="nome" id="" placeholder="name:">
                    </div>
                    <div>
                        <label class="text-blue-950" for="custo">custo:</label>
                        <input class="bg-slate-100 outline-none rounded-lg h-10 border border-slate-300 w-125 px-3 text-blue-950" type="number" name="custo"   step="0.01" min="0" placeholder="0,00">
                    </div>

                       </div>
                    
                <div class="flex flex-row gap-5 mr-10">
                        <div class="flex flex-col">
                    <label class="text-blue-950" for="preço">Preço:</label>
                     <input class="bg-slate-100 outline-none rounded-lg h-10 border border-slate-300 w-125 px-3 text-blue-950" type="number" name="prec"  step="0.01" min="0" placeholder="o,oo">
                        </div>
                                                <div class="flex flex-col">
                    <label class="text-blue-950" for="quantidade">Quantidade:</label>
                     <input class="bg-slate-100 outline-none rounded-lg h-10 w-125 border border-slate-300 px-3 text-blue-950" type="number" name="quant" id="" placeholder="0">
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
      <div class="bg-white rounded-xl shadow-md p-5 border border-slate-200 hover:shadow-xl transition">
                <h1 class="flex text-3xl font-bold text-blue-950 justify-center"><?php echo htmlspecialchars($produto['nome_produto']) ?></h1>
            <div class="flex flex-col gap-3 mt-5">
                <h3 class="text-xl font-bold text-red-500 flex justify-center">
                    Preço: <?php echo htmlspecialchars($produto['preco']) ?>
                </h3>
                 <h3 class="text-xl font-bold text-yellow-500 flex justify-center">
                    Quantidade: <?php echo htmlspecialchars($produto['quantidade']) ?>
                </h3>
            </div>
            <div class="flex flex-row gap-3 justify-center">
            <a href="mov.php?tipo=entrada&id_produto=<?php echo $produto['id_produto']; ?>&id_estoque=<?php echo $id_estoque; ?>">
          <button name="entrada" class="bg-green-500 hover:bg-green-600 rounded text-base font-bold text-white w-25 h-8 mt-8">
                    entrada
                </button>
         </a>
         <a href="mov.php?tipo=saida&id_produto=<?php echo $produto['id_produto']; ?>&id_estoque=<?php echo $id_estoque; ?>">
                <button name="saida" class="bg-red-500 hover:bg-red-600 rounded text-base font-bold text-white w-25 h-8 mt-8">
                    saida
                </button>
         </a>
            </div>
          </div>
          <?php endforeach; ?>
            </section>
    </main>
    <script>
document.getElementById("btnEditarEstoque").addEventListener("click", () => {
    document.getElementById("modalEditarEstoque").classList.remove("hidden");
});

document.getElementById("fecharModal").addEventListener("click", () => {
    document.getElementById("modalEditarEstoque").classList.add("hidden");
});
</script>

</body>
</html>