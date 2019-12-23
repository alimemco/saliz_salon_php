<?php

include '../../center/SalizDatabaseManager.php';
header('Content-Type: application/json');

$db = new SalizDatabaseManager();

$request = $_GET['request'];

define("REGISTER","REGISTER");
define("LOGIN","LOGIN");
define("EDIT","EDIT");
define("CHECK_ADMIN","CHECK_ADMIN");
if ( isset( $request ) ) {

	$first_name = $_GET['FIRST_NAME'];
	$last_name  = $_GET['LAST_NAME'];
	$phone      = $_GET['PHONE'];
	$new_phone      = $_GET['NEW_PHONE'];
	$password   = $_GET['PASSWORD'];


	if ( $request == REGISTER ) {
		$res = $db->register( $first_name, $last_name, $phone, $password );
		echo json_encode( ['result' => $res] );

	} else if ( $request == LOGIN ) {
		$res = $db->login( $phone, $password );
		echo json_encode( ['result' => $res] );

	} else if ( $request == EDIT ) {

		if ( isset( $phone ) ) {
			$res = $db->editUser( $first_name, $last_name, $phone,$new_phone ,  $password );
			echo json_encode( ['result' => $res] );
		} else {
			echo "[phone] parameter is null";
		}

	}else if ( $request == CHECK_ADMIN ) {

		if ( isset( $phone ) ) {
			$res = $db->checkAdmin( $phone);
			echo json_encode( ['result' => $res] );
		} else {
			echo "[phone] parameter is null";
		}

	}else {
		echo "check [request] param";
	}


} else {
	echo " Parameters : </br> </br> </br> ";
	echo "[ request ] ? { REGISTER , LOGIN , EDIT }";
	echo "</br> </br>";
	echo "[ first_name ]";
	echo "</br> </br>";
	echo "[ last_name ]";
	echo "</br> </br>";
	echo "[ phone ]";
	echo "</br> </br>";
	echo "[ password ]";
}


