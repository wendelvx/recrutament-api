-- Criação do banco de dados
CREATE DATABASE IF NOT EXISTS recrutamento;
USE recrutamento;

-- Tabela de vagas
CREATE TABLE vagas (
    id CHAR(36) PRIMARY KEY,
    empresa VARCHAR(100) NOT NULL,
    titulo VARCHAR(100) NOT NULL,
    descricao TEXT,
    localizacao CHAR(1) NOT NULL,
    nivel INT NOT NULL CHECK (nivel BETWEEN 1 AND 5)
);

-- Tabela de pessoas
CREATE TABLE pessoas (
    id CHAR(36) PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    profissao VARCHAR(100) NOT NULL,
    localizacao CHAR(1) NOT NULL,
    nivel INT NOT NULL CHECK (nivel BETWEEN 1 AND 5)
);

-- Tabela de candidaturas
CREATE TABLE candidaturas (
    id CHAR(36) PRIMARY KEY,
    id_vaga CHAR(36) NOT NULL,
    id_pessoa CHAR(36) NOT NULL,
    UNIQUE (id_vaga, id_pessoa),
    FOREIGN KEY (id_vaga) REFERENCES vagas(id) ON DELETE CASCADE,
    FOREIGN KEY (id_pessoa) REFERENCES pessoas(id) ON DELETE CASCADE
);
