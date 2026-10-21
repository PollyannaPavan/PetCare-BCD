# PetCare — Sistema de Gerenciamento Veterinário
## *(Projeto integrador - Banco de Dados Relacionais e API em PHP)*

## 1. Integrantes

- **Integrante 1:** Mayne Zardo Moretti
- **Integrante 2:** Pollyanna Rodrigues Pavan
- **Integrante 3:** Julia Guerra Menoni

> ***I1D46B** - TÉC. EM DESENVOLVIMENTO DE SISTEMAS, SENAI AMERICANA*

## 2. Descrição da proposta

O PetCare é um sistema de gerenciamento de consultas veterinárias. O projeto busca facilitar a organização das informações de tutores, animais, veterinários e consultas, centralizando os dados em um banco de dados para tornar o acesso e o gerenciamento mais simples.

O sistema será destinado a clínicas veterinárias, veterinários e funcionários responsáveis pelo atendimento e pelo agendamento de consultas.

## 3. Funcionalidades

O projeto prevê:

- Cadastro e consulta de tutores.
- Cadastro e consulta de animais e seus respectivos tutores.
- Cadastro e consulta de veterinários.
- Registro e consulta de consultas veterinárias.
- Organização das informações por meio de consultas SQL.
- API para cadastrar, listar, consultar, atualizar e excluir tutores.
- Interface web para facilitar a visualização e o gerenciamento das informações.

## 4. Tecnologias utilizadas

- HTML5: estrutura das páginas.
- CSS3: aparência e organização visual.
- JavaScript: interações e comunicação com a API.
- PHP: desenvolvimento da API.
- PDO: conexão entre PHP e PostgreSQL.
- PostgreSQL: banco de dados relacional.
- Thunder Client: ferramenta para testar os endpoints da API.

## 5. Banco de dados

O banco de dados se chama `petcare` e possui quatro tabelas principais.

### Tabela `tutores`

Armazena os dados dos responsáveis pelos animais.

- `id`: chave primária e identificador do tutor.
- `nome`: nome do tutor.
- `telefone`: telefone para contato.
- `email`: e-mail do tutor.

### Tabela `veterinarios`

Armazena os dados dos profissionais.

- `id`: chave primária.
- `nome`: nome do veterinário.
- `crmv`: registro profissional.
- `telefone`: telefone para contato.

### Tabela `animais`

Armazena os dados dos animais cadastrados.

- `id`: chave primária.
- `nome`: nome do animal.
- `especie`: espécie do animal.
- `raca`: raça do animal.
- `data_nascimento`: data de nascimento.
- `tutor_id`: chave estrangeira que referencia `tutores(id)`.

Um tutor pode estar relacionado a vários animais. Cada animal cadastrado possui um tutor associado.

### Tabela `consultas`

Armazena os dados dos atendimentos veterinários.

- `id`: chave primária.
- `animal_id`: chave estrangeira que referencia `animais(id)`.
- `veterinario_id`: chave estrangeira que referencia `veterinarios(id)`.
- `data_consulta`: data da consulta.
- `motivo`: motivo do atendimento.
- `status`: situação da consulta.

Cada consulta está relacionada a um animal e a um veterinário. Um animal ou veterinário pode aparecer em várias consultas.

## 6. Relacionamentos

O banco utiliza chaves primárias e estrangeiras para relacionar os registros:

- `tutores` → `animais`: relacionamento de um para muitos, por meio de `animais.tutor_id`.
- `animais` → `consultas`: relacionamento de um para muitos, por meio de `consultas.animal_id`.
- `veterinarios` → `consultas`: relacionamento de um para muitos, por meio de `consultas.veterinario_id`.

Esses relacionamentos evitam que animais e consultas referenciem tutores, animais ou veterinários inexistentes.

## 7. Arquivos do projeto

```text
PetCare/
├── api/
│   ├── conexao.php
│   └── tutores.php
├── frontend/
│   ├── index.html
│   ├── style.css
│   ├── script.js
│   └── config.js
├── banco.sql
├── consultas.sql
└── README.md
```

- `banco.sql`: criação das tabelas e inserção dos dados iniciais.
- `consultas.sql`: exemplos de INSERT, SELECT, WHERE, ORDER BY, UPDATE, DELETE e JOIN.
- `api/conexao.php`: configuração da conexão PDO com o PostgreSQL.
- `api/tutores.php`: operações da API para a entidade tutores.
- `frontend/`: arquivos da interface web.
- `README.md`: documentação do projeto.

## 8. Como criar e configurar o banco de dados

### 8.1. Criar o banco

No PostgreSQL, execute:

```sql
CREATE DATABASE petcare;
```

Se o banco já existir, não é necessário criá-lo novamente.

### 8.2. Criar as tabelas e inserir os dados

1. Conecte-se ao banco `petcare`.
2. Abra o arquivo `banco.sql`.
3. Execute os comandos de criação das tabelas e de inserção dos dados iniciais.

Se as tabelas e os dados já estiverem criados, evite executar novamente os comandos de inserção para não duplicar registros.

### 8.3. Consultar os dados

O arquivo `consultas.sql` contém exemplos de consultas para visualizar e organizar os dados, além de exemplos de atualização e exclusão.

Antes de executar comandos UPDATE ou DELETE, confira o registro identificado pelo WHERE, pois essas operações alteram ou excluem dados.

## 9. Configuração da conexão PHP

No arquivo `api/conexao.php`, configure os dados de acesso ao PostgreSQL:

```php
$host = 'localhost';
$port = '5432';
$banco = 'petcare';
$usuario = 'postgres';
$senha = 'SUA_SENHA';
```

Substitua `SUA_SENHA` pela senha configurada no PostgreSQL.

A conexão utiliza PDO com o driver PostgreSQL. Verifique se o PHP e a extensão `pdo_pgsql` estão instalados e habilitados.

Não compartilhe a senha real do banco em repositórios públicos.

## 10. Como executar a API

No terminal, acesse a pasta principal do projeto e execute:

```bash
php -S localhost:8000
```

Com o servidor iniciado, o endpoint principal de tutores será:

`http://localhost:8000/api/tutores.php`

Esse endereço pressupõe que o arquivo `api/tutores.php` já esteja implementado e que a conexão com o banco esteja funcionando.

## 11. Endpoints da API

A API será implementada inicialmente para a tabela `tutores`.

| Método HTTP | Endpoint | Descrição |
|---|---|---|
| GET | `/api/tutores.php` | Lista todos os tutores |
| GET | `/api/tutores.php?id=1` | Consulta um tutor pelo ID |
| POST | `/api/tutores.php` | Cadastra um tutor |
| PUT | `/api/tutores.php?id=1` | Atualiza um tutor |
| DELETE | `/api/tutores.php?id=1` | Exclui um tutor |

Os endpoints acima representam o contrato planejado. Devem ser conferidos e testados depois da implementação da API.

### 11.1. GET — Listar tutores

Requisição:

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

A resposta acima é apenas um exemplo de formato. Os dados retornados dependerão dos registros existentes no banco.

### 11.2. GET — Consultar tutor por ID

Requisição:

```http
GET http://localhost:8000/api/tutores.php?id=1
```

Exemplo de resposta JSON:

```json
{
  "id": 1,
  "nome": "Pollyanna Pavan",
  "telefone": "19993839840",
  "email": "pollyanna@gmail.com"
}
```

Se o tutor não existir, a API deverá retornar uma resposta JSON informando que o registro não foi encontrado, com status HTTP 404.

### 11.3. POST — Cadastrar tutor

Requisição:

```http
POST http://localhost:8000/api/tutores.php
Content-Type: application/json
```

Corpo JSON enviado:

```json
{
  "nome": "Gabriel Féboli",
  "telefone": "19971296932",
  "email": "gabriel@gmail.com"
}
```

Exemplo de resposta após o cadastro:

```json
{
  "mensagem": "Tutor cadastrado com sucesso.",
  "id": 4
}
```

O identificador retornado dependerá dos registros existentes no banco.

A API deverá verificar se os campos obrigatórios foram enviados e retornar uma mensagem de erro quando os dados forem inválidos.

### 11.4. PUT — Atualizar tutor

Requisição:

```http
PUT http://localhost:8000/api/tutores.php?id=1
Content-Type: application/json
```

Corpo JSON enviado:

```json
{
  "nome": "Pollyanna Pavan",
  "telefone": "19990001111",
  "email": "pollyanna@gmail.com"
}
```

Exemplo de resposta:

```json
{
  "mensagem": "Tutor atualizado com sucesso."
}
```

Se o ID não corresponder a um tutor existente, a API deverá retornar uma mensagem informando que o registro não foi encontrado.

### 11.5. DELETE — Excluir tutor

Requisição:

```http
DELETE http://localhost:8000/api/tutores.php?id=1
```

Exemplo de resposta:

```json
{
  "mensagem": "Tutor excluído com sucesso."
}
```

Se o tutor não existir, a API deverá retornar uma resposta JSON com status HTTP 404.

A exclusão também deverá respeitar as chaves estrangeiras do banco. Caso o tutor possua animais associados, o banco poderá impedir a exclusão. A API deverá tratar essa situação e informar o usuário sem expor detalhes técnicos internos.

## 12. Validações e segurança

A implementação da API deverá incluir:

- Consultas preparadas com parâmetros para evitar SQL Injection.
- Verificação dos campos obrigatórios.
- Validação do identificador informado.
- Respostas em JSON.
- Códigos HTTP apropriados para sucesso e erro.
- Tratamento de registros inexistentes.
- Tratamento de erros de conexão e de restrições do banco sem expor informações confidenciais.

## 13. Como testar a API

Os testes poderão ser realizados pelo Thunder Client no VS Code.

1. Inicie o servidor PHP.
2. Confirme que a conexão com o PostgreSQL está funcionando.
3. Envie uma requisição GET para listar os tutores.
4. Envie uma requisição POST com os dados em JSON.
5. Consulte o tutor cadastrado pelo ID.
6. Envie uma requisição PUT para atualizar os dados.
7. Teste o DELETE com um registro apropriado.
8. Teste IDs inexistentes e campos obrigatórios ausentes.
9. Confira o status HTTP e o conteúdo JSON de cada resposta.

As operações de atualização e exclusão devem ser testadas com cuidado para evitar a perda de dados necessários ao projeto.

## 14. Como acessar o frontend

Depois de criar os arquivos HTML, CSS e JavaScript na pasta `frontend`, inicie um servidor local para disponibilizar a página.

Por exemplo, a partir da pasta `frontend`, execute:

```bash
php -S localhost:8080
```

Depois, acesse:

`http://localhost:8080`

O JavaScript deverá utilizar o endereço da API para enviar requisições HTTP e receber os dados em JSON.

A integração deverá ser testada com o servidor da API em execução. Se houver problemas de comunicação entre portas diferentes, será necessário configurar corretamente o CORS no backend.

## 15. Considerações finais

O PetCare é um projeto acadêmico que aplica conhecimentos de banco de dados relacionais, SQL, desenvolvimento web e integração entre frontend e backend.

O banco de dados e os exemplos de consultas SQL foram desenvolvidos como base do sistema. A API PHP e o frontend deverão ser implementados e testados para que as funcionalidades descritas sejam consideradas concluídas.

---
---

***PROJETO EM ANDAMENTO***