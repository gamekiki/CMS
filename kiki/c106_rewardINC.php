<?	$sub_menu1 = "";	// 대시보드
	$sub_menu2 = "";	// 회원관리
	$sub_menu3 = "";	// 액티비티 관리
	$sub_menu4 = "";	// 업적관리
	$sub_menu5 = "";	// 뱃지관리
	$sub_menu6 = "";	//통계/분석
	$sub_menu7 = "on";	//리워드 관리
	$sub_menu8 = "";	//레벨설정	?> 
	  <div class="kiki_content">
        <div class="kiki_conwrap">    
            <div class="kiki_box">
               <!-- <div class="tit_top bm20">Bookoa</div> -->
<?	include "./kiki/kiki_header.php";		?>

			   <div class="kiki_row"  style="margin-top:50px">
                 <p class="tit">리워드 관리</p>
                 <div class="con"> 
                   <div class="kiki_boardlist">
                     <!-- table :리워드 20개씩 출력 -->
                     <table class="kiki_tblT01" cellspacing="0" cellpadding="0" border="0">
                               <colgroup>
                                 <col width="10%">
                                 <col width="20%">
                                 <col width="">
                                 <col width="10%">
                                 <col width="10%">
                                 <col width="10%">
                                 <col width="20%">
                                </colgroup>
                         <thead>
                          <tr>
                            <th>No</th>
                            <th>아이디</th>
                            <th>이름</th>
                            <th>액티비티</th>
                            <th>포인트</th>
                            <th>사유</th>
                            <th>지급/회수일시</th>
                          </tr>
                         </thead> 
                         <tbody>
<?	$pagesize = 15 ;
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

if($totcnt == 0) {	?>
                           <tr>
                            <td colspan="7" class="kiki_nodata">자료가 없습니다.</td>
                           </tr>
<?}  Else {
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
			$point = stripslashes($point);
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
			$writeDate2 = date_format($writeDate, "Y-m-d");
			if ($nowdate == $writeDate2) { // 오늘 등록한 글이라면
				$writeDate = date_format($writeDate, "H:i");
			} else {
				$writeDate = date_format($writeDate, "Y-m-d H:i");
			}	?>
                           <tr>
                            <td><?=$num?></td>
                            <td><?=$userId?></td>
                            <td><?=$userName?></td>
                            <td><?=$actname?></td>
                            <td><span class="kiki_point"> <?=$sign1?> <?=$point?>pts </span></td>
                            <td><?=$comments?></td>
                            <td> <?=$writeDate?></td>
                           </tr>
<?			$num = $num - 1;
		}
		mysqli_free_result( $result);
	}
}  //  if($totcnt == 0) { 
	mysqli_close($conn);		?>
                         </tbody>
                      </table>  
                      <!-- // table :액티비티 --> 
<?  if ($totcnt != 0) {	
		include "./kiki/kiki_pageINC.php";
	}	?>
                   </div><!-- //kiki_boradlist-->
                 </div> <!-- //.con -->
               </div> <!-- //.kiki_row -->
            </div> <!-- //kiki_box -->      
       </div>
      </div>

<script>
function kiki_list(pg){
     document.kiki_frm_sub.cur_page.value = pg;
	 document.kiki_frm_sub.method="post";
	 document.kiki_frm_sub.action="./c106_reward.php";
     document.kiki_frm_sub.submit();
}
</script>


<form name="kiki_frm_sub" method="post">
  <input type="hidden" name="cur_page" value="<?=$cur_page?>">
</form>