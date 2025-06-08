<?php
require_once __DIR__ . '/../models/Candidatura.php';
require_once __DIR__ . '/../vendor/autoload.php';

use Ramsey\Uuid\Uuid;

class CandidaturaController {
    public function criarCandidatura() {
        $dados = json_decode(file_get_contents("php://input"), true);

    
        if (!is_array($dados)) {
            http_response_code(400); 
            return;
        }

        if (!isset($dados['id'], $dados['id_vaga'], $dados['id_pessoa'])) {
            http_response_code(400); 
            return;
        }

        // Validação dos UUIDs
        if (!Uuid::isValid($dados['id']) || !Uuid::isValid($dados['id_vaga']) || !Uuid::isValid($dados['id_pessoa'])) {
            http_response_code(400); 
            return;
        }

        $candidatura = new Candidatura();

        if (!$candidatura->existeVaga($dados['id_vaga']) || !$candidatura->existePessoa($dados['id_pessoa'])) {
            http_response_code(404); 
            return;
        }

        if ($candidatura->jaCandidatado($dados['id_vaga'], $dados['id_pessoa'])) {
            http_response_code(400); 
            return;
        }

    
        if ($candidatura->idCandidaturaExiste($dados['id'])) {
            http_response_code(400); 
            return;
        }

        
        if ($candidatura->salvar($dados['id'], $dados['id_vaga'], $dados['id_pessoa'])) {
            http_response_code(201); 
            return;
        } else {
            http_response_code(400); // Internal Server Error, foi usado código 400 por especificação do desafio, mas o correto aqui seria 500.
            return;
        }
    }
}
?>
