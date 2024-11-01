angular.module('campanha', ['datatables']).controller('ControllerCampanha', DataTables)

function DataTables(DTOptionsBuilder, DTColumnBuilder, DTDefaultOptions, $q) {
    var vm = this;
    var api_encoded = encodeURIComponent(api);

    vm.dtDefaultOptions = DTDefaultOptions.setDOM('rt<"floatedinfo"i><"marginright"p>');
    vm.dtOptions = DTOptionsBuilder.fromFnPromise($q.when(campanhas))
            .withPaginationType('full_numbers')
            .withLanguage({
                "sEmptyTable": "Você não possui nenhuma campanha",
                "sInfo": "Listando _START_-_END_ de _TOTAL_ campanhas",
                "sInfoEmpty": "Nenhuma campanha criada",
                "sInfoFiltered": "(filtrado de _MAX_ registros totais)",
                "sInfoPostFix": "",
                "sInfoThousands": ",",
                "sLengthMenu": "Mostrando _MENU_ campanhas",
                "sLoadingRecords": "Carregando",
                "sProcessing": "Processando",
                "sSearch": "Pesquisar :",
                "sZeroRecords": "Nenhuma campanha encontrada",
                "oPaginate": {
                    "sFirst": "Primeiro",
                    "sLast": "Último",
                    "sNext": "Próximo",
                    "sPrevious": "Anterior"
                }});
    vm.dtColumns = [
        DTColumnBuilder.newColumn('nome').withTitle('Nome'),
        DTColumnBuilder.newColumn('template').withTitle('Template'),
        DTColumnBuilder.newColumn('filtro').withTitle('Grupo').renderWith(function(name){
            var str = name.replace("FILTRO", "GRUPO");
            return str;
        }),
        DTColumnBuilder.newColumn('data').withTitle('Data de Envio'),
        DTColumnBuilder.newColumn('status').withTitle('Status').renderWith(function (status) {
            return status == '0' ? 'Não enviado' : status == '1' ? 'Enviando' : 'Enviado';
        }),
        DTColumnBuilder.newColumn('acoes').withTitle('Ações').renderWith(function (_, _, full) {
            if (full.status == '0') {
                return '<a id="gerar-campanha-teste" data-id=' + full.id + ' title="Gerar Campanha Teste" class="click dashicons dashicons-share-alt2"</a>\n\
            <a id="campanha-edit" data-id=' + full.id + ' title="Editar" class="click dashicons dashicons-edit"</a>\n\
            <a id="campanha-spamassassin" href="https://app.webcourier.com.br/api/mailmarketing/spamassassin?id=' + full.id + '&api=' + api_encoded + '" title="Validação Spamassassin" class="click dashicons dashicons-shield"</a>\n\
            <a data-id=' + full.id + ' id="gerar-campanha" title="Gerar Campanha" class="click dashicons dashicons-migrate"</a>'
            } else if (full.status == '1') {
                return '<a id="campanha-spamassassin" href="https://app.webcourier.com.br/api/mailmarketing/spamassassin?id=' + full.id + '&api=' + api_encoded + '"><i title="Validação Spamassassin" class="click dashicons dashicons-shield"></i></a>\n\
            	<a data-id=' + full.id + ' id="gerar-campanha-teste" title="Gerar Campanha Teste" class="click dashicons dashicons-share-alt2"></a>\n\
            	<a data-id=' + full.id + ' id="gerar-campanha" title="Gerar Campanha" class="click dashicons dashicons-migrate"></a>'
            } else {
                return '<a id="gerar-campanha-teste" data-id=' + full.id + ' title="Gerar Campanha Teste" class="click dashicons dashicons-share-alt2"</a>\n\
            <a data-id=' + full.id + ' title="Copiar" class="click dashicons dashicons-format-gallery"></a>\n\
            <a id="campanha-spamassassin" href="https://app.webcourier.com.br/api/mailmarketing/spamassassin?id=' + full.id + '&api=' + api_encoded + '" title="Validação Spamassassin" class="click dashicons dashicons-shield"</a>\n\
            <a href="https://app.webcourier.com.br/api/mailmarketing/report?api=' + api_encoded + '&id=' + full.id + '" title="Relatório" data-id=' + full.id + ' class="campanha-report click dashicons dashicons-dashboard"></a>';
            }
        })
    ];
}

jQuery(document).ready(function () {
    jQuery('#add-campanha').on('click', function(e){
        e.preventDefault();
        window.location.href = url + '&add'
    });
    
    jQuery('table').on('click', '#campanha-spamassassin', function (e) {
        e.preventDefault();
        var elem = this;
        showEnvioModal();
        jQuery.ajax({
            type: 'GET',
            url: elem.href,
            dataType: 'html'
        }).done(function (response) {
            showEnvioModal(13);
            showSpamsinModal(response, true);
        }).fail(function () {
            showEnvioModal(13);
            var msg = 'Ocorreu algum problema na validação.<br/>'
                    + 'Em caso de dúvida, entrar em contato pelo telefone: (85) 3288-2000';
            showSpamsinModal(msg, false);
        });
    });
    jQuery('table').on('click', '.dashicons-format-gallery', function (e) {
        location.href = url + '&copy=' + jQuery(this).data('id');
    });
    jQuery('table').on('click', '#campanha-edit', function (e) {
        location.href = url + '&edit=' + jQuery(this).data('id');
    });
    jQuery('table').on('click', '#gerar-campanha-teste', function (e) {
        e.preventDefault();
        var elem = this;
        showEnvioModal();
        jQuery.ajax({
            type: 'GET',
            url: "https://app.webcourier.com.br/api/mailmarketing/gerarcampanha",
            dataType: 'html',
            data: {
                api: api,
                id: jQuery(elem).data('id'),
                flag: 1
            }
        }).done(function (response) {
            showEnvioModal(13);
            jQuery('body').append(response);
            jQuery('#result-modal').modal('show');
        });
    });
    jQuery('table').on('click', '#gerar-campanha', function (e) {
        e.preventDefault();
        var elem = this;
        var id = jQuery(elem).data('id');
        showEnvioModal();
        jQuery.ajax({
            type: 'GET',
            url: "https://app.webcourier.com.br/api/mailmarketing/gerarcampanha",
            data: {
                api: api,
                id: id,
                flag: 0
            },
        }).done(function (response) {
            console.log(response);
            showEnvioModal(1);
        }).fail(function () {
            showEnvioModal(2);
        });
    });
    jQuery('body').on('click', '.campanha-report', function (e) {
        e.preventDefault();
        var elem = this;
        var id = jQuery(elem).data('id');
        jQuery.ajax({
            type: 'GET',
            url: 'https://app.webcourier.com.br/api/mailmarketing/checkreport/' + id,
            dataType: 'JSON',
            data: {
                api: api,
                id: id,
            }
        }).done(function (data) {
            if (data.status == "success") {
                document.location = elem.href;
            } else {
                jQuery('#c-hd').hide();
                jQuery('#c-suc').show();
                jQuery('#c-err').hide();
                jQuery('#c-alert').hide();
                jQuery('#c-alert2').hide();
                jQuery('#c-alert3').hide();
                jQuery('#c-alert4').hide();
                jQuery('#c-modal .progress').hide();
                jQuery('#c-suc').html("Relatório desta campanha ainda não foi gerado completamente. Aguarde em torno de 1 hora dependendo do número de tickets gerados.").show();
                jQuery('#c-modal').modal('show');
            }
        });
    });
    function showSpamsinModal(msg, success)
    {
        var msg = msg === undefined ? null : msg;
        if (msg === null)
        {
            jQuery('#ss-start').show();
            jQuery('#spamsin .progress').show();
            jQuery('#ss-error').hide();
            jQuery('#ss-end').hide();
            jQuery('#spamsin .modal-body').hide();
        } else if (!success)
        {
            jQuery('#ss-start').hide();
            jQuery('#spamsin .progress').hide();
            jQuery('#ss-error').show();
            jQuery('#ss-end').hide();
            jQuery('#spamsin .modal-body').html(msg).show();
        } else
        {
            jQuery('#ss-start').hide();
            jQuery('#spamsin .progress').hide();
            jQuery('#ss-error').hide();
            jQuery('#ss-end').show();
            jQuery('#spamsin .modal-body').html(msg).show();
        }
        if (!jQuery('#spamsin').hasClass('in'))
        {
            jQuery('#spamsin').modal('show');
        }
    }

    function showEnvioModal(flag)
    {
        var flag = flag ? flag : 0;
        if (flag === 1)
        {
            jQuery('#c-hd').hide();
            jQuery('#c-suc').show();
            jQuery('#c-err').hide();
            jQuery('#c-alert').hide();
            jQuery('#c-alert2').hide();
            jQuery('#c-alert3').hide();
            jQuery('#c-alert4').hide();
            jQuery('#c-modal .progress').hide();
        } else if (flag === 2)
        {
            jQuery('#c-hd').hide();
            jQuery('#c-suc').hide();
            jQuery('#c-err').show();
            jQuery('#c-alert').hide();
            jQuery('#c-alert2').hide();
            jQuery('#c-alert3').hide();
            jQuery('#c-alert4').hide();
            jQuery('#c-modal .progress').hide();
        } else if (flag === 8)
        {
            jQuery('#c-hd').hide();
            jQuery('#c-suc').hide();
            jQuery('#c-err').hide();
            jQuery('#c-alert').show();
            jQuery('#c-alert2').hide();
            jQuery('#c-alert3').hide();
            jQuery('#c-alert4').hide();
            jQuery('#c-modal .progress').hide();
        } else if (flag === 9)
        {
            jQuery('#c-hd').hide();
            jQuery('#c-suc').hide();
            jQuery('#c-err').hide();
            jQuery('#c-alert').hide();
            jQuery('#c-alert2').show();
            jQuery('#c-alert3').hide();
            jQuery('#c-alert4').hide();
            jQuery('#c-modal .progress').hide();
        } else if (flag === 10)
        {
            jQuery('#c-hd').hide();
            jQuery('#c-suc').hide();
            jQuery('#c-err').hide();
            jQuery('#c-alert').hide();
            jQuery('#c-alert2').hide();
            jQuery('#c-alert3').show();
            jQuery('#c-alert4').hide();
            jQuery('#c-modal .progress').hide();
        } else if (flag === 11)
        {
            jQuery('#c-hd').hide();
            jQuery('#c-suc').hide();
            jQuery('#c-err').hide();
            jQuery('#c-alert').hide();
            jQuery('#c-alert2').hide();
            jQuery('#c-alert3').hide();
            jQuery('#c-alert4').show();
            jQuery('#c-modal .progress').hide();
        } else if (flag === 13)
        {
            jQuery('#c-hd').hide();
            jQuery('#c-suc').hide();
            jQuery('#c-err').hide();
            jQuery('#c-alert').hide();
            jQuery('#c-alert2').hide();
            jQuery('#c-alert3').hide();
            jQuery('#c-alert4').hide();
            jQuery('#c-modal .progress').hide();
            jQuery('#c-modal').modal('hide');
        } else
        {
            jQuery('#c-hd').show();
            jQuery('#c-suc').hide();
            jQuery('#c-err').hide();
            jQuery('#c-alert').hide();
            jQuery('#c-alert2').hide();
            jQuery('#c-alert3').hide();
            jQuery('#c-alert4').hide();
            jQuery('#c-modal .progress').show();
        }
        if (!jQuery('#c-modal').hasClass('in') && flag !== 13 && flag !== 11)
        {
            jQuery('#c-modal').modal('show');
        }
    }
});

