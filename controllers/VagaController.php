<?php
require_once __DIR__ . '/../models/Vaga.php';
require_once __DIR__ . '/../models/CandidaturaModel.php';
require_once __DIR__ . '/../vendor/autoload.php';


use Ramsey\Uuid\Uuid;

class VagaController
{
    public function criarVaga()
    {
        $dados = json_decode(file_get_contents("php://input"), true);

        if (!is_array($dados)) {
            http_response_code(400);
            
            return;
        }

        if (!isset($dados['id'])) {
    http_response_code(422);
    
    return;
}


        $vaga = new Vaga($dados);

        $erros = $vaga->validar();

        if (!empty($erros)) {
            http_response_code(422);

            return;
        }
        if ($vaga->existeId()) {
    http_response_code(422);
    return;
}

        if ($vaga->salvar()) {
            http_response_code(201);
        } else {
            http_response_code(400);
        }
    }

    public function getRanking($id)
    {
        $model = new CandidaturaModel();
        $ranking = $model->getRankingPorVaga($id);

        if (empty($ranking)) {
            http_response_code(404);
            return;
        }

        http_response_code(200);
        echo json_encode($ranking);
    }
    
}
