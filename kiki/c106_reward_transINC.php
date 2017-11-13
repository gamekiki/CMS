 <? header("Content-Type: text/html; charset=UTF-8");
	include "./kiki_user.php";	

$result_stmt .= "<table class='kiki_tblT01' border='0' cellspacing='0' cellpadding='0'>";
$result_stmt .= " <colgroup> ";
$result_stmt .= "  <col width='10%'> ";
$result_stmt .= "  <col width=''> ";
$result_stmt .= "  <col width=''> ";
$result_stmt .= "  <col width='10%'> ";
$result_stmt .= "  <col width='15%'> ";
$result_stmt .= "  <col width='15%'> ";
$result_stmt .= "  <col width='15%'> ";
$result_stmt .= " </colgroup> ";
$result_stmt .= " <thead> ";
$result_stmt .= "  <tr> ";
$result_stmt .= "   <th><input type='checkbox' name='all_chk' value='Y' onclick='javascript:SetChecked_mile()'></th> ";
$result_stmt .= "   <th>아이디</th> ";
$result_stmt .= "   <th>이름</th> ";
$result_stmt .= "   <th>마일리지</th> ";
$result_stmt .= "   <th>신청일시</th> ";
$result_stmt .= "   <th>전환일시</th> ";
$result_stmt .= "   <th>상태</th> ";
$result_stmt .= "  </tr> ";
$result_stmt .= " </thead>  ";
$result_stmt .= " <tbody> ";
//$result_stmt .= "  <form name='frm_reward' id='frm_reward' method='post'> ";
$result_stmt .= "  <input type='hidden'name='appId' value='$kiki_appId'> ";

	$pagesize = 15 ;
	$page_cont = "mileage_trans";
	$cur_page = isset($_POST["cur_page"]) ? kiki_isnumb($_POST["cur_page"]) : 1;
	$schSel = isset($_POST["schSel"]) ? kiki_ischar($_POST["schSel"]) : 'a.userId';	
	$schStr = isset($_POST["schStr"]) ? kiki_ischar($_POST["schStr"]) : '';	

	$board = "mileage_UseLog";

	$wheStr = "a.appId = '$kiki_appId' and chk = 'T'";
	$wheStr .= " and ($schSel like '%". trim($schStr). "%')"; 


	$SQL = "Select count(muLogSerno) as totcnt from $board a INNER JOIN user b ";
	$SQL .= " ON a.appId = b.appId and a.userId = b.userId WHERE $wheStr ";
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
	$SQL = "SELECT muLogSerno, a.userId, userName, mileage, a.regiYHS  ";
	$SQL .= ", modiYHS, sign1 FROM $board a INNER JOIN user b ON a.appId = ";
	$SQL .= " b.appId and a.userId = b.userId WHERE $wheStr "; 
	$SQL .= " order by muLogSerno desc limit $start, $pagesize  ";
//echo $SQL;
	$result = mysqli_query($kiki_conn, $SQL);
	if( $result === false) {
		 die( print_r( mysqli_connect_error(), true) );
	} else {
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
	$modiYHS = "";
			$muLogSerno = $row["muLogSerno"];			
			$userId = $row["userId"];
			$userId = stripslashes($userId);			
			$userName = $row["userName"];
			$userName = stripslashes($userName);

			$mileage = $row["mileage"];
	if ($mileage) {
		$mileage = number_format($mileage);
	}

			$regiYHS = new DateTime($row["regiYHS"]);
			$regiYHS = date_format($regiYHS, "Y-m-d H:i");
			
			$sign1 = $row["sign1"];
			if ($sign1 == "M") {
				$modiYHS = new DateTime($row["modiYHS"]);
				$modiYHS = date_format($modiYHS, "Y-m-d H:i");
			}
$result_stmt .= "   ";
$result_stmt .= "  <tr> ";
  if ($sign1 == "M") {	// 전환 완료 되었다면
$result_stmt .= "   <td>$num</td> ";
  } else {
$result_stmt .= "   <td><span id='chk_$muLogSerno' style='display:'><input type='checkbox' name='muLogSerno[]' value='$muLogSerno'></span><span id='txt_$muLogSerno' style='display:none'>$num</span></td> ";
  }
$result_stmt .= "   <td>$userId</td> ";
$result_stmt .= "   <td>$userName</td> ";
$result_stmt .= "   <td> $mileage </td> ";
$result_stmt .= "   <td>$regiYHS</td> ";
$result_stmt .= "   <td id='modi_$muLogSerno'>$modiYHS</td> ";
  if ($sign1 == "M") {	// 전환 완료 되었다면
$result_stmt .= "   <td>전환 완료</td> ";
  } else {
$result_stmt .= "   <td id='btn_$muLogSerno'><a href='javascript:go_trans($muLogSerno)' class='kikibtn'>전환</a></td> ";
  }
$result_stmt .= "  </tr> ";
			$num = $num - 1;
		}
		mysqli_free_result( $result);
	}
}  //  if($totcnt == 0) { 
	mysqli_close($kiki_conn);	
//$result_stmt .= "  </form> ";	
$result_stmt .= " </tbody> ";
$result_stmt .= "</table>   ";

  if ($totcnt != 0) {	
		include "./kiki_page2INC.php";

$result_stmt .= "<div class='kikibtnarea'><a href='javascript:register()' class='kikibtn'>일괄전환</a></div> ";
  }
echo $result_stmt;		
	?>