<?php
defined('ABSPATH') or exit; //if tried to access directly, exit
require_once(WEBCOURIER_PLUGIN_MAIL_DIR . '/views/forwarder.php');
$url = $_SERVER['REQUEST_URI'];
$request = new WebcourierFunctions();
$result = $request->getCampanhasWordpress($api);
$campanhas = $result->campanhas;
?>
<script>
    campanhas = <?= (json_encode($campanhas) != 'null') ? (json_encode($campanhas)) : '{}' ?>;
    api = '<?= $api; ?>';
    url = '<?= $url; ?>'
</script>
<body ng-app="campanha" ng-controller="ControllerCampanha as dt">
    <h2><b>Campanhas</b></h2>

    <div>
        <hr style="border-top: 1px solid #ccc !important"> 
    </div>
    
    <input type="text" name="webcourier_form[name]" ng-model="vm.searchField" value="" 
           spellcheck="true" autocomplete="off" placeholder="Pesquisar..." style="margin-bottom: 15px; width:20%">
    
    <button id="add-campanha" class="btn btn-primary" style="float:right; margin-right: 2em">Nova Campanha</button>

    <!--<h3 style="margin-bottom: 10px;">Lista de Campanhas</h3>-->
    <div ng-app="campanha" ng-controller="ControllerCampanha as dt">
        <table  datatable='' dt-options="dt.dtOptions" dt-columns="dt.dtColumns" dt-defaultoptions="dt.dtDefaultOptions" 
                class="webcourier-table table table-striped table-bordered table-hover"></table>
    </div>
    <div id="spamsin" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">Close</span>
                    </button>
                    <h5 id="ss-start" class="heavier blue text-center">
                        Processando Spamassassin...
                    </h5>
                    <h5 id="ss-end" class="heavier blue text-center">
                        Validação Spamassassin.
                    </h5>
                    <h5 id="ss-error" class="heavier blue text-center">
                        Não foi possível realizar a operação.
                    </h5>
                    <div class="progress progress-striped active">
                        <div class="progress-bar"  role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                        </div>
                    </div>
                </div>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>

    <div id="c-modal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">Close</span>
                    </button>
                    <h5 id="c-hd" class="heavier blue text-center">
                        Aguarde...
                    </h5>
                    <div class="progress progress-striped active">
                        <div class="progress-bar"  role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                        </div>
                    </div>
                    <h5 id="c-suc" class="heavier blue text-center" style="display: none">
                        Sua campanha está sendo gerada.<br /> Daqui alguns instantes aparecerá o relatório de geração de tickets. <br />Enquanto isso navegue pelo nosso sistema a vontade.
                    </h5>
                    <h5 id="c-err" class="heavier red text-center" style="display: none">
                        Não foi possível realizar a operação. <i class="fa fa-meh-o fa-lg fa-fw"></i>
                    </h5>
                    <h5 id="c-alert" class="heavier red text-center" style="display: none">
                        Aguarde enquanto estamos gerando os tickets da campanha anterior. Por favor, tente novamente daqui alguns instantes. <i class="fa fa-meh-o fa-lg fa-fw"></i>
                    </h5>
                    <h5 id="c-alert2" class="heavier red text-center" style="display: none">
                        O filtro utilizado para gerar a campanha não está habilitado para criação de tickets. Por favor, verifiquei seu filtro antes de enviar. <i class="fa fa-meh-o fa-lg fa-fw"></i>
                    </h5>
                    <h5 id="c-alert3" class="heavier red text-center" style="display: none">
                        O filtro utilizado para gerar a campanha não está habilitado para criação de tickets e por esse motivo o envio de teste ficará desabilitado. Por favor, verifique o filtro desta campanha e tente novamente. <i class="fa fa-meh-o fa-lg fa-fw"></i>
                    </h5>
                    <h5 id="c-alert4" class="heavier red text-center" style="display: none">
                        Os tickets desta campanha ainda estão sendo gerados. <br /> Daqui alguns instantes aparecerá o relatório de geração de tickets. <br />Enquanto isso navegue pelo nosso sistema a vontade. <i class="fa fa-meh-o fa-lg fa-fw"></i>
                    </h5>
                </div>
            </div>
        </div>
    </div>
</body>