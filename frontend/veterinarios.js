// API de veterinários
const API = "../api/veterinarios.php";

// Elementos do cadastro
const formVeterinario = document.getElementById("formVeterinario");
const veterinarioId = document.getElementById("veterinarioId");
const vetNome = document.getElementById("vetNome");
const vetCrmv = document.getElementById("vetCrmv");
const vetTelefone = document.getElementById("vetTelefone");
const listaVeterinarios = document.getElementById("listaVeterinarios");

// GET - Listar veterinários
async function listarVeterinarios() {
    try {
        const resposta = await fetch(API);
        const veterinarios = await resposta.json();

        listaVeterinarios.innerHTML = "";

        veterinarios.forEach(vet => {
            listaVeterinarios.innerHTML += `
                <tr>
                    <td>${vet.id}</td>
                    <td>${vet.nome}</td>
                    <td>${vet.crmv}</td>
                    <td>${vet.telefone}</td>
                    <td>
                        <button type="button"
                            onclick="editarVeterinario(${vet.id})">
                            Editar
                        </button>

                        <button type="button"
                            onclick="excluirVeterinario(${vet.id})">
                            Excluir
                        </button>
                    </td>
                </tr>
            `;
        });

    } catch (erro) {
        alert("Erro ao carregar veterinários.");
        console.error(erro);
    }
}

// POST e PUT - Salvar veterinário
formVeterinario.addEventListener("submit", async (evento) => {
    evento.preventDefault();

    const dados = {
        nome: vetNome.value,
        crmv: vetCrmv.value,
        telefone: vetTelefone.value
    };

    const id = veterinarioId.value;
    const metodo = id ? "PUT" : "POST";
    const url = id ? `${API}?id=${id}` : API;

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
            alert(resultado.Mensagem || resultado.mensagem || "Erro ao salvar.");
            return;
        }

        alert(resultado.Mensagem || resultado.mensagem || "Veterinário salvo!");

        limparVeterinario();
        listarVeterinarios();

    } catch (erro) {
        alert("Erro ao conectar com a API.");
        console.error(erro);
    }
});

// GET - Buscar veterinário para edição
async function editarVeterinario(id) {
    try {
        const resposta = await fetch(`${API}?id=${id}`);
        const vet = await resposta.json();

        if (!resposta.ok) {
            alert(vet.Mensagem || vet.mensagem || "Veterinário não encontrado.");
            return;
        }

        veterinarioId.value = vet.id;
        vetNome.value = vet.nome;
        vetCrmv.value = vet.crmv;
        vetTelefone.value = vet.telefone;

        document.getElementById("cadastro").scrollIntoView({
            behavior: "smooth"
        });

        vetNome.focus();

    } catch (erro) {
        alert("Erro ao buscar veterinário.");
        console.error(erro);
    }
}

// DELETE - Excluir veterinário
async function excluirVeterinario(id) {
    if (!confirm("Deseja realmente excluir este veterinário?")) {
        return;
    }

    try {
        const resposta = await fetch(`${API}?id=${id}`, {
            method: "DELETE"
        });

        const resultado = await resposta.json();

        if (!resposta.ok) {
            alert(resultado.Mensagem || resultado.mensagem || "Erro ao excluir.");
            return;
        }

        alert(resultado.Mensagem || resultado.mensagem || "Veterinário excluído!");
        listarVeterinarios();

    } catch (erro) {
        alert("Erro ao excluir veterinário.");
        console.error(erro);
    }
}

// Limpar formulário
function limparVeterinario() {
    formVeterinario.reset();
    veterinarioId.value = "";
}

// Disponibilizar funções para os botões
window.editarVeterinario = editarVeterinario;
window.excluirVeterinario = excluirVeterinario;
window.limparVeterinario = limparVeterinario;

// Carregar veterinários ao abrir a página
listarVeterinarios();