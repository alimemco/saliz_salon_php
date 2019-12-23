<?php
/**
 * Created by PhpStorm.
 * User: Ali
 * Date: 12/8/2019
 * Time: 12:08 PM
 */

require '../../api/sms/vendor/autoload.php';
header('Content-Type: application/json');

$TOKEN = $_GET['TOKEN'];

$sender = "1000596446";

$receptor_admin = "09169501905";
$message_admin = $_GET['message_admin'];

$receptor_client = $_GET['receptor_client'];
$message_client = $_GET['message_client'];

$result = array();
$success = false;

$api = new Kavenegar\KavenegarApi("4D6866464C59417A6179766958365457484672704C6A39336352674D4F4E47507639365A793949394670303D");

if (isset($receptor_admin) && isset($message_admin)) {

    $api->Send($sender, $receptor_admin, $message_admin);
    $success = true;

}
if (isset($receptor_client) && isset($message_client)) {
    $api->Send($sender, $receptor_client, $message_client);
    $success = true;
}

$result = [
    "success" => $success
];

echo json_encode($result);

