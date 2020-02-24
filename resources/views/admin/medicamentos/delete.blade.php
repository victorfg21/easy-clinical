<form id="frmMedicamento" class="form-horizontal">
    {{ csrf_field() }}

    <div class="box-body">

        <input type="hidden" value="{{ $medicamento->id }}" name="id">

        <div class="alert alert-danger" role="alert">
            Deseja realmente EXCLUIR esse Medicamento?
        </div>

        <div class="form-group">
            <div class="row">
                <label for="nome" class="col-sm-3 control-label">Nome Genérico</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="nome_generico" value="{{ $medicamento->nome_generico }}" disabled="disabled">
                </div>
            </div>
            <div class="row">
                <label for="nome" class="col-sm-3 control-label">Nome Fábrica</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="nome_fabrica" value="{{ $medicamento->nome_fabrica }}" disabled="disabled">
                </div>
            </div>
        </div>

    </div>
</form>

<script>
    $("#btnSave").unbind("click").click(function (e) {
        e.preventDefault();
        var form = $("#frmMedicamento").serialize();
        $("#btnSave").css("pointer-events", "none");
        $("#btnClose").css("pointer-events", "none");
        $.ajax({
            type: "POST",
            url: "{{ route('admin.medicamentos.confirmardelete', $medicamento->id) }}",
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
                    Swal.fire({
                        position: 'center',
                        type: 'error',
                        title: "Erro ao remover medicamento",
                        showConfirmButton: false,
                        timer: 1500
                    })
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
        $("#tblMedicamentos").DataTable().ajax.reload();
    });
</script>
