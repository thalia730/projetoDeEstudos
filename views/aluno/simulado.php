<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
if (!isset($_SESSION['usuario_logado']) || $_SESSION['tipo'] !== 'aluno') {
   header("Location: ../login.php");
    exit();
}

require_once '../../config/conexao.php';
require_once '../../app/models/questao.php';

$questaoModel = new Questao($conexao);
$questoes = $questaoModel->listarQuestoes();
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
            <h1>Simulado em Andamento</h1>
            <a href="dashboard.php" class="btn btn-voltar">← Voltar ao Menu</a>
        </header>

        <?php if (isset($_GET['resultado'])): ?>
            <?php if ($_GET['resultado'] === 'correto'): ?>
                <div class="alerta sucesso">🎉 Resposta correta! Parabéns!</div>
            <?php else: ?>
                <div class="alerta erro">❌ Resposta incorreta. Tente novamente!</div>
            <?php endif; ?>
        <?php endif; ?>

        <div class="lista-questoes">
            <?php if (empty($questoes)): ?>
                <p>Nenhuma questão disponível no momento. Avise o seu professor!</p>
            <?php else: ?>
                <?php foreach ($questoes as $index => $q): ?>
                    <div class="card-questao">
                        <span class="tag-materia"><?= htmlspecialchars($q['materia_nome']) ?></span>
                        <h3>Questão <?= $index + 1 ?></h3>
                        <p class="enunciado"><?= nl2br(htmlspecialchars($q['enunciado'])) ?></p>
                        
                        <form action="../../public/index.php?action=corrigirQuestao" method="POST">
                            <input type="hidden" name="id_questao" value="<?= $q['id'] ?>">
                            
                            <label class="opcao">
                                <input type="radio" name="resposta_marcada" value="A" required>
                                <span>A) <?= htmlspecialchars($q['alternativa_a']) ?></span>
                            </label>
                            
                            <label class="opcao">
                                <input type="radio" name="resposta_marcada" value="B">
                                <span>B) <?= htmlspecialchars($q['alternativa_b']) ?></span>
                            </label>
                            
                            <label class="opcao">
                                <input type="radio" name="resposta_marcada" value="C">
                                <span>C) <?= htmlspecialchars($q['alternativa_c']) ?></span>
                            </label>
                            
                            <label class="opcao">
                                <input type="radio" name="resposta_marcada" value="D">
                                <span>D) <?= htmlspecialchars($q['alternativa_d']) ?></span>
                            </label>

                            <button type="submit" class="btn-responder">Confirmar Resposta</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
