    <?php header('X-UA-Compatible: IE=edge'); ?>
    <?php header('X-UA-Compatible: IE=8'); ?>
<?php
header('Content-Type: text/html; charset=UTF-8');

	$UserID = $_COOKIE["UserID"];
	include "./kiki_user.php";
	$board = "activity";
	
	$cur_page = kiki_ischar($_POST["cur_page"]);
	$actId = kiki_ischar($_POST["actId"]);
	$actName = kiki_ischar($_POST["actName"]);
	$actDesc = kiki_ischar($_POST["actDesc"]);
	$rewardP = kiki_ischar($_POST["rewardP"]);	// 리워드 포인트
	$rewardB = kiki_ischar($_POST["rewardB"]);	// 리워드 뱃지
	$rewardPoint = kiki_isnumb($_POST["rewardPoint"]);	// 리워드 포인트 값
	$restricted = kiki_ischar($_POST["rew_point_restrict"]);	// 리워드 제약조건
	$rewardBadge = kiki_ischar($_POST["rewardBadge"]);	// 리워드 뱃지 id
	$badgeDel = kiki_ischar($_POST["badgeDel"]);		// 기 등록된 리워드 뱃지 삭제여부 Y/N
	$restrictP = kiki_ischar($_POST["restrictP"]);
	if ($restricted == "P") {	// 제약횟수 직업 입력
		$restricted = $restrictP;
	}
//echo "rewardP = $rewardP /  rewardPoint = $rewardPoint / restricted = $restricted <BR>";
//echo "$rewardB = $rewardB /  rewardBadge = $rewardBadge / restricted = $restricted <BR>";
//exit;
if($actName and $actId) {
	$SQL = "UPDATE $board SET actName = '$actName' ";
	$SQL .= ", actDesc = '$actDesc'";
	$SQL .= " WHERE developerId = '$developerId'";
	$SQL .= " and actId = '$actId' ";
	$SQL .= " and appId  = '$kiki_appId' " ;
//echo "user = $UserID <BR>";
//echo $SQL . "<BR>";
//exit;
/* */	$result = mysqli_query($kiki_conn, $SQL);
	if ( $result === false ) {
	   die( print_r( mysqli_connect_error(), true));
	}

		$SQL = "Select rewSerno FROM  activity_reward where ";
		$SQL .= " actId = '$actId' AND rewKind = 'P'  ";
//echo $SQL . "<BR>";
		$result = mysqli_query($kiki_conn, $SQL);
		if( $result === false) {
			 die( print_r( mysqli_connect_error(), true) );
		} else {
			$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
			$rewSernoP = $row["rewSerno"];
			mysqli_free_result( $result);
		}

	if ($badgeDel) { // 기존에 뱃지 등록되었고, 지금 없다면
		$SQL = "delete from activity_reward where actId = '$actId'";
		$SQL .= " and rewKind = 'B' ";
		$result = mysqli_query($kiki_conn, $SQL);
//echo "badel = $SQL <BR>";
		if ( $result === false ) {
		   die( print_r( mysqli_connect_error(), true));
		}
		$rewardB = "";
		$rewardBadge = "";
	} else {
		$SQL = "Select rewSerno FROM  activity_reward where ";
		$SQL .= " actId = '$actId' AND rewKind = 'B'  ";
//echo "badelNo = $SQL <br>";
		$result = mysqli_query($kiki_conn, $SQL);
		if( $result === false) {
			 die( print_r( mysqli_connect_error(), true) );
		} else {
			$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
			$rewSernoB = $row["rewSerno"];
			mysqli_free_result( $result);
		}
	}
	if ($rewardP) { // 리워드 포인트 추가라면
	  if($rewardPoint <> "" && $restricted AND $rewSernoP) {
		$SQL = "UPDATE activity_reward SET rewardValue = '$rewardPoint' ";
		$SQL .= ", restricted = '$restricted' ";
		$SQL .= " WHERE rewKind = 'P'";
		$SQL .= " AND actId = '$actId'";
		$SQL .= " AND rewSerno = '$rewSernoP'";
//echo "rewardP1 = $SQL <br>";
	/**/	$result = mysqli_query($kiki_conn, $SQL);
		if ( $result === false ) {
		   die( print_r( mysqli_connect_error(), true));
		}
	  } else if ($rewardPoint <> "" && $restricted AND !$rewSernoP) {
		$SQL = "INSERT INTO activity_reward (rewKind, rewardValue ";
		$SQL .= ", actId, regiYHS, UserIP, restricted) ";
		$SQL .= " values ('P'";
		$SQL .= ", '$rewardPoint'";
		$SQL .= ", '$actId'";
		$SQL .= ",  now(), '$UserIP'";
		$SQL .= ", '$restricted')";
//echo "rewardP2 = $SQL <br>";
	//echo $SQL;	
	/**/	$result = mysqli_query($kiki_conn, $SQL);
		if ( $result === false ) {
		   die( print_r( mysqli_connect_error(), true));
		}
	  }
	}
	if (!$rewardP and $rewSernoP) { // 기존에 포인트 등록되었고, 지금 없다면
		$SQL = "delete from activity_reward where rewSerno = '$rewSernoP'";
		$result = mysqli_query($kiki_conn, $SQL);
		if ( $result === false ) {
		   die( print_r( mysqli_connect_error(), true));
		}
	}

	if ($rewardB) { // 리워드 뱃지라면
	  if($rewardBadge and $rewSernoB) {
		$SQL = "UPDATE activity_reward SET rewardValue = '$rewardBadge' ";
		$SQL .= ", restricted = '$restricted' ";
		$SQL .= " WHERE rewKind = 'B'";
		$SQL .= " AND actId = '$actId'";
		$SQL .= " AND rewSerno = '$rewSernoB'";
 //echo "rewardB1 = $SQL <br>";
	//echo $SQL;	
	/**/	$result = mysqli_query($kiki_conn, $SQL);
		if ( $result === false ) {
		   die( print_r( mysqli_connect_error(), true));
		}
	  } elseif ($rewardBadge and !$rewSernoB) {
		$SQL = "INSERT INTO activity_reward (rewKind, rewardValue ";
		$SQL .= ", actId, regiYHS, UserIP, restricted) ";
		$SQL .= " values ('B'";
		$SQL .= ", '$rewardBadge'";
		$SQL .= ", '$actId'";
		$SQL .= ",  now(), '$UserIP'";
		$SQL .= ", '$restricted')";
//echo "rewardB2 = $SQL <br>";
	//echo $SQL;	
	/**/	$result = mysqli_query($kiki_conn, $SQL);
		if ( $result === false ) {
		   die( print_r( mysqli_connect_error(), true));
		}
	  }
	}
	if (!$rewardB and $rewSernoB) { // 기존에 뱃지 등록되었고, 지금 없다면
		$SQL = "delete from activity_reward where rewSerno = '$rewSernoB'";
		$result = mysqli_query($kiki_conn, $SQL);
		if ( $result === false ) {
		   die( print_r( mysqli_connect_error(), true));
		}
	}
}
//exit;
mysqli_close($kiki_conn);	?>
<form name="list" method="post" action="../c102_activities.php">
  <input type="hidden" name="cur_page" value="<?=$cur_page?>">
  <input type="hidden" name="appId" value="<?=$kiki_appId?>">
</form>

<Script language="JavaScript">
	document.list.submit();
</Script> 