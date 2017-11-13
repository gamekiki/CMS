<? header("Content-Type: text/html; charset=UTF-8");
	include "./kiki_user.php";
		//
	$mgSubSerno = kiki_ischar($_POST["mgSubSerno"]);
	$UserID = $_COOKIE["UserID"];

	if(!$UserID or !$mgSubSerno ) {	// 기본 값이 등록되지 않았다면
		$prog = "false";
	} else { // 등록되어 있지 않다면
		$SQL = "Select rwdTitle, rwdType, rwdValue ";
		$SQL .= ", rwdProb, rwdRestrict, rwdPrice ";
		$SQL .= " from mg_sub where mgSubSerno = '$mgSubSerno' ";
		$result = mysqli_query($kiki_conn, $SQL);
		if( $result === false) {
			 die( print_r( mysqli_connect_error(), true) );
				$prog = "false";
		} else {
			$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
			$rwdTitle = $row["rwdTitle"];		
			$rwdType = $row["rwdType"];
			$rwdValue = $row["rwdValue"];		
			$rwdProb = $row["rwdProb"];
			$rwdProb = $rwdProb * 100;
			$rwdRestrict = $row["rwdRestrict"];
			$rwdPrice = $row["rwdPrice"];
		  if ($rwdRestrict and $rwdType == "G") {	// 당첨 제한 횟수 있는 기프티콘이라면	
			 $onePrice = $rwdRestrict * $rwdPrice;
			 $onePrice = number_format($onePrice);
		  }
			mysqli_free_result( $result);
			$prog = "true";
		}
	}
	mysqli_close($kiki_conn);	
echo $_REQUEST["callback"]."({'prog':'". $prog . "', 'rwdTitle' : '". $rwdTitle ."', 'rwdType' : '". $rwdType ."', 'rwdValue' : '". $rwdValue ."', 'rwdProb' : '". $rwdProb ."', 'rwdRestrict' : '". $rwdRestrict ."', 'rwdPrice' : '". $rwdPrice ."', 'onePrice' : '". $onePrice ."'})";	?>