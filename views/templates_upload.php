<?php
$currenturl = $_SERVER['REQUEST_URI'];
$url = explode('&tipo', $currenturl);
$url = $url[0];
?>
<script>
    var api = '<?= $api ?>';
    var id = '<?= $id ? $id : '0'; ?>';
    var url = '<?= $url ? $url : '' ?>';
</script>
<h2><b>Templates</b></h2>

<div>
    <hr style="border-top: 1px solid #ccc !important"> 
</div>

<div class="panel panel-default">
    <div class="panel-heading" style="font-size:17px"><?= $id ? "Editar Template" : "Adicionar Template" ?></div>
    <div class="panel-body">
        <div class="row" id="resposta-erro" style="display:none">
            <div class="col-md-12 info-msg-template-upload">
                <ul style="color:red"><b>Favor corrija os seguintes erros : </b></ul>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 form-group" style="margin: 0 auto; float:none">
                <label class="control-label" required>Nome</label>
                <input id="template-nome" class="form-control" type="text" value="<?= $id ? $template->template->nome : '' ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 form-group" style="margin: 20px auto 0 auto; float:none;">
                <label class="control-label" style="width: 100%" required>Escolha o arquivo</label>
                <div style="width: 25%; float:left">
                    <button id="upload-btn" class="btn btn-primary form-control"><strong>Upload</strong></button>
                </div>
                <div id="template-uploaded-div" class="template-upload"></div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row" style="margin: 0">
        <div class="col-md-12">
            <div class="alert alert-info">
                <ul class="info-msg-template-upload">
                    <li>
                        O nome da pasta de imagens é justamente a pasta onde foram colocadas todas as imagens do seu e-mail
                    </li>
                    <br/>
                    <li>                          
                        Obrigatoriamente esta pasta de imagens deverá estar localizada dentro do seu arquivo zipado ou .zip
                    </li>
                    <br/>
                    <li>                          
                        O arquivo .html deve ser renomeado para index.html (Auxilia o sistema a encontrar o arquivo que você deseja enviar como corpo do seu e-mail) 
                    </li>
                    <br/>
                    <li>                          
                        Caso você tenha interesse de ultilizar este template para algum boletim, você terá a opção de inserir tags que na hora do envio do e-mail serão substituídas com o nome e/ou conteúdo do boletim
                    </li>
                    <br/>
                    <li>                          
                        As tags mencionadas acima são "nome" e "conteudo", ambas deverão aparecer no arquivo .html da seguinte maneira: {nome}
                    </li>
                    <br/>
                    <li>                          
                        Lembrando que o tamanho máximo permitido pelo nosso sistema para o arquivo .zip é de 1MB.
                    </li>
                    <br/>
                    <li>                          
                        Importante ressaltar que os nomes das imagens não devem conter caracteres especiais ou acentos, pois dificulta o envio e favorece a inclusão da mensagem para a pasta Spam.
                    </li>
                    <br/>
                    <li>                          
                        Segue ao lado um exemplo simples de um arquivo .html utilizando tags: <a data-target="#template-modal" data-toggle="modal" style="cursor: pointer">Exemplo de um template utilizando tags</a>
                    </li>
                </ul>
            </div>
        </div>
        <div>
            <div class="col-md-12">
                <button id="back" class="btn btn-warning pull-left" style="margin: 0 0 10px 0; width: 7%">Voltar</button>
                <button id="submit-btn-file" class="btn btn-primary pull-right" style="margin: 0 0 10px 0; width: 7%">Criar</button>
            </div>
        </div>
    </div>
</div>
<script>
</script>
