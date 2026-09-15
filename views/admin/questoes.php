<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario_logado']) || $_SESSION['tipo'] !== 'admin') {
    header("Location: /projetoDeEstudos/views/login.php");
    exit();
}

require_once '../../config/conexao.php';
require_once '../../app/models/questao.php';
require_once '../../app/models/materia.php';

$questaoModel = new Questao($conexao);
$materiaModel = new Materia($conexao);

$id_materia = $_GET['id_materia'] ?? null;
$editar = $_GET['editar'] ?? null;

$materias = $materiaModel->listarMaterias();

$questoes = [];

if ($id_materia) {
    $questoes = $questaoModel->listarQuestoes($id_materia);
}

$materia = null;

if ($id_materia) {
    $materia = $materiaModel->buscarMateriaPorId($id_materia);
}

$questaoEditando = null;

if ($editar) {
    $questaoEditando = $questaoModel->buscarQuestaoPorId($editar);
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Gerenciar Questões</title>
    <link rel="stylesheet" href="/projetoDeEstudos/public/style.css">
</head>

<body>

    <div class="container">

        <header>

            <h1>Gerenciar Questões</h1>

            <a href="dashboard.php" class="btn btn-voltar">
                ← Voltar ao Painel
            </a>

        </header>


        <!-- Escolher matéria -->

        <div class="campo">

            <label for="id_materia">
                Escolha uma matéria:
            </label>

            <form action="questoes.php" method="GET">

                <select name="id_materia" id="id_materia" required>

                    <option value="">
                        -- Escolha uma disciplina --
                    </option>

                    <?php foreach ($materias as $m): ?>

                        <option
                            value="<?= $m['id'] ?>"
                            <?= $id_materia == $m['id'] ? 'selected' : '' ?>>

                            <?= htmlspecialchars($m['nome']) ?>

                        </option>

                    <?php endforeach; ?>

                </select>

                <button type="submit" class="btn">
                    Ver Questões
                </button>

            </form>

        </div>


        <?php if ($materia): ?>

            <h2>
                Questões de <?= htmlspecialchars($materia['nome']) ?>
            </h2>


            <?php if (isset($_GET['sucesso'])): ?>

                <div class="alerta sucesso">

                    <?php if ($_GET['sucesso'] === 'editado'): ?>

                        Questão editada com sucesso!

                    <?php elseif ($_GET['sucesso'] === 'deletado'): ?>

                        Questão excluída com sucesso!

                    <?php endif; ?>

                </div>

            <?php endif; ?>


            <?php if (empty($questoes)): ?>

                <div class="alerta">
                    Nenhuma questão cadastrada para esta matéria.
                </div>

            <?php else: ?>


                <div class="lista-questoes">


                    <?php foreach ($questoes as $index => $q): ?>


                        <div class="card-questao">


                            <?php if ($editar == $q['id']): ?>


                                <!-- FORMULÁRIO DE EDIÇÃO -->

                                <h3>
                                    Editando Questão <?= $index + 1 ?>
                                </h3>


                                <form
                                    action="/projetoDeEstudos/public/index.php?action=editarQuestao"
                                    method="POST"
                                    class="formulario">

                                    <input
                                        type="hidden"
                                        name="id"
                                        value="<?= $q['id'] ?>">

                                    <input
                                        type="hidden"
                                        name="id_materia"
                                        value="<?= $id_materia ?>">


                                    <div class="campo">

                                        <label>
                                            Enunciado:
                                        </label>

                                        <textarea
                                            name="enunciado"
                                            rows="4"
                                            required><?= htmlspecialchars($q['enunciado']) ?></textarea>

                                    </div>


                                    <div class="campo">

                                        <label>
                                            Alternativa A:
                                        </label>

                                        <input
                                            type="text"
                                            name="alternativa_a"
                                            value="<?= htmlspecialchars($q['alternativa_a']) ?>"
                                            required>

                                    </div>


                                    <div class="campo">

                                        <label>
                                            Alternativa B:
                                        </label>

                                        <input
                                            type="text"
                                            name="alternativa_b"
                                            value="<?= htmlspecialchars($q['alternativa_b']) ?>"
                                            required>

                                    </div>


                                    <div class="campo">

                                        <label>
                                            Alternativa C:
                                        </label>

                                        <input
                                            type="text"
                                            name="alternativa_c"
                                            value="<?= htmlspecialchars($q['alternativa_c']) ?>"
                                            required>

                                    </div>


                                    <div class="campo">

                                        <label>
                                            Alternativa D:
                                        </label>

                                        <input
                                            type="text"
                                            name="alternativa_d"
                                            value="<?= htmlspecialchars($q['alternativa_d']) ?>"
                                            required>

                                    </div>


                                    <div class="campo">

                                        <label>
                                            Resposta correta:
                                        </label>

                                        <select
                                            name="resposta_correta"
                                            required>

                                            <option
                                                value="A"
                                                <?= $q['resposta_correta'] === 'A' ? 'selected' : '' ?>>
                                                Alternativa A
                                            </option>

                                            <option
                                                value="B"
                                                <?= $q['resposta_correta'] === 'B' ? 'selected' : '' ?>>
                                                Alternativa B
                                            </option>

                                            <option
                                                value="C"
                                                <?= $q['resposta_correta'] === 'C' ? 'selected' : '' ?>>
                                                Alternativa C
                                            </option>

                                            <option
                                                value="D"
                                                <?= $q['resposta_correta'] === 'D' ? 'selected' : '' ?>>
                                                Alternativa D
                                            </option>

                                        </select>

                                    </div>


                                    <button
                                        type="submit"
                                        class="btn-salvar">
                                        Salvar Alterações
                                    </button>


                                    <a
                                        href="questoes.php?id_materia=<?= $id_materia ?>"
                                        class="btn btn-voltar">
                                        Cancelar
                                    </a>

                                </form>


                            <?php else: ?>


                                <!-- EXIBIÇÃO NORMAL DA QUESTÃO -->

                                <span class="tag-materia">

                                    <?= htmlspecialchars($q['materia_nome']) ?>

                                </span>


                                <h3>
                                    Questão <?= $index + 1 ?>
                                </h3>


                                <p class="enunciado">

                                    <?= nl2br(htmlspecialchars($q['enunciado'])) ?>

                                </p>


                                <p>
                                    <strong>A)</strong>
                                    <?= htmlspecialchars($q['alternativa_a']) ?>
                                </p>


                                <p>
                                    <strong>B)</strong>
                                    <?= htmlspecialchars($q['alternativa_b']) ?>
                                </p>


                                <p>
                                    <strong>C)</strong>
                                    <?= htmlspecialchars($q['alternativa_c']) ?>
                                </p>


                                <p>
                                    <strong>D)</strong>
                                    <?= htmlspecialchars($q['alternativa_d']) ?>
                                </p>


                                <p>
                                    <strong>Resposta correta:</strong>
                                    <?= htmlspecialchars($q['resposta_correta']) ?>
                                </p>


                                <a
                                    href="questoes.php?id_materia=<?= $id_materia ?>&editar=<?= $q['id'] ?>"
                                    class="btn">
                                    Editar
                                </a>


                                <a
                                    href="/projetoDeEstudos/public/index.php?action=deletarQuestao&id=<?= $q['id'] ?>&id_materia=<?= $id_materia ?>"
                                    class="btn btn-sair"
                                    onclick="return confirm('Tem certeza que deseja excluir esta questão?')">
                                    Excluir
                                </a>


                            <?php endif; ?>


                        </div>


                    <?php endforeach; ?>


                </div>


            <?php endif; ?>


        <?php endif; ?>


    </div>

</body>

</html>
