<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
// Segurança: garante que apenas admins acessem
if (!isset($_SESSION['usuario_logado']) || $_SESSION['tipo'] !== 'admin') {
    header("Location: ../../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel Administrativo</title>
    <link rel="stylesheet" href="../../public/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Painel do Administrador</h1>
            <p>Bem-vindo, <strong><?= htmlspecialchars($_SESSION['email']) ?></strong></p>
        </header>

        <nav class="menu-dashboard">
            <a href="cadastrarQuestao.php" class="btn">Gerenciar Questões</a>
            <a href="../../login.php" class="btn btn-sair">Sair do Sistema</a>
        </nav>

        <main class="dashboard-welcome">
            <h3>Visão Geral</h3>
            <p>Utilize o menu acima para cadastrar novas perguntas no banco de dados do simulado.</p>
        </main>
    </div>
</body>
</html>
