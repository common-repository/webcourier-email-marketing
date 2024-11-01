<?php

require_once(WEBCOURIER_PLUGIN_MAIL_DIR . '/src/WebcourierFunctions.php');
$cliente_idx = new WebcourierFunctions();
$meta_data = get_option('webcourier_api_key_mail');
parse_str($meta_data, $result);
$api = $result['api'];
$status = $result['status'];
$cliente_idx = $cliente_idx->getClienteIdx($api);
$request = new WebcourierFunctions();

if (!$status) {
    include_once(WEBCOURIER_PLUGIN_MAIL_DIR . '/views/error.php');
    die();
}

if (isset($_GET['copy']) || isset($_GET['edit']) || isset($_GET['add'])) {
    if (isset($_GET['copy']))
        $id = $_GET['copy'];
    if (isset($_GET['edit'])) {
        $id = $_GET['edit'];
        $edit = true;
    }
    if (isset($_GET['add'])) {
        $add = true;
    }
    $response = $request->getCampanhaById($api, $id);
    $campanha = $response->campanha;
    $filtros_ids = $response->filtros_ids;
    $templates = $response->templates;
    include_once(WEBCOURIER_PLUGIN_MAIL_DIR . '/views/campanhas_add.php');
    die();
}

if(isset($_GET['tipo'])){
    $tipo = $_GET['tipo'];
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $template = $request->getTemplateById($api, $id, $tipo);
    }
    if(!$tipo){
        $controller = 3;
    } else {
        $controller = 2;
    }
}