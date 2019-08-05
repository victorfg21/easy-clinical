$(document).ready(function() {
    $('.tabela-pesquisa').DataTable({
        "paging":   true,
        "ordering": false,
        "info":     false,
        /*"oLanguage": {
            "sEmptyTable": "Nenhum registro encontrado",
            "sLoadingRecords": "Carregando...",
            "sProcessing": "Processando...",
            "sZeroRecords": "Nenhum registro encontrado",
            "sSearch": "Pesquisar",
            "oPaginate" :{
                "sFirst" : "Primeiro",
                "sPrevious" : "Anterior",
                "sNext"	: "Seguinte",
                "sLast" : "Último",
            },
        }*/
        "language": {
            "url": "http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json"
        }        
    }); 
});