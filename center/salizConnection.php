<?php

function OpenSalizCon()
{

    $servername = "localhost";
    $username = "USERNAME";
    $password = "PASSWORD";
    $db = "DATABASE";

	$conn = new mysqli( $servername, $username, $password,$db) or die("Connect failed: %s\n". $conn -> error);

	return $conn;
}

function CloseCon($conn)
{
	$conn -> this->close();
}
