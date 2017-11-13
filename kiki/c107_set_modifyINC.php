
<?	$sub_menu1 = "";	// 대시보드
	$sub_menu2 = "";	// 회원관리
	$sub_menu3 = "";	// 액티비티 관리
	$sub_menu4 = "";	// 업적관리
	$sub_menu5 = "";	// 뱃지관리
	$sub_menu6 = "";	//통계/분석
	$sub_menu7 = "";	//리워드 관리
	$sub_menu8 = "on";	//레벨설정	
	$sub_menu9 = "";	//미니게임
	$sub_menu10 = "";	//상품추천		?>
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
<form action="./kiki/c107_set_modify.php" method="POST" name="kiki_frm">
<?	$i = 1;
	$SQL = " Select LevelSerno, levelImg, levelId, levelName, minPoint, maxPoint ";
	$SQL .= " from $board where $wheStr order by LevelSerno  ";
	$result = mysqli_query($kiki_conn, $SQL);
	if( $result === false) {
		 die( print_r( mysqli_connect_error(), true) );
	} else {
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		$LevelSerno = $row["LevelSerno"];			
		$levelId = $row["levelId"];
		$levelImg = $row["levelImg"];
		$levelName = $row["levelName"];
		$levelName = stripslashes($levelName);
		$minPoint = $row["minPoint"];
		$maxPoint = $row["maxPoint"]; ?>
                               <tr>
<input type="hidden" id="LevelSerno<?=$i?>" name="LevelSerno[]" value="<?=$LevelSerno?>">
                                <td><img src="./kiki/img/icon_level.png" alt="level"></td>
                                <td><?=$levelId?></td>
                                <td><?=$levelName?></td>
                                <td><input name="minPoint[]" value="<?=$minPoint?>" maxlength="5"  size="15" type="text"> ~ <input  name="maxPoint[]" value="<?=$maxPoint?>" maxlength="5" size="15" type="text"></td>
                               </tr>
<?			$i = $i + 1;
		} // while
  	mysqli_free_result( $result);
	}
	mysqli_close($kiki_conn);
	$i = $i - 1;	?>
  <input type="hidden" name="board" value="<?=$board?>">
  <input type="hidden" name="appId" value="<?=$kiki_appId?>">
</form>
                             </tbody>
                          </table>
                      <!-- // table :액티비티 --> 
                       <!-- kikibtnarea -->
                       <div class="kikibtnarea text_right">
                          <a href="./c107_set.php" class="kikibtn"> 목록 </a> <a href="javascript:document.kiki_frm.submit();" class="kikibtn"> 수정 </a>
                       </div>
                       <!-- // kikibtnarea -->
           
                   </div><!-- //kiki_boradlist-->

                 </div> <!-- //.con -->
               </div> <!-- //.kiki_row -->
              
            </div> <!-- //kiki_box -->      
       </div>
      </div>