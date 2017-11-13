<? header("Content-Type: text/html; charset=UTF-8");
	include "./kiki_user.php";

	$mgId = kiki_ischar($_POST["mgId"]);

	$mgSubSerno = kiki_ischar($_POST["mgSubSerno"]);
	$rwdType = kiki_ischar($_POST["rwdType"]);
	$rwdValue = kiki_ischar($_POST["rwdValue"]);
	$rwdTitle = kiki_ischar($_POST["rwdTitle"]);
	$rwdProb = kiki_ischar($_POST["rwdProb"]);
	$rwdProb = $rwdProb / 100;
	$rwdRestrict = kiki_ischar($_POST["rwdRestrict"]);
	$rwdPrice = kiki_ischar($_POST["rwdPrice"]);

	$UserID = $_COOKIE["UserID"];

	if(!$UserID or !$mgSubSerno or !$rwdType or !$rwdValue) {	// 기본 값이 등록되지 않았다면
		$prog = "false";
	} else { // 등록되어 있지 않다면
		$SQL = "UPDATE mg_sub SET rwdType = '$rwdType' ";
		$SQL .= ", rwdValue = '$rwdValue' ";
		$SQL .= ", rwdTitle = '$rwdTitle' ";
		$SQL .= ", rwdProb = '$rwdProb' ";
		$SQL .= ", rwdRestrict = '$rwdRestrict' ";
		$SQL .= "  WHERE mgSubSerno = '$mgSubSerno' ";
		$result = mysqli_query($kiki_conn, $SQL);
		if ( $result === false ) {
	      die( print_r( mysqli_connect_error(), true));
		}

		if ($rwdRestrict and $rwdType == "G") {	// 당첨 제한 횟수 있는 기프티콘이라면	
		   $onePrice = $rwdRestrict * $rwdPrice;
		   $onePrice = number_format($onePrice);
		}

		$totPrice = 0;
		$SQL = "Select rwdRestrict, rwdPrice from mg_sub where ";
		$SQL .= " mgId = '$mgId' and rwdType = 'G'  order by mgSubSerno  ";
		$result = mysqli_query($kiki_conn, $SQL);
		if( $result === false) {
			 die( print_r( mysqli_connect_error(), true) );
		} else {
			while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			  $rwdRestrict = $row["rwdRestrict"];
			  $rwdPrice = $row["rwdPrice"];	
				 $onePrice = $rwdRestrict * $rwdPrice;
				 $totPrice = $totPrice + $onePrice;
			}
		}
		$prog = "true";
		if ($onePrice) {
		 $onePrice = number_format($onePrice);
		 $onePrice = $onePrice . "원";
		}
		if ($totPrice) {
		 $totPrice = number_format($totPrice);
		 $totPrice = "- 비용 총합 : ". $totPrice . "원";
		}
	}
	mysqli_close($kiki_conn);	
echo $_REQUEST["callback"]."({'prog':'". $prog . "', 'totPrice' : '". $totPrice ."', 'onePrice' : '". $onePrice ."', 'rwdProb' : '". $rwdProb ."'})";	?>