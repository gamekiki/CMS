    <?php header('X-UA-Compatible: IE=edge'); ?>
    <?php header('X-UA-Compatible: IE=8'); ?>
<?php
header('Content-Type: text/css; charset=UTF-8');

	$UserID = $_COOKIE["UserID"];
	$UserIP =  $_SERVER["REMOTE_ADDR"];
	include "./kiki_user.php";

	$kiki_appId = kiki_ischar($_REQUEST["appId"]);
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

//	$code1 = "bag_";
/* 랜덤 문자 */
$feed = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"; 
$size = 8;
$board = "appbadges";
foreach ($_REQUEST["badgesSerno"] as $k=>$chkb) { 

//echo "for ech = $k <br>";	
	$badgesSerno = kiki_ischar($_REQUEST["badgesSerno"][$k]); 

	$SQL = "select badgesImg, badgesName from default_badges ";
	$SQL .= " where badgesSerno = '$badgesSerno' ";
//echo $SQL;
	$result = mysqli_query($kiki_conn, $SQL);
	if ( $result === false ) {
	   die( print_r( mysqli_connect_error(), true));
	} else {
	   $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	   $badgesImg = $row["badgesImg"];
	   if($badgesImg) {
		 $temp_name = explode("||", $badgesImg);
		 $badgesImg = $temp_name[0];
		 $thumb_img = "thumb_".$temp_name;
	   }
	   $badgesName = $row["badgesName"];
	   mysqli_free_result($result);
	}
$code1 = "bag_";
    /* 랜덤 문자 */
    for ($i=0; $i < $size; $i++) {
        $code1 .= substr($feed, rand(0, strlen($feed)-1), 1);  
    }
	$SQL = "Select MAX(badgeId) as badgeId from $board Where left(badgeId,12) = '$code1'";
//echo $SQL."<BR>";
	$result = mysqli_query($kiki_conn, $SQL);
	if( $result === false) {
		 die( print_r( mysqli_connect_error(), true) );
	}else {
	  $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
 	  $badgeId = $row["badgeId"];	
	  $badgeId = trim($badgeId);
	  mysqli_free_result($result);
	}
	if($badgeId != NULL) {
		$badgeId_ = substr($badgeId,12,5);
		$badgeId_2 = substr($badgeId,0,12);
		$badgeId_ = $badgeId_ + 1;
		$badgeId_ =  sprintf("%.0f",$badgeId_);
		$badgeId_ = makeZeroNumeric($badgeId_,5) ;
		$badgeId = $badgeId_2 . $badgeId_;
	} else {
		$badgeId = makeZeroNumeric($badgeId,5) ;
		$badgeId = $code1 . $badgeId;
	}

$new_badgesImg =  $badgeId."_". $badgesImg . "|| ". $badgesImg ;

// 이미지 복사
	$oldfile = "../../data/defbadge/". $badgesImg;
	$newfile = "../../data/badge/".$developerId."/".$kiki_appId."/". $badgeId."_". $badgesImg;

//echo "check 1 = $oldfile  :: ";
	if(file_exists($oldfile)) {
//echo "copy 1 <br>";
	   copy($oldfile, $newfile);// 
    } 

//// 썸네일 복사 처리...
	$thumb_oldfile = "../../data/defbadge/thumb_". $badgesImg;
	$thumb_newfile = "../../data/badge/".$developerId."/".$kiki_appId."/thumb_". $badgeId."_". $badgesImg;
// echo "check 2  :: ";
    if(file_exists($thumb_oldfile)) {
// echo "copy 2 <br>";
	   copy($thumb_oldfile, $thumb_newfile);// 
    }

	$SQL  = "INSERT INTO $board (badgeId, badgeName, appId ";
	$SQL .= ", badgeImg, badgeDate, UserIP, developerId) ";
	$SQL .= "  values ('$badgeId'";
	$SQL .= ", '$badgesName' ";
	$SQL .= ", '$kiki_appId' ";
	$SQL .= ", '$new_badgesImg' ";
	$SQL .= ", now(), '$UserIP', '$developerId' )";
//echo "sql1 = $SQL <br><BR>";
/**/	$result = mysqli_query($kiki_conn, $SQL);
	if ( $result === false ) {
	   die( print_r( mysqli_connect_error(), true));
	} 
}  // foreach


// 등록된 배지 가져오기
$wheStr = "appId = '$kiki_appId' and developerId = '$developerId'";

		$SQL = "select badgeSerno, badgeId, badgeName, badgeImg, badgeDate from $board";
		$SQL .= " WHERE  $wheStr ORDER BY badgeSerno desc ";
		$result_Q = mysqli_query($kiki_conn, $SQL);
		if( $result_Q === false) {
			 die( print_r( mysqli_connect_error(), true) );
		} else {
			$num = $totcnt ;
			while($row = mysqli_fetch_array($result_Q, MYSQLI_ASSOC)) {
			   $badgeSerno = $row["badgeSerno"];		
			   $badgeId = $row["badgeId"];
			   $badgeName = $row["badgeName"];
			   $badgeName = stripslashes($badgeName);
			   $badgeImg = $row["badgeImg"];
			   $badgeImg = stripslashes($badgeImg);
			   if($badgeImg) {
				 $temp_name = explode("||", $badgeImg);
				 $save_file_name = $temp_name[0];
				 $badgeImg = "../data/badge/".$developerId."/".$kiki_appId."/thumb_".$save_file_name;
			   } else {
				   $badgeImg = "./kiki/img/badge01.png";
			   }
			   $regiYHS = new DateTime($row["badgeDate"]);
			   $regiYHS = date_format($regiYHS, "Y.m.d");		
$result1 .= "  <tr id='$badgeId'> ";
$result1 .= "    <td> $badgeId </td> ";
$result1 .= "    <td id='img_$badgeId'> <img src='$badgeImg'/> </td> ";
$result1 .= "    <td id='name_$badgeId'> $badgeName </td> ";
$result1 .= "    <td> $regiYHS </td> ";
$result1 .= "    <td> <a href='javascript:kiki_badge_show(\"$badgeId\")' class='kikibtn_modify'>수정</a> &nbsp; <a href='javascript:kiki_remove_badge(\"$badgeId\")' class='kikibtn_del'>삭제</a> </td> ";
$result1 .= "  </tr> ";
		$num = $num - 1;
		  } // while
		  mysqli_free_result( $result_Q);
		}  // if $result != false

mysqli_close($kiki_conn);

echo $result1;		?>