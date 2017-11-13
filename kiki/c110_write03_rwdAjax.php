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
//	$rwdPrice = kiki_ischar($_POST["rwdPrice"]);

	$UserID = $_COOKIE["UserID"];
	

	if(!$UserID or !$mgSubSerno or !$rwdType or !$rwdValue) {	// 기본 값이 등록되지 않았다면
		$prog = "false";
	} else { // 등록되어 있지 않다면
		if ($rwdType == "G") {	
			$SQL = "Select giftPrice from mg_gifticon ";
			$SQL .= " where giftText = '$rwdValue'   ";
		//echo $SQL;
			$result = mysqli_query($kiki_conn, $SQL);
			if( $result === false) {
				 die( print_r( mysqli_connect_error(), true) );
			} else {
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
				$giftPrice = $row["giftPrice"];
				mysqli_free_result( $result);
			}
			$onePrice = $rwdRestrict * $giftPrice;
		}
		
		$SQL = "UPDATE mg_sub SET rwdType = '$rwdType' ";
		$SQL .= ", rwdValue = '$rwdValue' ";
		$SQL .= ", rwdTitle = '$rwdTitle' ";
		$SQL .= ", rwdProb = '$rwdProb' ";
		$SQL .= ", rwdRestrict = '$rwdRestrict' ";
	if ($rwdType == "G") {	
		$SQL .= ", rwdPrice = '$giftPrice' ";
	}
		$SQL .= "  WHERE mgSubSerno = '$mgSubSerno' ";
		$result = mysqli_query($kiki_conn, $SQL);
		if ( $result === false ) {
	      die( print_r( mysqli_connect_error(), true));
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
			  $this_price = $rwdRestrict * $rwdPrice;
			  $totPrice = $totPrice + $this_price;
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