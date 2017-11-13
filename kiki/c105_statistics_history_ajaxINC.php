 <? header("Content-Type: text/html; charset=UTF-8");
	include "./kiki_user.php";	

//$kiki_appId = "app_Bx8BoU1g00000";
$result_stmt .= "<table class='kiki_tblT01'>";
$result_stmt .= " <colgroup> ";
$result_stmt .= "  <col width='10%'> ";
$result_stmt .= "  <col width=''> ";
$result_stmt .= "  <col width=''> ";
$result_stmt .= "  <col width=''> ";
$result_stmt .= "  <col width=''> ";
$result_stmt .= " </colgroup> ";
$result_stmt .= " <thead> ";
$result_stmt .= "  <tr> ";
$result_stmt .= "   <th>No</th> ";
$result_stmt .= "   <th>아이디</th> ";
$result_stmt .= "   <th>내용</th> ";
$result_stmt .= "   <th>일시</th> ";
$result_stmt .= "   <th>상태</th> ";
$result_stmt .= "  </tr> ";
$result_stmt .= " </thead>  ";
$result_stmt .= " <tbody> ";

	$pagesize = 10 ;
	$page_cont = "history_inc";
	$cur_page = isset($_POST["cur_page"]) ? kiki_isnumb($_POST["cur_page"]) : 1;
	$schSel = isset($_POST["schSel"]) ? kiki_ischar($_POST["schSel"]) : 'c.regYHS';	
	$schStr = isset($_POST["schStr"]) ? kiki_ischar($_POST["schStr"]) : '';	

//$schSel = "c.regYHS";
//$schStr = "2017-10-27";
//$cur_page = 13;
	$wheStr = "a.appId = '$kiki_appId' ";
if ($schStr) {
	$wheStr .= " and ($schSel like '%". trim($schStr). "%')"; 
}
	$SQL = "Select count(mgLogSerno) as totcnt from mg_main a INNER JOIN mg_sub b ";
	$SQL .= " ON a.mgId = b.mgId INNER JOIN mg_log c ON a.mgId = c.mgId AND ";
	$SQL .= " b.rwdId = c.rwdId WHERE $wheStr ";
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
//echo "tot =$totcnt / $totpage <BR>";
  if($totcnt == 0) {	
$result_stmt .= "  <tr> ";
$result_stmt .= "   <td colspan='5' class='kiki_nodata'>검색된 결과가 없습니다.</td> ";
$result_stmt .= "  </tr> ";
  }  Else {
		$start = ($cur_page-1) * $pagesize;
		$num = $totcnt - (($cur_page - 1) * $pagesize);
		$nowdate = date('Y-m-d');
		$difftime2 = date_create($nowdate);
	$SQL = "SELECT userId, rwdValue, c.regYHS, rwdType, CASE ";
	$SQL .= " WHEN  rwdType = 'P' THEN '' ";
	$SQL .= " ELSE (select usedYHS from mg_st where c.mgId = mgId ";
	$SQL .= " and c.rwdId = rwdId and c.userId = selectedUserId AND (usedYHS IS NOT NULL OR usedYHS != '') limit 0,1) ";
	$SQL .= " END as usedYHS from mg_main a ";
	$SQL .= " INNER JOIN mg_sub b ON a.mgId = b.mgId INNER JOIN mg_log c ";
	$SQL .= " ON a.mgId = c.mgId AND b.rwdId = c.rwdId WHERE $wheStr "; 
	$SQL .= " order by mgLogSerno desc limit $start, $pagesize  ";
//echo $SQL;
	$result = mysqli_query($kiki_conn, $SQL);
	if( $result === false) {
		 die( print_r( mysqli_connect_error(), true) );
	} else {
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
	$usedYHS = "";
	$chk = "";
	$chkdate = "";
			$userId = $row["userId"];
			$userId = stripslashes($userId);			
			$rwdValue = $row["rwdValue"];
			$rwdValue = stripslashes($rwdValue);

			$rwdType = $row["rwdType"];
			$rwdType = stripslashes($rwdType);

			$writeDate = new DateTime($row["regYHS"]);
			$writeDay = date_format($writeDate, "Y-m-d");
			$writeDate = date_format($writeDate, "Y-m-d H:i");		

	if ($rwdType == "P") {
		$rwdValue = "마일리지 ". $rwdValue;
	} else {
		$rwdValue = "기프티콘 ". $rwdValue;
	}
			$usedYHS = $row["usedYHS"];
			if (!$usedYHS and $rwdType == "G") {	// 기프티콘 당첨 후 30일 이내 발급 신청하지 않았다면
				$difftime1 = date_create($writeDay); // 타겟 날짜를 지정합니다.
	
				$interval = date_diff($difftime2, $difftime1);
//				$interval = date_diff("2017-10-31", "2017-10-21");
				$chkdate = $interval->days;
				if ($chkdate > 30) {
					$chk = "미신청";
				}
			}
//echo "chkda = $chkdate ";
		/*	if ($nowdate == $writeDate2) { // 오늘 등록한 글이라면
				$writeDate = date_format($writeDate, "H:i");
			} else {
				$writeDate = date_format($writeDate, "Y-m-d H:i");
			}	*/
$result_stmt .= "  <tr> ";
$result_stmt .= "   <td>$num</td> ";
$result_stmt .= "   <td>$userId</td> ";
$result_stmt .= "   <td>$rwdValue</td> ";
$result_stmt .= "   <td>$writeDate</td> ";
$result_stmt .= "   <td> $chk</td> ";
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