$(document).ready(function () {
    $('#btnSetItemValorRef').on('click', function (e) {
        // Captura a referência da tabela com id “minhaTabela”
        var table = $('#tblValorReferencia')[0];
        // Captura a quantidade de linhas já existentes na tabela
        var numOfRows = table.tBodies[0].rows.length;
        var numOfRowsHead = table.tHead.rows.length;
        // Captura a quantidade de colunas da última linha da tabela
        var numOfCols = table.tHead.rows[numOfRowsHead - 1].cells.length;

        var idValorReferencia = $('select[name="valor_referencia_id"] option:selected').val();
        var valorReferencia = $('select[name="valor_referencia_id"] option:selected').text();
        if (valorReferencia !== null && valorReferencia !== '') {
            //Verifica se a lista ja possui o item adicionado
            for (var i = 0; i < numOfRows; i++) {
                if (idValorReferencia == table.tBodies[0].rows[i].cells[0].innerHTML) {
                    Swal.fire({
                        position: 'center',
                        type: 'error',
                        title: 'Valor de Referência já foi adicionada!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    return;
                }
            }

            // Insere uma linha no fim da tabela.
            var newRow = table.tBodies[0].insertRow(numOfRows);

            // Faz um loop para criar as colunas
            for (var j = 0; j < numOfCols; j++) {
                // Insere uma coluna na nova linha
                newCell = newRow.insertCell(j);

                switch (j) {
                    case 0:
                        newCell.innerHTML = idValorReferencia;
                        break;

                    case 1:
                        newCell.innerHTML = valorReferencia;
                        break;

                    case 2:
                        newCell.innerHTML = '<a class="btnDelLinhaValorRef"><i class="fa fa-trash fa-lg"></i></a>';
                        break;
                    default:
                        break;
                }
            }
        } else {
            if (valorReferencia == null || valorReferencia == '')
                Swal.fire({
                    position: 'center',
                    type: 'error',
                    title: 'Valor de Referência não foi selecionado!',
                    showConfirmButton: false,
                    timer: 1500
                });
                return;
        }
    });

    $(document).on('click', '.btnDelLinhaValorRef', function (e) {
        // Captura a referência da tabela com id “minhaTabela”
        var table = $('#tblValorReferencia')[0];
        //Id da linha que será removida
        var idLinha = e.currentTarget.parentElement.parentElement.sectionRowIndex;
        // Número de linhas
        var numOfRows = table.tBodies[0].rows.length;
        table.tBodies[0].deleteRow(idLinha);
    });
});
