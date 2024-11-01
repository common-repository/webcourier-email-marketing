<?php
defined('ABSPATH') or exit;
?>

<h2><b>Configurações</b></h2>

<div>
    <hr style="border-top: 1px solid #ccc !important"> 
</div>
<?php 
    $meta_data = get_option('webcourier_api_key_mail');
    parse_str($meta_data, $result);
    $apiz = $result['api'];
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
        foreach ($usersSubscribers as $user) {
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
    $requester = new WebcourierFunctions();
?>
<script>
    jQuery('#update-users').on('click', function(e){
       e.preventDefault();
       jQuery.ajax({
           'url': 
       }).done(function(response){
           console.log(response);
       }).fail(function(){
           console.log(arguments);
       })
    });
</script>