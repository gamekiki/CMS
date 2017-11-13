<? header("Content-Type: text/html; charset=UTF-8");
	include "./kiki_user.php";

	$kiki_point = kiki_ischar($_POST["kiki_point"]); 
	$kiki_comments = kiki_ischar2($_POST["kiki_comments"]); 
	$kiki_userSerno = kiki_ischar($_POST["userSerno"]);	 
	$kiki_sign = kiki_ischar($_POST["kiki_sign"]); 
	$kiki_chk = kiki_ischar($_POST["kiki_chk"]);	// P : 포인트 , M : 마일리지
if (!$kiki_sign ) {
	$kiki_sign  = "+";
}
if (!$kiki_chk ) {
	$kiki_chk  = "P";
}
/*	$kiki_point = "50"; 
	$kiki_comments = "17번 50포인트 지급"; 
	$kiki_userSerno = "17";	 
	$kiki_sign = "+";  */

	$UserID = $_COOKIE["UserID"];
	if(!$kiki_point or !$kiki_userSerno or !$UserID ) {
//	if(!$kiki_point or !$kiki_comments or !$kiki_userSerno or !$UserID ) {	// 기본 값이 등록되지 않았다면
		$prog = "false";
	} else { // 등록되어 있지 않다면

		$SQL = "Select UserPoint, userMileage from user a ";
		$SQL .= " where userId = '$kiki_userSerno' and appID = '$kiki_appId'  ";
//echo "5 = $SQL <BR>";
		$result = mysqli_query($kiki_conn, $SQL);
		if( $result === false) {
			 die( print_r( mysqli_connect_error(), true) );
		} else {
		  $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		  $UserPoint = $row["UserPoint"];	
		  $UserPoint = stripslashes($UserPoint);
		  $userMileage = $row["userMileage"];
		  $userMileage = stripslashes($userMileage);
		  mysqli_free_result($result);
		}

	  if ($kiki_chk == "P") { // 포인트라면 	
		if ($kiki_sign == "+") {
			$UserPoint_ = $UserPoint + $kiki_point;
		} else {
			$UserPoint_ = $UserPoint - $kiki_point;
		}
		if ($UserPoint_ < 1) {
			$UserPoint_ = 0;
			$kiki_point = $UserPoint;
		}
		
		$SQL = "INSERT INTO user_reward_log (userId, sign1, point ";
		$SQL .= ", WriteDate, appId, actId, comments, rewSerno )";
		$SQL .= "  values ( '$kiki_userSerno' ";
		$SQL .= ", '$kiki_sign'";
		$SQL .= ", '$kiki_point'"; 
		$SQL .= ", now() ";		// writedate
		$SQL .= ", '$kiki_appId' ";
		$SQL .= ", '$adm_activity' ";
		$SQL .= ", '$kiki_comments'";
		$SQL .= ", '' )";
//echo "4 = $SQL <BR>";
		$result = mysqli_query($kiki_conn, $SQL);
		if ( $result === false ) {
		   die( print_r( mysqli_connect_error(), true));
		}

		$SQL = "UPDATE user SET UserPoint = $UserPoint_ ";
		$SQL .= " where userId = '$kiki_userSerno' and appID = '$kiki_appId'  ";
//echo "4 = $SQL <BR>";
		$result = mysqli_query($kiki_conn, $SQL);
		if ( $result === false ) {
		   die( print_r( mysqli_connect_error(), true));
		}
	  } else { // kiki_chk == M 마일리지라면

		if ($kiki_sign == "+") {
			$userMileage_ = $userMileage + $kiki_point;
		} else {
			$userMileage_ = $userMileage - $kiki_point;
		}
		if ($userMileage_ < 1) {
			$userMileage_ = 0;
			$kiki_point = $userMileage;
		}

	if ($kiki_sign == "+") {
	  $sign1 = "A";
    } else {
	  $sign1 = "M";
    }
		$SQL = "INSERT INTO mileage_UseLog (userId, sign1, mileage ";
		$SQL .= ", regiYHS, appId, comments, rwdId , chk, balanMileage, modiYHS)";
		$SQL .= "  values ( '$kiki_userSerno' ";
		$SQL .= ", '$sign1'";
		$SQL .= ", '$kiki_point'"; 
		$SQL .= ", now() ";		// writedate
		$SQL .= ", '$kiki_appId' ";
		$SQL .= ", '$kiki_comments'";
		$SQL .= ", '', 'A' ";
		$SQL .= ", '$userMileage_', now())";
//echo "4 = $SQL <BR>";
		$result = mysqli_query($kiki_conn, $SQL);
		if ( $result === false ) {
		   die( print_r( mysqli_connect_error(), true));
		}

		$SQL = "UPDATE user SET userMileage = $userMileage_ ";
		$SQL .= " where userId = '$kiki_userSerno' and appID = '$kiki_appId'  ";
		$result = mysqli_query($kiki_conn, $SQL);
		if ( $result === false ) {
		   die( print_r( mysqli_connect_error(), true));
		}
	  }
		$prog = "true";
	// 이름 불러오기
		$SQL = "Select UserPoint, (select levelId from appLevel where ";
		$SQL .= " appId = '$kiki_appId' and a.UserPoint >= minPoint and ";
		$SQL .= " a.Userpoint <  maxPoint ) as levelId, userMileage from user a ";
		$SQL .= " where userId = '$kiki_userSerno' and appID = '$kiki_appId'  ";
//echo "5 = $SQL <BR>";
		$result = mysqli_query($kiki_conn, $SQL);
		if( $result === false) {
			 die( print_r( mysqli_connect_error(), true) );
		} else {
		  $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		  $UserPoint = $row["UserPoint"];	
		  $UserPoint = stripslashes($UserPoint);
	if ($UserPoint) {
		$UserPoint = number_format($UserPoint);
	}
		  $levelId = $row["levelId"];	
		  $levelId = stripslashes($levelId);
		  $userMileage = $row["userMileage"];
		  $userMileage = stripslashes($userMileage);
	if ($userMileage) {
		$userMileage = number_format($userMileage);
	}
		  mysqli_free_result($result);
		}
	}
	mysqli_close($kiki_conn);
echo $_REQUEST["callback"]."({'prog':'". $prog ."','UserPoint':'". $UserPoint ."','levelId':'". $levelId ."','userMileage':'". $userMileage ."'})";				?>	