<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../vendor/autoload.php';
use Ramsey\Uuid\Uuid;


class Vaga
{
    public $id, $empresa, $titulo, $descricao, $localizacao, $nivel;

    public function __construct($dados)
    {
        $this->id = $dados['id'] ?? null;
        $this->empresa = $dados['empresa'] ?? null;
        $this->titulo = $dados['titulo'] ?? null;
        $this->descricao = $dados['descricao'] ?? null;
        $this->localizacao = $dados['localizacao'] ?? null;
        $this->nivel = $dados['nivel'] ?? null;
    }

    public function existeId()
{
    $db = new Database();
    $pdo = $db->connect();
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM vagas WHERE id = ?");
    $stmt->execute([$this->id]);
    return $stmt->fetchColumn() > 0;
}

//O array de erros foi usado para verificar se as funcionalidades estavão funcionando no controller.
//Na versão final as mensagens de erro não foram utilizadas devido um dos requisitos da avaliação ser não ter nenhum corpo na resposta.
    public function validar()
    {
        $erros = [];

        if (!$this->id || !Uuid::isValid($this->id)) {
    $erros[] = "ID deve ser um UUID válido";
}
        if (!$this->empresa) $erros[] = "Empresa é obrigatória";
        if (!$this->titulo) $erros[] = "Título é obrigatório";
        $locaisValidos = ['A','B','C','D','E','F'];
        if (!$this->localizacao || !in_array(strtoupper($this->localizacao), $locaisValidos)) {
            $erros[] = "Localização inválida";
        }


        if (!is_numeric($this->nivel)) {
    $erros[] = "Nível deve ser numérico";
} else {
    $nivelInt = (int) $this->nivel;
    if ($nivelInt < 1 || $nivelInt > 5) {
        $erros[] = "Nível deve estar entre 1 e 5";
    }
}

        return $erros;
    }

   public function salvar()
{

    $db = new Database();
    $pdo = $db->connect();

    $stmt = $pdo->prepare("INSERT INTO vagas (id, empresa, titulo, descricao, localizacao, nivel)
                           VALUES (?, ?, ?, ?, ?, ?)");
    return $stmt->execute([
        $this->id, $this->empresa, $this->titulo,
        $this->descricao, $this->localizacao, $this->nivel
    ]);
    
 
    
}

}
