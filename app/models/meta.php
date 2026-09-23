<?php

class Meta
{
    private $conexao;

    public function __construct($conexao)
    {
        $this->conexao = $conexao;
    }

    public function adicionarMeta($email, $titulo, $descricao)
    {
        $sql = "INSERT INTO metas
                (email_aluno, titulo, descricao)
                VALUES
                (:email, :titulo, :descricao)";

        $stmt = $this->conexao->prepare($sql);

        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':descricao', $descricao);

        return $stmt->execute();
    }

    public function listarMetas($email)
    {
        $sql = "SELECT *
                FROM metas
                WHERE email_aluno = :email
                ORDER BY concluida, data_criacao DESC";

        $stmt = $this->conexao->prepare($sql);

        $stmt->bindParam(':email', $email);

        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function buscarMetaPorId($id, $email)
    {
        $sql = "SELECT *
                FROM metas
                WHERE id = :id
                AND email_aluno = :email";

        $stmt = $this->conexao->prepare($sql);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':email', $email);

        $stmt->execute();

        return $stmt->fetch();
    }

    public function atualizarMeta($id, $email, $titulo, $descricao)
    {
        $sql = "UPDATE metas
                SET titulo = :titulo,
                    descricao = :descricao
                WHERE id = :id
                AND email_aluno = :email";

        $stmt = $this->conexao->prepare($sql);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':descricao', $descricao);

        return $stmt->execute();
    }

    public function deletarMeta($id, $email)
    {
        $sql = "DELETE FROM metas
                WHERE id = :id
                AND email_aluno = :email";

        $stmt = $this->conexao->prepare($sql);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':email', $email);

        return $stmt->execute();
    }

    public function concluirMeta($id, $email)
    {
        $sql = "UPDATE metas
                SET concluida = NOT concluida
                WHERE id = :id
                AND email_aluno = :email";

        $stmt = $this->conexao->prepare($sql);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':email', $email);

        return $stmt->execute();
    }
}