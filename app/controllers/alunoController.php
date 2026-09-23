<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../../config/conexao.php';
require_once __DIR__ . '/../models/questao.php';
require_once __DIR__ . '/../models/meta.php';

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

            $questoes = $_POST['questoes'] ?? [];
            $respostas = $_POST['respostas'] ?? [];
            $email = $_SESSION['email'] ?? null;

            if (empty($questoes) || empty($respostas) || !$email) {
                die("Erro ao finalizar o simulado: " .
                    "não foi possível encontrar as questões, as respostas ou o aluno logado.");
            }

            $acertos = 0;
            $erros = 0;

            $respostasSalvas = [];

            foreach ($questoes as $id_questao) {

                if (!isset($respostas[$id_questao])) {
                    continue;
                }

                $resposta_aluno = $respostas[$id_questao];

                $respostasSalvas[$id_questao] = $resposta_aluno;

                $questao = $questaoModel->buscarQuestaoPorId($id_questao);

                if (!$questao) {
                    continue;
                }

                $acertou = ($questao['resposta_correta'] === $resposta_aluno) ? 1 : 0;

                if ($acertou) {
                    $acertos++;
                } else {
                    $erros++;
                }

                $sql = "INSERT INTO respostas
                (email_aluno, id_questao, resposta_marcada, acertou)
                VALUES (:email_aluno, :id_questao, :resposta_marcada, :acertou)
                ON DUPLICATE KEY UPDATE
                resposta_marcada = :resposta_marcada_update,
                acertou = :acertou_update,
                data_resposta = CURRENT_TIMESTAMP";

                $stmt = $conexao->prepare($sql);

                $stmt->bindParam(':email_aluno', $email);
                $stmt->bindParam(':id_questao', $id_questao);
                $stmt->bindParam(':resposta_marcada', $resposta_aluno);
                $stmt->bindParam(':acertou', $acertou);
                $stmt->bindParam(':resposta_marcada_update', $resposta_aluno);
                $stmt->bindParam(':acertou_update', $acertou);

                $stmt->execute();
            }

            $total = $acertos + $erros;

            if ($total > 0) {
                $porcentagem = round(($acertos / $total) * 100);
            } else {
                $porcentagem = 0;
            }

            $respostasTexto = json_encode($respostasSalvas);
            $respostasTexto = urlencode($respostasTexto);
            header(
                'Location: /projetoDeEstudos/views/aluno/resultado.php?' .
                    'total=' . $total .
                    '&acertos=' . $acertos .
                    '&erros=' . $erros .
                    '&porcentagem=' . $porcentagem .
                    '&respostas=' . $respostasTexto 
            );

            exit();
        }
    }
    public function criarMeta()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        global $conexao;

        $email = $_SESSION['email'] ?? null;

        if (!$email) {
            die("Aluno não está logado.");
        }

        $metaModel = new Meta($conexao);

        $metaModel->adicionarMeta(
            $email,
            $_POST['titulo'],
            $_POST['descricao']
        );

        header("Location: /projetoDeEstudos/views/aluno/metas.php?sucesso=cadastrada");
        exit();
    }
}

public function editarMeta()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        global $conexao;

        $email = $_SESSION['email'] ?? null;

        if (!$email) {
            die("Aluno não está logado.");
        }

        $metaModel = new Meta($conexao);

        $metaModel->atualizarMeta(
            $_POST['id'],
            $email,
            $_POST['titulo'],
            $_POST['descricao']
        );

        header("Location: /projetoDeEstudos/views/aluno/metas.php?sucesso=editada");
        exit();
    }
}

public function deletarMeta()
{
    if (isset($_GET['id'])) {
        global $conexao;

        $email = $_SESSION['email'] ?? null;

        if (!$email) {
            die("Aluno não está logado.");
        }

        $metaModel = new Meta($conexao);

        $metaModel->deletarMeta(
            $_GET['id'],
            $email
        );

        header("Location: /projetoDeEstudos/views/aluno/metas.php?sucesso=deletada");
        exit();
    }
}

public function concluirMeta()
{
    if (isset($_GET['id'])) {
        global $conexao;

        $email = $_SESSION['email'] ?? null;

        if (!$email) {
            die("Aluno não está logado.");
        }

        $metaModel = new Meta($conexao);

        $metaModel->concluirMeta(
            $_GET['id'],
            $email
        );

        header("Location: /projetoDeEstudos/views/aluno/metas.php");
        exit();
    }
}
}
