<script src="https://code.jquery.com/jquery-2.1.0.min.js"></script>
<?	$sub_menu1 = "";	// 대시보드
	$sub_menu2 = "";	// 회원관리
	$sub_menu3 = "";	// 액티비티 관리
	$sub_menu4 = "";	// 업적관리
	$sub_menu5 = "";	// 뱃지관리
	$sub_menu6 = "";	//통계/분석
	$sub_menu7 = "";	//리워드 관리
	$sub_menu8 = "on";	//레벨설정	?>
	  <div class="kiki_content">
        <div class="kiki_conwrap">    
            <div class="kiki_box">
               <!-- <div class="tit_top bm20">Bookoa</div> -->
<?	include "./kiki/kiki_header.php";
	$board = "applevel";
	$wheStr = " (developerId = '$developerId' and appId = '$kiki_appId') ";	?>
              
               <div class="kiki_row"  style="margin-top:50px">
                 <p class="tit">레벨 설정</p>
                 <div class="con"> 
                   <div class="kiki_boardlist">
                     <!-- table :리워드 20개씩 출력 -->
                     <table summary="설정" class="kiki_tblT01 val_mid" cellspacing="0" cellpadding="0" border="0">
                           <colgroup>
                             <col width="15%">
                             <col width="15%">
                             <col width="20%">
                             <col width="">
                            </colgroup>
                             <thead>
                              <tr>
                                <th>이미지</th>
                                <th>레벨</th>
                                <th>레벨명</th>
                                <th>포인트구간</th>
                              </tr>
                             </thead> 
                             <tbody>
<?	$SQL = "Select count(levelId) as totcnt from $board where $wheStr ";
	$result_count = mysqli_query($kiki_conn, $SQL);
	if ( $result_count === false ) {
		die( print_r( mysqli_connect_error(), true));
		mysqli_close($kiki_conn);
	} else {
	  $row = mysqli_fetch_array($result_count, MYSQLI_ASSOC);
 	  $totcnt = $row["totcnt"];	
	  mysqli_free_result($result_count);
	}
	if (!$totcnt) {
		$totpage=1;
	}

	if($totcnt == 0) { ?>
                               <tr>
                                <td colspan="4" class="kiki_nodata">등록된 레벨이 없습니다.</td>	
                               </tr>
<? }  Else {	

	$SQL = "Select levelId, levelImg, levelName, minPoint, maxPoint ";
	$SQL .= " from $board where $wheStr order by LevelSerno ";
	$result = mysqli_query($kiki_conn, $SQL);
	if( $result === false) {
		 die( print_r( mysqli_connect_error(), true) );
	} else {
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		$levelId = $row["levelId"];	
		$levelImg = $row["levelImg"];
		$levelName = $row["levelName"];
		$levelName = stripslashes($levelName);
		$minPoint = $row["minPoint"];
		$maxPoint = $row["maxPoint"];	?>
                               <tr>
                                <td><img src="./kiki/img/icon_level.png" alt="level"></td>
                                <td><?=$levelId?></td>
                                <td><?=$levelName?></td>
                                <td><?=$minPoint?>~<?=$maxPoint?></td>
                               </tr>
<?	  } // while
  	mysqli_free_result( $result);
	}
}  //  if($totcnt == 0) {	
	mysqli_close($kiki_conn);	?>
                             </tbody>
                          </table>
                      <!-- // table :액티비티 --> 
                       <!-- kikibtnarea -->
                       <div class="kikibtnarea text_right">
                          <a href="javascript:modify_set();" class="kikibtn"> 수정 </a>
                       </div>
                       <!-- // kikibtnarea -->
           
                   </div><!-- //kiki_boradlist-->

                 </div> <!-- //.con -->
               </div> <!-- //.kiki_row -->
              
            </div> <!-- //kiki_box -->      
       </div>
      </div>

<script>

function modify_set(){
	 document.kiki_frm_sub2.method="post";
	 document.kiki_frm_sub2.action="./c107_set_modify.php";
     document.kiki_frm_sub2.submit();
}
</script>