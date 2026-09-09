<?php

class Materia {
    private $conexao;

    public function __construct($conexao) {
        $this->conexao = $conexao;
    }

    public function listarMaterias() {
        $sql = "SELECT * FROM materias";
        $stmt = $this->conexao->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function adicionarMateria($nome) {
        $sql = "INSERT INTO materias (nome ) VALUES (:nome)";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        return $stmt->execute();
    }

    public function atualizarMateria($id, $nome) {
        $sql = "UPDATE materias SET nome = :nome WHERE id = :id";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nome', $nome);
        return $stmt->execute();
    }

    public function deletarMateria($id) {
        $sql = "DELETE FROM materias WHERE id = :id";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function buscarMateriaPorId($id) {
        $sql = "SELECT * FROM materias WHERE id = :id";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }
}
