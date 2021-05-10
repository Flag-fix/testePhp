<?php

class Usuario
{
    private $id = 0;
    private $nome = null;
    private $endereco_id = null;
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

    public function setEndereco_id(int $endereco_id): void
    {
        $this->endereco_id = $endereco_id;
    }

    public function getEndereco_id(): int
    {
        return $this->endereco_id;
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

    public function create(): array
    {
        $con = $this->connection();
        $stmt = $con->prepare("INSERT INTO usuario VALUES (NULL,:nome,:endereco_id)");
        $stmt->bindValue(':nome', $this->getNome(), \PDO::PARAM_STR);
        $stmt->bindValue(':endereco_id', $this->getEndereco_id(), \PDO::PARAM_INT);
        if ($stmt->execute()) {
            $this->setId($con->lastInsertId());
            return $this->read();
        }
        return [];
    }

    public function read(): array
    {
        $con = $this->connection();
        if ($this->getId() === 0) {
            $stmt = $con->prepare("
            SELECT u.nome Usuario, e.nome Endereco, c.nome Cidade , CONCAT(est.nome,' - ',est.UF) Estado
            FROM usuario u
            INNER JOIN endereco e ON e.id = u.endereco_id
            INNER JOIN cidade c ON c.id = e.cidade_id
            INNER JOIN estado est ON est.id = c.estado_id
            ORDER BY u.id ASC");
            if ($stmt->execute()) {
                return $stmt->fetchAll(\PDO::FETCH_ASSOC);
            }
        } else if ($this->getId() > 0) {
            $stmt = $con->prepare("
            SELECT u.nome Usuario, e.nome Endereco, c.nome Cidade , CONCAT(est.nome,' - ',est.UF) Estado
            FROM usuario u
            INNER JOIN endereco e ON e.id = u.endereco_id
            INNER JOIN cidade c ON c.id = e.cidade_id
            INNER JOIN estado est ON est.id = c.estado_id            
            WHERE u.id = :id");
            $stmt->bindValue(':id', $this->getId(), \PDO::PARAM_INT);
            if ($stmt->execute()) {
                return $stmt->fetchAll(\PDO::FETCH_ASSOC);
            }
        }
        return [];
    }

    public function readCidade(): array
    {
        $con = $this->connection();
        if ($this->getId() === 0) {
            $stmt = $con->prepare("
            SELECT c.nome, COUNT(u.id) Total
            FROM usuario u
            INNER JOIN endereco e ON e.id = u.endereco_id
            INNER JOIN cidade c ON c.id = e.cidade_id
            WHERE e.cidade_id = c.id
            GROUP BY c.nome");
            if ($stmt->execute()) {
                return $stmt->fetchAll(\PDO::FETCH_ASSOC);
            }
        } else if ($this->getId() > 0) {
            $stmt = $con->prepare("
            SELECT c.nome, COUNT(u.id) Total
            FROM usuario u
            INNER JOIN endereco e ON e.id = u.endereco_id
            INNER JOIN cidade c ON c.id = e.cidade_id
            WHERE e.cidade_id = :id
            GROUP BY c.nome");
            $stmt->bindValue(':id', $this->getId(), \PDO::PARAM_INT);
            if ($stmt->execute()) {
                return $stmt->fetchAll(\PDO::FETCH_ASSOC);
            }
        }
        return [];
    }
    public function readEstado(): array
    {
        $con = $this->connection();
        if ($this->getId() === 0) {
            $stmt = $con->prepare("
            SELECT est.nome, COUNT(u.id) Total
            FROM usuario u
            INNER JOIN endereco e ON e.id = u.endereco_id
            INNER JOIN cidade c ON c.id = e.cidade_id
            INNER JOIN estado est ON est.id = c.estado_id
            WHERE c.estado_id = est.id
            GROUP BY est.nome");
            if ($stmt->execute()) {
                return $stmt->fetchAll(\PDO::FETCH_ASSOC);
            }
        } else if ($this->getId() > 0) {
            $stmt = $con->prepare("
            SELECT est.nome, COUNT(u.id) Total
            FROM usuario u
            INNER JOIN endereco e ON e.id = u.endereco_id
            INNER JOIN cidade c ON c.id = e.cidade_id
            INNER JOIN estado est ON est.id = c.estado_id
            WHERE est.id = :id
            GROUP BY est.nome");
            $stmt->bindValue(':id', $this->getId(), \PDO::PARAM_INT);
            if ($stmt->execute()) {
                return $stmt->fetchAll(\PDO::FETCH_ASSOC);
            }
        }
        return [];
    }






    public function update(): array
    {
        $con = $this->connection();
        $stmt = $con->prepare("UPDATE usuario SET nome = :nome, endereco_id = :endereco_id,cidade_id= :cidade_id  WHERE id = :id");
        $stmt->bindValue(':nome', $this->getNome(), \PDO::PARAM_STR);
        $stmt->bindValue(':endereco_id', $this->getEndereco_id(), \PDO::PARAM_INT);
        $stmt->bindValue(':cidade_id', $this->getCidade_id(), \PDO::PARAM_INT);
        $stmt->bindValue(':id', $this->getId(), \PDO::PARAM_INT);
        if ($stmt->execute()) {
            return $this->read();
        }
        return [];
    }

    public function delete(): array
    {
        $user = $this->read();
        $con = $this->connection();
        $stmt = $con->prepare("DELETE FROM usuario WHERE id = :id");
        $stmt->bindValue(':id', $this->getId(), \PDO::PARAM_INT);
        if ($stmt->execute()) {
            return $user;
        }
        return [];
    }

}