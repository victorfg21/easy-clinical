function modalBootstrap(caminho, titulo, idModal, id, botaoSalvar, botaoCancelar, botaoFecharSuperior,
    textoBtnSalvar, textoBtnFechar, possuiCabecalho) {

    if (id !== undefined && id != "" && id != null)
        caminho = caminho + id;

    $.ajax({
        url: caminho,
        method: 'GET',
        success: function(data) {

            if (possuiCabecalho == 'false')
                $(idModal + " .modal-header").css("display", "none");
            else
                $(idModal + " .modal-header").css("display", "block");

            if (botaoSalvar == 'true') {
                $(idModal + " .modal-footer .btnSave").show();
                //Mudar o botão Salvar se tiver definido outro nome
                if (textoBtnSalvar != null && textoBtnSalvar != "" && textoBtnSalvar !== undefined)
                    $(idModal + " .modal-footer .btnSave").text(textoBtnSalvar);
                else
                    $(idModal + " .modal-footer .btnSave").text("Salvar");
            } else {
                $(idModal + " .modal-footer .btnSave").hide();
            }



            if (botaoCancelar == 'true') {
                $(idModal + " .modal-footer .btnClose").show();
                //Mudar o botão Fechar se tiver definido outro nome
                if (textoBtnFechar != null && textoBtnFechar != "" && textoBtnFechar !== undefined)
                    $(idModal + " .modal-footer .btnClose").text(textoBtnFechar);
                else
                    $(idModal + " .modal-footer .btnClose").text("Fechar");
            } else {
                $(idModal + " .modal-footer .btnClose").hide();
            }


            if (botaoFecharSuperior == 'true') {
                $(idModal + " .modal-header .close").show();
            } else {
                $(idModal + " .modal-header .close").hide();
            }

            $(idModal + " .modal-body").html(data);
            $(idModal + " .modal-title").html(titulo);
            $(idModal).modal('toggle');
            $(idModal).modal('show');


        }
    })
}

function modalBootstrapView(view, titulo, idModal, id, botaoSalvar, botaoCancelar, botaoFecharSuperior,
    textoBtnSalvar, textoBtnFechar, possuiCabecalho) {

    if (id !== undefined && id != "" && id != null)
        caminho = caminho + id;
    {
        if (possuiCabecalho == 'false')
            $(idModal + " .modal-header").css("display", "none");
        else
            $(idModal + " .modal-header").css("display", "block");

        if (botaoSalvar == 'true') {
            $(idModal + " .modal-footer .btnSave").show();
            //Mudar o botão Salvar se tiver definido outro nome
            if (textoBtnSalvar != null && textoBtnSalvar != "" && textoBtnSalvar !== undefined)
                $(idModal + " .modal-footer .btnSave").text(textoBtnSalvar);
            else
                $(idModal + " .modal-footer .btnSave").text("Salvar");
        } else {
            $(idModal + " .modal-footer .btnSave").hide();
        }



        if (botaoCancelar == 'true') {
            $(idModal + " .modal-footer .btnClose").show();
            //Mudar o botão Fechar se tiver definido outro nome
            if (textoBtnFechar != null && textoBtnFechar != "" && textoBtnFechar !== undefined)
                $(idModal + " .modal-footer .btnClose").text(textoBtnFechar);
            else
                $(idModal + " .modal-footer .btnClose").text("Fechar");
        } else {
            $(idModal + " .modal-footer .btnClose").hide();
        }


        if (botaoFecharSuperior == 'true') {
            $(idModal + " .modal-header .close").show();
        } else {
            $(idModal + " .modal-header .close").hide();
        }

        $(idModal + " .modal-body").html(view);
        $(idModal + " .modal-title").html(titulo);
        $(idModal).modal('toggle');
        $(idModal).modal('show');
    }
}
