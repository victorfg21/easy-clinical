<form id="frmProfissional">
    {{ csrf_field() }}
    @include('admin.profissionais._form')
    <!-- DIV ERROS -->
    <div class="alert alert-danger print-error-msg" style="display:none">
        <ul></ul>
    </div>
</form>

<script src="{{ asset('js/cep.js') }}"></script>
<script src="{{ asset('js/mascaraform.js') }}"></script>

<script>
    $("#btnSaveLarge").unbind("click").click(function (e) {
        e.preventDefault();
        var form = $("#frmProfissional").serialize();
        var especialidades = [];
        var areasAtuacao = [];
        var id = "";
        var nome = "";

        $("#tblEspecialidades tbody tr").each(function () {
            id = $(this).find("td:nth-child(1)").text();
            nome = $(this).find("td:nth-child(2)").text();

            especialidades.push({
                "id": id,
                "nome": nome
            });
        });
        especialidades = JSON.stringify(especialidades);

        $("#tblAreasAtuacao tbody tr").each(function () {
            id = $(this).find("td:nth-child(1)").text();
            nome = $(this).find("td:nth-child(2)").text();

            areasAtuacao.push({
                "id": id,
                "nome": nome
            });
        });
        areasAtuacao = JSON.stringify(areasAtuacao);

        form = form + "&especialidades=" + especialidades + "&areasAtuacao=" + areasAtuacao;

        $("#btnSaveLarge").css("pointer-events", "none");
        $("#btnCloseLarge").css("pointer-events", "none");
        $.ajax({
            type: "POST",
            url: "{{ route('admin.profissionais.store') }}",
            data: form,
            success: function (data) {

                if (data == "Cadastrado com sucesso!") {
                   Swal.fire({
                        position: 'center ',
                        type: 'success',
                        title: data,
                        showConfirmButton: false,
                        timer: 1500
                    })
                    $("#tblProfissionais").DataTable().ajax.reload();
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
            associate_errors(response['responseJSON']['errors'], $("#frmProfissional"));
            $("#btnSaveLarge").css("pointer-events", "");
            $("#btnCloseLarge").css("pointer-events", "");

            Swal.fire({
                position: 'center',
                type: 'error',
                title: "Erro ao cadastrar profissional",
                showConfirmButton: false,
                timer: 1500
            })
        });
    });
    $('#modal_Large').unbind("hide.bs.modal").on('hide.bs.modal', function () {
        $("#tblProfissionais").DataTable().ajax.reload();
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
