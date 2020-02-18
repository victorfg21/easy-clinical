<form id="frmAgendamento">
    {{ csrf_field() }}
    @include('atendimento.agendamento-consulta._form')
    <!-- DIV ERROS -->
    <div class="alert alert-danger print-error-msg" style="display:none">
        <ul></ul>
    </div>
</form>

<script src="{{ asset('js/cep.js') }}"></script>
<script src="{{ asset('js/mascaraform.js') }}"></script>

<script>
    $("#btnSave").unbind("click").click(function (e) {
        e.preventDefault();
        var form = $("#frmAgendamento").serialize();
        $("#btnSave").css("pointer-events", "none");
        $("#btnClose").css("pointer-events", "none");
        $.ajax({
            type: "POST",
            url: "{{ route('atendimento.agendamento-consulta.store') }}",
            data: form,
            success: function (data) {

                if (data == "Cadastrado com sucesso!") {
                   Swal.fire({
                        position: 'center ',
                        type: 'success',
                        title: data,
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $("#modal_CRUD").modal("hide");
                }
                else {
                    $("#modalMensagens .modal-body").html(data);
                    $("#modalMensagens .modal-title").html("Erros");
                    $('#modalMensagens').modal('toggle');
                    $('#modalMensagens').modal('show');
                }
                $("#btnSave").css("pointer-events", "");
                $("#btnClose").css("pointer-events", "");
            }
        }).fail(function (response){
            associate_errors(response['responseJSON']['errors'], $("#frmAgendamento"));
            $("#btnSave").css("pointer-events", "");
            $("#btnClose").css("pointer-events", "");

            Swal.fire({
                position: 'center',
                type: 'error',
                title: "Erro ao cadastrar consulta",
                showConfirmButton: false,
                timer: 1500
            });
        });
    });

    $("#btnClose").unbind("click").click(function (e) {
        e.preventDefault();
        var form = $("#frmAgendamento").serialize();
        $("#btnSave").css("pointer-events", "none");
        $("#btnClose").css("pointer-events", "none");
        $.ajax({
            type: "POST",
            url: "{{ route('atendimento.agendamento-consulta.reservaconsultacancel') }}",
            data: form,
            success: function (data) {
                if (data == "Agendamento Cancelado!") {
                    $("#modal_CRUD").modal("hide");
                }
                else {
                    $("#modalMensagens .modal-body").html(data);
                    $("#modalMensagens .modal-title").html("Erros");
                    $('#modalMensagens').modal('toggle');
                    $('#modalMensagens').modal('show');
                }
                $("#btnSave").css("pointer-events", "");
                $("#btnClose").css("pointer-events", "");
            }).fail(function (response){
                associate_errors(response['responseJSON']['errors'], $("#frmAgendamento"));
                $("#btnSave").css("pointer-events", "");
                $("#btnClose").css("pointer-events", "");

                Swal.fire({
                    position: 'center',
                    type: 'error',
                    title: "Erro ao cadastrar consulta",
                    showConfirmButton: false,
                    timer: 1500
                });
            });
        });
    });

    $('#modal_CRUD').unbind("hide.bs.modal").on('hide.bs.modal', function () {
        $("#tblAgendamentos").DataTable().ajax.reload();
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
