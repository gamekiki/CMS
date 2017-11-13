<? header("Content-Type: text/html; charset=UTF-8");
	include "./kiki_user.php";

	$muLogSerno = kiki_isnumb($_POST["muLogSerno"]);
	$UserID = $_COOKIE["UserID"];
//$kiki_appId = "app_Bx8BoU1g00000";
//$muLogSerno =2;
	if(!$UserID or !$muLogSerno) {	// 기본 값이 등록되지 않았다면
		$prog = "false";
		$msg = "처리 중 오류가 발생했습니다. 잠시 후 다시 시도해 주세요.";
	} else { // 등록되어 있지 않다면
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
	mysqli_close($kiki_conn);

echo $_REQUEST["callback"]."({'prog':'". $prog ."','msg' : '". $msg ."','modiYHS' : '". $modiYHS ."' })";		?>	