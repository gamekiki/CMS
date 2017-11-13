 <script src="https://code.jquery.com/jquery-2.1.0.min.js"></script>
 <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
 <link rel="stylesheet" href="./kiki/css/jquery.switchButton.css">
<script src="./kiki/js/jquery.switchButton.js"></script>

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
<script>
/*$(function() {
  $(".booky_sw input").switchButton({
	width: 68,
	height: 30,
	button_width: 34
  });
}) */
	var listedDone = false;

$(function() {
  $(".booky_sw input").each(function(){
	var checked = ($(this).attr("actYN")=="Y")? true : false;
	  $(this).switchButton({
		checked : checked,
		width: 68,
		height: 30,
		button_width: 34,
		checkCallback : function(){
	if(listedDone){
		  check = $(this).prop("checked");
		if (check == true) {
		  if(confirm('정말 중단하시겠습니까?'))	{
			return true;
		  } else {
			return false;
		  }
		} else {
			return true;
		}
	} else {
		return true;
	}
			},	
		off_callback : function(){modifyActYN(this.element[0], "N", this.element[0].getAttribute("mgId"))},
		on_callback : function(){modifyActYN(this.element[0], "Y", this.element[0].getAttribute("mgId"))},		
	  });
  }).promise().done(function(){
	listedDone= true;  
  });
}) 

function modifyActYN(elem,actYN,mgId){
//console.log("el="+elem + ", act = "+actYN + ", mgId = "+mgId+ ", listedDone = "+listedDone);
	if(!listedDone){
		return
	}
//console.log ("abc")
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: "./kiki/c109_actYNAjax.php?callback=?",
		data: {
			"actYN" : actYN,
			"mgId" : mgId
		},
		success: function (data) {
//console.log("data="+data);
			if(data.prog == "true"){
				//listHotTag();
			}
		},
		error: function (request, status, error) {
			console.log('code: '+request.status+"\n"+'message: '+request.responseText+"\n"+'error: '+error);
		}
	});		
}
</script>

	  <div class="kiki_content">
        <div class="kiki_conwrap">    
            <div class="kiki_box">
               <!-- <div class="tit_top bm20">Bookoa</div> -->
<?	include "./kiki/kiki_header.php";
	$cur_page = kiki_isnumb($_POST["cur_page"]);
	if (!$cur_page) {
	   $cur_page = 1;
	}		?>
              
               <div class="kiki_row" style="margin-top:50px">
                 <p class="tit">비용 현황</p>
<?	$wheStr = " (delFlag = 'N' and appId = '$kiki_appId') ";
	$nowMonth = date("m");
	$nowYM = date("Y-m");
// 	해당 월 기프티콘 소요 비용
$giftPrice = 0;	// 기프티콘 총 비용
$milePrice = 0;	// 마일리지 총비용
	$SQL = "Select count(mgStSerno) as mgcnt, SUM(rwdPrice) as giftPrice from mg_sub a ";
	$SQL .= " INNER JOIN mg_st b ON a.mgId = b.mgId and a.rwdId = b.rwdId INNER JOIN";
	$SQL .= " mg_main c ON a.mgId = c.mgId where $wheStr and LEFT(compYHS,7) = '$nowYM' ";
	$SQL .= " AND (compYHS IS NOT NULL OR compYHS != '')  GROUP BY appId ";
//echo $SQL;
	$result_count = mysqli_query($kiki_conn, $SQL);
	if ( $result_count === false ) {
//		die( print_r( mysqli_connect_error(), true));
		mysqli_close($kiki_conn);
	} else {
	  $row = mysqli_fetch_array($result_count, MYSQLI_ASSOC);
 	  $mgcnt = $row["mgcnt"];	
 	  $giftPrice = $row["giftPrice"];	
	  mysqli_free_result($result_count);
	}
// 	해당 월 기프티콘 소요 비용 끝...  	해당 월 마일리지 소요 비용 시작 ...
	$SQL = "Select count(mgLogSerno) as mgcnt, SUM(rwdValue) as milePrice from ";
	$SQL .= " mg_sub a INNER JOIN mg_log b ON a.mgId = b.mgId and a.rwdId = ";
	$SQL .= " b.rwdId INNER JOIN mg_main c ON a.mgId = c.mgId where $wheStr and ";
	$SQL .= " LEFT(b.regYHS,7) = '$nowYM' and rwdType = 'P' GROUP BY appId ";
//echo $SQL;
	$result_count = mysqli_query($kiki_conn, $SQL);
	if ( $result_count === false ) {
//		die( print_r( mysqli_connect_error(), true));
		mysqli_close($kiki_conn);
	} else {
	  $row = mysqli_fetch_array($result_count, MYSQLI_ASSOC);
 	  $mgcnt = $row["mgcnt"];	
 	  $milePrice = $row["milePrice"];	

	  mysqli_free_result($result_count);
	}
// 	해당 월 마일리지 소요 비용 끝...
	$totPrice = $giftPrice + $milePrice;

	if ($milePrice) {
		$milePrice = number_format($milePrice);
	}
	if ($giftPrice) {
		$giftPrice = number_format($giftPrice);
	}
	if ($totPrice) {
		$totPrice = number_format($totPrice);
	}

	$SQL = "Select mgId, title, img, startYHS, endYHS, mgRestrict ";
	$SQL .= " from mg_main where actYN = 'Y' and $wheStr ";
	$SQL .= " order by mgMainSerno desc limit 0, 1  ";
//echo $SQL;
	$result = mysqli_query($kiki_conn, $SQL);
	if( $result === false) {
		 die( print_r( mysqli_connect_error(), true) );
	} else {
	  $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		$mgId = $row["mgId"];
		$title = $row["title"];
		$title = stripslashes($title);
		if (strlen($title) > 32) {
			$title = utf8_strcut($title,32); 
		}
		$img = stripslashes($row["img"]);
		if(!$img) {
			$img = "./kiki/img/test_img.png";
		}
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
		 mysqli_free_result($result);
	}		?>
                 <div class="con">
                    <p class="info"> 
                    - <?=$nowMonth?>월 소요된 총 비용 : <?=$totPrice?>원  <br>
                    - 기프티콘 총 비용 : <?=$giftPrice?>원 <br>
                    - 마일리지 총 비용 : <?=$milePrice?>원
                     </p>
                
                 </div> <!-- //.con -->
               </div> <!-- //.kiki_row -->
               <div class="kiki_row tm20">
                 <p class="tit">현재 진행중인 미니게임</p>
<? if ($mgId) { // 등록된 게임이 있다면	?>
				 <div class="con">
                 <div>
                  <div class="fl_left" style="margin:0 25px">
                  <img src="<?=$img?>"/>
                   <!-- switch btn -->
                      <div class="swbtn_wrapper" style="margin: 10px auto;">
                        <div class="booky_sw slider demo ">
                          <input type="checkbox" value="<?=$actYN?>" mgId="<?=$mgId?>" actYN="Y" checked>
                        </div>
                      </div>
                     <!-- // switch btn -->
                  </div>
                  <div class="p_txtarea" style="margin-top: 12px;">
                   <p> <?=$title?> (<?=$mgId?>)</p>
                   <p> 조건 : <?=$restrict?> </p>
                   <p> 기간 : <?=$startYHS?> ~ <?=$endYHS?> </p>
                   
                   <div class="btnarea mgt20">
                     <div class="fl_left">
                      <a href="javascript:GoStatic('<?=$mgId?>');" class="kikibtn">통 계</a> &nbsp;
                      <a href="javascript:GoModify('<?=$mgId?>');" class="kikibtn red">수 정</a> <!-- &nbsp; <a href="javascript:open_priview('<?=$mgId?>');" class="kikibtn gray2"> 미리보기</a> -->
                     </div> 
                   </div>
                  </div>
                 </div>
<?	} else { // 진행중인 게임이 없다면	?>
                 <!-- 진행중인 게임이 없을 경우 -->
                 <div class="no_game">
                 - 현제 진행중인 게임이 없습니다.
                 </div>  
                 <!-- // 진행중인 게임이 없을 경우 -->
<?	}	?>
                 </div> <!-- // con -->
<? if ($mgId) { // 등록된 게임이 있다면	?>
                 <div class="con clearfix"> 
                     <!-- table :액티비티 -->
                     <table class="kiki_tblT01" cellspacing="0" cellpadding="0" border="0">
                               <colgroup>
                                 <col width="">
                                 <col width="20%">
                                 <col width="20%">
    
                                </colgroup>
                         <thead>
                          <tr>
                            <th>표시문구</th>
                            <th>내용</th>
                            <th>확률</th>
                            <th>당첨제한</th>
                          </tr>
                         </thead> 
                         <tbody>
<?	$SQL = "Select rwdTitle, rwdType, rwdValue, rwdProb, rwdRestrict  ";
	$SQL .= " from mg_sub a where mgId = '$mgId' ";
	$SQL .= " order by mgSubSerno  ";
//echo $SQL;
	$result = mysqli_query($kiki_conn, $SQL);
	if( $result === false) {
		 die( print_r( mysqli_connect_error(), true) );
	} else {
	  while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		$Restrict = "";
		$rwdTitle = $row["rwdTitle"];
		$rwdTitle = stripslashes($rwdTitle);
		if (strlen($rwdTitle) > 20) {
			$rwdTitle = utf8_strcut($rwdTitle,20); 
		}
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
		if ($rwdRestrict) {
		  switch ($rwdRestrict) {
			case "A" :
				$Restrict = "단회";
				break;
			case "N" :
				$Restrict = "매회";
				break;
			default :
				$Restrict = "하루 ". $rwdRestrict . "회";
				break;
		  }	
		}	?>
                           <tr>
                            <td><?=$rwdTitle?></td>
                            <td><?=$rwdValue?></td>
                            <td><?=$rwdProb?>%</td>
                            <td><?=$Restrict?></td>
                           </tr>
<?		  } // while
  		mysqli_free_result( $result);
	}	?>
                         </tbody>
                      </table>  
                      <!-- // table :액티비티 -->                 
                 </div> <!-- //..con -->
<?	}	// if ($mgId) { // 등록된 게임이 있다면 ?>
               </div> <!-- //.kiki_row -->
               <div class="kiki_row tm20">
                 <p class="tit">저장된 미니 게임</p>
                 <div class="con clearfix"> 
                     <!-- table :액티비티 -->
                     <table class="kiki_tblT01" cellspacing="0" cellpadding="0" border="0">
                               <colgroup>
                                 <col width="">
                                 <col width="20%">
                                 <col width="20%">
    
                                </colgroup>
                         <thead>
                          <tr>
                            <th>아이콘</th>
                            <th>제목</th>
                            <th>내용</th>
                            <th>기간</th>
                            <th>on/off</th>
                            <th>통계</th>
                          </tr>
                         </thead> 
                         <tbody>
<?	$pagesize = 10 ;

	$SQL = "Select count(mgMainSerno) as totcnt from mg_main where $wheStr ";
	$SQL .= " and mgId != '$mgId' ";
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
	if (!$totcnt) {
		$totpage=1;
	}
	if($totcnt == 0) {	?>
						   <tr>
						     <td colspan="6"><div class='no_data'>등록된 게임이 없습니다.</div></td>
						  </tr>
<?	}  Else {
		$start = ($cur_page-1) * $pagesize;
		$nowdate = date("Y-m-d");

		$SQL = "Select mgId, title, img, description, startYHS, endYHS ";
		$SQL .= ", actYN from mg_main where $wheStr and mgId != '$mgId' ";
		$SQL .= " order by mgMainSerno desc ";
		$SQL .= " limit $start, $pagesize ";
		$result = mysqli_query($kiki_conn, $SQL);
		if( $result === false) {
//			 die( print_r( mysqli_connect_error(), true) );
		} else {
		  while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			$mgId = $row["mgId"];
			$title = $row["title"];
			$title = stripslashes($title);
			if (strlen($title) > 12) {
				$title = utf8_strcut($title,12); 
			}
			$img = stripslashes($row["img"]);
			if(!$img) {
				$img = "./kiki/img/test_img.png";
			}
			$description = $row["description"];
			$description = strip_tags($description);
			if (strlen($description) > 32) {
				$description = utf8_strcut($description,32); 
			}
			$startYHS = $row["startYHS"];
			$endYHS = $row["endYHS"];

			$actYN = $row["actYN"];			?>
                           <tr>
                            <td><img src="<?=$img?>" class="icon_img"/></td>
                            <td><a href="javascript:GoView('<?=$mgId?>');"><?=$title?></a> (<?=$mgId?>)</td>
                            <td><?=$description?></td>
                            <td><?=$startYHS?> ~ <?=$endYHS?></td>
                            <td>
                            <!-- switch btn -->
                              <div class="swbtn_wrapper">
                                <div class="booky_sw slider demo ">
                                  <input type="checkbox" value="<?=$actYN?>" <? if ($actYN == "Y") { ?>checked <? } ?> mgId="<?=$mgId?>" actYN="<?=$actYN?>">
                                </div>
                              </div>
                             <!-- // switch btn -->
                           </td>
                            <td><!-- <a href="javascript:GoModify('<?=$mgId?>');" class="kikibtn_modify">수정</a> &nbsp; <a href="javascript:cdelete('<?=$mgId?>');" class="kikibtn_del">삭제</a> --> <a href="javascript:GoStatic('<?=$mgId?>');" class="kikibtn_modify">통계</a></td>
                           </tr>
<?		  } // while
  		mysqli_free_result( $result);
		}	
	}	
	mysqli_close($kiki_conn);	?>
                         </tbody>
                      </table>  
                      <!-- // table :액티비티 -->
 
<?	include "./kiki/kiki_pageINC.php";		?>

                       <div class="kikibtnarea text_right">
                          <a href="javascript:go_write()" class="kikibtn">신규등록 </a>
                       </div>     
                                
                 </div>
               </div> <!-- //.kiki_row -->
              
            </div> <!-- //kiki_box -->      
       </div>
      </div>

<script>
function go_write(){ // 도서 서평등록
	document.list.method = "post";
	document.list.action = "./c110_write01.php";
	document.list.submit();
}

function kiki_list(pg){
    document.list.cur_page.value = pg;
    document.list.submit();
}

function cdelete(mgId){
  if(confirm('정말 삭제하시겠습니까?'))	{
	document.list.mgId.value = mgId;
	document.list.action='./kiki/c109_delete.php';
    document.list.submit();
  }
}

function GoModify(mgId){
	document.list.mgId.value = mgId;
	document.list.action='./c110_modify02.php';
    document.list.submit();
}

function GoView(mgId){
	document.list.mgId.value = mgId;
	document.list.action='./c110_view.php';
    document.list.submit();
}

function GoStatic(mgId){
	document.list.mgId.value = mgId;
	document.list.action='./c105_statistics_cost.php';
    document.list.submit();
}

function open_priview(mgId) {
	URL = "http://gamebin.iptime.org/kshop/wheel/preview.html?mgId="+mgId
	window.open(URL,'priview',"left=0, top=0, width=817,height=900,scrollbars=yes,resizable=no");
}
</script>

<form name="list" method="post" action="./c109_minigame.php">
  <input type="hidden" name="cur_page" value="<?=$cur_page?>" id="cur_page">
  <input type="hidden" name="mgId" value="">
  <input type="hidden" name="appId" value="<?=$kiki_appId?>">
</form>