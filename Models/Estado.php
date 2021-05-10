<?php

class Estado
{
    private $id = 0;
    private $nome = null;
    private $UF = null;

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

    public function setUF(int $UF): void
    {
        $this->UF = $UF;
    }

    public function getUF(): int
    {
        return $this->UF;
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
            $stmt = $con->prepare("SELECT * FROM estado ORDER BY id ASC");
            if ($stmt->execute()) {
                return $stmt->fetchAll(\PDO::FETCH_ASSOC);
            }
        } else if ($this->getId() > 0) {
            $stmt = $con->prepare("SELECT * FROM estado WHERE id = :id");
            $stmt->bindValue(':id', $this->getId(), \PDO::PARAM_INT);
            if ($stmt->execute()) {
                return $stmt->fetchAll(\PDO::FETCH_ASSOC);
            }
        }
        return [];
    }

}