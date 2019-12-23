<?php

include '../../center/SalizDatabaseManager.php';
$db = new SalizDatabaseManager();

const USER_RESERVE_LIST="USER_RESERVE_LIST";
const CATEGORY="CATEGORY";
const POSTS="POSTS";
const GET_TIMES="GET_TIMES";
const SERVICES="SERVICES";
const GET_BANNERS="GET_BANNERS";

$request = $_GET['request'];


if ( isset( $request ) ) {

	switch ( $request ) {
		case USER_RESERVE_LIST;
			$phone = $_GET['PHONE'];
			$res = $db->getUserReserveList( $phone );
			echo json_encode( [ 'result' => $res ] );
			break;

		case CATEGORY;
			$res = $db->getCategory();
			echo json_encode( [ 'result' => $res ] );
			break;


		case POSTS;
			$res = $db->getPosts();
			echo json_encode( [ 'result' => $res ] );
			break;

		case GET_TIMES;
			$day   = $_GET['DAY'];
			$res = $db->getTimes( $day );
			echo json_encode( [ 'result' => $res ] );
			break;

		case SERVICES;
			$res = $db->getServices();
			echo json_encode( [ 'result' => $res ] );

			break;

			case GET_BANNERS;
			$res = $db->get_banner_admin();
			echo json_encode( [ 'result' => $res ] );

			break;
	}



} else {
	echo " Parameters : </br> </br> </br> ";
	echo "[ request ] ? { USER_RESERVE_LIST  }";
	echo "</br> </br>";
}


