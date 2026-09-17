<?php

class Questao
{

    private $conexao;

    public function __construct($conexao)
    {
        $this->conexao = $conexao;
    }

    public function listarQuestoes($id_materia = null)
    {

        $sql = "SELECT q.*, m.nome AS materia_nome 
        FROM questoes q 
        INNER JOIN materias m ON q.id_materia = m.id";

        if ($id_materia !== null) {
            $sql .= " WHERE q.id_materia = :id_materia";
        }

        $sql .= " ORDER BY q.id DESC";

        $stmt = $this->conexao->prepare($sql);

        if ($id_materia !== null) {
            $stmt->bindParam(':id_materia', $id_materia);
        }
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function listarQuestoesSimulado($materias, $status, $quantidade, $email)
    {

        $placeholders = implode(',', array_fill(0, count($materias), '?'));

        $sql = "SELECT q.*, m.nome AS materia_nome
            FROM questoes q
            INNER JOIN materias m ON q.id_materia = m.id
            LEFT JOIN respostas r
            ON q.id = r.id_questao
            AND r.email_aluno = ?
            WHERE q.id_materia IN ($placeholders)";

        $parametros = [$email];

        foreach ($materias as $materia) {
            $parametros[] = $materia;
        }

        if ($status === 'acertou') {

            $sql .= " AND r.acertou = 1";
        } elseif ($status === 'errou') {

            $sql .= " AND r.acertou = 0";
        } elseif ($status === 'nao_feitas') {

            $sql .= " AND r.id IS NULL";
        }

        $sql .= " ORDER BY RAND() LIMIT " . (int)$quantidade;

        $stmt = $this->conexao->prepare($sql);

        $stmt->execute($parametros);

        return $stmt->fetchAll();
    }

    public function adicionarQuestao($enunciado, $alternativa_a, $alternativa_b, $alternativa_c, $alternativa_d, $resposta_correta, $id_materia, $explicacao)
    {

        $sql = "INSERT INTO questoes (enunciado, alternativa_a, alternativa_b, alternativa_c, alternativa_d, resposta_correta, id_materia, explicacao) VALUES (:enunciado, :alternativa_a, :alternativa_b, :alternativa_c, :alternativa_d, :resposta_correta, :id_materia, :explicacao)";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(':enunciado', $enunciado);
        $stmt->bindParam(':alternativa_a', $alternativa_a);
        $stmt->bindParam(':alternativa_b', $alternativa_b);
        $stmt->bindParam(':alternativa_c', $alternativa_c);
        $stmt->bindParam(':alternativa_d', $alternativa_d);
        $stmt->bindParam(':resposta_correta', $resposta_correta);
        $stmt->bindParam(':id_materia', $id_materia);
        $stmt->bindParam(':explicacao', $explicacao);
        return $stmt->execute();
    }

    public function atualizarQuestao($id, $enunciado, $alternativa_a, $alternativa_b, $alternativa_c, $alternativa_d, $resposta_correta, $id_materia, $explicacao)
    {
        $sql = "UPDATE questoes SET enunciado = :enunciado, alternativa_a = :alternativa_a, alternativa_b = :alternativa_b, alternativa_c = :alternativa_c, alternativa_d = :alternativa_d, resposta_correta = :resposta_correta, id_materia = :id_materia, explicacao = :explicacao WHERE id = :id";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':enunciado', $enunciado);
        $stmt->bindParam(':alternativa_a', $alternativa_a);
        $stmt->bindParam(':alternativa_b', $alternativa_b);
        $stmt->bindParam(':alternativa_c', $alternativa_c);
        $stmt->bindParam(':alternativa_d', $alternativa_d);
        $stmt->bindParam(':resposta_correta', $resposta_correta);
        $stmt->bindParam(':id_materia', $id_materia);
        $stmt->bindParam(':explicacao', $explicacao);
        return $stmt->execute();
    }

    public function deletarQuestao($id)
    {
        $sql = "DELETE FROM questoes WHERE id = :id";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function buscarQuestaoPorId($id)
    {
        $sql = "SELECT * FROM questoes WHERE id = :id";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }
}
