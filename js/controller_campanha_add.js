angular.module('campanhaAdd', []).controller('campanhaAddTemplates', templateGrid);

function templateGrid() {
    var cat = this;
    var templateIds = Object.keys(templates);
    var templateName = !add ? templates['id' + campanha.item_envio_idx].nome : '';

    cat.angularTemplates = templates;
    cat.currentPage = 0;
    cat.pageSize = 12;
    cat.templateValue = templateName;
    cat.templateId = campanha.item_envio_idx;
    cat.numberOfPages = function () {
        return Math.ceil(templateIds.length / cat.pageSize);
    }
    console.log(cat.angularTemplates);
    cat.nextPage = function (state) {
        state ? cat.currentPage++ : cat.currentPage--;
    }
    cat.isInPage = function (idx) {
        return (idx >= cat.currentPage * 12 && (idx < (cat.currentPage * 12) + 12));
    }
    cat.setTemplateValue = function (pasta) {
        cat.templateId = pasta.slice(11);
        var re = /^(.*?_){2}(\d+)/g;
        var templatePosition = re.exec(pasta);
        cat.templateValue = templates['id' + templatePosition[2]].nome;
        jQuery('#template-img').html('<img  style="height: auto; max-width: 100%;" src="http://app.webcourier.com.br/templates/'+pasta+'/thumb.png">');
        jQuery('#template-modal').modal('hide');
    }
}

jQuery(document).ready(function () {
    jQuery("#back").on('click', function(e){
        e.preventDefault();
        window.location.href = url; 
    });

    jQuery('#AplCampanha_dt_p_envio').datetimepicker({
            format: "DD/MM/YYYY HH:mm:ss",
            locale: "pt-br",
            minDate: new Date().getTime(),
    });
    
    jQuery('#criarCampanha').on('click', function (e) {
        e.preventDefault();
        jQuery.ajax({
            method: 'POST',
            url: 'https://app.webcourier.com.br/api/mailmarketing/copy',
            data: jQuery('form').serialize(),
            id: (edit == "true" ? id : undefined)
        }).done(function (response) {
            if (!response.status) {
                jQuery('#divResponseMessageSuccess').hide();
                jQuery('#divResponseMessageError').show();
                jQuery('#responseMessageError').html('');
                for (var attr in response.message) {
                    for (var i = 0; i < response.message[attr].length; i++) {
                        jQuery('#responseMessageError').append("<li>" + response.message[attr][i]) + "</li>";
                    }
                }
            } else {
                jQuery('#divResponseMessageError').hide();
                window.location.href = url;
            }
        });
    });
});
