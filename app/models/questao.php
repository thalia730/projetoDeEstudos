<?php

class questao {
    private $conexao;

    public function __construct($conexao) {
        $this->conexao = $conexao;
    }

    public function listarQuestoes() {
        $sql = "SELECT q.*, m.nome AS materia_nome 
        FROM questoes q 
        INNERJOIN materias m ON q.id_materia = m.id
        order by q.id desc";
        $stmt = $this->conexao->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function adicionarQuestao($enunciado,$alternativa_a, $alternativa_b, $alternativa_c, $alternativa_d, $resposta_correta, $id_materia) {
        $sql = "INSERT INTO questoes (enunciado, alternativa_a, alternativa_b, alternativa_c, alternativa_d, resposta_correta, id_materia) VALUES (:enunciado, :alternativa_a, :alternativa_b, :alternativa_c, :alternativa_d, :resposta_correta, :id_materia)";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(':enunciado', $enunciado);
        $stmt->bindParam(':alternativa_a', $alternativa_a);
        $stmt->bindParam(':alternativa_b', $alternativa_b);
        $stmt->bindParam(':alternativa_c', $alternativa_c);
        $stmt->bindParam(':alternativa_d', $alternativa_d);
        $stmt->bindParam(':resposta_correta', $resposta_correta);
        $stmt->bindParam(':id_materia', $id_materia);
        return $stmt->execute();
    }

    public function atualizarQuestao($id, $enunciado, $alternativa_a, $alternativa_b, $alternativa_c, $alternativa_d, $resposta_correta, $id_materia) {
        $sql = "UPDATE questoes SET enunciado = :enunciado, alternativa_a = :alternativa_a, alternativa_b = :alternativa_b, alternativa_c = :alternativa_c, alternativa_d = :alternativa_d, resposta_correta = :resposta_correta, id_materia = :id_materia WHERE id = :id";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':enunciado', $enunciado);
        $stmt->bindParam(':alternativa_a', $alternativa_a);
        $stmt->bindParam(':alternativa_b', $alternativa_b);
        $stmt->bindParam(':alternativa_c', $alternativa_c);
        $stmt->bindParam(':alternativa_d', $alternativa_d);
        $stmt->bindParam(':resposta_correta', $resposta_correta);
        $stmt->bindParam(':id_materia', $id_materia);
        return $stmt->execute();
    }

    public function deletarQuestao($id) {
        $sql = "DELETE FROM questoes WHERE id = :id";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function buscarQuestaoPorId($id) {
        $sql = "SELECT * FROM questoes WHERE id = :id";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }
}