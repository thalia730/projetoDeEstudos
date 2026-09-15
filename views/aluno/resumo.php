<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
if (!isset($_SESSION['usuario_logado']) || $_SESSION['tipo'] !== 'aluno') {
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Resumo do Desempenho</title>
    <link rel="stylesheet" href="../../public/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Resumo de Estudos</h1>
            <a href="dashboard.php" class="btn">Voltar para o Início</a>
        </header>

        <main class="card-resumo">
            <h3>Progresso Salvo!</h3>
            <p>Você revisou suas questões com sucesso hoje.</p>
            <p>Continue praticando diariamente para reter melhor as disciplinas estudadas.</p>
        </main>
    </div>
</body>
</html>
