<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Pessoa.php';
require_once __DIR__ . '/../vendor/autoload.php'; // Autoload do Composer

use Ramsey\Uuid\Uuid;

class PessoaController {
    public function criarPessoa() {
        $dados = json_decode(file_get_contents("php://input"), true);

        if (!is_array($dados)) {
            http_response_code(400);
            
            return;
        }

        $pessoa = new Pessoa($dados);

        $erros = $pessoa->validar();

        if ($pessoa->existeId()) {
            http_response_code(422);
            
            return;
        }

        if (!empty($erros)) {
            http_response_code(422);
            
            return;
        }

        if ($pessoa->salvar()) {
            http_response_code(201);
            
        } else {
            http_response_code(500);
            
        }
    }
}
