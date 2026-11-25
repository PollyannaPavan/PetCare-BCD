# PetCare — Sistema de Gerenciamento Veterinário

## Projeto Integrador — Banco de Dados Relacionais e API em PHP

## 1. Integrantes

- **Mayne Zardo Moretti**
- **Pollyanna Rodrigues Pavan**
- **Julia Guerra Menoni**

> I1D46B — Técnico em Desenvolvimento de Sistemas — SENAI Americana

---

## 2. Descrição do projeto

O PetCare é um sistema de gerenciamento veterinário desenvolvido para facilitar a organização de tutores, animais, veterinários e consultas.

O projeto centraliza as informações em um banco de dados, permitindo cadastrar, consultar, atualizar e excluir registros por meio de uma interface web integrada a uma API em PHP.

O sistema foi desenvolvido para atender às necessidades de uma clínica veterinária, auxiliando na organização dos dados e no gerenciamento dos atendimentos.

---

## 3. Funcionalidades

O sistema possui as seguintes funcionalidades:

- Cadastro, listagem, consulta, atualização e exclusão de tutores.
- Cadastro, listagem, consulta, atualização e exclusão de veterinários.
- Cadastro, listagem, consulta, atualização e exclusão de animais.
- Cadastro, listagem, consulta, atualização e exclusão de consultas.
- Associação dos animais aos seus respectivos tutores.
- Associação das consultas aos animais e veterinários.
- Exibição dos registros em tabelas.
- Comunicação entre frontend e backend por requisições HTTP.

A página inicial possui o gerenciamento de tutores. As demais funcionalidades estão organizadas em páginas separadas.

---

## 4. Tecnologias utilizadas

- **HTML5:** estrutura das páginas.
- **CSS3:** estilização e organização visual.
- **JavaScript:** interações e comunicação com a API.
- **PHP:** desenvolvimento da API.
- **PDO:** conexão e execução de comandos no banco de dados.
- **PostgreSQL:** armazenamento dos dados.
- **Thunder Client:** testes das requisições HTTP.
- **Visual Studio Code:** editor de código utilizado.

---

## 5. Banco de dados

O banco de dados utilizado se chama `petcare` e possui quatro tabelas principais.

### Tabela `tutores`

Armazena os dados dos responsáveis pelos animais.

| Campo | Descrição |
|---|---|
| id | Identificador do tutor |
| nome | Nome do tutor |
| telefone | Telefone para contato |
| email | E-mail do tutor |

### Tabela `veterinarios`

Armazena os dados dos profissionais da clínica.

| Campo | Descrição |
|---|---|
| id | Identificador do veterinário |
| nome | Nome do veterinário |
| crmv | Registro profissional |
| telefone | Telefone para contato |

### Tabela `animais`

Armazena os dados dos animais cadastrados.

| Campo | Descrição |
|---|---|
| id | Identificador do animal |
| nome | Nome do animal |
| especie | Espécie do animal |
| raca | Raça do animal |
| data_nascimento | Data de nascimento |
| tutor_id | ID do tutor responsável |

### Tabela `consultas`

Armazena os dados das consultas veterinárias.

| Campo | Descrição |
|---|---|
| id | Identificador da consulta |
| animal_id | ID do animal atendido |
| veterinario_id | ID do veterinário responsável |
| data_consulta | Data da consulta |
| motivo | Motivo do atendimento |
| status | Situação da consulta |

---

## 6. Relacionamentos

O banco de dados utiliza chaves primárias e estrangeiras para relacionar as tabelas.

- **Tutores e animais:** um tutor pode possuir vários animais.
- **Animais e consultas:** um animal pode possuir várias consultas.
- **Veterinários e consultas:** um veterinário pode realizar várias consultas.

Os relacionamentos são realizados por meio das chaves estrangeiras, garantindo que os registros estejam associados corretamente.

---

## 7. Estrutura do projeto

```text
PetCare-BCD/
│
├── api/
│   ├── .gitignore
│   ├── conexao.php
│   ├── tutores.php
│   ├── veterinarios.php
│   ├── animais.php
│   └── consultas.php
│
├── frontEnd/
│   ├── index.html
│   ├── veterinarios.html
│   ├── animais.html
│   ├── consultas.html
│   │
│   ├── script.js
│   ├── veterinarios.js
│   ├── animais.js
│   ├── consultas.js
│   │
│   ├── style.css
│   └── Imagens/
│       └── logo.png
│
├── banco.sql
├── consultas.sql
└── README.md
```

### Arquivos principais

- `banco.sql`: criação das tabelas e dados iniciais.
- `consultas.sql`: comandos SQL utilizados para consultar e manipular os dados.
- `api/conexao.php`: conexão com o PostgreSQL.
- `api/tutores.php`: API de tutores.
- `api/veterinarios.php`: API de veterinários.
- `api/animais.php`: API de animais.
- `api/consultas.php`: API de consultas.
- `frontEnd/index.html`: página inicial e gerenciamento de tutores.
- `frontEnd/veterinarios.html`: gerenciamento de veterinários.
- `frontEnd/animais.html`: gerenciamento de animais.
- `frontEnd/consultas.html`: gerenciamento de consultas.
- `frontEnd/script.js`: JavaScript da página inicial e tutores.
- `frontEnd/veterinarios.js`: JavaScript de veterinários.
- `frontEnd/animais.js`: JavaScript de animais.
- `frontEnd/consultas.js`: JavaScript de consultas.
- `frontEnd/style.css`: estilos utilizados nas páginas.

---

## 8. Configuração do banco de dados

### 8.1. Criar o banco

No PostgreSQL, execute:

```sql
CREATE DATABASE petcare;
```

Caso o banco já exista, não é necessário criá-lo novamente.

### 8.2. Criar as tabelas

1. Conecte-se ao banco `petcare`.
2. Abra o arquivo `banco.sql`.
3. Execute os comandos para criar as tabelas e inserir os dados iniciais.

Caso as tabelas já estejam criadas e os dados inseridos, não execute novamente os comandos de inserção para evitar duplicidade.

### 8.3. Consultas SQL

O arquivo `consultas.sql` possui exemplos de comandos SQL utilizados para consultar e manipular os dados do banco.

---

## 9. Configuração da conexão PHP

No arquivo `api/conexao.php`, configure os dados de acesso ao PostgreSQL.

Exemplo:

```php
<?php
declare(strict_types=1);

$host = "127.0.0.1";
$usuario = "SEU_USUARIO";
$senha = "SUA_SENHA";
$banco = "petcare";

$pdo = new PDO(
    "pgsql:host=$host;port=5432;dbname=$banco",
    $usuario,
    $senha
);
```

Substitua os valores pelos dados do PostgreSQL utilizado.

Não compartilhe sua senha real em repositórios públicos.

---

## 10. Como executar o projeto

### 10.1. Iniciar o servidor PHP

Abra o terminal na pasta principal `PetCare-BCD` e execute:

```bash
php -S localhost:8000
```

Mantenha o terminal aberto enquanto estiver utilizando o sistema.

### 10.2. Acessar o frontend

Abra o navegador e acesse:

```text
http://localhost:8000/frontEnd/index.html
```

### 10.3. Acessar a API

Os endpoints ficam disponíveis dentro da pasta `api`.

Exemplo:

```text
http://localhost:8000/api/tutores.php
```

Para o funcionamento do sistema, é necessário que o PostgreSQL esteja ativo, que a conexão PHP esteja configurada e que o servidor PHP esteja em execução.

Não utilize o Live Server para executar o projeto, pois ele não interpreta arquivos PHP.

---

## 11. Endpoints da API

A API utiliza os métodos HTTP para realizar as operações CRUD.

### 11.1. Métodos CRUD

| Método HTTP | Operação | Descrição |
|---|---|---|
| GET | Read | Consulta ou lista registros |
| POST | Create | Cadastra registros |
| PUT | Update | Atualiza registros |
| DELETE | Delete | Exclui registros |

### 11.2. Tutores

| Método | Endpoint | Descrição |
|---|---|---|
| GET | `/api/tutores.php` | Lista todos os tutores |
| GET | `/api/tutores.php?id=1` | Consulta tutor por ID |
| POST | `/api/tutores.php` | Cadastra tutor |
| PUT | `/api/tutores.php?id=1` | Atualiza tutor |
| DELETE | `/api/tutores.php?id=1` | Exclui tutor |

### 11.3. Veterinários

| Método | Endpoint | Descrição |
|---|---|---|
| GET | `/api/veterinarios.php` | Lista veterinários |
| GET | `/api/veterinarios.php?id=1` | Consulta veterinário por ID |
| POST | `/api/veterinarios.php` | Cadastra veterinário |
| PUT | `/api/veterinarios.php?id=1` | Atualiza veterinário |
| DELETE | `/api/veterinarios.php?id=1` | Exclui veterinário |

### 11.4. Animais

| Método | Endpoint | Descrição |
|---|---|---|
| GET | `/api/animais.php` | Lista animais |
| GET | `/api/animais.php?id=1` | Consulta animal por ID |
| POST | `/api/animais.php` | Cadastra animal |
| PUT | `/api/animais.php?id=1` | Atualiza animal |
| DELETE | `/api/animais.php?id=1` | Exclui animal |

### 11.5. Consultas

| Método | Endpoint | Descrição |
|---|---|---|
| GET | `/api/consultas.php` | Lista consultas |
| GET | `/api/consultas.php?id=1` | Consulta por ID |
| POST | `/api/consultas.php` | Cadastra consulta |
| PUT | `/api/consultas.php?id=1` | Atualiza consulta |
| DELETE | `/api/consultas.php?id=1` | Exclui consulta |

Os IDs utilizados nos exemplos são ilustrativos e devem ser substituídos pelos IDs existentes no banco.

---

## 12. Exemplo de requisições

### GET — Listar tutores

Endpoint:

```http
GET http://localhost:8000/api/tutores.php
```

Exemplo de resposta JSON:

```json
[
    {
        "id": 1,
        "nome": "Pollyanna Pavan",
        "telefone": "19993839840",
        "email": "pollyanna@gmail.com"
    }
]
```

### POST — Cadastrar tutor

Endpoint:

```http
POST http://localhost:8000/api/tutores.php
```

Corpo JSON:

```json
{
    "nome": "Luiz Platini",
    "telefone": "1234567890",
    "email": "platini@gmail.com"
}
```

### PUT — Atualizar tutor

Endpoint:

```http
PUT http://localhost:8000/api/tutores.php?id=1
```

Corpo JSON:

```json
{
    "nome": "Pollyanna Pavan",
    "telefone": "22222222222",
    "email": "pollyannaP@gmail.com"
}
```

### DELETE — Excluir tutor

Endpoint:

```http
DELETE http://localhost:8000/api/tutores.php?id=1
```

O ID é enviado pela URL, utilizando o parâmetro `id`.

As requisições de cadastro e atualização enviam os dados no formato JSON.

---

## 13. Validações e cuidados

Durante o desenvolvimento, foram utilizados alguns cuidados:

- Utilização de consultas preparadas com PDO.
- Identificação dos registros por ID.
- Uso de chaves primárias e estrangeiras.
- Envio e recebimento de dados no formato JSON.
- Comunicação entre frontend e backend utilizando `fetch()`.
- Verificação de registros antes das operações.
- Respeito aos relacionamentos entre as tabelas.

As chaves estrangeiras ajudam a manter a integridade dos dados, evitando associações inválidas entre registros.

---

## 14. Testes da API

Os endpoints foram testados utilizando o Thunder Client no Visual Studio Code.

Foram realizados testes com os métodos:

- GET — listagem e consulta por ID.
- POST — cadastro de novos registros.
- PUT — atualização de registros.
- DELETE — exclusão de registros.

Os testes foram realizados nos módulos de tutores, veterinários, animais e consultas, verificando o funcionamento das operações e as respostas da API.

---

## 15. Frontend

O frontend foi desenvolvido utilizando HTML, CSS e JavaScript, com páginas separadas para cada funcionalidade.

### Páginas do sistema

- **Início:** cadastro e listagem de tutores.
- **Veterinários:** cadastro, listagem e gerenciamento de veterinários.
- **Animais:** cadastro, listagem e gerenciamento de animais e seus tutores.
- **Consultas:** cadastro, listagem e gerenciamento de consultas, incluindo animal, veterinário, data, motivo e status.

As páginas utilizam um arquivo CSS compartilhado para manter a identidade visual e arquivos JavaScript para realizar as operações e se comunicar com a API.

### Integração frontend e backend

O JavaScript utiliza `fetch()` para enviar requisições HTTP para os endpoints PHP.

O fluxo de funcionamento é:

1. O usuário realiza uma ação na página.
2. O JavaScript envia uma requisição para a API.
3. O PHP recebe a requisição e executa a operação.
4. O PDO realiza a comunicação com o PostgreSQL.
5. A API retorna uma resposta em JSON.
6. O frontend atualiza a tabela ou exibe uma mensagem ao usuário.

---

## 16. CRUD no frontend

As operações CRUD estão integradas às ações da interface.

- **GET:** carrega e exibe os registros nas tabelas.
- **POST:** cadastra novos registros por meio dos formulários.
- **PUT:** permite editar registros existentes.
- **DELETE:** permite excluir registros por meio dos botões da interface.

Dessa forma, o usuário consegue gerenciar os dados pelo site sem precisar executar as requisições manualmente no Thunder Client.

---

## 17. Considerações finais

O PetCare foi desenvolvido como projeto integrador, aplicando os conhecimentos de banco de dados relacionais, SQL, PHP, PDO, HTML, CSS e JavaScript.

Durante o desenvolvimento, foram trabalhados a criação de tabelas, relacionamentos entre dados, operações CRUD, desenvolvimento de uma API e integração entre frontend e backend.

O projeto permite organizar as informações de uma clínica veterinária em um sistema simples, facilitando o gerenciamento de tutores, animais, veterinários e consultas.