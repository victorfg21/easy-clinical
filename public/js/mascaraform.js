$(document).ready(function() {
    $('.data').mask('00/00/0000');
    $('.ano').mask('0000');
    $('.hora').mask('00:00');
    $('.hora-completa').mask('00:00');
    $(".cpf").mask("999.999.999-99");
    $('.cnpj').mask('00.000.000/0000-00');
    $('.cnae').mask('0000-0/00');
    $('.eleitor').mask('000000000000');
    $(".telFixo").mask("(99) 9999-9999");
    $(".telCel").mask("(99) 9 9999-9999");
    $(".cep").mask("99.999-999");
    $('.quantidade').mask("#.##0", { reverse: true });
    $('.peso').mask("#.##0,00", { reverse: true });
    $('.dinheiro').mask("#.##0,00", { reverse: true });

    $('.js-example-basic-single').select2();
    $('.js-example-basic-multiple').select2();
    $(".js-example-responsive").select2({
        width: '100% ' // need to override the changed default
    });
});
