<form id="frmAgendamento" class="form-horizontal">
    {{ csrf_field() }}

    <div class="box-body">
        <input type="hidden" value="{{ $consulta->id }}" name="id">
        <div class="alert alert-danger" role="alert">
            Deseja realmente CANCELAR essa Consulta?
        </div>
    </div>
</form>

<script>
    $("#btnSave").unbind("click").click(function (e) {
        e.preventDefault();
        var form = $("#frmAgendamento").serialize();
        $("#btnSave").css("pointer-events", "none");
        $("#btnClose").css("pointer-events", "none");
        $.ajax({
            type: "POST",
            url: "{{ route('atendimento.agendamento-consulta.confirmardelete', $consulta->id) }}",
            data: form,
            success: function (data) {

                if (data == "Cancelado com sucesso!") {
                    Swal.fire({
                        position: 'center ',
                        type: 'success',
                        title: data,
                        showConfirmButton: false,
                        timer: 1500
                    })
                    $("#tblAgendamentos").DataTable().ajax.reload();
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
        });
    });
    $('#modal_CRUD').unbind("hide.bs.modal").on('hide.bs.modal', function () {
        $("#tblAgendamentos").DataTable().ajax.reload();
    });
</script>
