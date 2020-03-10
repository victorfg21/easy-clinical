<form id="frmExames">
    {{ csrf_field() }}
    @include('admin.exames._form')
    <!-- DIV ERROS -->
    <div class="alert alert-danger print-error-msg" style="display:none">
        <ul></ul>
    </div>
</form>

<script src="{{ asset('js/mascaraform.js') }}"></script>

<script>
    $("#btnSaveLarge").unbind("click").click(function (e) {
        e.preventDefault();
        var form = $("#frmExames").serialize();
        var exameLinha = [];
        var id = "";
        var descricao = "";
        var minimo = "";
        var maximo = "";
        var unidade = "";

        $("#btnSaveLarge").css("pointer-events", "none");
        $("#btnCloseLarge").css("pointer-events", "none");

        $("#tblExameLinha tbody tr").each(function () {
            id = $(this).find("td:nth-child(1)").text();
            descricao = $(this).find("td:nth-child(2)>input").val();
            grupo = $(this).find("td:nth-child(3)>select option:selected").val();
            minimo = $(this).find("td:nth-child(4)>input").val();
            maximo = $(this).find("td:nth-child(5)>input").val();
            unidade = $(this).find("td:nth-child(6)>input").val();

            exameLinha.push({
                "id": id,
                "descricao": descricao,
                "grupo": grupo,
                "minimo": minimo,
                "maximo": maximo,
                "unidade": unidade
            });
        });
        exameLinha = JSON.stringify(exameLinha);
        console.log(exameLinha);
        form = form + "&exameLinha=" + exameLinha;

        $.ajax({
            type: "POST",
            url: "{{ route('admin.exames.store') }}",
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
            associate_errors(response['responseJSON']['errors'], $("#frmExames"));
            $("#btnSaveLarge").css("pointer-events", "");
            $("#btnCloseLarge").css("pointer-events", "");

            Swal.fire({
                position: 'center',
                type: 'error',
                title: "Erro ao cadastrar exame",
                showConfirmButton: false,
                timer: 1500
            })
        });
    });
    $('#modal_Large').unbind("hide.bs.modal").on('hide.bs.modal', function () {
        $("#tblExames").DataTable().ajax.reload();
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
