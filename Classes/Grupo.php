<?php

class Grupo {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function listarGrupos() {
        $query = "SELECT * FROM grupos";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function cadastrarGrupo($nome, $membros) {
        $query = "INSERT INTO grupos (nome, membros) VALUES (:nome, :membros)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':membros', $membros, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Verifica se o grupo já existe
    public function grupoExiste($nome) {
        $query = "SELECT COUNT(*) FROM grupos WHERE nome = :nome";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    public function excluirGrupo($grupo_id) {
        $query = "DELETE FROM grupos WHERE id = :grupo_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':grupo_id', $grupo_id, PDO::PARAM_INT);
        return $stmt->execute();
    }    

    public function getMembrosPorGrupo($grupo_id) {
        // Lógica para obter o número máximo de membros do grupo do banco de dados
        $query = "SELECT membros FROM grupos WHERE id = :grupo_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':grupo_id', $grupo_id);
        $stmt->execute();
    
        return $stmt->fetchColumn(); // Retorna o número de membros
    }
}
?>