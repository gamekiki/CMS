<? header("Content-Type: text/html; charset=UTF-8");
	include "./kiki_user.php";

	$actYN = kiki_ischar($_POST["actYN"]);			//
	$mgId = kiki_ischar($_POST["mgId"]);	//1: 댓글, 2: 댓글의 답글
	$UserID = $_COOKIE["UserID"];

//	if(!$UserID or !$actYN or !$mgId ) {	// 기본 값이 등록되지 않았다면
	if(!$actYN or !$mgId ) {	// 기본 값이 등록되지 않았다면
		$prog = "false";
	} else { // 
	  if ($actYN == "Y") {  // 활성화라면
		$SQL = "UPDATE mg_main SET actYN = 'N' ";
		$SQL .= " WHERE mgId <> '$mgId' and delFlag = 'N' "; 		//
		$result = mysqli_query($kiki_conn, $SQL);
		if ( $result === false ) {
		   die( print_r( mysqli_connect_error(), true));
		}
		
		$SQL = "UPDATE mg_main SET actYN = 'Y' ";
		$SQL .= " WHERE mgId = '$mgId' "; 		//
		$result = mysqli_query($kiki_conn, $SQL);
		if ( $result === false ) {
		   die( print_r( mysqli_connect_error(), true));
		}
	  } else {  // 비활성화라면
		$SQL = "UPDATE mg_main SET actYN = '$actYN' ";
		$SQL .= " WHERE mgId = '$mgId' "; 		//
		$result = mysqli_query($kiki_conn, $SQL);
		if ( $result === false ) {
		   die( print_r( mysqli_connect_error(), true));
		}
	  }
		$prog = "true";
	}
	mysqli_close($kiki_conn);

echo $_REQUEST["callback"]."({'prog':'". $prog ."'})";		?>	