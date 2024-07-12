<?php

class Usuario
{
    private $conn;
    private $table_name = "usuarios";

    public function __construct($dbProjeto)
    {
        $this->conn = $dbProjeto;
    }

    public function registrar($nome, $sexo, $fone, $email, $senha, $cargo)
    {
        if ($this->emailExiste($email)) {
            return false; // Email já existe
        }

        $query = "INSERT INTO " . $this->table_name . " (nome, sexo, fone, email, senha, cargo) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $hashed_password = password_hash($senha, PASSWORD_BCRYPT);

        $stmt->execute([$nome, $sexo, $fone, $email, $hashed_password, $cargo]);
        return $stmt;
    }

    public function emailExiste($email)
    {
        $query = "SELECT id FROM " . $this->table_name . " WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$email]);
        return $stmt->rowCount() > 0;
    }

    public function login($email, $senha)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($usuario && password_verify($senha, $usuario['senha'])) {
            return $usuario;
        }
        return false;
    }

    public function listarUsuarios()
    {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUsuarioById($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function editarUsuario($id, $nome, $sexo, $fone, $email, $cargo, $ferias)
    {
        $query = "UPDATE " . $this->table_name . " SET nome = ?, sexo = ?, fone = ?, email = ?, cargo = ?, ferias = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$nome, $sexo, $fone, $email, $cargo, $ferias, $id]);
        return $stmt;
    }

    public function excluirUsuario($id)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->rowCount() > 0;
    }

    public function adicionarGrupo($id, $grupo)
    {
        $query = "UPDATE " . $this->table_name . " SET idgru = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$grupo, $id]);
        return $stmt;
    }

    public function removerGrupo($usuario_id)
    {
        $query = "UPDATE " . $this->table_name . " SET idgru = NULL WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$usuario_id]);
        return $stmt->rowCount() > 0;
    }


    public function getGrupoById($id)
    {
        $query = "SELECT idgru FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function listarUsuariosPorGrupo($grupo_id)
    {
        try {
            $query = "SELECT * FROM usuarios WHERE idgru = :grupo_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':grupo_id', $grupo_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erro ao listar usuários por grupo: " . $e->getMessage();
            return array();
        }
    }
    
    public function verificarFerias($id) {
        $query = "SELECT ferias FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
