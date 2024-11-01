angular.module('templates', ['datatables']).controller('ControllerTemplates', DataTables)

function DataTables(DTOptionsBuilder, DTColumnBuilder, DTDefaultOptions, $q) {
    var ct = this;
    var templateIds = Object.keys(templates);
    ct.templateSize = templateIds.length;

    ct.angularTemplates = templates;
    ct.currentPage = 0;
    ct.pageSize = 8;
    
    ct.numberOfPages = function () {
        return Math.ceil(templateIds.length / ct.pageSize);
    }
    ct.nextPage = function (state) {
        state ? ct.currentPage++ : ct.currentPage--;
    }
    ct.isInPage = function (idx) {
        return (idx >= ct.currentPage * ct.pageSize && (idx < (ct.currentPage * ct.pageSize) + ct.pageSize));
    }
}

jQuery(document).ready(function(){
    jQuery('[data-toggle="popover"]').popover();
    
    jQuery('.template-search').on('click', function(e){
        e.preventDefault();
        jQuery('#iframe-modal h5').text(jQuery(this).closest('.darken').find('h4').text());
        jQuery('#my-iframe').attr('src', jQuery(this).closest('.darken').find('img').attr('src'));
        jQuery('#iframe-modal').modal({
            backdrop: false,
            keyboard: false
        });
    });
    
    jQuery('#iframe-modal .close').on('click', function() {
        
    });
    
    jQuery('.template-edit').on('click', function(){
       var id = jQuery(this).data('id');
       if(id){
           jQuery('#choose-modal').modal('show');
           jQuery('#choose-modal').attr('data-id',id);
       } else {
           jQuery('#choose-modal').modal('show');
       }
    });
    
    jQuery('.template-choose').on('click',function(){
        var id = jQuery('#choose-modal').data('id')
        if(jQuery(this).data('tipo') == "1"){
            window.location.href = (url + '&tipo=1') + (id ? '&id=' + id : '');
        } else {
            window.location.href = (url + '&tipo=0') + (id ? '&id=' + id : '');
        }
    });
        
    jQuery('.template-delete').on('click', function(e){
        var elem = this;
        swal({
                    title: "Tem certeza?",
                    text: "Você não poderá recuperar seu template",
                    type: "warning",
                    showCancelButton: true,
                    cancelButtonText: 'Cancelar',
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Sim, deletar!",
                    closeOnConfirm: false
                }, function () {
                    jQuery.ajax({
                        'method': 'POST',
                        'url': 'https://app.webcourier.com.br/api/mailmarketing/deletetemplate',
                        'data': {id: jQuery(elem).data('id'), api: api},
                        'dataType': 'JSON'
                    }).done(function (response) {
                        if (response.status == 'success') {
                            swal("Removido!", "Seu template foi removido com sucesso.", "success");
                        }
                        location.reload();
                    })
                });
    });
    
    jQuery('.dashicons-search').on('click', function(){
        
    });
    
})