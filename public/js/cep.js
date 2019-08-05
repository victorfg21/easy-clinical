$(document).ready(function () {

    var vetSiglas = new Array("ac", "al", "am", "ap", "ba", "ce", "df", "es", "go", "ma", "mt", "ms", "mg", "pa", "pb", "pr", "pe", "pi", "rj", "rn", "ro", "rs", "rr", "sc", "se", "sp", "to");
    var vetEstados = new Array("Acre", "Alagoas", "Amazonas", "Amapá", "Bahia", "Ceará", "Distrito Federal", "Espírito Santo", "Goiás", "Maranhão", "Mato Grosso", "Mato Grosso do Sul", "Minas Gerais", "Pará", "Paraíba", "Paraná", "Pernambuco", "Piauí", "Rio de Janeiro", "Rio Grande do Norte", "Rondônia", "Rio Grande do Sul", "Roraima", "Santa Catarina", "Sergipe", "São Paulo", "Tocantins");
    var selectbox = $('#comboEstado');
    var siglaCadastro = $('input[name="hiddenEstadoSigla"]').val();

    $('<option selected="selected">').val('').text('').appendTo(selectbox);
    for (var i = 0; i < vetSiglas.length; i++) {
        if (siglaCadastro == vetSiglas[i].toUpperCase()) {
            console.log(siglaCadastro);
            $('<option selected="selected">').val(vetSiglas[i].toUpperCase()).text(vetEstados[i]).appendTo(selectbox);
        } else {
            $('<option>').val(vetSiglas[i].toUpperCase()).text(vetEstados[i]).appendTo(selectbox);
        }
    }
});

$("#cep").click(function () {
    var cep = $('input[name="cep"]').val() + "/json/";
    var cepFormatado = cep.replace(".", "").replace("-", "");
    $.get("https://viacep.com.br/ws/" + cepFormatado, function (data) {
        if(data.logradouro == '' || data.logradouro == null){
            $('input[name="cep"]').val("");
            swal({
                    type: 'error',
                    title: 'Ops!', 
                    text: 'CEP não localizado!',
                    confirmButtonText: 'Ok'
                });
        }else{
            $("#comboEstado").val(data.uf).trigger('change');
            $('input[name="cidade"]').val(data.localidade);
            $('input[name="bairro"]').val(data.bairro);
            $('input[name="endereco"]').val(data.logradouro);
        }        
    });
});