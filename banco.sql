-- PROJETO PetCare
-- Criação das tabelas

CREATE TABLE tutores (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    telefone VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL
);

CREATE TABLE veterinarios (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    crmv VARCHAR(50) NOT NULL,
    telefone VARCHAR(50) NOT NULL
);

CREATE TABLE animais (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    especie VARCHAR(50) NOT NULL,
    raca VARCHAR(50) NOT NULL,
    data_nascimento DATE NOT NULL,
    tutor_id INT NOT NULL,
    FOREIGN KEY (tutor_id) REFERENCES tutores(id)
);

CREATE TABLE consultas (
    id SERIAL PRIMARY KEY,
    animal_id INT NOT NULL,
    veterinario_id INT NOT NULL,
    data_consulta DATE NOT NULL,
    motivo VARCHAR(50) NOT NULL,
    status VARCHAR(50) NOT NULL,
    FOREIGN KEY (animal_id) REFERENCES animais(id),
    FOREIGN KEY (veterinario_id) REFERENCES veterinarios(id)
);

-- Inserção de dados

-- Tutores
INSERT INTO tutores (nome, telefone, email) VALUES
('Pollyanna Pavan', '19993839840', 'pollyanna@gmail.com'),
('Julia Menoni', '19996301427', 'julia@gmail.com'),
('Mayne Moretti', '19992396006', 'mayne@gmail.com');

-- Veterinários
INSERT INTO veterinarios (nome, crmv, telefone) VALUES
('Gabriel Arruda', 'CRMV-SP-12345', '19992456250'),
('Lucas Dantas', 'CRMV-SP-67890', '19999873456');

-- Animais
INSERT INTO animais (
    nome, especie, raca, data_nascimento, tutor_id
) VALUES
('Amora', 'Cachorro', 'Rottweiler', '2023-08-07', 1),
('Toretto', 'Cachorro', 'Shih-tzu', '2019-06-14', 1),
('Sophie', 'Cachorro', 'Shih-tzu', '2025-04-25', 2),
('Kiara', 'Cachorro', 'Shih-tzu', '2024-05-13', 2),
('Pitoca', 'Hamster', 'Anão-russo', '2024-09-12', 3),
('Nenê', 'Pássaro', 'Maritaca', '2023-01-25', 3);

-- Consultas
INSERT INTO consultas (
    animal_id, veterinario_id, data_consulta, motivo, status
) VALUES
(1, 1, '2026-10-22', 'Consulta de rotina', 'agendada'),
(2, 2, '2026-10-23', 'Avaliação de saúde', 'agendada'),
(3, 1, '2026-10-24', 'Vacinação', 'agendada'),
(4, 2, '2026-10-25', 'Consulta de rotina', 'agendada'),
(5, 1, '2026-10-26', 'Avaliação de saúde', 'agendada'),
(6, 2, '2026-10-27', 'Verificação de saúde', 'agendada');

-- Conferência dos dados

SELECT * FROM tutores;
SELECT * FROM veterinarios;
SELECT * FROM animais;
SELECT * FROM consultas;