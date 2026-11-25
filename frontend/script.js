
 // API de tutores
const API = "../api/tutores.php";

// Carrossel de imagens
const imagensCarrossel = document.querySelector(".imagens-carrossel");
const botaoAnterior = document.getElementById("anterior");
const botaoProximo = document.getElementById("proximo");
const indicadores = document.getElementById("indicadores");

if (imagensCarrossel && botaoAnterior && botaoProximo && indicadores) {
    const imagens = imagensCarrossel.querySelectorAll("img");
    let indiceAtual = 0;
    let intervalo;

    imagens.forEach((imagem, indice) => {
        const ponto = document.createElement("button");
        ponto.type = "button";
        ponto.classList.add("indicador");
        ponto.setAttribute("aria-label", `Ir para imagem ${indice + 1}`);

        ponto.addEventListener("click", () => {
            indiceAtual = indice;
            atualizarCarrossel();
            reiniciarIntervalo();
        });

        indicadores.appendChild(ponto);
    });

    const pontos = indicadores.querySelectorAll(".indicador");

    function atualizarCarrossel() {
        imagensCarrossel.style.transform =
            `translateX(-${indiceAtual * 100}%)`;

        pontos.forEach((ponto, indice) => {
            ponto.classList.toggle("ativo", indice === indiceAtual);
        });
    }

    function proximaImagem() {
        indiceAtual = (indiceAtual + 1) % imagens.length;
        atualizarCarrossel();
    }

    function imagemAnterior() {
        indiceAtual = (indiceAtual - 1 + imagens.length) % imagens.length;
        atualizarCarrossel();
    }

    function reiniciarIntervalo() {
        clearInterval(intervalo);
        intervalo = setInterval(proximaImagem, 4000);
    }

    botaoProximo.addEventListener("click", () => {
        proximaImagem();
        reiniciarIntervalo();
    });

    botaoAnterior.addEventListener("click", () => {
        imagemAnterior();
        reiniciarIntervalo();
    });

    atualizarCarrossel();
    reiniciarIntervalo();
}

// Elementos do cadastro
const formTutor = document.getElementById("formTutor");
const tutorId = document.getElementById("tutorId");
const tutorNome = document.getElementById("tutorNome");
const tutorTelefone = document.getElementById("tutorTelefone");
const tutorEmail = document.getElementById("tutorEmail");
const listaTutores = document.getElementById("listaTutores");

// GET - Listar tutores
async function listarTutores() {
    if (!listaTutores) return;

    try {
        const resposta = await fetch(API);
        const tutores = await resposta.json();

        listaTutores.innerHTML = "";

        tutores.forEach(tutor => {
            listaTutores.innerHTML += `
                <tr>
                    <td>${tutor.id}</td>
                    <td>${tutor.nome}</td>
                    <td>${tutor.telefone}</td>
                    <td>${tutor.email}</td>
                    <td>
                        <button type="button" onclick="editarTutor(${tutor.id})">
                            Editar
                        </button>
                        <button type="button" onclick="excluirTutor(${tutor.id})">
                            Excluir
                        </button>
                    </td>
                </tr>
            `;
        });

    } catch (erro) {
        alert("Erro ao carregar tutores.");
        console.error(erro);
    }
}

// POST e PUT - Salvar tutor
if (formTutor) {
    formTutor.addEventListener("submit", async (evento) => {
        evento.preventDefault();

        const dados = {
            nome: tutorNome.value,
            telefone: tutorTelefone.value,
            email: tutorEmail.value
        };

        const id = tutorId.value;
        const metodo = id ? "PUT" : "POST";

        if (id) {
            dados.id = id;
        }

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
                alert(resultado.Mensagem || "Erro ao salvar tutor.");
                return;
            }

            alert(resultado.Mensagem);
            limparTutor();
            listarTutores();

        } catch (erro) {
            alert("Erro ao conectar com a API.");
            console.error(erro);
        }
    });
}

// GET - Buscar tutor para edição
async function editarTutor(id) {
    try {
        const resposta = await fetch(`${API}?id=${id}`);
        const tutor = await resposta.json();

        tutorId.value = tutor.id;
        tutorNome.value = tutor.nome;
        tutorTelefone.value = tutor.telefone;
        tutorEmail.value = tutor.email;

        const cadastro = document.getElementById("cadastro");

        if (cadastro) {
            cadastro.scrollIntoView({ behavior: "smooth" });
        }

        tutorNome.focus();

    } catch (erro) {
        alert("Erro ao buscar tutor.");
        console.error(erro);
    }
}

// DELETE - Excluir tutor
async function excluirTutor(id) {
    if (!confirm("Deseja realmente excluir este tutor?")) {
        return;
    }

    try {
        const resposta = await fetch(`${API}?id=${id}`, {
            method: "DELETE"
        });

        const resultado = await resposta.json();

        alert(resultado.Mensagem);
        listarTutores();

    } catch (erro) {
        alert("Erro ao excluir tutor.");
        console.error(erro);
    }
}

// Limpar formulário
function limparTutor() {
    if (!formTutor) return;

    formTutor.reset();
    tutorId.value = "";
}

// Disponibiliza funções para os botões HTML
window.editarTutor = editarTutor;
window.excluirTutor = excluirTutor;
window.limparTutor = limparTutor;

// Carrega os tutores ao abrir a página
listarTutores();
