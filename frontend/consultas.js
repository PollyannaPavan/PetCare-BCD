
const API_CONSULTAS = "../api/consultas.php";
const API_ANIMAIS = "../api/animais.php";
const API_VETERINARIOS = "../api/veterinarios.php";

let animais = [];
let veterinarios = [];
let consultas = [];

const formConsulta = document.getElementById("formConsulta");

formConsulta.addEventListener("submit", salvarConsulta);

async function carregarDados() {
    try {
        const [resAnimais, resVeterinarios, resConsultas] =
            await Promise.all([
                fetch(API_ANIMAIS),
                fetch(API_VETERINARIOS),
                fetch(API_CONSULTAS)
            ]);

        animais = await resAnimais.json();
        veterinarios = await resVeterinarios.json();
        consultas = await resConsultas.json();

        carregarSelectAnimais();
        carregarSelectVeterinarios();
        listarConsultas();
    } catch (erro) {
        alert("Erro ao carregar os dados!");
        console.error(erro);
    }
}

function carregarSelectAnimais() {
    const select = document.getElementById("consultaAnimal");

    select.innerHTML = '<option value="">Selecione o animal</option>';

    animais.forEach(animal => {
        select.innerHTML += `
            <option value="${animal.id}">
                ${animal.nome}
            </option>
        `;
    });
}

function carregarSelectVeterinarios() {
    const select = document.getElementById("consultaVeterinario");

    select.innerHTML = '<option value="">Selecione o veterinário</option>';

    veterinarios.forEach(veterinario => {
        select.innerHTML += `
            <option value="${veterinario.id}">
                ${veterinario.nome}
            </option>
        `;
    });
}

function listarConsultas() {
    const lista = document.getElementById("listaConsultas");

    lista.innerHTML = "";

    consultas.forEach(consulta => {
        const animal = animais.find(a => a.id == consulta.animal_id);
        const veterinario = veterinarios.find(
            v => v.id == consulta.veterinario_id
        );

        lista.innerHTML += `
            <tr>
                <td>${consulta.id}</td>
                <td>${animal ? animal.nome : "Animal não encontrado"}</td>
                <td>${veterinario ? veterinario.nome : "Veterinário não encontrado"}</td>
                <td>${consulta.data_consulta}</td>
                <td>${consulta.motivo}</td>
                <td>${consulta.status}</td>
                <td>
                    <button onclick="editarConsulta(${consulta.id})">Editar</button>
                    <button onclick="excluirConsulta(${consulta.id})">Excluir</button>
                </td>
            </tr>
        `;
    });
}

async function salvarConsulta(event) {
    event.preventDefault();

    const id = document.getElementById("consultaId").value;

    const dados = {
        animal_id: document.getElementById("consultaAnimal").value,
        veterinario_id: document.getElementById("consultaVeterinario").value,
        data_consulta: document.getElementById("consultaData").value,
        motivo: document.getElementById("consultaMotivo").value,
        status: document.getElementById("consultaStatus").value
    };

    const metodo = id ? "PUT" : "POST";
    const url = id ? `${API_CONSULTAS}?id=${id}` : API_CONSULTAS;

    try {
        const resposta = await fetch(url, {
            method: metodo,
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(dados)
        });

        const retorno = await resposta.json();

        if (!resposta.ok) {
            alert(retorno.Mensagem || "Erro ao salvar consulta!");
            return;
        }

        alert(retorno.Mensagem);
        limparConsulta();
        await carregarDados();
    } catch (erro) {
        alert("Erro ao conectar com a API!");
        console.error(erro);
    }
}

function editarConsulta(id) {
    const consulta = consultas.find(c => c.id == id);

    if (!consulta) {
        alert("Consulta não encontrada!");
        return;
    }

    document.getElementById("consultaId").value = consulta.id;
    document.getElementById("consultaAnimal").value = consulta.animal_id;
    document.getElementById("consultaVeterinario").value = consulta.veterinario_id;
    document.getElementById("consultaData").value = consulta.data_consulta;
    document.getElementById("consultaMotivo").value = consulta.motivo;
    document.getElementById("consultaStatus").value = consulta.status;

    document.querySelector("button[type='submit']").textContent = "Atualizar";

    window.scrollTo({
        top: 0,
        behavior: "smooth"
    });
}

async function excluirConsulta(id) {
    if (!confirm("Deseja realmente excluir esta consulta?")) {
        return;
    }

    try {
        const resposta = await fetch(`${API_CONSULTAS}?id=${id}`, {
            method: "DELETE"
        });

        const retorno = await resposta.json();

        if (!resposta.ok) {
            alert(retorno.Mensagem || "Erro ao excluir consulta!");
            return;
        }

        alert(retorno.Mensagem);
        await carregarDados();
    } catch (erro) {
        alert("Erro ao conectar com a API!");
        console.error(erro);
    }
}

function limparConsulta() {
    formConsulta.reset();
    document.getElementById("consultaId").value = "";
    document.querySelector("button[type='submit']").textContent = "Salvar";
}

carregarDados();
