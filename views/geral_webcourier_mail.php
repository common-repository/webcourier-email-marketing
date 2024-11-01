<?php
defined('ABSPATH') or exit;
if (!class_exists('WP_Http')) {
    include_once( ABSPATH . WPINC . '/class-http.php' );
}
$requestGroup = new WebcourierFunctions();
$request = new WP_Http;
$connected = false;
$true = false;
$headers = array('Accept-Language' => '*');
$url = 'https://app.webcourier.com.br/api/apicheck/checkapi?tipo=2&api=##api##';
$api = urlencode($_POST['api_key']);

if ($api != '') {
    $url = str_replace('##api##', $api, $url);
    $result = $request->request($url, array('headers' => $headers));
    $response = json_decode($result['body']);
}

if (isset($result['response']) && $result['response']['message'] == 'OK') {
    $true = true;
    $connected = $response->status;
    $connected ? $status = 1 : $status = 0;
    $api = $response->api;
    $groupFull = [];
    $groupSubscriber = [];
    $users = get_users();
    $reg = '/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD';
    if (!empty($users)) {
        foreach ($users as $user) {
            if (preg_match($reg, $user->data->user_email))
                array_push($groupFull, $user->data);
        }
    }
    $usersSubscribers = get_users(['role' => 'subscriber']);
    if (!empty($usersSubscribers)) {
        foreach ($userSubscribers as $user) {
            if (preg_match($reg, $user->data->user_email))
                array_push($groupSubscriber, $user->data);
        }
    }
    global $wpdb;
    $query = "select
    max( CASE WHEN pm.meta_key = '_billing_email' and p.ID = pm.post_id THEN pm.meta_value END ) as user_email,
    max( CASE WHEN pm.meta_key = '_billing_first_name' and p.ID = pm.post_id THEN pm.meta_value END ) as display_name
from
    {$wpdb->prefix}posts as p,
    {$wpdb->prefix}postmeta as pm
where
    post_type = 'shop_order' and
    p.ID = pm.post_id and
    post_status = 'wc-completed'
group by
p.ID;";
    $groupCustomers = $wpdb->get_results($query);
    $resultGroup = $requestGroup->createWordpressGroups($api, $groupFull, $groupSubscriber, $groupCustomers);
}

if($_POST['submit'] == "Atualizar grupos"){
    $groupFull = [];
    $groupSubscriber = [];
    $users = get_users();
    $reg = '/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD';
    if (!empty($users)) {
        foreach ($users as $user) {
            if (preg_match($reg, $user->data->user_email))
                array_push($groupFull, $user->data);
        }
    }
    $usersSubscribers = get_users(['role' => 'subscriber']);
    if (!empty($usersSubscribers)) {
        foreach ($userSubscribers as $user) {
            if (preg_match($reg, $user->data->user_email))
                array_push($groupSubscriber, $user->data);
        }
    }
    global $wpdb;
    $query = "select
    max( CASE WHEN pm.meta_key = '_billing_email' and p.ID = pm.post_id THEN pm.meta_value END ) as user_email,
    max( CASE WHEN pm.meta_key = '_billing_first_name' and p.ID = pm.post_id THEN pm.meta_value END ) as display_name
from
    {$wpdb->prefix}posts as p,
    {$wpdb->prefix}postmeta as pm
where
    post_type = 'shop_order' and
    p.ID = pm.post_id and
    post_status = 'wc-completed'
group by
p.ID;";
    $groupCustomers = $wpdb->get_results($query);
    $resultGroup = $requestGroup->createWordpressGroups($api, $groupFull, $groupSubscriber, $groupCustomers);
}

$keyExists = get_option('webcourier_api_key_mail');

if (empty($keyExists) && $true) {
    $user_user = ["api" => $api, "status" => $status];
    add_option('webcourier_api_key_mail', http_build_query($user_user));
} else if ($true) {
    parse_str($keyExists, $user_user);
    $user_user['api'] = $api;
    $user_user['status'] = $status;
    update_option('webcourier_api_key_mail', http_build_query($user_user));
} else if (!empty($keyExists)) {
    parse_str($keyExists, $user_user);
    $api = $user_user['api'];
    $status = $user_user['status'];
}
?>
<div id="webcourier-admin" class="webcourier-settings">

    <div class="row">
        <div class="col-md-12">

            <h2><b>Configurações Gerais</b></h2>
            <hr style="border-top: 1px solid #ccc !important"> 

            <h2 style="display: none;"></h2>
            <?php settings_errors(); ?>

            <form method="post">

                <h4> Configurações API Key WebCourier </h4>

                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">
                            Status
                        </th>
                        <td>
                            <?php if ($status == 1) { ?>
                                <span class="status positive">CONECTADO</span>
                            <?php } else { ?>
                                <span class="status negative">NÃO CONECTADO</span>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">
                            Chave API
                        </th>
                        <td>
                            <input type="text" name='api_key' class="widefat" placeholder="Sua chave API" id="webcourier-api-key" value="<?php echo $api ?>">
                            <p class="help">
                                A chave API para se conectar com a sua conta no WebCourier
                                <a target="_blank" href="https://app.webcourier.com.br/admlogin/index">Pegue sua chave API aqui.</a>
                            </p>
                        </td>
                    </tr>

                </table>
                <div style="float:left; margin-right: 15px">
                    <?php submit_button('Salvar alterações'); ?>
                </div>
                <div style="float:left">
                    <?php submit_button('Atualizar grupos'); ?>
                </div>

            </form>
                
        </div>
    </div>
</div>
<script>
    (function($) {
        $(document).ready(function() {
            $('#save').on('click', function() {
                
            });
        })
    })(jQuery);
</script>
