<?php
require_once 'shield.php';
include('conect.php');

$id_usuario = $_SESSION['usuario_id'];
$usuario = [];

$sql = "SELECT * FROM usuarios WHERE id_usuario = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("s", $id_usuario);
$stmt->execute();
$resultado = $stmt->get_result();

$usuario = $resultado->fetch_assoc();

//lógica de selecionar produto com mais saida (chat resolver mandar de cara sem eu pedir, mas eu to entendendo e vou estudando)
//sempre peço p nao mandar nada, mas dps de um tempo escapa
$sql_top = "SELECT p.nome_produto, p.saida, p.faturamento, p.lucro
            FROM produtos p
            JOIN estoque e ON p.id_estoque = e.id_estoque
            WHERE e.id_usuario = ?
            ORDER BY p.saida DESC
            LIMIT 1";

$stmt_top = $conexao->prepare($sql_top);
$stmt_top->bind_param("i", $id_usuario);
$stmt_top->execute();
$top_produto = $stmt_top->get_result()->fetch_assoc();

//a mesma coisa(depois eu mudo tudo para entender cada parte do codigo e deixo u comentario abaixo)
$sql_faltando = "SELECT p.nome_produto, p.quantidade
                 FROM produtos p
                 JOIN estoque e ON p.id_estoque = e.id_estoque
                 WHERE e.id_usuario = ?
                 AND p.quantidade <= 0
                 LIMIT 1";

$stmt_faltando = $conexao->prepare($sql_faltando);
$stmt_faltando->bind_param("i", $id_usuario);
$stmt_faltando->execute();
$produto_faltando = $stmt_faltando->get_result()->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  </head>
  <body class="bg-slate-100 flex">
    <section class="bg-blue-800 w-64 h-screen text-white fixed shadow-lg">
      <img class="w-30 ml-5" src="../images/logo.png" alt="" />
      <p class="text-xl font-bold ml-5 mt-5">Menu</p>
      <ul class="ml-5 mt-10 mr-5 flex flex-col gap-5">
        <li>
          <a class="block hover:bg-blue-900 rounded p-2" href="#"
            >Configurações</a
          >
        </li>
        <li>
          <a class="block hover:bg-blue-900 rounded p-2" href="perfil.php">Perfil</a>
        </li>
        <li>
          <a
            class="block hover:bg-blue-900 rounded p-2"
            href="gerenciador.php"
            >Gerenciador</a
          >
        </li>
        <li>
          <a class="block hover:bg-blue-900 rounded p-2" href="#">Relatorio</a>
        </li>
        <li>
          <a class="block hover:bg-red-900 rounded p-2" href="#">Logout</a>
        </li>
      </ul>
    </section>
    <main class="ml-64 p-6 flex flex-col">
      <section class="mb-5">
        <div>
          <h1 class="text-5xl font-bold">Dashboard</h1>
        </div>
        <div class="">

        </div>
      </section>
      <section class="bg-white p-6 rounded-xl shadow-lg ml-5">
        <canvas class="w-235 h-100" id="meuGrafico"></canvas>
        <select class="bg-gray-50 h-10 border-1 border-gray-100 rounded-lg shadow-xl">
   <option value="financeiro">Visão financeira</option>
   <option disabled>Comparar estoques (em breve)</option>
   <option disabled>Comparar produtos (em breve)</option>
   <option disabled>Desempenho mensal (em breve)</option>
       </select>
      </section>
      <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10 ml-10 mt-3">
    <div class="bg-white rounded-xl shadow-md p-5 border border-slate-200 hover:shadow-xl transition flex flex-col gap-3">
    <h2 class="text-xl font-bold text-center">Produto com mais saída</h2>
    <p class="text-gray-600 ml-5">Nome: <?php echo $top_produto['nome_produto']; ?></p>
    <p class="text-gray-600 ml-5">Saídas: <?php echo $top_produto['saida']; ?></p>
    </div>

     <div class="bg-white rounded-xl shadow-md p-5 border border-slate-200 hover:shadow-xl transition flex flex-col gap-3">
    <h2 class="text-xl font-bold text-center">Estoque com mais faturamento</h2>
    <p class="text-gray-600 ml-5">Estoque: <?php echo $top_produto['nome_produto']; ?></p>
    <p class="text-gray-600 ml-5">Lucro: <?php echo $top_produto['saida']; ?></p>
    </div>

     <div class="bg-white rounded-xl shadow-md p-5 border border-slate-200 hover:shadow-xl transition flex flex-col gap-3">
     <h2 class="text-xl font-bold text-center">Produto em Falta</h2>

    <?php if ($produto_faltando): ?>
        <p class="mt-3 text-red-600 font-semibold text-xl text-center">
            <?= $produto_faltando['nome_produto']; ?>
        </p>
    <?php else: ?>
        <p class="mt-3 text-green-600 text-lg text-center">Nenhum produto em falta 🎉</p>
    <?php endif; ?>
    </div>
      </section>
    </main>
    <script>
const ctx = document.getElementById('meuGrafico');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Lucro', 'Faturamento', 'Gastos'],
        datasets: [{
            label: 'Situação',
            data: [
                <?= $usuario['lucro_total'] ?>,
                <?= $usuario['faturamento_total'] ?>,
                <?= $usuario['gasto_total'] ?>
            ],
            backgroundColor: ['#4ade80', '#60a5fa', '#f87171'],
            borderColor: ['#15803d', '#1e40af', '#b91c1c'],
            borderWidth: 1,
            borderRadius: 5,
            maxBarThickness: 200
        }]
    },
    options: {
        plugins: {
            title: {
                display: true,
                text: 'Visão Financeira Geral',
                font: { size: 20, weight: 'bold' },
                color: '#0f172a',
                padding: { top: 10, bottom: 20 }
            },
            tooltip: {
                backgroundColor: 'rgba(30, 41, 59, 0.8)',
                borderColor: '#1e293b',
                borderWidth: 1,
                padding: 12,
                titleFont: { size: 16 },
                bodyFont: { size: 14 }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    color: '#334155',
                    font: { size: 14 }
                }
            },
            x: {
                ticks: {
                    color: '#334155',
                    font: { size: 14 }
                }
            }
        }
    }
});

</script>
  </body>
</html>
