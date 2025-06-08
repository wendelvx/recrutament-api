<?php
require_once __DIR__ . '/../config/database.php';

class CandidaturaModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    private function getDistancia($origem, $destino) {
        $grafo = [
            'A' => ['B' => 5],
            'B' => ['A' => 5, 'C' => 7, 'D' => 3],
            'C' => ['B' => 7, 'E' => 4],
            'D' => ['B' => 3, 'E' => 10, 'F' => 8],
            'E' => ['C' => 4, 'D' => 10],
            'F' => ['D' => 8]
        ];

        // Valida se origem e destino existem no grafo
        if (!isset($grafo[$origem]) || !isset($grafo[$destino])) {
            return -1; // Distância inválida
        }

        $distancias = [];
        $visitados = [];

        foreach ($grafo as $vertice => $vizinhos) {
            $distancias[$vertice] = INF;
            $visitados[$vertice] = false;
        }

        $distancias[$origem] = 0;

        while (true) {
            $minDist = INF;
            $minVertice = null;

            foreach ($distancias as $vertice => $dist) {
                if (!$visitados[$vertice] && $dist < $minDist) {
                    $minDist = $dist;
                    $minVertice = $vertice;
                }
            }

            if ($minVertice === null) break;

            $visitados[$minVertice] = true;

            foreach ($grafo[$minVertice] as $vizinho => $peso) {
                if ($distancias[$vizinho] > $distancias[$minVertice] + $peso) {
                    $distancias[$vizinho] = $distancias[$minVertice] + $peso;
                }
            }
        }

        $dist = $distancias[$destino];
        return is_infinite($dist) ? -1 : intval($dist);
    }

    private function calcularScore($nivelVaga, $nivelCandidato, $distancia) {
        if ($distancia < 0) return 0; // Distância inválida → Score zero

        $N = 100 - 25 * abs($nivelVaga - $nivelCandidato);

        if ($distancia <= 5) $D = 100;
        elseif ($distancia <= 10) $D = 75;
        elseif ($distancia <= 15) $D = 50;
        elseif ($distancia <= 20) $D = 25;
        else $D = 0;

        return floor(($N+$D)/2);
    }

    public function getRankingPorVaga($idVaga) {
        $sql = "SELECT p.nome, p.profissao, p.localizacao AS local_pessoa, p.nivel AS nivel_candidato,
       v.nivel AS nivel_vaga, v.localizacao AS local_vaga
                FROM candidaturas c
                JOIN pessoas p ON c.id_pessoa = p.id
                JOIN vagas v ON c.id_vaga = v.id
                WHERE v.id = :idVaga";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idVaga', $idVaga);
        $stmt->execute();
        $candidaturas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$candidaturas) return [];

        $resultado = [];

        foreach ($candidaturas as $candidato) {
            $distancia = $this->getDistancia($candidato['local_vaga'], $candidato['local_pessoa']);
            $score = $this->calcularScore($candidato['nivel_vaga'], $candidato['nivel_candidato'], $distancia);
            $resultado[] = [
    'nome' => $candidato['nome'],
    'profissao' => $candidato['profissao'],
    'localizacao' => $candidato['local_pessoa'],
    'nivel' => $candidato['nivel_candidato'],
    'score' => $score
];

        }

        usort($resultado, fn($a, $b) => $b['score'] <=> $a['score']);

        return $resultado;
    }
}
?>
