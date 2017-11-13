<?php
	include "./kiki_user.php";
	$actSerno = kiki_ischar($_POST["actSerno"]);
	$actId = kiki_ischar($_POST["actId"]);

if ($actId) {
// 리워드 삭제
	$SQL = "delete from activity_reward where actId = '$actId' ";
	$result = mysqli_query($kiki_conn, $SQL);
	if ( $result === false ) {
	   die( print_r( mysqli_connect_error(), true));
	}
// activity 삭제
	$SQL = "delete from activity where actId = '$actId'";
	$result = mysqli_query($kiki_conn, $SQL);
	if ( $result === false ) {
	   die( print_r( mysqli_connect_error(), true));
	}
// user_record 삭제
	$SQL = "delete from user_record where actId='$actId'";
	$result = mysqli_query($kiki_conn, $SQL);
	if ( $result === false ) {
	   die( print_r( mysqli_connect_error(), true));
	}
	mysqli_close($kiki_conn);
// 등록된 user_record 삭제해야 할까?

	echo $_REQUEST["callback"]."({'prog':'true'})";
} else {
	echo $_REQUEST["callback"]."({'prog':'false'})";
}
	?>