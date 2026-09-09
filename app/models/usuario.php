<?php

class Usuario {
    private $conexao;

    public function __construct($conexao) {
        $this->conexao = $conexao;
    }

    public function listarUsuarios() {
        $sql = "SELECT * FROM usuarios";
        $stmt = $this->conexao->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function adicionarUsuario($nome, $email, $senha) {
        $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', password_hash($senha, PASSWORD_DEFAULT));
        return $stmt->execute();
    }

    public function atualizarUsuario($id, $nome, $email) {
        $sql = "UPDATE usuarios SET nome = :nome, email = :email WHERE id = :id";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        return $stmt->execute();
    }

    public function deletarUsuario($id) {
        $sql = "DELETE FROM usuarios WHERE id = :id";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function buscarUsuarioPorId($id) {
        $sql = "SELECT * FROM usuarios WHERE id = :id";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }
}