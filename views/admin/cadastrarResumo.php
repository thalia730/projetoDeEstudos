<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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
    <title>Cadastrar Resumo</title>
    <link rel="stylesheet" href="/projetoDeEstudos/public/style.css">
</head>

<body>

    <div class="container">

        <header>
            <h1>Cadastrar Novo Resumo</h1>
        </header>

        <?php if (isset($_GET['sucesso']) && $_GET['sucesso'] === 'cadastrado'): ?>
            <p class="mensagem-sucesso">
                Resumo cadastrado com sucesso!
            </p>
        <?php endif; ?>

        <form action="/projetoDeEstudos/public/index.php?action=criarResumo" method="POST">

            <div class="campo">

                <label for="id_materia">Matéria:</label>

                <select name="id_materia" id="id_materia" required>

                    <option value="">-- Escolha uma matéria --</option>

                    <?php foreach ($materias as $materia): ?>

                        <option value="<?= $materia['id'] ?>">
                            <?= htmlspecialchars($materia['nome']) ?>
                        </option>

                    <?php endforeach; ?>

                </select>

            </div>

            <div class="campo">

                <label for="titulo">Conteúdo:</label>

                <input
                    type="text"
                    name="titulo"
                    id="titulo"
                    placeholder="Ex.: Equação do 2º grau"
                    required>

            </div>

            <div class="campo">

                <label for="conteudo">Resumo:</label>

                <textarea
                    name="conteudo"
                    id="conteudo"
                    rows="12"
                    placeholder="Digite o resumo aqui..."
                    required></textarea>

            </div>

            <button type="submit" class="btn">
                Cadastrar Resumo
            </button>

            <a href="dashboard.php" class="btn">
                Voltar
            </a>

        </form>

    </div>

</body>

</html>