    <?php header('X-UA-Compatible: IE=edge'); ?>
    <?php header('X-UA-Compatible: IE=8'); ?>
<?php
header('Content-Type: application/json; charset=UTF-8');
	include "./kiki_user.php";
	$badgeId = kiki_ischar($_REQUEST["badgeId"]);

	$SQL = "Select badgeName, badgeImg from appbadges where badgeId = '$badgeId' ";
	$result = mysqli_query($kiki_conn, $SQL);
	if( $result === false) {
		 die( print_r( mysqli_connect_error(), true) );
		 	$prog = "false";
	} else {
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		$badgeName = $row["badgeName"];		
		$badgeImg = $row["badgeImg"];
		if($badgeImg) {
			 $temp_name = explode("||", $badgeImg);
			 $badgeImg = $temp_name[0];
		}
		mysqli_free_result( $result);
		$prog = "true";
	}
	mysqli_close($kiki_conn);	
echo $_REQUEST["callback"]."({'prog':'". $prog . "', 'badgeName' : '". $badgeName ."', 'badgeImg' : '". $badgeImg ."'})";	?>