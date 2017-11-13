<?	$sub_menu1 = "";	// 대시보드
	$sub_menu2 = "";	// 회원관리
	$sub_menu3 = "";	// 액티비티 관리
	$sub_menu4 = "on";	// 업적관리
	$sub_menu5 = "";	// 뱃지관리
	$sub_menu6 = "";	//통계/분석
	$sub_menu7 = "";	//리워드 관리
	$sub_menu8 = "";	//레벨설정
	$sub_menu9 = "";	//미니게임
	$sub_menu10 = "";	//상품추천		?>
	  <div class="kiki_content">
        <div class="kiki_conwrap">    
            <div class="kiki_box">
               <!-- <div class="tit_top bm20">Bookoa</div> -->
<?	include "./kiki/kiki_header.php";	

	$cur_page = kiki_ischar($_POST["cur_page"]);
	$achiId = kiki_ischar($_POST["achiId"]);
	$achiName = kiki_ischar($_POST["achiName"]);
	
	$pagesize = 20 ;
	$cur_page2 = isset($_POST["cur_page2"]) ? kiki_isnumb($_POST["cur_page2"]) : 1;

	$wheStr = "achiId = '$achiId' and a.appId = '$kiki_appId' ";
	$SQL = "Select count(achiUserSerno) as totcnt from achievement_user_comp a ";
	$SQL .= " INNER JOIN user b ON a.userId = b.userId WHERE $wheStr ";
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
	}	?>
              
               <div class="kiki_row"  style="margin-top:50px">
                 <p class="tit"><?=$achiName?> 업적 현황</p>
                 <div class="con"> 
                   <div class="kiki_boardlist">
                     <!-- table :액티비티 20개씩 출력 -->
                     <table class="kiki_tblT01" cellspacing="0" cellpadding="0" border="0">
                               <colgroup>
                                 <col width="10%">
                                 <col width="">
                                 <col width="10%">
                                 <col width="20%">
                                 <col width="20%">
                                </colgroup>
                         <thead>
                          <tr>
                            <th>No</th>
                            <th>이름</th>
                            <th>레벨</th>
                            <th>업적이름</th>
                            <th>일시</th>
                          </tr>
                         </thead> 
                         <tbody>
<?	if ($totcnt == 0) {	// 자료가 없다면	?>
                           <tr>
                            <td colspan='5' class='kiki_nodata'>자료가 없습니다.</td>
                           </tr>
<?	} else {
		$start = ($cur_page2-1) * $pagesize;
		$num = $totcnt;
		$SQL = "select achiId, userName, (SELECT levelId FROM appLevel WHERE appId =  ";
		$SQL .= " '$kiki_appId' AND b.UserPoint >= minPoint AND b.Userpoint <  maxPoint )  ";
		$SQL .= "as levelId, compDate from achievement_user_comp a ";
		$SQL .= " INNER JOIN user b ON a.userId = b.userId WHERE  $wheStr ";
		$SQL .= " ORDER BY achiUserSerno desc limit $start, $pagesize ";
//	echo $SQL;
		$result_Q = mysqli_query($kiki_conn, $SQL);
		if( $result_Q === false) {
			 die( print_r( mysqli_connect_error(), true) );
		} else {
			while($row = mysqli_fetch_array($result_Q, MYSQLI_ASSOC)) {
			   $achiId = $row["achiId"];
			   $achiId = stripslashes($achiId);
			   $userName = $row["userName"];
			   $userName = stripslashes($userName);
			   $levelId = $row["levelId"];
			   $levelId = stripslashes($levelId);
			   $compDate = $row["compDate"];
			   $compDate = stripslashes($compDate);?>
                           <tr>
                            <td><?=$num?></td>
                            <td><?=$userName?></td>
                            <td><?=$levelId?></td>
                            <td><?=$achiName?></td>
                            <td> <?=$compDate?></td>
                           </tr>
<?		$num = $num - 1;
		} // row while
  	mysqli_free_result( $result_Q);
		$rewSerno = "";
	}
}  // if($totcnt == 0) {
	mysqli_close($kiki_conn);	?>
                         </tbody>
                      </table>  
                      <!-- // table :액티비티 --> 
<?  if ($totcnt != 0) {	
		include "./kiki/kiki_page2INC.php";
	}	?>
                   </div>

                 </div> <!-- //.con -->
               </div> <!-- //.kiki_row -->
              
            </div> <!-- //kiki_box -->      
       </div>
      </div>