<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario_logado']) || $_SESSION['tipo'] !== 'admin') {
    header("Location: /projetoDeEstudos/views/login.php");
    exit();
}

require_once '../../config/conexao.php';
require_once '../../app/models/resumo.php';
require_once '../../app/models/materia.php';

$resumoModel = new Resumo($conexao);
$materiaModel = new Materia($conexao);

$id_materia = $_GET['id_materia'] ?? null;

$resumos = [];

if ($id_materia) {
    $resumos = $resumoModel->listarResumosPorMateria($id_materia);
}
$id_editar = $_GET['id'] ?? null;

$resumoEditar = null;

if ($id_editar) {
    $resumoEditar = $resumoModel->buscarResumoPorId($id_editar);
}
$materias = $materiaModel->listarMaterias();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Gerenciar Resumos</title>
    <link rel="stylesheet" href="/projetoDeEstudos/public/style.css">
</head>

<body>

    <div class="container">

        <header>
            <h1>Gerenciar Resumos</h1>
            <p>Visualize, edite ou exclua os resumos cadastrados.</p>
        </header>

        <?php if (isset($_GET['sucesso'])): ?>

            <?php if ($_GET['sucesso'] === 'editado'): ?>
                <p class="mensagem-sucesso">
                    Resumo editado com sucesso!
                </p>
            <?php endif; ?>

            <?php if ($_GET['sucesso'] === 'deletado'): ?>
                <p class="mensagem-sucesso">
                    Resumo excluído com sucesso!
                </p>
            <?php endif; ?>

        <?php endif; ?>

        <form action="resumos.php" method="GET">

            <div class="campo">

                <label for="id_materia">
                    Escolha a matéria:
                </label>

                <select name="id_materia" id="id_materia" required>

                    <option value="">
                        -- Escolha uma matéria --
                    </option>

                    <?php foreach ($materias as $materia): ?>

                        <option
                            value="<?= $materia['id'] ?>"
                            <?= ($id_materia == $materia['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($materia['nome']) ?>
                        </option>

                    <?php endforeach; ?>

                </select>

                <button type="submit" class="btn">
                    Ver Resumos
                </button>

            </div>

        </form>

        <br>
        <?php if (empty($resumos)): ?>

            <p>Nenhum resumo cadastrado ainda.</p>

        <?php else: ?>

            <?php foreach ($resumos as $resumo): ?>

                <div class="card-resumo">

                    <?php if ($resumoEditar && $resumoEditar['id'] == $resumo['id']): ?>

                        <form action="/projetoDeEstudos/public/index.php?action=editarResumo" method="POST">

                            <input type="hidden" name="id" value="<?= $resumo['id'] ?>">

                            <div class="campo">

                                <label for="id_materia">Matéria:</label>

                                <select name="id_materia" id="id_materia" required>

                                    <?php foreach ($materias as $materia): ?>

                                        <option
                                            value="<?= $materia['id'] ?>"
                                            <?= ($materia['id'] == $resumo['id_materia']) ? 'selected' : '' ?>>
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
                                    value="<?= htmlspecialchars($resumo['titulo']) ?>"
                                    required>

                            </div>

                            <div class="campo">

                                <label for="conteudo">Resumo:</label>

                                <textarea
                                    name="conteudo"
                                    id="conteudo"
                                    rows="12"
                                    required><?= htmlspecialchars($resumo['conteudo']) ?></textarea>

                            </div>

                            <button type="submit" class="btn">
                                Salvar Alterações
                            </button>

                            <a
                                href="resumos.php?id_materia=<?= $id_materia ?>"
                                class="btn">
                                Cancelar
                            </a>

                        </form>

                    <?php else: ?>

                        <h2>
                            <?= htmlspecialchars($resumo['titulo']) ?>
                        </h2>

                        <p>
                            <strong>Matéria:</strong>
                            <?= htmlspecialchars($resumo['materia']) ?>
                        </p>

                        <p>
                            <?= nl2br(htmlspecialchars($resumo['conteudo'])) ?>
                        </p>

                        <a
                            href="resumos.php?id=<?= $resumo['id'] ?>&id_materia=<?= $id_materia ?>"
                            class="btn">
                            Editar
                        </a>

                        <a
                            href="/projetoDeEstudos/public/index.php?action=deletarResumo&id=<?= $resumo['id'] ?>"
                            class="btn btn-sair"
                            onclick="return confirm('Tem certeza que deseja excluir este resumo?')">
                            Excluir
                        </a>

                    <?php endif; ?>

                </div>
            <?php endforeach; ?>

        <?php endif; ?>

        <br>

        <a href="dashboard.php" class="btn">
            Voltar
        </a>

    </div>

</body>

</html>