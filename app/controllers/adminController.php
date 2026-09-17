<?php
require_once __DIR__ . '/../../config/conexao.php';
require_once __DIR__ . '/../models/usuario.php';
require_once __DIR__ . '/../models/questao.php';
require_once __DIR__ . '/../models/materia.php';

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
                header("Location: materias.php?sucesso=editado");
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
                header("Location: materia.php?sucesso=deletado");
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
                $_POST['alternativa_d'],
                $_POST['resposta_correta'],
                $_POST['id_materia'],
                $_POST['explicacao']
            );
            if ($sucesso) {
                header("Location: /projetoDeEstudos/views/admin/cadastrarQuestao.php?sucesso=cadastrado");
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
                $_POST['enunciado'],
                $_POST['alternativa_a'],
                $_POST['alternativa_b'],
                $_POST['alternativa_c'],
                $_POST['alternativa_d'],
                $_POST['resposta_correta'],
                $_POST['id_materia'],
                $_POST['explicacao']
            );

            if ($sucesso) {

                header(
                    "Location: /projetoDeEstudos/views/admin/questoes.php?id_materia="
                        . $_POST['id_materia']
                        . "&sucesso=editado"
                );

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

                $id_materia = $_GET['id_materia'] ?? '';

                header(
                    "Location: /projetoDeEstudos/views/admin/questoes.php?id_materia="
                        . $id_materia
                        . "&sucesso=deletado"
                );

                exit();
            }
        }
    }
}
