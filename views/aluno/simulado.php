<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['usuario_logado']) || $_SESSION['tipo'] !== 'aluno') {
    header("Location: ../login.php");
    exit();
}
require_once '../../config/conexao.php';
require_once '../../app/models/materia.php';
require_once '../../app/models/questao.php';

$materiaModel = new Materia($conexao);
$materias = $materiaModel->listarMaterias();

$questaoModel = new Questao($conexao);

$questoes = [];

if (isset($_GET['iniciar'])) {

    $materiasSelecionadas = $_GET['materias'] ?? [];
    $status = $_GET['status'] ?? 'todas';
    $quantidade = $_GET['quantidade'] ?? 10;
    $email = $_SESSION['email'];

    if (!empty($materiasSelecionadas)) {

        $questoes = $questaoModel->listarQuestoesSimulado(
            $materiasSelecionadas,
            $status,
            $quantidade,
            $email
        );
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Simulado de Estudos</title>
    <link rel="stylesheet" href="../../public/style.css">
</head>

<body>
    <div class="container">
        <header>
            <h1>Configurar Simulado</h1>
            <a href="dashboard.php" class="btn btn-voltar">← Voltar ao Menu</a>
        </header>

        <?php if (!isset($_GET['iniciar'])): ?>

            <form action="simulado.php" method="GET" class="formulario">

                <input type="hidden" name="iniciar" value="1">

                <div class="campo">

                    <label>
                        Escolha as matérias:
                    </label>

                    <?php foreach ($materias as $m): ?>

                        <label class="opcao">

                            <input
                                type="checkbox"
                                name="materias[]"
                                value="<?= $m['id'] ?>">

                            <span>
                                <?= htmlspecialchars($m['nome']) ?>
                            </span>

                        </label>

                    <?php endforeach; ?>

                </div>


                <div class="campo">

                    <label>
                        Tipo de questões:
                    </label>

                    <label class="opcao">
                        <input type="radio" name="status" value="todas" checked>
                        <span>Todas</span>
                    </label>

                    <label class="opcao">
                        <input type="radio" name="status" value="acertou">
                        <span>Somente as que acertei</span>
                    </label>

                    <label class="opcao">
                        <input type="radio" name="status" value="errou">
                        <span>Somente as que errei</span>
                    </label>

                    <label class="opcao">
                        <input type="radio" name="status" value="nao_feitas">
                        <span>Somente as que ainda não fiz</span>
                    </label>

                </div>


                <div class="campo">

                    <label for="quantidade">
                        Quantidade de questões:
                    </label>

                    <select name="quantidade" id="quantidade">

                        <option value="5">5 questões</option>
                        <option value="10" selected>10 questões</option>
                        <option value="15">15 questões</option>
                        <option value="20">20 questões</option>
                        <option value="30">30 questões</option>
                        <option value="50">50 questões</option>

                    </select>

                </div>


                <button type="submit" class="btn">
                    🚀 Iniciar Simulado
                </button>

            </form>
        <?php endif; ?>

        <?php if (isset($_GET['resultado']) && $_GET['resultado'] === 'final'): ?>

            ```
            <div class="card-questao">

                <h2>🎉 Simulado Finalizado!</h2>

                <p>
                    Você respondeu <strong><?= $_GET['total'] ?></strong> questões.
                </p>

                <p>
                    ✅ Acertos: <strong><?= $_GET['acertos'] ?></strong>
                </p>

                <p>
                    ❌ Erros: <strong><?= $_GET['erros'] ?></strong>
                </p>

                <p>
                    📊 Aproveitamento:
                    <strong><?= $_GET['porcentagem'] ?>%</strong>
                </p>

                <a href="simulado.php" class="btn">
                    Fazer Novo Simulado
                </a>

            </div>
            ```

        <?php endif; ?>


        <?php if (isset($_GET['iniciar'])): ?>

            <div class="lista-questoes">

                <?php if (empty($questoes)): ?>

                    <p>Nenhuma questão encontrada para os filtros escolhidos.</p>

                <?php else: ?>

                    <form action="/projetoDeEstudos/public/index.php?action=corrigirQuestoes" method="POST">

                        <?php foreach ($questoes as $index => $q): ?>

                            <div class="card-questao">

                                <span class="tag-materia">
                                    <?= htmlspecialchars($q['materia_nome']) ?>
                                </span>

                                <h3>Questão <?= $index + 1 ?></h3>

                                <p class="enunciado">
                                    <?= nl2br(htmlspecialchars($q['enunciado'])) ?>
                                </p>

                                <input type="hidden" name="questoes[]" value="<?= $q['id'] ?>">

                                <label class="opcao">
                                    <input type="radio" name="respostas[<?= $q['id'] ?>]" value="A" required>
                                    <span>A) <?= htmlspecialchars($q['alternativa_a']) ?></span>
                                </label>

                                <label class="opcao">
                                    <input type="radio" name="respostas[<?= $q['id'] ?>]" value="B">
                                    <span>B) <?= htmlspecialchars($q['alternativa_b']) ?></span>
                                </label>

                                <label class="opcao">
                                    <input type="radio" name="respostas[<?= $q['id'] ?>]" value="C">
                                    <span>C) <?= htmlspecialchars($q['alternativa_c']) ?></span>
                                </label>

                                <label class="opcao">
                                    <input type="radio" name="respostas[<?= $q['id'] ?>]" value="D">
                                    <span>D) <?= htmlspecialchars($q['alternativa_d']) ?></span>
                                </label>

                            </div>

                        <?php endforeach; ?>

                        <button type="submit" class="btn">
                            Finalizar Simulado
                        </button>

                    </form>

                <?php endif; ?>

            </div>


        <?php endif; ?>
    </div>
</body>

</html>