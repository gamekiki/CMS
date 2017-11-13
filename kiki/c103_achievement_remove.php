<?php
	include "./kiki_user.php";
	$achiSerno = kiki_ischar($_POST["achiSerno"]);
	$achiId = kiki_ischar($_POST["achiId"]);

if ($achiId) {
// 리워드 삭제
	$SQL = "update  achievement set delFlag = 'Y' ";
	$SQL .= " where achiSerno = '$achiSerno' ";
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