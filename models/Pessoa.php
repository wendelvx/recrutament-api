<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../vendor/autoload.php'; // Autoload do Composer

use Ramsey\Uuid\Uuid;
class Pessoa {
    public $id, $nome, $profissao, $localizacao, $nivel;

    public function __construct($dados) {
        $this->id = $dados['id'] ?? null;
        $this->nome = trim($dados['nome'] ?? '');
        $this->profissao = trim($dados['profissao'] ?? '');
        $this->localizacao = $dados['localizacao'] ?? null;
        $this->nivel = $dados['nivel'] ?? null;
    }

    public function validar() {
        $erros = [];

        if (!$this->id || !Uuid::isValid($this->id)) {
            $erros[] = "ID deve ser um UUID válido";
        }
        if (!$this->nome) {
            $erros[] = "Nome é obrigatório";
        }
        if (!$this->profissao) {
            $erros[] = "Profissão é obrigatória";
        }
        $locaisValidos = ['A','B','C','D','E','F'];
        if (!$this->localizacao || !in_array(strtoupper($this->localizacao), $locaisValidos)) {
            $erros[] = "Localização inválida";
        }
        if (!is_numeric($this->nivel) || (int)$this->nivel < 1 || (int)$this->nivel > 5) {
            $erros[] = "Nível deve ser numérico entre 1 e 5";
        }

        return $erros;
    }

    public function existeId() {
        $db = new Database();
        $pdo = $db->connect();
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM pessoas WHERE id = ?");
        $stmt->execute([$this->id]);
        return $stmt->fetchColumn() > 0;
    }

    public function salvar() {
            $db = new Database();
        $pdo = $db->connect();

        $stmt = $pdo->prepare("INSERT INTO pessoas (id, nome, profissao, localizacao, nivel) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([
            $this->id,
            $this->nome,
            $this->profissao,
            $this->localizacao,
            $this->nivel
        ]);

        
    }
}

?>