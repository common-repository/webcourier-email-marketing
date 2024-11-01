<?php
defined('ABSPATH') or exit; //if tried to access directly, exit
$controller = 1;
require_once(WEBCOURIER_PLUGIN_MAIL_DIR . '/views/forwarder.php');
if($controller == 1){
    include_once(WEBCOURIER_PLUGIN_MAIL_DIR . '/views/templates_list.php');
} else if ($controller == 2){
    include_once(WEBCOURIER_PLUGIN_MAIL_DIR . '/views/templates_upload.php');
} else if ($controller == 3){
    include_once(WEBCOURIER_PLUGIN_MAIL_DIR . '/views/templates_code.php');
}
?>