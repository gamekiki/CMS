<? header("Content-Type: text/html; charset=UTF-8");
	include "./kiki_user.php";

	$UserID = $_COOKIE["UserID"];
	if(!$UserID) {	// 기본 값이 등록되지 않았다면
		$prog = "false";
		$msg = "처리 중 오류가 발생했습니다. 잠시 후 다시 시도해 주세요.";
	} else { // 등록되어 있지 않다면

	  foreach ($_POST['muLogSerno'] as $k=>$chkb) { 
// 유저의 마일리지 - 처리 해 줄 것.
		$muLogSerno = kiki_isnumb($_POST['muLogSerno'][$k]); 

		$SQL = "UPDATE mileage_UseLog ";
		$SQL .= " SET sign1 = 'M'"; 
		$SQL .= ", modiYHS = now()"; 
		$SQL .= " WHERE muLogSerno = '$muLogSerno' ";
//	echo "4= $SQL <BR>";
		$result = mysqli_query($kiki_conn, $SQL);
		if ( $result === false ) {
		   die( print_r( mysqli_connect_error(), true));
		}

		$prog = "true";
		$msg = "";
		$modiYHS = date("Y-m-d H:i");
	  }
	}
	mysqli_close($kiki_conn);

echo $_REQUEST["callback"]."({'prog':'". $prog ."','msg' : '". $msg ."','modiYHS' : '". $modiYHS ."' })";		?>	