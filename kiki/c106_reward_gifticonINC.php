 <? header("Content-Type: text/html; charset=UTF-8");
	include "./kiki_user.php";	
//$kiki_appId = "app_Bx8BoU1g00000";
$result_stmt .= "<table class='kiki_tblT01' border='0' cellspacing='0' cellpadding='0'>";
$result_stmt .= " <colgroup> ";
$result_stmt .= "  <col width='8%'> ";
$result_stmt .= "  <col width=''> ";
$result_stmt .= "  <col width='15%'> ";
$result_stmt .= "  <col width=''> ";
$result_stmt .= "  <col width='15%'> ";
$result_stmt .= "  <col width='15%'> ";
$result_stmt .= "  <col width='10%'> ";
$result_stmt .= " </colgroup> ";
$result_stmt .= " <thead> ";
$result_stmt .= "  <tr> ";
$result_stmt .= "   <th><input type='checkbox' name='all_chk' value='Y' onclick='javascript:SetChecked_gift()'></th> ";
$result_stmt .= "   <th>아이디</th> ";
$result_stmt .= "   <th>휴대폰번호</th> ";
$result_stmt .= "   <th>기프티콘</th> ";
$result_stmt .= "   <th>신청일시</th> ";
$result_stmt .= "   <th>발급일시</th> ";
$result_stmt .= "   <th>상태</th> ";
$result_stmt .= "  </tr> ";
$result_stmt .= " </thead>  ";
$result_stmt .= " <tbody> ";
$result_stmt .= "  <input type='hidden'name='appId' value='$kiki_appId'> ";

	$pagesize = 15 ;
	$page_cont = "gifticon_list";
	$cur_page = isset($_POST["cur_page"]) ? kiki_isnumb($_POST["cur_page"]) : 1;
	$schSel = isset($_POST["schSel"]) ? kiki_ischar($_POST["schSel"]) : 'selectedUserId';	
	$schStr = isset($_POST["schStr"]) ? kiki_ischar($_POST["schStr"]) : '';	
	$board = "mg_st";
if ($schSel == "UserId") {
	$schSel = "selectedUserId"; 
}
	$wheStr = "a.appId = '$kiki_appId' ";
	$wheStr .= " and ($schSel like '%". trim($schStr). "%')"; 

	$SQL = "Select count(mgStSerno) as totcnt from mg_main a INNER JOIN mg_sub b ";
	$SQL .= " ON a.mgId = b.mgId INNER JOIN mg_st c ON a.mgId = c.mgId AND ";
	$SQL .= " b.rwdId = c.rwdId WHERE $wheStr AND (c.usedYHS IS NOT NULL OR c.usedYHS != '') ";
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
	$SQL = "SELECT mgStSerno, selectedUserId, rwdValue, usedPhone, c.usedYHS  ";
	$SQL .= ", compYHS  FROM mg_main a INNER JOIN mg_sub b ";
	$SQL .= " ON a.mgId = b.mgId INNER JOIN mg_st c ON a.mgId = c.mgId AND ";
	$SQL .= " b.rwdId = c.rwdId WHERE $wheStr AND (c.usedYHS IS NOT NULL OR c.usedYHS != '') "; 
	$SQL .= " order by mgStSerno desc limit $start, $pagesize  ";
//echo $SQL;
	$result = mysqli_query($kiki_conn, $SQL);
	if( $result === false) {
		 die( print_r( mysqli_connect_error(), true) );
	} else {
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
	$compYHS = "";
			$mgStSerno = $row["mgStSerno"];			
			$userId = $row["selectedUserId"];
			$userId = stripslashes($userId);
			$rwdValue = $row["rwdValue"];
			$rwdValue = stripslashes($rwdValue);
			$usedPhone = $row["usedPhone"];
			$usedPhone = stripslashes($usedPhone);

			$usedYHS = $row["usedYHS"];
			if ($usedYHS) {
				$usedYHS = new DateTime($usedYHS);
				$usedYHS = date_format($usedYHS, "Y-m-d H:i");
			}
			
			$compYHS = $row["compYHS"];
//	echo "comp = $compYHS <BR>";	
			if ($compYHS) {
				$compYHS = new DateTime($compYHS);
				$compYHS = date_format($compYHS, "Y-m-d H:i");
			}
$result_stmt .= "   ";
$result_stmt .= "  <tr> ";
  if ($compYHS) {	// 발급 완료 되었다면
$result_stmt .= "   <td>$num</td> ";
  } else {
$result_stmt .= "   <td><span id='gchk_$mgStSerno' style='display:'><input type='checkbox' name='mgStSerno[]' value='$mgStSerno'></span><span id='gtxt_$mgStSerno' style='display:none'>$num</span></td> ";
  }
$result_stmt .= "   <td>$userId</td> ";
$result_stmt .= "   <td>$usedPhone</td> ";
$result_stmt .= "   <td> $rwdValue </td> ";
$result_stmt .= "   <td>$usedYHS</td> ";
$result_stmt .= "   <td id='gmodi_$mgStSerno'>$compYHS</td> ";
  if ($compYHS) {	// 발급 완료 되었다면
$result_stmt .= "   <td>발급 완료</td> ";
  } else {
$result_stmt .= "   <td id='gbtn_$mgStSerno'><a href='javascript:go_gifticon($mgStSerno)' class='kikibtn'>발급</a></td> ";
  }
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

$result_stmt .= "<div class='kikibtnarea'><a href='javascript:gifticon_register()' class='kikibtn'>일괄발급</a></div> ";
  }

echo $result_stmt;		
	?>