<?php

include '../../center/SalizDatabaseManager.php';

header('Content-Type: application/json');

$db = new SalizDatabaseManager();

$request = $_GET['request'];
$token = $_GET['TOKEN'];

$url = $_GET['URL'];
$position = $_GET['POSITION'];
$id = $_GET['ID'];
$timeID = $_GET['TIME_ID'];
$status = $_GET['STATUS'];

$hour = $_GET['HOUR'];
$reserved = $_GET['RESERVED'];
$day_of_week = $_GET['DAY_OF_WEEK'];
$username = $_GET['username'];
$user_level = $_GET['level'];

//GET
const GET_ORDERS = "GET_ORDERS";
const GET_TIMES = "GET_TIMES";
const GET_BANNERS = "GET_BANNERS";
const GET_USERS = "GET_USERS";

//ADD
const ADD_BANNER = "ADD_BANNER";
const ADD_TIME = "ADD_TIME";

//EDIT
const EDIT_BANNER = "EDIT_BANNER";
const EDIT_ORDER = "EDIT_ORDER";
const EDIT_TIME = "EDIT_TIME";
const EDIT_USER_LEVEL = "EDIT_USER_LEVEL";

//DELETE
const DELETE_BANNER = "DELETE_BANNER";
const DELETE_TIME = "DELETE_TIME";


if (isset($request) && isset($token)) {

    if ($token == $TOKEN) {

        switch ($request) {


            case GET_ORDERS:
                $res = $db->get_orders_admin();
                echo json_encode(['result' => $res]);
                break;

            case GET_TIMES:
                $res = $db->get_times_admin();
                echo json_encode($res);
                break;

            case GET_BANNERS:
                $res = $db->get_banner_admin();
                echo json_encode(['result' => $res]);
                break;


            case ADD_BANNER:
                if (isset($url) ) {
                    $res = $db->add_banner_admin($url);
                    echo json_encode(['result' => $res]);
                } else {
                    echo "[url]  is missing";
                }
                break;

            case EDIT_ORDER:
                if (isset($id) && isset($timeID) && isset($status)) {
                    $res = $db->edit_order_admin($id, $timeID, $status);
                    echo json_encode(['result' => $res]);

                } else {
                    echo "[id] OR [confirm] OR [timeID] is missing";
                }
                break;

            case EDIT_TIME:
                if (isset($id) && isset($hour) && isset($reserved)) {
                    $res = $db->edit_time_admin($id, $hour, $reserved);
                    echo json_encode(['result' => $res]);

                } else {
                    echo "[id] OR [hour] OR [reserved] is missing";
                }
                break;

            case ADD_TIME:
                if (isset($day_of_week) && isset($hour)) {
                    $res = $db->add_time_admin($day_of_week, $hour);
                    echo json_encode(['result' => $res]);

                } else {
                    echo "[day_of_week] OR [hour] is missing";
                }
                break;

            case DELETE_TIME:
                if (isset($id)) {
                    $res = $db->delete_time($id);
                    echo json_encode(['result' => $res]);

                } else {
                    echo "[ID] is missing";
                }
                break;

            case DELETE_BANNER:
                if (isset($id)) {
                    $res = $db->delete_banner($id);
                    echo json_encode(['result' => $res]);

                } else {
                    echo "[ID] is missing";
                }
                break;

            case GET_USERS:

                $res = $db->getUsers();
                echo json_encode(['result' => $res]);

                break;

                case EDIT_USER_LEVEL:
                    if (isset($id) && isset($user_level)){
                        $res = $db->edit_user_level($id,$user_level);
                        echo json_encode(['result' => $res]);
                    }else {
                        echo "[id] OR [user_level] is missing";
                    }


                break;

            default:
                echo "check [request] parameter";
        }

    } else {
        echo "TOKEN DON,T MATCH";
    }


} else {
    echo " Parameters : </br> </br> </br> ";
    echo "[ request ] ? { ORDERS , TIMES , BANNERS}";
    echo "</br> </br>";
    echo "[ TOKEN ] ? ( put token here )";
    echo "</br> </br>";

}


