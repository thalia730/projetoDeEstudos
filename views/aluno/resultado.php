<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario_logado']) || $_SESSION['tipo'] !== 'aluno') {
    header("Location: /projetoDeEstudos/views/login.php");
    exit();
}

$total = $_GET['total'] ?? 0;
$acertos = $_GET['acertos'] ?? 0;
$erros = $_GET['erros'] ?? 0;
$porcentagem = $_GET['porcentagem'] ?? 0;
$respostas = [];

if (isset($_GET['respostas'])) {
    $respostas = json_decode(urldecode($_GET['respostas']), true);
}

require_once '../../config/conexao.php';
require_once '../../app/models/questao.php';

$questaoModel = new Questao($conexao);

$questoesResultado = [];

foreach ($respostas as $id_questao => $resposta) {

    $questao = $questaoModel->buscarQuestaoPorId($id_questao);

    if ($questao) {
        $questoesResultado[] = $questao;
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Resultado do Simulado</title>
    <link rel="stylesheet" href="/projetoDeEstudos/public/style.css">
</head>

<body>
    <main class="pagina-resultado">
    <div class="topo-resultado">

    <h1>🎓 Simulado Finalizado!</h1>

    <p>Confira abaixo seu desempenho e a correção das questões.</p>

</div>

<div class="resumo-resultado">

    <div class="item-resumo total">
        <span class="icone-resumo">📄</span>
        <span>Total de questões</span>
        <strong><?= $total ?></strong>
    </div>

    <div class="item-resumo acertos">
        <span class="icone-resumo">✅</span>
        <span>Acertos</span>
        <strong><?= $acertos ?></strong>
    </div>

    <div class="item-resumo erros">
        <span class="icone-resumo">❌</span>
        <span>Erros</span>
        <strong><?= $erros ?></strong>
    </div>

    <div class="item-resumo aproveitamento">
        <span class="icone-resumo">📊</span>
        <span>Aproveitamento</span>
        <strong><?= $porcentagem ?>%</strong>
    </div>

</div>

<h2 class="titulo-correcao">Correção das questões</h2>

    <?php foreach ($questoesResultado as $index => $q): ?>

        <?php
        $respostaAluno = $respostas[$q['id']] ?? null;
        $respostaCorreta = $q['resposta_correta'];
        ?>

        <div class="card-resultado">
            <h3>Questão <?= $index + 1 ?></h3>

            <p>
                <?= htmlspecialchars($q['enunciado']) ?>
            </p>

            <p class="alternativa <?php
                                    if ($respostaCorreta === 'A') {
                                        echo 'correta';
                                    } elseif ($respostaAluno === 'A') {
                                        echo 'errada';
                                    }
                                    ?>
">
                A) <?= htmlspecialchars($q['alternativa_a']) ?>
            </p>

            <p class="alternativa <?php
                                    if ($respostaCorreta === 'B') {
                                        echo 'correta';
                                    } elseif ($respostaAluno === 'B') {
                                        echo 'errada';
                                    }
                                    ?>">
                B) <?= htmlspecialchars($q['alternativa_b']) ?>
            </p>

            <p class="alternativa <?php
                                    if ($respostaCorreta === 'C') {
                                        echo 'correta';
                                    } elseif ($respostaAluno === 'C') {
                                        echo 'errada';
                                    }
                                    ?>">
                C) <?= htmlspecialchars($q['alternativa_c']) ?>
            </p>

            <p class="alternativa <?php
                                    if ($respostaCorreta === 'D') {
                                        echo 'correta';
                                    } elseif ($respostaAluno === 'D') {
                                        echo 'errada';
                                    }
                                    ?>">
                D) <?= htmlspecialchars($q['alternativa_d']) ?>
            </p>
            <?php if ($respostaAluno !== null && $respostaAluno !== $respostaCorreta): ?>

                <button
                    type="button"
                    id="btn-por-que-<?= $q['id'] ?>"
                    class="btn-por-que"
                    onclick="mostrarExplicacao(<?= $q['id'] ?>)">
                    Por que?
                </button>

                <div
                    id="explicacao-<?= $q['id'] ?>"
                    class="caixa-explicacao escondida">

                    <button
                        type="button"
                        class="btn-fechar-explicacao"
                        onclick="fecharExplicacao(<?= $q['id'] ?>)">
                        X
                    </button>

                    <h4>💡 Por que?</h4>

                    <p>
                        <?= nl2br(htmlspecialchars($q['explicacao'] ?? 'Explicação ainda não cadastrada.')) ?>
                    </p>

                </div>

            <?php endif; ?>
        </div>

    <?php endforeach; ?>

    <script>
        function mostrarExplicacao(id) {
            document.getElementById('explicacao-' + id).classList.remove('escondida');
            document.getElementById('btn-por-que-' + id).style.display = 'none';
        }

        function fecharExplicacao(id) {
            document.getElementById('explicacao-' + id).classList.add('escondida');
            document.getElementById('btn-por-que-' + id).style.display = 'block';
        }
    </script>

    <a href="/projetoDeEstudos/views/aluno/simulado.php" class="btn-voltar">
        ← Voltar
    </a>
    </main>
</body>

</html>