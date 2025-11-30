<?php
require_once 'shield.php';
require '../fpdf/fpdf.php';
include('conect.php');

$id_usuario = $_SESSION['usuario_id'];
$id_estoque = isset($_GET['id']) ? $_GET['id'] : null;
$data = date('d/m/Y');
$hora = date('H:i:s');

// ================== DADOS DO USUÁRIO ==================
$sql = "SELECT nome, faturamento_total, gasto_total, lucro_total 
        FROM usuarios 
        WHERE id_usuario = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$resultado = $stmt->get_result();
$usuario = $resultado->fetch_assoc();

// ================== ESTOQUE COM MAIS Faturamento ==================
$sql = "SELECT categoria, faturamento_estoque 
        FROM estoque
        WHERE id_usuario = ?
        ORDER BY faturamento_estoque DESC
        LIMIT 1";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$resultEstoque = $stmt->get_result();
$estoque = $resultEstoque->fetch_assoc();

// ================== PRODUTOS EM destaque ==================
$resultProdutos = null;

if ($id_estoque) {
    $sql = "SELECT *
            FROM produtos
            WHERE id_estoque = ?
            ORDER BY faturamento DESC
            LIMIT 1";

    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $id_estoque);
    $stmt->execute();
    $resultProdutos = $stmt->get_result();
}



// ================== CRIAÇÃO DO PDF ==================
$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();

// LOGO (se existir)
if(file_exists('../images/logo.png')){
    $pdf->Image('../images/logo.png', 10, 10, 30);
}

$pdf->SetFont('Arial','B',16);
$pdf->Cell(0,10,'Relatorio Financeiro - E-Stock',0,1,'C');

$pdf->SetFont('Arial','',12);
$pdf->Cell(0,5,"Data: $data  |  Hora: $hora",0,1,'C');

$pdf->Ln(10);

// ================== RESUMO FINANCEIRO ==================
$pdf->SetFont('Arial','B',14);
$pdf->Cell(0,10,'Resumo Financeiro Geral',0,1);

$pdf->SetFont('Arial','',12);
$pdf->Cell(90,8,'Faturamento Total',1,0);
$pdf->Cell(0,8,'R$ '.number_format($usuario['faturamento_total'],2,',','.'),1,1);

$pdf->Cell(90,8,'Gastos Totais',1,0);
$pdf->Cell(0,8,'R$ '.number_format($usuario['gasto_total'],2,',','.'),1,1);

$pdf->Cell(90,8,'Lucro Total',1,0);
$pdf->Cell(0,8,'R$ '.number_format($usuario['lucro_total'],2,',','.'),1,1);

$pdf->Ln(10);


// ================== ESTOQUE EM DESTAQUE ==================
$pdf->SetFont('Arial','B',14);
$pdf->Cell(0,10,'Estoque em Destaque',0,1);

if($estoque){
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(90,8,'Nome do Estoque',1,0);
    $pdf->Cell(0,8,$estoque['categoria'],1,1);

    $pdf->Cell(90,8,'Faturamento',1,0);
    $pdf->Cell(0,8,$estoque['faturamento_estoque'],1,1);
} else {
    $pdf->Cell(0,8,'Nenhum estoque registrado.',1,1);
}

$pdf->Ln(10);


// ================== PRODUTOS EM destaque ==================
$pdf->SetFont('Arial','B',14);
$pdf->Cell(0,10,'Produto em Destaque',0,1);

$pdf->SetFont('Arial','',12);

if($resultProdutos && $resultProdutos->num_rows > 0){
    while($produto = $resultProdutos->fetch_assoc()){
   $pdf->SetFont('Arial','',12);
    $pdf->Cell(90,8,'Nome do Produto',1,0);
    $pdf->Cell(0,8,$produto['nome_produto'],1,1);

    $pdf->Cell(90,8,'Faturamento',1,0);
    $pdf->Cell(0,8,$produto['faturamento'],1,1);
    }
} else {
    $pdf->Cell(0,8,'Nenhum produto encontrado para este estoque.',0,1);
}
$pdf->Ln(10);


// ================== RODAPÉ ==================
$pdf->SetY(-25);
$pdf->SetFont('Arial','I',10);
$pdf->Cell(0,10,'Relatorio gerado automaticamente pelo sistema E-Stock',0,0,'C');

// ================== SAÍDA ==================
$pdf->Output('I', 'Relatorio_Financeiro.pdf');
?>
