const formLogin = document.getElementById("formLogin");
const mensagem = document.getElementById("mensagemLogin");

formLogin.addEventListener("submit", async (event) => {
    event.preventDefault();

    const dados = {
        tipo: document.getElementById("tipo").value,
        email: document.getElementById("email").value,
        senha: document.getElementById("senha").value
    };

    try {
        const resposta = await fetch("../api/login.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(dados)
        });

        const resultado = await resposta.json();

        if (!resposta.ok) {
            mensagem.textContent = resultado.erro;
            return;
        }

        window.location.href = resultado.pagina;

    } catch (erro) {
        mensagem.textContent = "Não foi possível conectar ao servidor.";
    }
});
