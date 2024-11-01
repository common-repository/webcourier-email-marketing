<?php
/*
  Plugin Name: Webcourier Email Marketing Plugin
  Plugin URI: https://www.webcourier.com.br/
  Description: Plugin utilizado para adicionar usuários que são cadastrados através do wordpress do cliente
  Author: WebCourier
  Version: 1.2
  Stable tag: 1.2
  Author URI: https://www.webcourier.com.br/
  License: GPLv2
  Domain Path: languages/
  Copyright: © 2016 Webcourier
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

function load_wp_media_files() {
    wp_enqueue_media();
}

add_action('admin_enqueue_scripts', 'load_wp_media_files');

if ((stripos($_SERVER['QUERY_STRING'], 'page=top-level-handle') !== false) ||
        (stripos($_SERVER['QUERY_STRING'], 'page=sub-page-templates') !== false) ||
        (stripos($_SERVER['QUERY_STRING'], 'page=sub-page-campanhas') !== false)) {
    wp_enqueue_style('bootstrap-css', plugins_url('/css/bootstrap.min.css', __FILE__), '', '', false);
    wp_enqueue_style('bootstrap-datatables', plugins_url('/css/dataTables.bootstrap.min.css', __FILE__), '', '', false);
    wp_enqueue_style('bootstrap-datepicker', plugins_url('/css/bootstrap-datepicker.css', __FILE__), '', '', false);
    wp_enqueue_style('bootstrap-datetimepicker', plugins_url('/css/bootstrap-datetimepicker.css', __FILE__), '', '', false);
    wp_enqueue_style('bootstrap-multiselect', plugins_url('/css/bootstrap-multiselect.css', __FILE__), '', '', false);
    wp_enqueue_style('sweetalert', plugins_url('/css/sweetalert.css', __FILE__), '', '', false);
    wp_enqueue_style('main-css-file', plugins_url('/css/styles_mail_marketing.css', __FILE__), '', '', false);
    wp_enqueue_style('summernote', plugins_url('/js/summernote-master/dist/summernote.css', __FILE__), '', '', false);

    wp_enqueue_script('jquery');
    wp_enqueue_script('moment', plugins_url('/js/moment.min.js', __FILE__), '', '', false);
    wp_enqueue_script('moment-with-locales', plugins_url('/js/moment-with-locales.js', __FILE__), '', '', false);
    wp_enqueue_script('bootstrap', plugins_url('/js/bootstrap.min.js', __FILE__), '', '', false);
    wp_enqueue_script('bootstrap-datepicker', plugins_url('/js/bootstrap-datepicker.js', __FILE__), '', '', false);
    wp_enqueue_script('bootstrap-datetimepicker', plugins_url('/js/bootstrap-datetimepicker.min.js', __FILE__), '', '', false);
    wp_enqueue_script('bootstrap-multiselect', plugins_url('/js/bootstrap-multiselect.js', __FILE__), '', '', false);
    wp_enqueue_script('datatables-jquery', plugins_url('/js/jquery.dataTables.min.js', __FILE__), '', '', false);
    wp_enqueue_script('datatables-bootstrap', plugins_url('/js/dataTables.bootstrap.min.js', __FILE__), '', '', false);
    wp_enqueue_script('angular', plugins_url('/js/angular.min.js', __FILE__), '', '', false);
    wp_enqueue_script('datatables-angular', plugins_url('/js/angular-datatables.min.js', __FILE__), '', '', false);
    wp_enqueue_script('sweetalert', plugins_url('/js/sweetalert.min.js', __FILE__), '', '', false);
    wp_enqueue_script('controller_campanha', plugins_url('/js/controller_campanha.js', __FILE__), '', '', false);
    wp_enqueue_script('controller_campanha_add', plugins_url('/js/controller_campanha_add.js', __FILE__), '', '', false);
    wp_enqueue_script('controller_templates', plugins_url('/js/controller_templates.js', __FILE__), '', '', false);
    wp_enqueue_script('template_upload', plugins_url('/js/template_upload.js', __FILE__), '', '', false);
    wp_enqueue_script('summernote', plugins_url('/js/summernote-master/dist/summernote.js', __FILE__), '', '', false);
    wp_enqueue_script('summernote-lang', plugins_url('/js/summernote-master/dist/lang/summernote-pt-BR.js', __FILE__), '', '', false);
}

//path to autoloader
define('WEBCOURIER_PLUGIN_MAIL_DIR', dirname(__FILE__) . '/');

//load autoloader
require_once WEBCOURIER_PLUGIN_MAIL_DIR . '/src/MailLoader.php';

$class_methods = get_class_methods('mailloader');
$loader = new MailLoader();

foreach ($class_methods as $function) {
    call_user_func(array($loader, $function));
}

function checar_campanha() {
    require_once WEBCOURIER_PLUGIN_MAIL_DIR . '/src/WebcourierFunctions.php';
    $request = new WebcourierFunctions();
    $metadata = get_option('webcourier_api_key_mail');
    parse_str($metadata, $data);
    $api = $data['api'];
    $status_api = $data['status'];
    $result = $request->checkCampanha($api);
    $campanha = $result->campanha;
    $filtro = $result->filtro;
    $template = $result->template;
    $numTickets = $result->numTickets;
    $tempo = $result->tempo;
    $status = $result->status;

    if ($status_api && $result && $status == 'ERROR: NONE') {
        ?>
        <div class="notice notice-success is-dismissible">
            <strong>Campanha: </strong><?= $campanha ?><br/>
            <strong>Filtro: </strong><?= $filtro ?><br/>
            <strong>Template: </strong><?= $template ?><br/>
            <strong>Tempo Transcorrido: </strong><?= $tempo ?><br/>
            <strong>Total de tickets gerados: </strong><?= $numTickets ?><br/><br/>
            Campanha gerada com sucesso.
        </div>
        <?php
    } elseif ($status_api && $result && $status && $status != 'ERROR: NONE') {
        ?>
        <div class="notice notice-error is-dismissible">
            <strong>Campanha: </strong><?= $campanha ?><br/>
            <strong>Filtro: </strong><?= $filtro ?><br/>
            <strong>Template: </strong><?= $template ?><br/>
            <?php if ($status == 'ERROR: NO USERS'): ?>
                Não foi possível gerar a campanha.
                Filtro não possui nenhum destinatário.
            <?php elseif ($status == 'ERROR: INSUFFICIENT CREDITS'): ?>
                Não foi possível gerar a campanha.
                Você não possui créditos suficientes para gerar essa campanha.
            <?php else: ?>
                Não foi possível gerar a campanha.
            <?php endif; ?>
        </div>
        <?php
    }
}

add_action('admin_notices', 'checar_campanha');