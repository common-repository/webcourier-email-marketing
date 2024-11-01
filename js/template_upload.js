var template_file = '';

jQuery(document).ready(function ($) {
    $('#upload-btn').click(function (e) {
        e.preventDefault();
        var template = wp.media({
            title: 'Upload Template',
            // mutiple: true if you want to upload multiple files at once
            multiple: false
        }).open()
                .on('select', function (e) {
                    // This will return the selected image from the Media Uploader, the result is an object
                    var uploaded_template = template.state().get('selection').first();
                    // We convert uploaded_image to a JSON object to make accessing it easier
                    // Output to the console uploaded_image
                    var template_filename = uploaded_template.toJSON().filename;
                    var template_url = uploaded_template.toJSON().url;
                    // Let's assign the url value to the input field
                    $('#template-uploaded-div').css("display", "block");
                    $('#template-uploaded-div').html('<i class="dashicons dashicons-media-default"></i> ' + template_filename);
                    // Create the var to send to webcourier
                    template_file = {
                        name: template_filename,
                        file: template_url,
                    };
                });
    });
    $('#submit-btn-file').on('click', function(e){
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'https://app.webcourier.com.br/api/mailmarketing/' + (id != "0" ? 'updatetemplate' : 'createtemplate'),
            data: {
                "AplTemplate[nome]" : jQuery('#template-nome').val(),
                "AplTemplate[file]": template_file.file,
                "AplTemplate[arquivo]" : template_file.name,
                "tipo": 1,
                "api": api,
                "id" : id != "0" ? id : undefined
            }
        }).done(function (response) {
            if(response.status == "Sucesso"){
                window.location.href = url;
            } else {
                for (var erro in response.erro) {
                        jQuery('#resposta-erro ul').append("<li style='color:red'>" + response.erro[erro] + "</li>");
                    }
                    jQuery('#resposta-erro').show();
            }
        });
    });
    $('#back').on('click', function(e){
        e.preventDefault();
        window.location.href = url;
    });
});
