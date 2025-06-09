# API REST para Avaliação de Candidaturas - Recrutamento

API desenvolvida em PHP puro (orientado a objetos) seguindo padrão MVC para automatizar a avaliação de candidatos a vagas de emprego.

## Objetivo

Esta API ajuda recrutadores a analisar candidaturas com base no nível de experiência do candidato e na menor distância entre sua localização e a da vaga, calculando um score para ranking.

## Tecnologias utilizadas

- PHP 7.x ou superior
- MySQL
- JSON para comunicação
- Sem uso de bibliotecas externas (exceto para UUID) e PDO.

## Funcionalidades

- Cadastro de vagas (`POST /vagas`)
- Cadastro de pessoas/candidatos (`POST /pessoas`)
- Registro de candidaturas (`POST /candidaturas`)
- Retorno do ranking de candidatos por vaga (`GET /vagas/{id}/candidaturas/ranking`)
- Cálculo da menor distância entre localidades sem bibliotecas externas (algoritmo Dijkstra)
- Validação e tratamento de erros conforme especificação

## Observações

-Usado XAMMP para facilitar a realização da atividade.
-Ao vizualizar o projeto percebe-se que foi criado um array de erros nos models, mas não foi usado no controller. Isto se dá, pois um dos requisitos do desafio é justamente devolver o código de resposta sem corpo.

## Como rodar o projeto

1. Clone o repositório:
   ```bash
   git clone https://github.com/wendelvx/recrutament-api

- Crie o banco de dados com as especificações do desafio.
-Utilize algum software como xammp, caso queria facilitar o processo.
-Divirta-se :)
