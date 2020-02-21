$(document).ready(function() {
    $('#btnAddLinhaExame').on('click', function(e) {
        // Captura a referência da tabela com id “minhaTabela”
        var table = $('#tblExameLinha')[0];
        // Captura a quantidade de linhas já existentes na tabela
        var numOfRows = table.tBodies[0].rows.length;
        var numOfRowsHead = table.tHead.rows.length;
        // Captura a quantidade de colunas da última linha da tabela
        var numOfCols = table.tHead.rows[numOfRowsHead - 1].cells.length;

        // Insere uma linha no fim da tabela.
        var newRow = table.tBodies[0].insertRow(numOfRows);

        // Faz um loop para criar as colunas
        for (var j = 0; j < numOfCols; j++) {
            // Insere uma coluna na nova linha
            newCell = newRow.insertCell(j);

            switch (j) {
                case 0:
                    newCell.innerHTML = numOfRows + 1;
                    break;

                case 1:
                    newCell.innerHTML = '<input for="descricao" class="form-control" type="text" name="descricao" value="" />';
                    break;

                case 2:
                    var comboGrid = '';

                    $.ajax({
                        type: "GET",
                        url: "/admin/exames/listarexamegrupos",
                        dataType: "json",
                        async: false,
                        success: function(data) {
                            comboGrid += '<select for="exame_grupo_id" class="form-control js-example-responsive" name="exame_grupo_id" >';
                            $.each(data, function(k, v) {
                                comboGrid += '<option value="' + v.id + '">' + v.nome + '</option>';
                            });

                            comboGrid += '</select>';
                            newCell.innerHTML = comboGrid;

                            $(".js-example-responsive").select2({
                                width: '100% ' // need to override the changed default
                            });
                        }
                    });
                    break;

                case 3:
                    newCell.innerHTML = '<input for="minimo" class="form-control peso" type="text" name="minimo" value="" />';
                    $('.peso').mask("#.##0,00", { reverse: true });
                    break;

                case 4:
                    newCell.innerHTML = '<input for="maximo" class="form-control peso" type="text" name="maximo" value="" />';
                    $('.peso').mask("#.##0,00", { reverse: true });
                    break;

                case 5:
                    newCell.innerHTML = '<input for="unidade" class="form-control" type="text" name="unidade" value="" />';
                    break;

                case 6:
                    newCell.innerHTML = '<a class="btnDelLinhaExame"><i class="fa fa-trash fa-lg"></i></a>';
                    break;

                default:
                    break;
            }
        }
    });

    $(document).on('click', '.btnDelLinhaExame', function(e) {
        // Captura a referência da tabela com id “minhaTabela”
        var table = $('#tblExameLinha')[0];
        //Id da linha que será removida
        var idLinha = e.currentTarget.parentElement.parentElement.sectionRowIndex;
        // Número de linhas
        var numOfRows = table.tBodies[0].rows.length;
        table.tBodies[0].deleteRow(idLinha);
    });
});
