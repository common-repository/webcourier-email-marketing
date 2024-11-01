<?php
$request = new WebcourierFunctions();
$result = $request->getTemplates($api);
$templates = $result->templates;
$url = $_SERVER['REQUEST_URI'];
?>

<script>
    templates = <?= (json_encode($templates) != 'null') ? (json_encode($templates)) : '{}' ?>;
    api = '<?= $api; ?>';
    url = '<?= $url; ?>'
    function changeHeight(iframe)
    {
        var formulaHeight = (((window.innerHeight/2)-400)*2);
        var height = formulaHeight < 100 ? 100 : formulaHeight;    
        iframe.parentElement.parentElement.style.marginTop = height + 'px';
        jQuery('iframe').parents().eq(3).find('h5').css("margin-top", height-40);
        jQuery('iframe').parents().eq(3).find('a').css("margin-top", height-40);
    }
</script>
<body>
    <h2><b>Templates</b></h2>

    <div>
        <hr style="border-top: 1px solid #ccc !important"> 
    </div>

    <div class="panel panel-default">
        <div class="panel-heading" style="font-size:17px">Lista de Templates
            <a href="#choose-modal" data-toggle="modal" class="btn btn-primary pull-right" style="line-height: 10px">Novo Template</a>
        </div>
        <div class="panel-body" ng-app="templates" ng-controller="ControllerTemplates as ct">
                <div class="col-md-3" ng-repeat="x in ct.angularTemplates">
                    <div class="darken" ng-show="ct.isInPage($index)">
                        <div class="row">
                            <h4 class="template-name">{{x.nome}}</h4>
                        </div>
                        <div class="line">
                            <a class="left-padding" title="Visualizar"><i id="template-search" class="dashicons dashicons-search template-search"></i></a>
                            <a class="left-padding" title="Editar"><i data-id="{{x.template_idx}}" class="dashicons dashicons-edit template-edit"></i></a>
                            <a class="left-padding" title="Deletar"><i data-id="{{x.template_idx}}" class="dashicons dashicons-trash template-delete"></i></a>
                        </div>
                        <img class="img_suc" ng-src="https://app.webcourier.com.br/templates/{{x.pasta}}/thumb.png">
                    </div>
                </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="top-margin">
                        <button class="btn btn-primary" ng-disabled="ct.currentPage == 0" ng-click="ct.nextPage(false)">Anterior</button>
                        {{ct.currentPage + 1}}/{{ct.numberOfPages()}}
                        <button class="btn btn-primary pull" ng-disabled="ct.currentPage + 1 == ct.numberOfPages()" ng-click="ct.nextPage(true)">Próximo</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="choose-modal" class="modal fade">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">Close</span>
                    </button>
                    <h5 class="heavier blue text-center">
                        Escolha como prosseguir
                    </h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <button class="btn btn-primary col-lg-12 template-choose" data-toggle="popover" title="Saiba mais"  data-content="- Crie seu próprio código html<br /> - Faça upload de imagem<br /> - Tamanho máximo de upload de 100KB<br />- Mais informações ao final da tela" data-tipo="0"  data-placement="left" data-trigger="hover" data-html="true">
                            Escrever seu código <i class="fa fa-code fa-fw"></i>
                        </button>
                    </div>
                    <div class="space-4"></div>
                    <div class="row">
                        <button class="btn btn-primary col-lg-12 template-choose" data-tipo="1" data-toggle="popover" title="Saiba mais"  data-content="- Faça upload de seu template<br />- Template em formato html<br />- Apenas arquivos zipados serão aceitos<br />- Extensão permitida: .zip<br /> - Tamanho máximo permitido de 1MB<br />- Mais informações ao final da tela" data-tipo="0"  data-placement="left" data-trigger="hover" data-html="true">
                            Importar de um arquivo <i class="fa fa-file fa-fw"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="iframe-modal" class="modal fade">
        <div class="modal-menu">
            <a class="close" data-dismiss="modal">&times;</a>
            <h5 class="heavier white text-center"></h5>
        </div>
        <div class="modal-background"></div>
        <div class="modal-dialog">
            <div class="modal-content">
                <div id="iframe-content" class="modal-body">
                    <iframe id="my-iframe" name="my-iframe" frameborder="0" onload="js:changeHeight(this);" seamless></iframe>
                </div>
            </div>
        </div>
    </div>
</body>