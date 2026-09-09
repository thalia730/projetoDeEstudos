<?php
require_once 'config/conexao.php';
require_once 'models/materia.php';
require_once 'models/questao.php';

class adminController
{
    public function criarMateria()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['nome'])) {
            global $conexao;
            $materiaModel = new Materia($conexao);

            if ($materiaModel->adicionarMateria($_POST['nome'])) {
                header("Location: materias.php?sucesso=cadastrado");
                exit();
            }
        }
    }

    public function editarMateria()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            global $conexao;
            $materiaModel = new Materia($conexao);

            if ($materiaModel->atualizarMateria($_POST['id'], $_POST['nome'])) {
                header("Location: materias.php?sucesso=deletado");
                exit();
            }
        }
    }

    public function deletarMateria()
    {
        if (isset($_GET['id'])) {
            global $conexao;
            $materiaModel = new Materia($conexao);

            if ($materiaModel->deletarMateria($_GET['id'])) {
                header("Location: materias.php?sucesso=deletado");
                exit();
            }
        }
    }
    public function criarQuestao()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            global $conexao;
            $questaoModel = new Questao($conexao);
            $sucesso = $questaoModel->adicionarQuestao(
                $_POST['enunciado'],
                $_POST['alternativa_a'],
                $_POST['alternativa_b'],
                $_POST['alternativa_c'],
                $_POST['enunciado_d'],
                $_POST['resposta_correta'],
                $_POST['id_materia']
            );
            if ($sucesso) {
                header("Location: questoes.php?sucesso=cadastrado");
                exit();
            }
        }
    }
    public function editarQuestao()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            global $conexao;
            $questaoModel = new Questao($conexao);
            $sucesso = $questaoModel->atualizarQuestao(
                $_POST['id'],
                $_POST['id_materia'],
                $_POST['enunciado'],
                $_POST['alternativa_a'],
                $_POST['alternativa_b'],
                $_POST['alternativa_c'],
                $_POST['enunciado_d'],
                $_POST['resposta_correta'],
            );
            if ($sucesso) {
                header("Location: questoes.php?sucesso=editao");
                exit();
            }
        }
    }
    public function deletarQuestao()
    {
        if (isset($_GET['id'])) {
            global $conexao;
            $questaoModel = new Questao($conexao);

            if ($questaoModel->deletarQuestao($_GET['id'])) {
                header("Location: questoes.php?sucesso=deletado");
                exit();
            }
        }
    }
}
