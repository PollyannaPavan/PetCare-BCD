const API = "http://localhost:8000";

// ================= TUTORES =================

const formTutor = document.getElementById("formTutor");

if (formTutor) {
    listarTutores();

    formTutor.addEventListener("submit", async function(e) {
        e.preventDefault();

        const id = tutorId.value;

        const dados = {
            nome: tutorNome.value,
            telefone: tutorTelefone.value,
            email: tutorEmail.value
        };

        await fetch(`${API}/tutores.php${id ? "?id=" + id : ""}`, {
            method: id ? "PUT" : "POST",
            headers: {"Content-Type": "application/json"},
            body: JSON.stringify(dados)
        });

        limparTutor();
        listarTutores();
    });
}

async function listarTutores() {
    const resposta = await fetch(`${API}/tutores.php`);
    const dados = await resposta.json();

    listaTutores.innerHTML = "";

    dados.forEach(tutor => {
        listaTutores.innerHTML += `
            <tr>
                <td>${tutor.id}</td>
                <td>${tutor.nome}</td>
                <td>${tutor.telefone}</td>
                <td>${tutor.email}</td>
                <td>
                    <button onclick="editarTutor(${tutor.id})">Editar</button>
                    <button onclick="excluirTutor(${tutor.id})">Excluir</button>
                </td>
            </tr>`;
    });
}

async function editarTutor(id) {
    const resposta = await fetch(`${API}/tutores.php?id=${id}`);
    const tutor = await resposta.json();

    tutorId.value = tutor.id;
    tutorNome.value = tutor.nome;
    tutorTelefone.value = tutor.telefone;
    tutorEmail.value = tutor.email;
}

async function excluirTutor(id) {
    if (confirm("Deseja excluir este tutor?")) {
        await fetch(`${API}/tutores.php?id=${id}`, {
            method: "DELETE"
        });

        listarTutores();
    }
}

function limparTutor() {
    formTutor.reset();
    tutorId.value = "";
}

// ================= VETERINÁRIOS =================

const formVeterinario = document.getElementById("formVeterinario");

if (formVeterinario) {
    listarVeterinarios();

    formVeterinario.addEventListener("submit", async function(e) {
        e.preventDefault();

        const id = veterinarioId.value;

        const dados = {
            nome: vetNome.value,
            crmv: vetCrmv.value,
            telefone: vetTelefone.value
        };

        await fetch(`${API}/veterinarios.php${id ? "?id=" + id : ""}`, {
            method: id ? "PUT" : "POST",
            headers: {"Content-Type": "application/json"},
            body: JSON.stringify(dados)
        });

        limparVeterinario();
        listarVeterinarios();
    });
}

async function listarVeterinarios() {
    const resposta = await fetch(`${API}/veterinarios.php`);
    const dados = await resposta.json();

    listaVeterinarios.innerHTML = "";

    dados.forEach(vet => {
        listaVeterinarios.innerHTML += `
            <tr>
                <td>${vet.id}</td>
                <td>${vet.nome}</td>
                <td>${vet.crmv}</td>
                <td>${vet.telefone}</td>
                <td>
                    <button onclick="editarVeterinario(${vet.id})">Editar</button>
                    <button onclick="excluirVeterinario(${vet.id})">Excluir</button>
                </td>
            </tr>`;
    });
}

async function editarVeterinario(id) {
    const resposta = await fetch(`${API}/veterinarios.php?id=${id}`);
    const vet = await resposta.json();

    veterinarioId.value = vet.id;
    vetNome.value = vet.nome;
    vetCrmv.value = vet.crmv;
    vetTelefone.value = vet.telefone;
}

async function excluirVeterinario(id) {
    if (confirm("Deseja excluir este veterinário?")) {
        await fetch(`${API}/veterinarios.php?id=${id}`, {
            method: "DELETE"
        });

        listarVeterinarios();
    }
}

function limparVeterinario() {
    formVeterinario.reset();
    veterinarioId.value = "";
}

// ================= ANIMAIS =================

const formAnimal = document.getElementById("formAnimal");

if (formAnimal) {
    listarTutores();
    listarAnimais();

    formAnimal.addEventListener("submit", async function(e) {
        e.preventDefault();

        const id = animalId.value;

        const dados = {
            nome: animalNome.value,
            especie: animalEspecie.value,
            raca: animalRaca.value,
            data_nascimento: animalNascimento.value,
            tutor_id: animalTutor.value
        };

        await fetch(`${API}/animais.php${id ? "?id=" + id : ""}`, {
            method: id ? "PUT" : "POST",
            headers: {"Content-Type": "application/json"},
            body: JSON.stringify(dados)
        });

        limparAnimal();
        listarAnimais();
    });
}

async function listarAnimais() {
    const resposta = await fetch(`${API}/animais.php`);
    const dados = await resposta.json();

    listaAnimais.innerHTML = "";

    dados.forEach(animal => {
        listaAnimais.innerHTML += `
            <tr>
                <td>${animal.id}</td>
                <td>${animal.nome}</td>
                <td>${animal.especie}</td>
                <td>${animal.raca}</td>
                <td>${animal.data_nascimento}</td>
                <td>${animal.tutor_id}</td>
                <td>
                    <button onclick="editarAnimal(${animal.id})">Editar</button>
                    <button onclick="excluirAnimal(${animal.id})">Excluir</button>
                </td>
            </tr>`;
    });
}

async function editarAnimal(id) {
    const resposta = await fetch(`${API}/animais.php?id=${id}`);
    const animal = await resposta.json();

    animalId.value = animal.id;
    animalNome.value = animal.nome;
    animalEspecie.value = animal.especie;
    animalRaca.value = animal.raca;
    animalNascimento.value = animal.data_nascimento;
    animalTutor.value = animal.tutor_id;
}

async function excluirAnimal(id) {
    if (confirm("Deseja excluir este animal?")) {
        await fetch(`${API}/animais.php?id=${id}`, {
            method: "DELETE"
        });

        listarAnimais();
    }
}

function limparAnimal() {
    formAnimal.reset();
    animalId.value = "";
}

// ================= CONSULTAS =================

const formConsulta = document.getElementById("formConsulta");

if (formConsulta) {
    listarAnimais();
    listarVeterinarios();
    listarConsultas();

    formConsulta.addEventListener("submit", async function(e) {
        e.preventDefault();

        const id = consultaId.value;

        const dados = {
            animal_id: consultaAnimal.value,
            veterinario_id: consultaVeterinario.value,
            data_consulta: consultaData.value,
            motivo: consultaMotivo.value,
            status: consultaStatus.value
        };

        await fetch(`${API}/consultas.php${id ? "?id=" + id : ""}`, {
            method: id ? "PUT" : "POST",
            headers: {"Content-Type": "application/json"},
            body: JSON.stringify(dados)
        });

        limparConsulta();
        listarConsultas();
    });
}

async function listarConsultas() {
    const resposta = await fetch(`${API}/consultas.php`);
    const dados = await resposta.json();

    listaConsultas.innerHTML = "";

    dados.forEach(consulta => {
        listaConsultas.innerHTML += `
            <tr>
                <td>${consulta.id}</td>
                <td>${consulta.animal_id}</td>
                <td>${consulta.veterinario_id}</td>
                <td>${consulta.data_consulta}</td>
                <td>${consulta.motivo}</td>
                <td>${consulta.status}</td>
                <td>
                    <button onclick="editarConsulta(${consulta.id})">Editar</button>
                    <button onclick="excluirConsulta(${consulta.id})">Excluir</button>
                </td>
            </tr>`;
    });
}

async function editarConsulta(id) {
    const resposta = await fetch(`${API}/consultas.php?id=${id}`);
    const consulta = await resposta.json();

    consultaId.value = consulta.id;
    consultaAnimal.value = consulta.animal_id;
    consultaVeterinario.value = consulta.veterinario_id;
    consultaData.value = consulta.data_consulta;
    consultaMotivo.value = consulta.motivo;
    consultaStatus.value = consulta.status;
}

async function excluirConsulta(id) {
    if (confirm("Deseja excluir esta consulta?")) {
        await fetch(`${API}/consultas.php?id=${id}`, {
            method: "DELETE"
        });

        listarConsultas();
    }
}

function limparConsulta() {
    formConsulta.reset();
    consultaId.value = "";
}