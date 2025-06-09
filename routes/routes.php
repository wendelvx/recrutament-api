<?php
require_once __DIR__ . '/../controllers/PessoaController.php';
require_once __DIR__ . '/../controllers/VagaController.php';
require_once __DIR__ . '/../controllers/CandidaturaController.php';


$uri = str_replace('/recrutamento-api/public', '', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

$method = $_SERVER['REQUEST_METHOD'];

if (preg_match('#/pessoas$#', $uri) && $method === 'POST') {
    $controller = new PessoaController();
    $controller->criarPessoa();
    exit;
}

if (preg_match('#/vagas$#', $uri) && $method === 'POST') {
    $controller = new VagaController();
    $controller->criarVaga();
    exit;
}

if (preg_match('#/candidaturas$#', $uri) && $method === 'POST') {
    $controller = new CandidaturaController();
    $controller->criarCandidatura();
    exit;
}

if (preg_match('#^/vagas/([a-f0-9\-]+)/candidaturas/ranking$#', $uri, $matches) && $method === 'GET') {
    $controller = new VagaController();
    $controller->getRanking($matches[1]);
    exit;
}

// Caso não encontre rota
http_response_code(404);

?>