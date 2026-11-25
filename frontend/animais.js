
 // APIs
const API_ANIMAIS = "../api/animais.php";
const API_TUTORES = "../api/tutores.php";

// Elementos do formulário
const formAnimal = document.getElementById("formAnimal");
const animalId = document.getElementById("animalId");
const animalNome = document.getElementById("animalNome");
const animalEspecie = document.getElementById("animalEspecie");
const animalRaca = document.getElementById("animalRaca");
const animalNascimento = document.getElementById("animalNascimento");
const animalTutor = document.getElementById("animalTutor");
const listaAnimais = document.getElementById("listaAnimais");

// GET - Listar tutores
async function listarTutores() {
    try {
        const resposta = await fetch(API_TUTORES);
        const tutores = await resposta.json();

        animalTutor.innerHTML = '<option value="">Selecione o tutor</option>';

        tutores.forEach(tutor => {
            animalTutor.innerHTML += `
                <option value="${tutor.id}">
                    ${tutor.nome}
                </option>
            `;
        });

    } catch (erro) {
        alert("Erro ao carregar tutores.");
        console.error(erro);
    }
}

// GET - Listar animais
async function listarAnimais() {
    try {
        const resposta = await fetch(API_ANIMAIS);
        const animais = await resposta.json();
        const tutores = await buscarTutores();

        listaAnimais.innerHTML = "";

        animais.forEach(animal => {
            const tutor = tutores.find(t => t.id == animal.tutor_id);

            listaAnimais.innerHTML += `
                <tr>
                    <td>${animal.id}</td>
                    <td>${animal.nome}</td>
                    <td>${animal.especie}</td>
                    <td>${animal.raca}</td>
                    <td>${animal.data_nascimento}</td>
                    <td>${tutor ? tutor.nome : "Não encontrado"}</td>
                    <td>
                        <button type="button"
                            onclick="editarAnimal(${animal.id})">
                            Editar
                        </button>

                        <button type="button"
                            onclick="excluirAnimal(${animal.id})">
                            Excluir
                        </button>
                    </td>
                </tr>
            `;
        });

    } catch (erro) {
        alert("Erro ao carregar animais.");
        console.error(erro);
    }
}

// Buscar tutores
async function buscarTutores() {
    const resposta = await fetch(API_TUTORES);
    return await resposta.json();
}

// POST e PUT - Salvar animal
formAnimal.addEventListener("submit", async (evento) => {
    evento.preventDefault();

    const dados = {
        nome: animalNome.value,
        especie: animalEspecie.value,
        raca: animalRaca.value,
        data_nascimento: animalNascimento.value,
        tutor_id: animalTutor.value
    };

    const id = animalId.value;
    const metodo = id ? "PUT" : "POST";
    const url = id ? `${API_ANIMAIS}?id=${id}` : API_ANIMAIS;

    try {
        const resposta = await fetch(url, {
            method: metodo,
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(dados)
        });

        const resultado = await resposta.json();

        if (!resposta.ok) {
            alert(resultado.Mensagem || "Erro ao salvar animal.");
            return;
        }

        alert(resultado.Mensagem);
        limparAnimal();
        listarAnimais();

    } catch (erro) {
        alert("Erro ao conectar com a API.");
        console.error(erro);
    }
});

// GET - Buscar animal para edição
async function editarAnimal(id) {
    try {
        const resposta = await fetch(`${API_ANIMAIS}?id=${id}`);
        const animal = await resposta.json();

        if (!resposta.ok) {
            alert(animal.Mensagem || "Animal não encontrado.");
            return;
        }

        animalId.value = animal.id;
        animalNome.value = animal.nome;
        animalEspecie.value = animal.especie;
        animalRaca.value = animal.raca;
        animalNascimento.value = animal.data_nascimento;
        animalTutor.value = animal.tutor_id;

        document.getElementById("cadastro").scrollIntoView({
            behavior: "smooth"
        });

        animalNome.focus();

    } catch (erro) {
        alert("Erro ao buscar animal.");
        console.error(erro);
    }
}

// DELETE - Excluir animal
async function excluirAnimal(id) {
    if (!confirm("Deseja realmente excluir este animal?")) {
        return;
    }

    try {
        const resposta = await fetch(`${API_ANIMAIS}?id=${id}`, {
            method: "DELETE"
        });

        const resultado = await resposta.json();

        if (!resposta.ok) {
            alert(resultado.Mensagem || "Erro ao excluir animal.");
            return;
        }

        alert(resultado.Mensagem);
        listarAnimais();

    } catch (erro) {
        alert("Erro ao excluir animal.");
        console.error(erro);
    }
}

// Limpar formulário
function limparAnimal() {
    formAnimal.reset();
    animalId.value = "";
}

// Funções dos botões
window.editarAnimal = editarAnimal;
window.excluirAnimal = excluirAnimal;
window.limparAnimal = limparAnimal;

// Carregar a página
async function iniciarPagina() {
    await listarTutores();
    await listarAnimais();
}

iniciarPagina();
