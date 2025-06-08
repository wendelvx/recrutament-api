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

    public function getRankingporVaga($id){
        echo "teste";
    }
}
?>
