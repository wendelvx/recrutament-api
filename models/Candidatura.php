<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../vendor/autoload.php'; // Para ramsey/uuid

use Ramsey\Uuid\Uuid;

class Candidatura {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    // Verifica se string é UUID válido
    private function validarUuid(string $uuid): bool {
        return Uuid::isValid($uuid);
    }
    
    public function idCandidaturaExiste($id) {
    $sql = "SELECT COUNT(*) FROM candidaturas WHERE id = :id";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetchColumn() > 0;
}


    public function existeVaga(string $id_vaga): bool {
        if (!$this->validarUuid($id_vaga)) {
            return false;
        }

        $query = "SELECT id FROM vagas WHERE id = :id_vaga";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_vaga', $id_vaga);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function existePessoa(string $id_pessoa): bool {
        if (!$this->validarUuid($id_pessoa)) {
            return false;
        }
        $query = "SELECT id FROM pessoas WHERE id = :id_pessoa";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_pessoa', $id_pessoa);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function jaCandidatado(string $id_vaga, string $id_pessoa): bool {
        if (!$this->validarUuid($id_vaga) || !$this->validarUuid($id_pessoa)) {
            return false;
        }

        $query = "SELECT id FROM candidaturas WHERE id_vaga = :id_vaga AND id_pessoa = :id_pessoa";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_vaga', $id_vaga);
        $stmt->bindParam(':id_pessoa', $id_pessoa);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function salvar(string $id, string $id_vaga, string $id_pessoa): bool {
        if (!$this->validarUuid($id)) {
            return false;
        }

            $query = "INSERT INTO candidaturas (id, id_vaga, id_pessoa)
                      VALUES (:id, :id_vaga, :id_pessoa)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':id_vaga', $id_vaga);
            $stmt->bindParam(':id_pessoa', $id_pessoa);

            return $stmt->execute();

        
    }
}
?>
