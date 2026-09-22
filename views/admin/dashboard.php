<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Segurança: garante que apenas admins acessem
if (!isset($_SESSION['usuario_logado']) || $_SESSION['tipo'] !== 'admin') {
    header("Location: /projetoDeEstudos/views/login.php");
    exit();
}

require_once '../../config/conexao.php';
require_once '../../app/models/materia.php';

$materiaModel = new Materia($conexao);
$materias = $materiaModel->listarMaterias();

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Painel Administrativo</title>
    <link rel="stylesheet" href="/projetoDeEstudos/public/style.css">
</head>

<body>
    <div class="container">
        <header>
            <h1>Painel do Administrador</h1>
            <p>Bem-vindo, <strong><?= htmlspecialchars($_SESSION['email']) ?></strong></p>
        </header>

        <nav class="menu-dashboard">

            <h2>Cadastrar</h2>

            <a href="cadastrarQuestao.php" class="btn">
                Cadastrar Nova Questão
            </a>

            <a href="cadastrarResumo.php" class="btn">
                Cadastrar Novo Resumo
            </a>

            <h2>Gerenciar</h2>
            <div class="campo">
                <label for="id_materia">Gerenciar Questões por Matéria:</label>

                <form action="questoes.php" method="GET">
                    <select name="id_materia" id="id_materia" required>
                        <option value="">-- Escolha uma disciplina --</option>

                        <?php foreach ($materias as $m): ?>
                            <option value="<?= $m['id'] ?>">
                                <?= htmlspecialchars($m['nome']) ?>
                            </option>
                        <?php endforeach; ?>

                    </select>

                    <button type="submit" class="btn">
                        Ver Questões
                    </button>
                </form>
                <a href="resumos.php" class="btn">
                    Gerenciar Resumos
                </a>
            </div>

            <a href="/projetoDeEstudos/public/index.php?action=deslogar" class="btn btn-sair">
                Sair do Sistema
            </a>

        </nav>

        <main class="dashboard-welcome">
            <h3>Visão Geral</h3>
            <p>
                Cadastre novas questões ou selecione uma matéria para visualizar,
                editar ou excluir suas questões.
            </p>
        </main>
    </div>
</body>

</html>