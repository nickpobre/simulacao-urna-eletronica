# Sistema de Votação - Simulação de Urna Eletrônica

Este é um sistema web simples que simula uma urna eletrônica. Foi desenvolvido em **PHP com MySQL**, usando conceitos de **Design Patterns**, especificamente o **Strategy Pattern**, para modularizar os diferentes tipos de votos (nominal, branco e nulo).

## Funcionalidades

- Votação nominal por número do candidato.
- Voto em branco e nulo.
- Exibição em tempo real do nome e partido do candidato conforme o número é digitado.
- Interface simples com botões numéricos (como uma urna).
- Armazenamento e contagem dos votos no banco de dados.
- Visualização dos resultados.

---

## Padrão de Projeto Usado

### **Strategy Pattern (Padrão de Estratégia)**

Foi utilizado para separar a lógica de cada tipo de voto (nominal, branco, nulo). Assim, é possível adicionar ou alterar comportamentos de voto sem modificar a lógica principal.

#### Estrutura:
- `VoteStrategy` (Interface)
- `NominalVote`, `BlankVote`, `NullVote` (implementações)
- `VotingContext` (classe que executa a estratégia escolhida)

---

## Estrutura de Arquivos

```

/classes
│   VoteStrategy.php
│   NominalVote.php
│   BlankVote.php
│   NullVote.php
│   VotingContext.php
db.php
index.php
vote.php
get\_candidato.php
result.php

````

---

## Banco de Dados

### Criação do Banco (MySQL)

Use o phpMyAdmin ou MySQL CLI para criar o banco e tabelas:

```sql
CREATE DATABASE urna;

USE urna;

CREATE TABLE votos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo ENUM('nominal', 'blank', 'null') NOT NULL,
    candidato VARCHAR(10) NULL,
    data_voto TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE candidatos (
    numero VARCHAR(10) PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    partido VARCHAR(50) NOT NULL
);

````

### Inserir candidatos

```sql
NSERT INTO candidatos (numero, nome, partido) VALUES
('10', 'João Silva', 'Partido A'),
('20', 'Maria Souza', 'Partido B'),
('30', 'Carlos Lima', 'Partido C');
```

---

## Como rodar localmente (XAMPP)

1. Instale o [XAMPP](https://www.apachefriends.org/index.html).
2. Coloque todos os arquivos dentro de `C:\xampp\htdocs\urna-eletronica`.
3. Crie o banco de dados `urna` no phpMyAdmin.
4. Ajuste as credenciais no `database/connection.php` se necessário.
5. Inicie o Apache e o MySQL pelo painel do XAMPP.
6. Acesse o sistema


## Tecnologias Usadas

* PHP 8+
* MySQL
* HTML + Tailwind CSS (via CDN)
* JavaScript (vanilla)

## Autor

Desenvolvido por Felipe O. Andrade.
Projeto educacional de simulação de urna eletrônica com aplicação de boas práticas de código usando Design Patterns.
