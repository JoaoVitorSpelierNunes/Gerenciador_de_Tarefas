<?php
class Administrador
{
    private $conn;
    private $table_name = "administrador";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function login($nome, $codigo)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE nome = ? AND codigo = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$nome, $codigo]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>