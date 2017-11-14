<?php
	include "./kiki_user.php";
	include "./file_library.php";

	$badgeId = kiki_ischar($_POST["badgeId"]);
//	$UserID = $_COOKIE["UserID"];

if ($badgeId) {
	$SQL = "select badgeImg from appbadges where badgeId = '$badgeId' ";
	$result_Q = mysqli_query($kiki_conn, $SQL);
	if( $result_Q === false) {
		 die( print_r( mysqli_connect_error(), true) );
	} else {
	   $row = mysqli_fetch_array($result_Q, MYSQLI_ASSOC);
	   $badgeImg = $row["badgeImg"];
	   if ($badgeImg) {  // 회원이 업로드 한 파일이라면 삭제...
	//	  $photo_pieces = explode("../data/badge/".$developerId."/".$kiki_appId."/", $badgeImg);
		  del_file2($badgeImg,$developerId,$kiki_appId);
	   }
	   mysqli_free_result( $result_Q);
	}
/* */// badge 삭제
	$SQL = "delete from appbadges where badgeId = '$badgeId'";
	$result = mysqli_query($kiki_conn, $SQL);
	if ( $result === false ) {
	   die( print_r( mysqli_connect_error(), true));
	}
// reward badge 삭제
	$SQL = "delete from activity_reward where rewardValue = '$badgeId'";
	$result = mysqli_query($kiki_conn, $SQL);
	if ( $result === false ) {
	   die( print_r( mysqli_connect_error(), true));
	}
// 보유 배지 삭제...
	$SQL = "delete from user_badges where badgeId = '$badgeId'";
	$result = mysqli_query($kiki_conn, $SQL);
	if ( $result === false ) {
	   die( print_r( mysqli_connect_error(), true));
	}
// 유저 보유 배지 수 감소처리?

	mysqli_close($kiki_conn);

	echo $_REQUEST["callback"]."({'prog':'true'})";
} else {
	echo $_REQUEST["callback"]."({'prog':'false'})";
}
	?>