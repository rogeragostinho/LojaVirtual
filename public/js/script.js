window.onload = function(){
    const url = "https://v6.exchangerate-api.com/v6/0f07201b48911821883a10bc/codes"

    fetch(url)
    .then(response => response.json())
    .then(data => {
        //Pega as moedas suportadas da API
        const moedasSuportadas = data.supported_codes
        //Adiciona as opçoes de moedas(nome do país) e o valor da option(três digitos)
        for(let i = 0; i < moedasSuportadas.length; i++)
        {
            if(moedasSuportadas[i][0] == "AOA"){
                document.querySelectorAll("select.moedasSuportadas")[0].innerHTML += `<option selected value = ${moedasSuportadas[i][0]}>"${moedasSuportadas[i][1]}"</option>`
            }else{
                document.querySelectorAll("select.moedasSuportadas")[0].innerHTML += `<option value = ${moedasSuportadas[i][0]}>"${moedasSuportadas[i][1]}"</option>`
            }
            if(moedasSuportadas[i][0] == "USD"){
                document.querySelectorAll("select.moedasSuportadas")[1].innerHTML += `<option selected value = ${moedasSuportadas[i][0]}>"${moedasSuportadas[i][1]}"</option>`
            }else{
                document.querySelectorAll("select.moedasSuportadas")[1].innerHTML += `<option value = ${moedasSuportadas[i][0]}>"${moedasSuportadas[i][1]}"</option>`
            }    
        }
    })
    .then(error => console.error("Erro: ", error))
}
document.querySelector("button#converter").addEventListener("click", function(){
    //Pega os moedas selecionadas(três digitos) para conversão
    let select1 = document.querySelector("select#moedaParaConverter")
    let select2 = document.querySelector("select#moedaDesejada")
    let moedaParaConverter = select1[select1.selectedIndex].value
    let moedaDesejada = select2[select2.selectedIndex].value

    //Pega o valor para conversão
    let valorParaConverter = document.querySelector("input#valorParaConverter").value
    let valorConvertido

    //FETCH API
    const url = "https://v6.exchangerate-api.com/v6/0f07201b48911821883a10bc/latest/" + moedaParaConverter

    fetch(url)
    .then(response => response.json())
    .then(data => {
        if(data.result == "error")
        {
            alert("Ocorreu um problema na conversão, por favor, verifique se informou os dados corretamente ou tente mais tarde")
        }else
        {
            let taxasDeCambio = data.conversion_rates
            valorConvertido = valorParaConverter * taxasDeCambio[moedaDesejada]
            console.log(valorConvertido)
            document.querySelector("input#valorConvertido").value = valorConvertido
        }
    })
    .then(error => console.error("Erro: ", error))
})