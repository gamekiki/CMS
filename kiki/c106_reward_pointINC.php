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
$result_stmt .= "   <th>액티비티</th> ";
$result_stmt .= "   <th>포인트</th> ";
$result_stmt .= "   <th>사유</th> ";
$result_stmt .= "   <th>지급/회수일시</th> ";
$result_stmt .= "  </tr> ";
$result_stmt .= " </thead>  ";
$result_stmt .= " <tbody> ";

	$pagesize = 15 ;
	$page_cont = "point_list";
	$cur_page = isset($_POST["cur_page"]) ? kiki_isnumb($_POST["cur_page"]) : 1;
	$board = "user_reward_log";

	$wheStr = "a.appId = '$kiki_appId'";
	$SQL = "Select count(userSerno) as totcnt from $board a INNER JOIN user b ";
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
	$SQL = "SELECT a.userId, userName, sign1, point, CASE ";
	$SQL .= " WHEN  actId = '$adm_activity' THEN '관리자' ";
	$SQL .= " ELSE (select actname from activity where a.actId = actId ) ";
	$SQL .= " END as actname  ";
	$SQL .= ", comments, writeDate FROM $board a INNER JOIN user b ON a.appId = ";
	$SQL .= " b.appId and a.userId = b.userId WHERE $wheStr "; 
	$SQL .= " order by rewLogSerno desc limit $start, $pagesize  ";
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
			$point = $row["point"];
	if ($point) {
		$point = number_format($point);
	}
			$actname = $row["actname"];
			$actname = stripslashes($actname);
	if ($sign1 == "-" and $actname == "관리자") {
		$actname = "관리자 회수";
	} elseif ($sign1 == "+" and $actname == "관리자") {
		$actname = "관리자 지급";
	}
			$comments = $row["comments"];
			$comments = stripslashes($comments);
			$writeDate = new DateTime($row["writeDate"]);
			$writeDate = date_format($writeDate, "Y-m-d H:i");
		/*	if ($nowdate == $writeDate2) { // 오늘 등록한 글이라면
				$writeDate = date_format($writeDate, "H:i");
			} else {
				$writeDate = date_format($writeDate, "Y-m-d H:i");
			}	*/
$result_stmt .= "  <tr> ";
$result_stmt .= "   <td>$num</td> ";
$result_stmt .= "   <td>$userId</td> ";
$result_stmt .= "   <td>$userName</td> ";
$result_stmt .= "   <td>$actname</td> ";
$result_stmt .= "   <td><span class='kiki_point'> $sign1 $point pts </span></td> ";
$result_stmt .= "   <td>$comments</td> ";
$result_stmt .= "   <td>$writeDate</td> ";
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