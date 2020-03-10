<form id="frmResultado">
    {{ csrf_field() }}
    @include('atendimento.resultado-exame._form')
    <!-- DIV ERROS -->
    <div class="alert alert-danger print-error-msg" style="display:none">
        <ul></ul>
    </div>
</form>

<script src="{{ asset('js/mascaraform.js') }}"></script>

<script>
    $("#btnSaveLarge").unbind("click").click(function (e) {
        e.preventDefault();
        var form = $("#frmResultado").serialize();
        var resultadoLinha = [];
        var id = "";
        var descricao = "";
        var minimo = "";
        var maximo = "";
        var unidade = "";

        $("#btnSaveLarge").css("pointer-events", "none");
        $("#btnCloseLarge").css("pointer-events", "none");

        $("#tblResultadoLinha tbody tr").each(function () {
            id = $(this).find("td:nth-child(1)").text();
            val_resultado = $(this).find("td:nth-child(3)>input").val();

            resultadoLinha.push({
                "id": id,
                "val_resultado": val_resultado
            });
        });
        resultadoLinha = JSON.stringify(resultadoLinha);

        form = form + "&resultadoLinha=" + resultadoLinha;

        $.ajax({
            type: "POST",
            url: "{{ route('atendimento.resultado-exame.store') }}",
            data: form,
            success: function (data) {
                if (data == "Resultado lançado com sucesso!") {
                   Swal.fire({
                        position: 'center ',
                        type: 'success',
                        title: data,
                        showConfirmButton: false,
                        timer: 1500
                    })
                    $("#modal_Large").modal("hide");
                }
                else {
                    $("#modalMensagens .modal-body").html(data);
                    $("#modalMensagens .modal-title").html("Erros");
                    $('#modalMensagens').modal('toggle');
                    $('#modalMensagens').modal('show');
                }
                $("#btnSaveLarge").css("pointer-events", "");
                $("#btnCloseLarge").css("pointer-events", "");
            }
        }).fail(function (response){
            associate_errors(response['responseJSON']['errors'], $("#frmResultado"));
            $("#btnSaveLarge").css("pointer-events", "");
            $("#btnCloseLarge").css("pointer-events", "");

            Swal.fire({
                position: 'center',
                type: 'error',
                title: "Erro ao lançar resultado de exame",
                showConfirmButton: false,
                timer: 1500
            })
        });
    });
    $('#modal_Large').unbind("hide.bs.modal").on('hide.bs.modal', function () {
        $("#tblResultado").DataTable().ajax.reload();
    });
    function associate_errors(errors, $form)
    {
        $form.find('.form-group').removeClass('has-error').find('.help-text').text('');
        $('.print-error-msg').css('display','none');
        $(".print-error-msg").find("ul").html('');

        $.each(errors, function (value, index) {
            $('.print-error-msg').css('display','block');
            var $group = $form.find('#' + value + '-group');
            $(".print-error-msg").find("ul").append('<li>'+index+'</li>');
            $group.addClass('has-error');
        });
    }
</script>
