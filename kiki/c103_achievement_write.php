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

//echo "kiki_point = $kiki_point /  kiki_pointoint = $kiki_count <BR>";

function makeZeroNumeric ($str, $num) {
	If (strlen($str) < $num) {
		$no = $num - strlen($str);
		for ($i = 1; $i <= $no; $i++) {
			$zero = $zero . "0";
		}
		return $zero . $str;
	} Else {
		return $str;
	}
}
	$code1 = "achi_";
/* 랜덤 문자 */
$feed = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"; 
$size = 8;
for ($i=0; $i < $size; $i++) {
    $code1 .= substr($feed, rand(0, strlen($feed)-1), 1);  
}
	$SQL = "Select MAX(achiId) as achiId from $board Where left(achiId,12) = '$code1'";
	$result = mysqli_query($kiki_conn, $SQL);
	if( $result === false) {
		 die( print_r( mysqli_connect_error(), true) );
	} else {
	  $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
 	  $achiId = $row["achiId"];	
	  $achiId = trim($achiId);
	  mysqli_free_result($result);
	}
	if($achiId != NULL) {
		$achiId_ = substr($achiId,12,5);
		$achiId_2 = substr($achiId,0,12);
		$achiId_ = $achiId_ + 1;
		$achiId_ =  sprintf("%.0f",$achiId_);
		$achiId_ = makeZeroNumeric($achiId_,5) ;
		$achiId = $achiId_2 . $achiId_;
	} else {
		$achiId = makeZeroNumeric($achiId,5) ;
		$achiId = $code1 . $achiId;
	}

//echo "achiId - $achiId  / name = $achiName / badge = $rewardBadge <BR>";
//$UserIP =  $_SERVER["REMOTE_ADDR"];
if($achiName and ($kiki_point <> "" or $rewardBadge)) {
	$SQL = "INSERT INTO $board (achiId, achiName ";
	$SQL .= ", point, badgeId, WriteDate, appId )";
	$SQL .= "  values ('$achiId'";
	$SQL .= ", '$achiName'";
	$SQL .= ", '$kiki_point'";
	$SQL .= ", '$rewardBadge'";
	$SQL .= ", now(), '$kiki_appId' )" ;
//echo $SQL . "<BR>";
/**/ 	$result = mysqli_query($kiki_conn, $SQL);
	if ( $result === false ) {
	   die( print_r( mysqli_connect_error(), true));
	}

	if ($kiki_count and $kiki_actId) { // 리워드 포인트 추가라면
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

mysqli_close($kiki_conn);
//exit;?>
<form name="list" method="post" action="../c103_achievement.php">
  <input type="hidden" name="cur_page" value="<?=$cur_page?>">
  <input type="hidden" name="appId" value="<?=$kiki_appId?>">
</form>

<Script language="JavaScript">
	document.list.submit();
</Script> 