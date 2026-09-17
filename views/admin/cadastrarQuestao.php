<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['usuario_logado']) || $_SESSION['tipo'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Puxa os dados das matérias para listar no <select>
require_once '../../config/conexao.php';
require_once '../../app/models/materia.php';
$materiaModel = new Materia($conexao);
$materias = $materiaModel->listarMaterias();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Cadastrar Questão</title>
    <link rel="stylesheet" href="../../public/style.css">
</head>

<body>
    <div class="container">
        <header>
            <h1>Cadastrar Nova Questão</h1>
            <a href="dashboard.php" class="btn btn-voltar">← Voltar ao Painel</a>
        </header>

        <?php if (isset($_GET['sucesso'])): ?>
            <div class="alerta sucesso">Operação realizada com sucesso!</div>
        <?php endif; ?>

        <form action="../../public/index.php?action=criarQuestao" method="POST">
            <div class="campo">
                <label for="id_materia">Selecione a Matéria:</label>
                <select name="id_materia" id="id_materia" required>
                    <option value="">-- Escolha uma disciplina --</option>
                    <?php foreach ($materias as $m): ?>
                        <option value="<?= $m['id'] ?>"><?= htmlspecialchars($m['nome']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="campo">
                <label for="enunciado">Enunciado da Pergunta:</label>
                <textarea name="enunciado" id="enunciado" rows="4" required placeholder="Digite a pergunta aqui..."></textarea>
            </div>

            <div class="campo-alternativa">
                <label>Alternativa A:</label>
                <input type="text" name="alternativa_a" required>
            </div>

            <div class="campo-alternativa">
                <label>Alternativa B:</label>
                <input type="text" name="alternativa_b" required>
            </div>

            <div class="campo-alternativa">
                <label>Alternativa C:</label>
                <input type="text" name="alternativa_c" required>
            </div>

            <div class="campo-alternativa">
                <label>Alternativa D:</label>
                <input type="text" name="alternativa_d" required>
            </div>

            <div class="campo">
                <label for="resposta_correta">Qual é a Alternativa Correta?</label>
                <select name="resposta_correta" id="resposta_correta" required>
                    <option value="A">Alternativa A</option>
                    <option value="B">Alternativa B</option>
                    <option value="C">Alternativa C</option>
                    <option value="D">Alternativa D</option>
                </select>
            </div>

            <div class="campo">
                <label for="explicacao">Explicação da Resposta:</label>
                <textarea
                    name="explicacao"
                    id="explicacao"
                    rows="5"
                    placeholder="Explique por que essa é a resposta correta..."></textarea>
            </div>

            <button type="submit" class="btn-salvar">Salvar Questão</button>
        </form>
    </div>
</body>

</html>