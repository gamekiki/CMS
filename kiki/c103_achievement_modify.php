    <?php header('X-UA-Compatible: IE=edge'); ?>
    <?php header('X-UA-Compatible: IE=8'); ?>
<?php
header('Content-Type: text/html; charset=UTF-8');

	$board = "achievement";
	include "./kiki_user.php";

	$cur_page = kiki_ischar($_POST["cur_page"]);
	$achiName = kiki_ischar($_POST["achiName"]);
	$kiki_count = kiki_ischar($_POST["kiki_count"]);
	$kiki_point = kiki_ischar($_POST["kiki_point"]);	// 리워드 포인트
	$kiki_actId = kiki_ischar($_POST["kiki_actId"]);	// 리워드 뱃지
	$rewardBadge = kiki_ischar($_POST["rewardBadge"]);	// 리워드 제약조건
	$achiId = kiki_ischar($_POST["achiId"]);
	$badgeDel = kiki_ischar($_POST["badgeDel"]);	// 뱃지 삭제 여부

//echo "kiki_point = $kiki_point /  kiki_pointoint = $kiki_pointoint / restricted = $restricted <BR>";
//exit;

	if ($badgeDel) { // 뱃지 삭제 선택했다면
		$rewardBadge = "";
	}

if($achiName and $kiki_count and ($kiki_point <> "" or $rewardBadge)) {
	$SQL = "UPDATE $board SET achiName = '$achiName' ";
	$SQL .= ", point = '$kiki_point' ";
	$SQL .= ", badgeId = '$rewardBadge' ";
	$SQL .= " WHERE achiId = '$achiId' ";
	$SQL .= " and appId  = '$kiki_appId' " ;
/**/ 	$result = mysqli_query($kiki_conn, $SQL);
	if ( $result === false ) {
	   die( print_r( mysqli_connect_error(), true));
	}

		$SQL = "Select achiSubSerno FROM  achievement_Sub where ";
		$SQL .= " achiId = '$achiId'  ";
//echo $SQL . "<BR>";
		$result = mysqli_query($kiki_conn, $SQL);
		if( $result === false) {
			 die( print_r( mysqli_connect_error(), true) );
		} else {
			$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
			$achiSubSerno = $row["achiSubSerno"];
			mysqli_free_result( $result);
		}

	if ($kiki_count and $kiki_actId) { // 리워드 포인트 추가라면
	  if ($achiSubSerno) {	//기존에 등록된 포인트 있담ㄴ
		$SQL = "UPDATE achievement_Sub SET actId = '$kiki_actId' ";
		$SQL .= ", count = '$kiki_count' ";
		$SQL .= " WHERE achiSubSerno = '$achiSubSerno'";
//echo "rewardP1 = $SQL <br>";
	/**/	$result = mysqli_query($kiki_conn, $SQL);
		if ( $result === false ) {
		   die( print_r( mysqli_connect_error(), true));
		}
	  } else {
		$SQL = "INSERT INTO achievement_Sub (achiId, actId, count) ";
		$SQL .= " values ('$achiId'";
		$SQL .= ", '$kiki_actId'";
		$SQL .= ", '$kiki_count')";
//	echo $SQL . "<BR>";	
	/**/	$result = mysqli_query($kiki_conn, $SQL);
		if ( $result === false ) {
		   die( print_r( mysqli_connect_error(), true));
		}
	  }
	}
}
mysqli_close($kiki_conn);

//exit;?>
<form name="list" method="post" action="../c103_achievement.php">
  <input type="hidden" name="cur_page" value="<?=$cur_page?>">
  <input type="hidden" name="appId" value="<?=$kiki_appId?>">
</form>

<Script language="JavaScript">
	document.list.submit();
</Script> 