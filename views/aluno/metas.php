<?php

session_start();

if (!isset($_SESSION['email'])) {
    header("Location: ../login.php");
    exit();
}

require_once '../../config/conexao.php';
require_once '../../app/models/meta.php';

$email = $_SESSION['email'];

$metaModel = new Meta($conexao);

$metas = $metaModel->listarMetas($email);

$metaEditar = null;

if (isset($_GET['id'])) {
    $metaEditar = $metaModel->buscarMetaPorId($_GET['id'], $email);
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Minhas Metas</title>
    <link rel="stylesheet" href="/projetoDeEstudos/public/style.css">
</head>

<body>

    <div class="metas-page">

        <div class="metas-header">
            <div>
                <h1>Minhas Metas</h1>
                <p>Organize seus objetivos e acompanhe seu progresso.</p>
            </div>

            <a href="dashboard.php" class="metas-voltar">← Voltar</a>
        </div>

        <?php if (isset($_GET['sucesso'])): ?>

            <?php if ($_GET['sucesso'] === 'cadastrada'): ?>
                <div class="mensagem-sucesso">
                    ✓ Meta cadastrada com sucesso!
                </div>
            <?php endif; ?>

            <?php if ($_GET['sucesso'] === 'editada'): ?>
                <div class="mensagem-sucesso">
                    ✓ Meta editada com sucesso!
                </div>
            <?php endif; ?>

            <?php if ($_GET['sucesso'] === 'deletada'): ?>
                <div class="mensagem-sucesso">
                    ✓ Meta excluída com sucesso!
                </div>
            <?php endif; ?>

        <?php endif; ?>


        <?php if ($metaEditar): ?>

            <div class="meta-form-card">

                <h2>Editar Meta</h2>

                <form action="/projetoDeEstudos/public/index.php?action=editarMeta" method="POST">

                    <input
                        type="hidden"
                        name="id"
                        value="<?= $metaEditar['id'] ?>">

                    <label>Meta:</label>

                    <input
                        type="text"
                        name="titulo"
                        value="<?= htmlspecialchars($metaEditar['titulo']) ?>"
                        required>

                    <label>Descrição:</label>

                    <textarea
                        name="descricao"
                        placeholder="Descreva sua meta"><?= htmlspecialchars($metaEditar['descricao']) ?></textarea>

                    <div class="metas-form-botoes">

                        <button type="submit" class="btn-meta-salvar">
                            Salvar alterações
                        </button>

                        <a href="metas.php" class="btn-meta-cancelar">
                            Cancelar
                        </a>

                    </div>

                </form>

            </div>

        <?php else: ?>

            <div class="meta-form-card">

                <h2>Nova Meta</h2>

                <form action="/projetoDeEstudos/public/index.php?action=criarMeta" method="POST">

                    <label>Meta:</label>

                    <input
                        type="text"
                        name="titulo"
                        placeholder="Ex: Estudar matemática"
                        required>

                    <label>Descrição:</label>

                    <textarea
                        name="descricao"
                        placeholder="Descreva sua meta"></textarea>

                    <button type="submit" class="btn-meta-salvar">
                        + Adicionar Meta
                    </button>

                </form>

            </div>

        <?php endif; ?>


        <div class="metas-lista">

            <div class="metas-lista-titulo">
                <h2>Minhas metas cadastradas</h2>
                <span><?= count($metas) ?> meta(s)</span>
            </div>


            <?php if (empty($metas)): ?>

                <div class="metas-vazia">
                    <div class="metas-vazia-icone">🎯</div>

                    <h3>Nenhuma meta cadastrada</h3>

                    <p>
                        Você ainda não possui metas cadastradas.
                        Comece adicionando uma acima!
                    </p>
                </div>

            <?php else: ?>

                <div class="metas-grid">

                    <?php foreach ($metas as $meta): ?>

                        <div class="meta-item <?= $meta['concluida'] ? 'meta-concluida' : '' ?>">

                            <div class="meta-item-conteudo">

                                <div class="meta-status">
                                    <?= $meta['concluida'] ? '✓' : '○' ?>
                                </div>

                                <div class="meta-textos">

                                    <h3>
                                        <?= htmlspecialchars($meta['titulo']) ?>
                                    </h3>

                                    <p>
                                        <?= nl2br(htmlspecialchars($meta['descricao'])) ?>
                                    </p>

                                    <?php if ($meta['concluida']): ?>

                                        <span class="meta-situacao concluida">
                                            ✓ Meta concluída
                                        </span>

                                    <?php else: ?>

                                        <span class="meta-situacao pendente">
                                            ⏳ Meta pendente
                                        </span>

                                    <?php endif; ?>

                                </div>

                            </div>


                            <div class="meta-acoes">

                                <a
                                    href="metas.php?id=<?= $meta['id'] ?>"
                                    class="meta-btn editar">
                                    Editar
                                </a>

                                <a
                                    href="/projetoDeEstudos/public/index.php?action=concluirMeta&id=<?= $meta['id'] ?>"
                                    class="meta-btn concluir">
                                    <?= $meta['concluida'] ? 'Desmarcar' : 'Concluir' ?>
                                </a>

                                <a
                                    href="/projetoDeEstudos/public/index.php?action=deletarMeta&id=<?= $meta['id'] ?>"
                                    class="meta-btn excluir"
                                    onclick="return confirm('Tem certeza que deseja excluir esta meta?')">
                                    Excluir
                                </a>

                            </div>

                        </div>

                    <?php endforeach; ?>

                </div>

            <?php endif; ?>

        </div>

    </div>

</body>

</html>