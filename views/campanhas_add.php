<?php
$currenturl = $_SERVER['REQUEST_URI'];
$url = explode('&add', $currenturl);
$url = $url[0];
?>
<script>
    var templates = <?= json_encode($templates); ?>;
    var campanha = <?= json_encode($campanha); ?>;
    var edit = '<?= $edit ? 'true' : ''; ?>';
    var add = '<?= $add ? 'true' : ''; ?>';
    var id = <?= $add ? 0 : $id; ?>;
    var url = '<?= $url ? $url : '' ?>';
</script>
<body>
    <h2><b>Campanhas</b></h2>
    
    <div>
        <hr style="border-top: 1px solid #ccc !important"> 
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div ng-app="campanhaAdd" ng-controller="campanhaAddTemplates as cat">
                <div class="panel panel-default">
                    <div class="panel-heading" style="font-size:17px">Nova Campanha</div>
                    <div class="panel-body">
                        <div id="divResponseMessageError" class="col-md-10 row alert alert-danger" style="display:none; margin-left: 0">
                            <h4>Por favor, corrija os seguintes erros :</h4>
                            <ul id="responseMessageError"></ul>
                        </div>
                        <form name="AplCampanha">
                            <div class="row">
                                <div class="form-group col-md-5">
                                    <label for="inputNome" class="control-label">Nome</label>
                                    <input name="AplCampanha[nome]" type="inputNome" class="form-control" value="<?= !$add ? $campanha->nome : ''; ?>" required>
                                </div>
                                <div class="form-group col-md-5">
                                    <label for="inputFiltro" class="control-label">Grupos</label>
                                    <select name="AplCampanha[filtro_idx]" class="form-control" required>
                                        <option value="<?= $filtros_ids[0] ?>">Grupo Completo</option>
                                        <option value="<?= $filtros_ids[1] ?>">Grupo Inscritos</option>
                                        <option value="<?= $filtros_ids[2] ?>">Grupo WooCommerce</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-5">
                                    <label for="inputNomeRemetente" class="control-label">Nome Remetente</label>
                                    <input name="AplCampanha[nome_sender]" type="inputNomeRemetente" class="form-control" value="<?= !$add ? $campanha->nome_sender : ''; ?>" required>
                                </div>
                                <div class="form-group col-md-5">
                                    <label for="inputEmail" class="control-label">Email remetente</label>
                                    <input name="AplCampanha[email_sender]" type="inputEmail" class="form-control" value="<?= !$add ? $campanha->email_sender : '' ?>" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-5">
                                    <label for="inputData" class="control-label">Data Prevista Envio</label>
                                    <input id="AplCampanha_dt_p_envio" name="AplCampanha[dt_p_envio]" type="inputData" class="form-control" value="<?= !$add ? date('dd/mm/yyyy H:i:s') : '' ?>" required>
                                </div>
                                <div class="form-group col-md-5">
                                    <button type="button" id="template-choose" data-toggle="modal" data-target="#template-modal" class="btn btn-xs btn-primary pull-right">Escolher</button>
                                    <label for="inputTemplate" class="control-label">Template</label>
                                    <div class="col-md-12 myinput">
                                        <div id="template-img">Escolha um template</div>
                                    </div>
                                    <!--<input type="inputTemplate" class="form-control" ng-model="cat.templateValue" required>-->
                                    <input name="AplCampanha[item_envio_idx]" type="hidden" ng-value="cat.templateId">
                                </div>
                            </div>
                            <hr style="border-top: 1px solid #ccc !important"> 
                            <div class="row">
                                <div class="col-md-12">
                                    <a id="back" class="btn btn-danger pull-left col-md-1" href="<?= $url ?>">Voltar</a>
                                    <button class="btn btn-primary pull-right col-md-1" type="submit" id="criarCampanha">Salvar</button>
                                </div>
                            </div>
                            <input name="AplCampanha[data_cadastro]" type="hidden" value="<?= date('Y-m-d H:i:s') ?>">
                            <input name="AplCampanha[cliente_idx]" type="hidden" value="<?= $cliente_idx->cliente_idx ?>">
                            <input name="api" type="hidden" value="<?= $api ?>">
                            <?php if ($edit): ?>
                                <input name="id" type="hidden" value="<?= $id ?>">
                            <?php endif; ?>
                            <?php //if($campanha):?>
                            <?php //endif; ?>
                        </form>
                        </div>
                    </div>

                <div id="template-modal" class="modal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header" style="text-align: center; color: #5D8BB4">
                                Escolha um Template
                                <button type="button" class="close" data-dismiss="modal">
                                    <span aria-hidden="true">×</span>
                                    <span class="sr-only">Close</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-3" ng-repeat="x in cat.angularTemplates">
                                        <a ng-show="cat.isInPage($index)" style="cursor:pointer;">
                                            <img class="img_suc_c" ng-click="cat.setTemplateValue(x.pasta)" style="width:100%; height: auto" ng-src="http://app.webcourier.com.br/templates/{{x.pasta}}/thumb.png">
                                        </a>
                                    </div>
                                </div>
                                <button class="btn btn-primary" ng-disabled="cat.currentPage == 0" ng-click="cat.nextPage(false)">Anterior</button>
                                {{cat.currentPage + 1}}/{{cat.numberOfPages()}}
                                <button class="btn btn-primary" ng-disabled="cat.currentPage + 1 == cat.numberOfPages()" ng-click="cat.nextPage(true)">Próximo</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
