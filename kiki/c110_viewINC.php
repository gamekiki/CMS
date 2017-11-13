  <script src="https://code.jquery.com/jquery-2.1.0.min.js"></script>
 <?	$sub_menu1 = "";	// 대시보드
	$sub_menu2 = "";	// 회원관리
	$sub_menu3 = "";	// 액티비티
	$sub_menu4 = "";	// 업적
	$sub_menu5 = "";	// 뱃지
	$sub_menu6 = "";	//통계/분석
	$sub_menu7 = "";	//리워드
	$sub_menu8 = "";	//레벨설정
	$sub_menu9 = "on";	//미니게임
	$sub_menu10 = "";	//상품추천		?>
	  <div class="kiki_content">
        <div class="kiki_conwrap">    
            <div class="kiki_box">
               <!-- <div class="tit_top bm20">Bookoa</div> -->
<?	include "./kiki/kiki_header.php";
	$cur_page = kiki_isnumb($_POST["cur_page"]);
	$mgId = kiki_ischar($_POST["mgId"]);	

	$SQL = "Select title, img, description, startYHS, endYHS ";
	$SQL .= ", mgRestrict from mg_main where delFlag = 'N' ";
	$SQL .= " and mgId = '$mgId'";
//echo $SQL;
	$result = mysqli_query($kiki_conn, $SQL);
	if( $result === false) {
//		 die( print_r( mysqli_connect_error(), true) );
	} else {
	  $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		$title = $row["title"];
		$title = stripslashes($title);
		$img = stripslashes($row["img"]);
		if(!$img) {
			$img = "./kiki/img/test_img_s.png.png";
		}
		$description = $row["description"];
		$description = strip_tags($description);
		$startYHS = $row["startYHS"];
		$endYHS = $row["endYHS"];
		$mgRestrict = $row["mgRestrict"];
		switch ($mgRestrict) {
			case "A" :
				$restrict = "단회";
				break;
			case "N" :
				$restrict = "매회";
				break;
			default :
				$restrict = "하루 ". $mgRestrict . "회";
				break;
		}
	}		?>
              
               <div class="kiki_row" style="margin-top:50px">
                 <p class="tit">미니게임 등록</p>
                 
                 <div class="con">
                   <div class="kiki_tbview">
                     <!-- table :액티비티 20개씩 출력 -->
                     <table class="tblT01_detail" border="0" cellspacing="0" cellpadding="0">
                         <colgroup>
                         <col width="15%">
                         <col width="">
                         </colgroup>
                       <thead>
                       </thead> 
                       <tbody>             
                          <tr>
                            <th>기간 </th>
                             <td><?=$startYHS?> ~ <?=$endYHS?></td>
                          </tr>
                          <tr>
                            <th>제목 </th>
                             <td><?=$title?></td>
                          </tr>
                          <tr>
                            <th>내용 </th>
                             <td><?=$description?></td>
                          </tr>
                          <tr>
                            <th>위젯 아이콘 </th>
                            <td><img src="<?=$img?>" class="icon_img" alt="룰렛이미지"></td>
                          </tr>
                           <tr>
                            <th>참여제한 </th>
                             <td><?=$restrict?></td>
                          </tr>
                         </tbody>
                      </table>
                     </div> <!-- kiki_tbview -->
                 </div> <!-- //.con -->
                 <div class="con clearfix"> 
                     <!-- table :액티비티 -->
                     <table class="kiki_tblT01" border="0" cellspacing="0" cellpadding="0">
                               <colgroup>
                                 <col width="">
                               <col width="">
                               <col width="">
                                 <col width="">
                                 <col width="">
    
                       </colgroup>
                         <thead>
                          <tr>
                            <th>경품 내용</th>
                            <th>표시 문구</th>
                            <th>당첨될 확률</th>
                            <th>당첨 제한수</th>
                            <th>비용</th>
                          </tr>
                         </thead> 
                         <tbody>
<?	$onePrice = 0;
	$totPrice = 0;
	$SQL = "Select mgSubSerno, rwdTitle, rwdType, rwdValue ";
	$SQL .= ", rwdProb, rwdRestrict, rwdPrice ";
	$SQL .= " from mg_sub where mgId = '$mgId' order by mgSubSerno  ";
//echo $SQL;
	$result = mysqli_query($kiki_conn, $SQL);
	if( $result === false) {
		 die( print_r( mysqli_connect_error(), true) );
	} else {
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		  $rwdRestrict = "";
		  $mgSubSerno = $row["mgSubSerno"];
		  $rwdTitle = $row["rwdTitle"];
		  $rwdTitle = stripslashes($rwdTitle);
		  $rwdType = $row["rwdType"];
		  $rwdValue = $row["rwdValue"];
	if ($rwdType == "G") {
		$rwdValue = "기프티콘 " . $rwdValue;
	} else {
		$rwdValue = "마일리지 " . $rwdValue;
	}
		  $rwdProb = $row["rwdProb"];
		  $rwdProb = $rwdProb * 100;
		  $rwdRestrict = $row["rwdRestrict"];
		  $rwdPrice = $row["rwdPrice"];	
		  if ($rwdRestrict and $rwdType == "G") {	// 당첨 제한 횟수 있는 기프티콘이라면	
			 $onePrice = $rwdRestrict * $rwdPrice;
			 $totPrice = $totPrice + $onePrice;
		  }	?>
                           <tr>
                            <td><?=$rwdValue?></td>
                            <td><?=$rwdTitle?> </td>
                            <td><?=$rwdProb?>%</td>
                            <td><?=$rwdRestrict?></td>
                            <td><? if ($onePrice) { ?> <?=number_format($onePrice)?>원 <? } ?></td>
                           </tr>
<?		} // while
  		mysqli_free_result( $result);
		}
	mysqli_close($kiki_conn);	?>
                         </tbody>
                     </table>  
                      <!-- // table :액티비티 -->   
                      <p>- 비용 총합 : <?=number_format($totPrice)?>원</p>              
                 </div>
                   <!-- btnarea -->
                     <div class="kikibtnarea text_right">
                       <a href="javascript:cdelete();" class="kikibtn gray2 fl_left"> 삭제 </a> <a href="javascript:open_priview('<?=$mgId?>');" class="kikibtn"> 미리보기 </a>  <a href="javascript:GoModify();" class="kikibtn"> 수정 </a>&nbsp;  <a href="javascript:GoList();" class="kikibtn"> 목록 </a>
                     </div>
                     <!-- // btnarea -->
                
               </div> <!-- // kiki_row -->
            </div> <!-- //kiki_box -->      
       </div>
      </div>
<script>
function cdelete(){
  if(confirm('정말 삭제하시겠습니까?'))	{
	document.list.action='./kiki/c109_delete.php';
    document.list.submit();
  }
}

function GoList(){
	document.list.action='./c109_minigame.php';
    document.list.submit();
}

function GoModify(){
	document.list.action='./c110_modify02.php';
    document.list.submit();
}

function open_priview(mgId) {
	URL = "http://gamebin.iptime.org/kshop/wheel/preview.html?mgId="+mgId
	window.open(URL,'priview',"left=0, top=0, width=817,height=900,scrollbars=yes,resizable=no");
}
</script>

<form name="list" method="post" action="./c109_minigame.php">
  <input type="hidden" name="cur_page" value="<?=$cur_page?>">
  <input type="hidden" name="mgId" value="<?=$mgId?>">
  <input type="hidden" name="appId" value="<?=$kiki_appId?>">
</form>