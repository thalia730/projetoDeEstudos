<?php

class Resumo
{
    private $conexao;

    public function __construct($conexao)
    {
        $this->conexao = $conexao;
    }

    public function adicionarResumo($id_materia, $titulo, $conteudo)
    {
        $sql = "INSERT INTO resumos
                (id_materia, titulo, conteudo)
                VALUES
                (:id_materia, :titulo, :conteudo)";

        $stmt = $this->conexao->prepare($sql);

        $stmt->bindParam(':id_materia', $id_materia);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':conteudo', $conteudo);

        return $stmt->execute();
    }

    public function listarResumos()
    {
        $sql = "SELECT resumos.*, materias.nome AS materia
                FROM resumos
                INNER JOIN materias
                ON resumos.id_materia = materias.id
                ORDER BY materias.nome, resumos.titulo";

        $stmt = $this->conexao->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

   public function listarResumosPorMateria($id_materia)
{
    $sql = "SELECT resumos.*, materias.nome AS materia
            FROM resumos
            INNER JOIN materias
            ON resumos.id_materia = materias.id
            WHERE resumos.id_materia = :id_materia
            ORDER BY resumos.titulo";

    $stmt = $this->conexao->prepare($sql);

    $stmt->bindParam(':id_materia', $id_materia);

    $stmt->execute();

    return $stmt->fetchAll();
}
    public function buscarResumoPorId($id)
    {
        $sql = "SELECT resumos.*, materias.nome AS materia
                FROM resumos
                INNER JOIN materias
                ON resumos.id_materia = materias.id
                WHERE resumos.id = :id";

        $stmt = $this->conexao->prepare($sql);

        $stmt->bindParam(':id', $id);

        $stmt->execute();

        return $stmt->fetch();
    }

    public function atualizarResumo($id, $id_materia, $titulo, $conteudo)
    {
        $sql = "UPDATE resumos
                SET id_materia = :id_materia,
                    titulo = :titulo,
                    conteudo = :conteudo
                WHERE id = :id";

        $stmt = $this->conexao->prepare($sql);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':id_materia', $id_materia);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':conteudo', $conteudo);

        return $stmt->execute();
    }

    public function deletarResumo($id)
    {
        $sql = "DELETE FROM resumos WHERE id = :id";

        $stmt = $this->conexao->prepare($sql);

        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }
}