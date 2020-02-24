<form id="frmExameGrupo" class="form-horizontal">
    {{ csrf_field() }}

    <div class="box-body">

        <input type="hidden" value="{{ $exameGrupo->id }}" name="id">

        <div class="alert alert-danger" role="alert">
            Deseja realmente EXCLUIR esse Grupo?
        </div>

        <div class="form-group">
            <label for="nome" class="col-sm-2 control-label">Descrição</label>

            <div class="col-sm-10">
                <input type="text" class="form-control" name="nome" value="{{ $exameGrupo->nome }}" disabled="disabled">
            </div>
        </div>

    </div>
</form>

<script>
    $("#btnSave").unbind("click").click(function (e) {
        e.preventDefault();
        var form = $("#frmExameGrupo").serialize();
        $("#btnSave").css("pointer-events", "none");
        $("#btnClose").css("pointer-events", "none");
        $.ajax({
            type: "POST",
            url: "{{ route('admin.exame-grupos.confirmardelete', $exameGrupo->id) }}",
            data: form,
            success: function (data) {

                if (data == "Removido com sucesso!") {
                    Swal.fire({
                        position: 'center ',
                        type: 'success',
                        title: data,
                        showConfirmButton: false,
                        timer: 1500
                    })
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
        $("#tblExameGrupos").DataTable().ajax.reload();
    });
</script>
