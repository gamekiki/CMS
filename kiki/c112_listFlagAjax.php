<? header("Content-Type: text/html; charset=UTF-8");
	include "./kiki_user.php";

	$listFlag = kiki_ischar($_POST["listFlag"]);			//
	$gdProdSerno = kiki_ischar($_POST["gdProdSerno"]);	//1: 댓글, 2: 댓글의 답글
	$UserID = $_COOKIE["UserID"];

//	if(!$UserID or !$listFlag or !$gdProdSerno ) {	// 기본 값이 등록되지 않았다면
	if(!$listFlag or !$gdProdSerno ) {	// 기본 값이 등록되지 않았다면
		$prog = "false";
	} else { // 
		$SQL = "UPDATE gd_prod SET listFlag = '$listFlag' ";
		$SQL .= " WHERE gdProdSerno = '$gdProdSerno' "; 		//
		$result = mysqli_query($kiki_conn, $SQL);
		if ( $result === false ) {
		   die( print_r( mysqli_connect_error(), true));
		}
		$prog = "true";
	}
	mysqli_close($kiki_conn);

echo $_REQUEST["callback"]."({'prog':'". $prog ."'})";		?>	