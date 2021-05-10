<?php

class Endereco
{
    private $id = 0;
    private $nome = null;
    private $cidade_id = null;

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setNome(string $nome): void
    {
        $this->nome = $nome;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function setCidade_id(int $cidade_id): void
    {
        $this->cidade_id = $cidade_id;
    }

    public function getCidade_id(): int
    {
        return $this->cidade_id;
    }

    private function connection(): \PDO
    {
        $db_user = 'root';
        $db_password = '';
        $db_name = 'testephppuro';
        return new PDO('mysql:host=localhost:3306;dbname=' . $db_name . ';charset=utf8', $db_user, $db_password);
    }

    public function read(): array
    {
        $con = $this->connection();
        if ($this->getId() === 0) {
            $stmt = $con->prepare("SELECT * FROM endereco ORDER BY id ASC");
            if ($stmt->execute()) {
                return $stmt->fetchAll(\PDO::FETCH_ASSOC);
            }
        } else if ($this->getId() > 0) {
            $stmt = $con->prepare("SELECT * FROM endereco WHERE id = :id");
            $stmt->bindValue(':id', $this->getId(), \PDO::PARAM_INT);
            if ($stmt->execute()) {
                return $stmt->fetchAll(\PDO::FETCH_ASSOC);
            }
        }
        return [];
    }

}