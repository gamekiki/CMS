 <? header("Content-Type: text/html; charset=UTF-8");
	include "./kiki_user.php";	

$result_stmt .= "<table class='kiki_tblT01' border='0' cellspacing='0' cellpadding='0'>";
$result_stmt .= " <colgroup> ";
$result_stmt .= "  <col width='10%'> ";
$result_stmt .= "  <col width='20%'> ";
$result_stmt .= "  <col width=''> ";
$result_stmt .= "  <col width='10%'> ";
$result_stmt .= "  <col width='10%'> ";
$result_stmt .= "  <col width='10%'> ";
$result_stmt .= "  <col width='20%'> ";
$result_stmt .= " </colgroup> ";
$result_stmt .= " <thead> ";
$result_stmt .= "  <tr> ";
$result_stmt .= "   <th>No</th> ";
$result_stmt .= "   <th>아이디</th> ";
$result_stmt .= "   <th>이름</th> ";
$result_stmt .= "   <th>내용</th> ";
$result_stmt .= "   <th>마일리지</th> ";
$result_stmt .= "   <th>사유</th> ";
$result_stmt .= "   <th>일시</th> ";
$result_stmt .= "  </tr> ";
$result_stmt .= " </thead>  ";
$result_stmt .= " <tbody> ";

	$pagesize = 15 ;
	$page_cont = "mileage_list";
	$cur_page = isset($_POST["cur_page"]) ? kiki_isnumb($_POST["cur_page"]) : 1;
	$schSel = isset($_POST["schSel"]) ? kiki_ischar($_POST["schSel"]) : 'a.userId';	
	$schStr = isset($_POST["schStr"]) ? kiki_ischar($_POST["schStr"]) : '';	

	$board = "mileage_UseLog";

	$wheStr = "a.appId = '$kiki_appId'";
if ($schSel == "a.userId" or $schSel == "username") {
	$wheStr .= " and ($schSel like '%". trim($schStr). "%')"; 
} else {
	if ($schStr) {
	$wheStr .= " and (chk = '". trim($schStr). "')"; 
	}
}

	$SQL = "Select count(muLogSerno) as totcnt from $board a INNER JOIN user b ";
	$SQL .= " ON a.appId = b.appId and a.userId = b.userId WHERE $wheStr ";
//	$SQL .= " and sign1 IN ('A','M') ";
//echo $SQL;
	$result_count = mysqli_query($kiki_conn, $SQL);
	if ( $result_count === false ) {
		die( print_r( mysqli_connect_error(), true));
		mysqli_close($kiki_conn);
	} else {
	  $row = mysqli_fetch_array($result_count, MYSQLI_ASSOC);
 	  $totcnt = $row["totcnt"];	
	  $totpage = ceil((($totcnt / $pagesize) * -1) * -1);
	  mysqli_free_result($result_count);
	}

  if($totcnt == 0) {	
$result_stmt .= "  <tr> ";
$result_stmt .= "   <td colspan='7' class='kiki_nodata'>자료가 없습니다.</td> ";
$result_stmt .= "  </tr> ";
  }  Else {
		$start = ($cur_page-1) * $pagesize;
		$num = $totcnt - (($cur_page - 1) * $pagesize);
		$nowdate = date("Y-m-d");
	$SQL = "SELECT a.userId, userName, sign1, mileage, chk  ";
	$SQL .= ", comments, a.regiYHS FROM $board a INNER JOIN user b ON a.appId = ";
	$SQL .= " b.appId and a.userId = b.userId WHERE $wheStr "; 
	$SQL .= " order by muLogSerno desc limit $start, $pagesize  ";
//echo $SQL;
	$result = mysqli_query($kiki_conn, $SQL);
	if( $result === false) {
		 die( print_r( mysqli_connect_error(), true) );
	} else {
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			$userId = $row["userId"];
			$userId = stripslashes($userId);			
			$userName = $row["userName"];
			$userName = stripslashes($userName);
			$sign1 = $row["sign1"];
			$sign1 = stripslashes($sign1);
if	($sign1 == "A") {
	$sign2 = "+";
} else {
	$sign2 = "-";
}
			$mileage = $row["mileage"];
	if ($mileage) {
		$mileage = number_format($mileage);
	}
			$chk = $row["chk"];
if	($chk == "A") {
	$ckName = "관리자 지급/회수";
} elseif	($chk == "G") {
	$ckName = "미니게임 당첨";
} else {
	$ckName = "마일리지 전환";
}
			$comments = $row["comments"];
			$comments = stripslashes($comments);
			$regiYHS = new DateTime($row["regiYHS"]);
			$regiYHS = date_format($regiYHS, "Y-m-d H:i");
		/*	if ($nowdate == $writeDate2) { // 오늘 등록한 글이라면
				$regiYHS = date_format($regiYHS, "H:i");
			} else {
				$regiYHS = date_format($regiYHS, "Y-m-d H:i");
			}	*/
$result_stmt .= "  <tr> ";
$result_stmt .= "   <td>$num</td> ";
$result_stmt .= "   <td>$userId</td> ";
$result_stmt .= "   <td>$userName</td> ";
$result_stmt .= "   <td>$ckName</td> ";
$result_stmt .= "   <td><span class='kiki_point'> $sign2 $mileage </span></td> ";
$result_stmt .= "   <td>$comments</td> ";
$result_stmt .= "   <td>$regiYHS</td> ";
$result_stmt .= "  </tr> ";
			$num = $num - 1;
		}
		mysqli_free_result( $result);
	}
}  //  if($totcnt == 0) { 
	mysqli_close($kiki_conn);		
$result_stmt .= " </tbody> ";
$result_stmt .= "</table>   ";

  if ($totcnt != 0) {	
		include "./kiki_page2INC.php";
	}
echo $result_stmt;		
	?>