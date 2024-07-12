<?php
class Tarefa {
private $conn;
private $table_name = "tarefas";
public function __construct($db) {
$this->conn = $db;
}
public function registrar($id, $nome, $descricao) {
$query = "INSERT INTO " . $this->table_name . " (idgrupo, nome, descricao) VALUES (?, ?, ?)";
$stmt = $this->conn->prepare($query);
$stmt->execute([$id, $nome, $descricao]);
return $stmt;
}

public function criar($id, $nome, $descricao) {
return $this->registrar($id, $nome, $descricao);
}
public function lerIdgrupo($id) {
    $query = "SELECT * FROM " . $this->table_name . " INNER JOIN grupos WHERE idgrupo = ? AND id = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$id, $id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function ler() {
    $query = "SELECT * FROM " . $this->table_name . " INNER JOIN grupos WHERE id = idgrupo";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
    }


public function lerPorId($id) {
$query = "SELECT * FROM " . $this->table_name . " WHERE idtarefa = ?";
$stmt = $this->conn->prepare($query);
$stmt->execute([$id]);
return $stmt->fetch(PDO::FETCH_ASSOC);
}
public function atualizar($id, $progresso, $anotacao) {
$query = "UPDATE " . $this->table_name . " SET progresso = ?, anotacao = ? WHERE idtarefa = ?";
$stmt = $this->conn->prepare($query);
$stmt->execute([$progresso, $anotacao, $id]);
return $stmt;
}
public function deletar($idtarefa) {
$query = "DELETE FROM " . $this->table_name . " WHERE idtarefa = ?";
$stmt = $this->conn->prepare($query);
$stmt->execute([$idtarefa]);
return $stmt;
}

}
?>