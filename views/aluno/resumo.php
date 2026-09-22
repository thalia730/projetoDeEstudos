<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
if (!isset($_SESSION['usuario_logado']) || $_SESSION['tipo'] !== 'aluno') {
    header("Location: ../login.php");
    exit();
}
require_once '../../config/conexao.php';
require_once '../../app/models/materia.php';
require_once '../../app/models/resumo.php';

$materiaModel = new Materia($conexao);
$resumoModel = new Resumo($conexao);

$materias = $materiaModel->listarMaterias();

$id_materia = $_GET['id_materia'] ?? null;
$id_resumo = $_GET['id'] ?? null;

$resumos = [];

if ($id_materia) {
    $resumos = $resumoModel->listarResumosPorMateria($id_materia);
}

$resumoSelecionado = null;

if ($id_resumo) {
    $resumoSelecionado = $resumoModel->buscarResumoPorId($id_resumo);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Resumo do Desempenho</title>
    <link rel="stylesheet" href="../../public/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Resumo de Estudos</h1>
            <a href="dashboard.php" class="btn">Voltar para o Início</a>
        </header>

       <h2>Resumos de Estudo</h2>

<form action="resumo.php" method="GET">

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
                    <?= ($id_materia == $materia['id']) ? 'selected' : '' ?>
                >
                    <?= htmlspecialchars($materia['nome']) ?>
                </option>

            <?php endforeach; ?>

        </select>

        <button type="submit" class="btn">
            Ver Conteúdos
        </button>

    </div>

</form>

<?php if ($id_materia && !empty($resumos)): ?>

    <h3>Conteúdos disponíveis:</h3>

    <?php foreach ($resumos as $resumo): ?>

        <p>
            <a
                href="resumo.php?id_materia=<?= $id_materia ?>&id=<?= $resumo['id'] ?>"
                class="btn"
            >
                <?= htmlspecialchars($resumo['titulo']) ?>
            </a>
        </p>

    <?php endforeach; ?>

<?php elseif ($id_materia): ?>

    <p>
        Nenhum resumo cadastrado para esta matéria.
    </p>

<?php endif; ?>

<?php if ($resumoSelecionado): ?>

    <div class="card-resumo">

        <h2>
            <?= htmlspecialchars($resumoSelecionado['titulo']) ?>
        </h2>

        <p>
            <strong>Matéria:</strong>
            <?= htmlspecialchars($resumoSelecionado['materia']) ?>
        </p>

        <p>
            <?= nl2br(htmlspecialchars($resumoSelecionado['conteudo'])) ?>
        </p>

    </div>

<?php endif; ?>
    </div>
</body>
</html>
