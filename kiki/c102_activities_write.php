    <?php header('X-UA-Compatible: IE=edge'); ?>
    <?php header('X-UA-Compatible: IE=8'); ?>
<?php
header('Content-Type: text/html; charset=UTF-8');

	$board = "activity";
	include "./kiki_user.php";

	$cur_page = kiki_ischar($_POST["cur_page"]);
	$actName = kiki_ischar($_POST["actName"]);
	$actDesc = kiki_ischar($_POST["actDesc"]);
	$rewardP = kiki_ischar($_POST["rewardP"]);	// 리워드 포인트
	$rewardB = kiki_ischar($_POST["rewardB"]);	// 리워드 뱃지
	$rewardPoint = kiki_isnumb($_POST["rewardPoint"]);	// 리워드 포인트 값
	$restricted = kiki_ischar($_POST["rew_point_restrict"]);	// 리워드 제약조건
	$rewardBadge = kiki_ischar($_POST["rewardBadge"]);	// 리워드 뱃지 id
	$restrictP = kiki_ischar($_POST["restrictP"]);
	if ($restricted == "P") {	// 제약횟수 직업 입력
		$restricted = $restrictP;
	}
//echo "rewardP = $rewardP /  rewardPoint = $rewardPoint / restricted = $restricted <BR>";
//exit;
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

	$code1 = "act_";
/* 랜덤 문자 */
$feed = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"; 
$size = 8;
for ($i=0; $i < $size; $i++) {
    $code1 .= substr($feed, rand(0, strlen($feed)-1), 1);  
}
	$SQL = "Select MAX(actId) as actId from $board Where left(actId,12) = '$code1'";
	$result = mysqli_query($kiki_conn, $SQL);
	if( $result === false) {
		 die( print_r( mysqli_connect_error(), true) );
	} else {
	  $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
 	  $actId = $row["actId"];	
	  $actId = trim($actId);
	  mysqli_free_result($result);
	}
	if($actId != NULL) {
		$actId_ = substr($actId,12,5);
		$actId_2 = substr($actId,0,12);
		$actId_ = $actId_ + 1;
		$actId_ =  sprintf("%.0f",$actId_);
		$actId_ = makeZeroNumeric($actId_,5) ;
		$actId = $actId_2 . $actId_;
	} else {
		$actId = makeZeroNumeric($actId,5) ;
		$actId = $code1 . $actId;
	}

$UserIP =  $_SERVER["REMOTE_ADDR"];
if($actName) {
	$SQL = "INSERT INTO $board (actId, actName, actDesc ";
	$SQL .= ", developerId, UserIP, regiYHS, appId )";
	$SQL .= "  values ('$actId'";
	$SQL .= ", '$actName'";
	$SQL .= ", '$actDesc'";
	$SQL .= ", '$developerId'";
	$SQL .= ", '$UserIP'";
	$SQL .= ", now(), '$kiki_appId' )" ;
//echo $SQL . "<BR>";
/**/ 	$result = mysqli_query($kiki_conn, $SQL);
	if ( $result === false ) {
	   die( print_r( mysqli_connect_error(), true));
	}

	if ($rewardP) { // 리워드 포인트 추가라면
	  if($rewardPoint <> "" && $restricted) {
		$SQL = "INSERT INTO activity_reward (rewKind, rewardValue ";
		$SQL .= ", actId, regiYHS, UserIP, restricted) ";
		$SQL .= " values ('P'";
		$SQL .= ", '$rewardPoint'";
		$SQL .= ", '$actId'";
		$SQL .= ",  now(), '$UserIP'";
		$SQL .= ", '$restricted')";
//	echo $SQL . "<BR>";	
	/**/	$result = mysqli_query($kiki_conn, $SQL);
		if ( $result === false ) {
		   die( print_r( mysqli_connect_error(), true));
		}
	  }
	}
	if ($rewardB) { // 리워드 뱃지라면
	  if($rewardBadge && $restricted) {
		$SQL = "INSERT INTO activity_reward (rewKind, rewardValue ";
		$SQL .= ", actId, regiYHS, UserIP, restricted) ";
		$SQL .= " values ('B'";
		$SQL .= ", '$rewardBadge'";
		$SQL .= ", '$actId'";
		$SQL .= ",  now(), '$UserIP'";
		$SQL .= ", '$restricted')";
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
<form name="list" method="post" action="../c102_activities.php">
  <input type="hidden" name="cur_page" value="<?=$cur_page?>">
</form>

<Script language="JavaScript">
	document.list.submit();
</Script> 