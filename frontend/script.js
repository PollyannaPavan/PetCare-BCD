
/* Carrossel de imagens */

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