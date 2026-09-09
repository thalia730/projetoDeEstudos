<?php
require_once 'config/conexao.php';
require_once 'models/questao.php';

class alunoController
{
    public function carregarSimulado()
    {
        global $conexao;
        $questaoModel = new Questao($conexao);

        if (isset($_GET['id_materia']) && !empty($_GET['id_materia'])) {
            return $questaoModel->listarQuestoes($_GET['id_materia']);
        }
        return $questaoModel->listarQuestoes();
    }
    public function corrigirQuestoes()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            global $conexao;
            $questaoModel = new Questao($conexao);

            $id_questao = $_POST['id_questao'];
            $resposta_aluno = $_POST['resposta_marcada'];

            $questao = $questaoModel->buscarQuestaoPorId($id_questao);
            if ($questao['resposta_correta'] === $resposta_aluno) {
                header('Location: simulado.php?sucesso=correto&id=' . $id_questao);
            } else {
                header('Location: simulado.php?resultado=errado&id=' . $id_questao);
            }
            exit();
        }
    }
}
