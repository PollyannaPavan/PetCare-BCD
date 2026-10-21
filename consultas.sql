-- PROJETO PetCare
-- Consultas SQL

-- 1. INSERT
-- Cadastra um novo tutor no banco de dados.

INSERT INTO tutores (nome, telefone, email) VALUES ('Gabriel Féboli', '19971296932', 'gabriel@gmail.com');


-- 2. SELECT
-- Exibe todos os animais cadastrados.

SELECT * FROM tutores;


-- 3. WHERE
-- Busca os animais da espécie Cachorro.

SELECT * FROM animais
WHERE especie = 'Cachorro';


-- 4. ORDER BY
-- Organiza os animais em ordem alfabética pelo nome.

SELECT * FROM animais
ORDER BY nome ASC;


-- 5. UPDATE
-- Atualiza o telefone de um tutor específico.
-- O WHERE evita alterar os telefones de todos os tutores.

UPDATE tutores
SET telefone = '19993839822'
WHERE id = 1;


-- 6. DELETE
-- Exclui uma consulta específica pelo seu ID.
-- O WHERE evita excluir todas as consultas.

DELETE FROM consultas
WHERE id = 6;


-- 7. JOIN
-- Mostra os animais, seus tutores e os veterinários responsáveis pelas consultas.

SELECT animais.nome, tutores.nome FROM animais
JOIN tutores ON animais.tutor_id = tutores.id;


-- 8. SELECT com WHERE e ORDER BY
-- Mostra as consultas agendadas da mais próxima para a mais distante.

SELECT * FROM consultas
WHERE status = 'agendada'
ORDER BY data_consulta ASC;