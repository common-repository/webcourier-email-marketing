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
            <div class="col-md-6 form-group">
                <label class="control-label" required>Nome</label>
                <input id="template-nome" class="form-control" type="text" value="<?= $id ? $template->template->nome : '' ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 form-group">
                <label class="control-label" required>Conteúdo</label>
                <div id="summernote-editor" name="AplTemplate_conteudo"><?= $id ? $template->template->conteudo : '' ?></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 form-group">
                <label class="control-label" required>Conteúdo Texto</label>
                <input type="text" class="form-control" value="<?= $id ? $template->template->conteudotxt : '' ?>">
            </div>
        </div>
    </div>
    <div class="row" style="margin: 0">
        <div class="col-md-12">
            <div class="alert alert-info">
                <ul class="info-msg-template-upload">
                    <li>
                        Seguem abaixo algumas tags que podem ser atribuídas ao boletim como forma de adicionar informações de cada destinatário contido em seu filtro no momento do envio da campanha.<br />
                        <table>
                            <tr><td><b>Tags</b></td><td><b>Descrição</b></td></tr>    
                            <tr><td>{segundonome}</td><td>Segundo Nome</td></tr>    
                            <tr><td>{primeironome}</td><td>Primeiro Nome</td></tr>    
                            <tr><td>{nomecompleto}</td><td>Nome Completo</td></tr>    
                            <tr><td>{idade}</td><td>Idade</td></tr>    
                            <tr><td>{email}</td><td>E-mail</td></tr>    
                            <tr><td>{datanascimento}&nbsp;&nbsp;&nbsp;</td><td>Data Nascimento</td></tr>    
                        </table>    
                    </li>
                    <br/>
                    <li>                          
                        O tamanho máximo permitido para fazer o upload de imagens é de 100KB por imagem.
                    </li>
                    <br/>
                    <li>                          
                        Importante ressaltar que o nome das imagens não devem conter caracteres especiais ou acentos, pois dificulta o envio e favorece a inclusão da mensagem para a pasta Spam.
                    </li>
                    <br/>
                </ul>
            </div>
        </div>
        <div>
            <div class="col-md-12">
                <button id="back" class="btn btn-warning pull-left" style="margin: 0 0 10px 0; width: 7%">Voltar</button>
                <button id="submit-btn-code" class="btn btn-primary pull-right" style="margin: 0 0 10px 0; width: 7%"><?= $id ? "Editar" : "Criar" ?></button>
            </div>
        </div>
    </div>
</div>
<script>
    var flag = true;
    jQuery(document).ready(function ($) {
        $('#summernote-editor').summernote({
            height: 300,
            lang: 'pt-BR'
        });
        $('.btn-sm[data-original-title="Imagem"]').unbind('click');
        $('.btn-sm[data-original-title="Imagem"]').on('click', function (e) {
            var imagem = wp.media({
                title: 'Upload Imagem',
                // mutiple: true if you want to upload multiple files at once
                multiple: false
            }).open()
                    .on('select', function (e) {
                        // This will return the selected image from the Media Uploader, the result is an object
                        var uploaded_imagem = imagem.state().get('selection').first();
                        // We convert uploaded_image to a JSON object to make accessing it easier
                        // Output to the console uploaded_image
                        var imagem_filename = uploaded_imagem.toJSON().filename;
                        var imagem_url = uploaded_imagem.toJSON().url;
                        // Let's assign the url value to the input field
                        $('#summernote-editor').summernote('insertImage', imagem_url, imagem_filename);
                        // Create the var to send to webcourier
                    });
        });
        $('.btn-fullscreen').attr('data-original-title', "Expandir");
        $('.btn-fullscreen').unbind('click');
        $('.btn-fullscreen').on('click', function () {
            var height = $('.note-editable').height();
            flag ? $('.note-editable').height(height + 400) : $('.note-editable').height(height - 400);
            flag = !flag;
        });
        $('#submit-btn-code').on('click', function (e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: 'https://app.webcourier.com.br/api/mailmarketing/' + (id != "0" ? 'updatetemplate' : 'createtemplate'),
                data: {
                    "AplTemplate[nome]": $('#template-nome').val(),
                    "AplTemplate[conteudo]": $('#summernote-editor').summernote('code'),
                    "tipo": 0,
                    "api": api,
                    "id": id != "0" ? id : undefined
                }
            }).done(function (response) {
                if (response.status == "Sucesso") {
                    window.location.href = url;
                } else {
                    for (var erro in response.erro) {
                        jQuery('#resposta-erro ul').append("<li style='color:red'>" + response.erro[erro] + "</li>");
                    }
                    jQuery('#resposta-erro').show();
                }
            });
        });
        $('#back').on('click', function (e) {
            e.preventDefault();
            window.location.href = url;
        });
    });

</script>