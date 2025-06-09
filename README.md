# API REST para Avaliação de Candidaturas - Recrutamento

API desenvolvida em PHP puro (orientado a objetos) seguindo o padrão MVC para automatizar a avaliação de candidatos a vagas de emprego.

---

## 🎯 Objetivo

A API auxilia recrutadores a analisar candidaturas com base no nível de experiência do candidato e na **menor distância** entre sua localização e a da vaga, calculando um **score** para gerar um ranking.

---

## 🛠️ Tecnologias utilizadas

- PHP 7.x ou superior
- MySQL
- JSON (requisições e respostas)
- PDO para acesso ao banco
- Sem bibliotecas externas, exceto para geração de UUIDs

---

## ⚙️ Funcionalidades

- `POST /vagas`: Cadastro de vagas
- `POST /pessoas`: Cadastro de candidatos
- `POST /candidaturas`: Registro de candidaturas
- `GET /vagas/{id}/candidaturas/ranking`: Retorno do ranking dos candidatos para uma vaga
- Cálculo da menor distância entre localidades (grafo) sem uso de bibliotecas externas (algoritmo Dijkstra)
- Validação e tratamento de erros conforme os requisitos técnicos

---

## 📁 Banco de Dados

Foi criado um arquivo `recrutamento.sql` com todos os comandos necessários para:

- Criar o banco de dados `recrutamento`
- Criar as tabelas: `vagas`, `pessoas` e `candidaturas`
- Definir os relacionamentos e tipos adequados

🔸 Basta importar o arquivo `.sql` no phpMyAdmin ou executar no MySQL para preparar o ambiente de dados.

---

## 📝 Observações

- Foi utilizado o **XAMPP** como ambiente local para facilitar a execução.
- O array de erros nos `models` foi implementado por boas práticas, mas **não utilizado nos controllers**, respeitando o requisito do desafio de retornar apenas o **código HTTP**, sem corpo nas respostas de erro.

---

## ▶️ Como rodar o projeto

1. Clone o repositório:

   ```bash
   git clone https://github.com/wendelvx/recrutament-api
