<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['usuario_logado']) || $_SESSION['tipo'] !== 'aluno') {
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Painel do Aluno</title>
    <link rel="stylesheet" href="../../public/style.css">
</head>

<body>
    <div class="container">
        <header>
            <h1>Área de Estudos do Aluno</h1>
            <p>Estudante logado: <strong><?= htmlspecialchars($_SESSION['email']) ?></strong></p>
        </header>

        <nav class="menu-dashboard">
            <a href="simulado.php" class="btn">Iniciar Simulado Geral</a>
            <a href="resumo.php" class="btn">
                Ver Resumos
            </a>
            <a href="../../public/index.php?action=deslogar" class="btn btn-sair">Sair</a>
        </nav>

        <main class="dashboard-welcome">
            <h3>Preparado para testar seus conhecimentos?</h3>
            <p>Clique no botão acima para abrir o caderno de questões cadastradas pelos professores.</p>
        </main>
    </div>
</body>

</html>