 <script src="https://code.jquery.com/jquery-2.1.0.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <link rel="stylesheet" href="./kiki/css/jquery-ui.css" />
 <?	$sub_menu1 = "";	// 대시보드
	$sub_menu2 = "";	// 회원관리
	$sub_menu3 = "";	// 액티비티 관리
	$sub_menu4 = "";	// 업적관리
	$sub_menu5 = "";	// 뱃지관리
	$sub_menu6 = "on";	//통계/분석
	$sub_menu7 = "";	//리워드 관리
	$sub_menu8 = "";	//레벨설정	
	$sub_menu9 = "";	//미니게임
	$sub_menu10 = "";	//상품추천
	
	$sub_menu6_01 = "";			// 액티비티
	$sub_menu6_02 = "";			// 가입자
	$sub_menu6_03 = "";			// 비용
	$sub_menu6_04 = "";			// 활동
	$sub_menu6_05 = "on";		// 히스토리		?>
<script>
$(function() {
	$("#beginDate").datepicker({
		buttonImageOnly: false,
		showButtonPanel: false,
		// date 포멧
		dateFormat : "yy-mm-dd",
		showAnim : "",
		// 다른 달의 일 보이기, 클릭 가능
		showOtherMonths: true,
	 	selectOtherMonths: false,
	 	// 년도, 달 변경
	 	changeMonth: true,
	 	changeYear: true,
	 // 여러달 보이기
	 	numberOfMonths: 1,
	 	showButtonPanel: true,
 // 달력 선택 제한 주기(min: 현재부터 -20일,max:현재부터 +1달+10일) // 아래주석이면 20년 정보
   		minDate: "-5Y +1M +10D",
   		maxDate: 0,
   		showWeek: false,
		firstDay: 0	// 0 : 주일, 1:월요일
	});
   $('#calendar1').on('click', function() {
      $("#beginDate").datepicker('show');
   });
});
</script>
	  <div class="kiki_content">
        <div class="kiki_conwrap">    
            <div class="kiki_box">
               <!-- <div class="tit_top bm20">Bookoa</div> -->
<?	include "./kiki/kiki_header.php";		?>
              
               <div class="kiki_row" style="margin-top:50px">
                 <p class="tit">통계/분석</p>
                 
                 
                 <div class="con">
                  <div class="maintab_area">
              <!-- 탭메뉴 -->
              <div class="pro_tabarea">           
              <div class="pro_tabarea" style="margin-bottom:40px">           
<?	// 통계 header 메뉴 
	include "./kiki/c105_statistics_header.php";		?>
              </div>
              <!-- 탭컨텐트 -->
              <div class="tab_con" id="tab_con">
                   <!-- pro_con05: 히스토리 -->
                  <div id="pro_con01" class="pro_con" style="display: block;">
                    <div class="pro_detail">
                   
                       <div class="searchtop_area">
                        <div class="fl_right">
                          <div class="search">
                          <label></label>
                          <select name="schSel" id="schSel" onchange="javascript:show_hide(this.value)" class="select_style">
                             <option value="c.regYHS" selected="">날짜</option>
                             <option value="UserId">아이디</option>
                             <option value="a.mgId">미니게임</option>
							 <option value="rwdValue">기프티콘</option>
							 <option value="">전체보기</option>
                          </select>
                          <span id="layer_date" style="display:''"><input name="beginDate" id="beginDate" class="" value="<?=$schStr?>" type="text" readonly>
                            <a href="#"><img id="calendar1" src="./kiki/img/icon_day.png" alt="달력"></a></span>
						  <span id="layer_userid" style="display:none">
							<input name="schStr" id="schStr_userid" maxlength="15" class="" value="<?=$schStr?>" type="text">
						  </span>
						  <span id="layer_game" style="display:none">
							<select name="schSel" id="schSel_mgId" class="select_style">
<?		$SQL = "Select mgId, title from mg_main where appId = '$kiki_appId' ";
		$SQL .= " order by mgMainSerno desc ";
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
			}	?>
                              <option value="<?=$mgId?>" selected=""><?=$title?></option>
<?		  } // while
  		mysqli_free_result( $result);
		}	?>
                            </select>
						  </span>
						  <span id="layer_gifti" style="display:none">
							<select name="schSel" id="schSel_gifti" class="select_style">
<?		$SQL = "Select giftText from mg_gifticon where appId = '$kiki_appId' ";
		$SQL .= " and useFlag = 'Y' order by giftSerno desc ";
		$result = mysqli_query($kiki_conn, $SQL);
		if( $result === false) {
//			 die( print_r( mysqli_connect_error(), true) );
		} else {
		  while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			$giftText = $row["giftText"];
			$giftText = stripslashes($giftText);
			if (strlen($giftText) > 12) {
				$giftText_ = utf8_strcut($giftText,12); 
			} else {
				$giftText_ = $giftText;
			}	?>
                              <option value="<?=$giftText?>" selected=""><?=$giftText_?></option>
<?		  } // while
  		mysqli_free_result( $result);
		}
mysqli_close($kiki_conn);		?>
                            </select>
						  </span>
						 
                          <a href="javascript:load_sch();" class="kikibtn gray2"> 검 색 </a>
                          </div>
                      </div>
                     </div>

                      <div id="history_inc" class="con board_list">

                      </div> <!-- // borad_list -->

                  </div> <!-- // pro_detail -->
                   </div> 
                   <!--//  pro_con05: 히스토리 -->
                  
               </div>  
               <!-- // 탭컨텐트 -->            
            </div>
                
                 </div> <!-- //.con -->
               </div><!-- //.kiki_row -->
               
              
            </div> <!-- //kiki_box -->      
       </div>
      </div>

<script>
$(function () {	
	load_sch();
});


function show_hide(val) {
  switch (val) {
    case "c.regYHS" :	// 날짜
	  $("#layer_date").show();
	  $("#layer_userid").hide();
	  $("#layer_game").hide();
	  $("#layer_gifti").hide();
      break;
    case "UserId" :	// 아이디
	  $("#layer_date").hide();
	  $("#layer_userid").show();
	  $("#layer_game").hide();
	  $("#layer_gifti").hide();
      break;
    case "a.mgId" :	// 미니게임
	  $("#layer_date").hide();
	  $("#layer_userid").hide();
	  $("#layer_game").show();
	  $("#layer_gifti").hide();
      break;
    case "rwdValue" :	// 기프티콘
	  $("#layer_date").hide();
	  $("#layer_userid").hide();
	  $("#layer_game").hide();
	  $("#layer_gifti").show();
      break;
    default  :		// 전체보기
	  $("#layer_date").hide();
	  $("#layer_userid").hide();
	  $("#layer_game").hide();
	  $("#layer_gifti").hide();
      break;
  }
}

function load_sch(){
	$("#cur_page").val(1);
	view_cont = "history_inc";
    schSel = $("#schSel").val();
 switch (schSel) {
  case "c.regYHS" :
	schStr = $("#beginDate").val();
    break;
  case "UserId" :
	schStr = $("#schStr_userid").val();
    break;
  case "a.mgId" :
	schStr = $("#schSel_mgId").val();
    break;
  case "rwdValue" :
	schStr = $("#schSel_gifti").val();
    break;
   default :
	schStr = "";
    break;
}
//console.log("sel="+schSel+", str="+schStr)
    $.ajax({
        url: './kiki/c105_statistics_history_ajaxINC.php?callback=?',
        type: 'POST',
		data: {
		  "cur_page": 1,
		  "appId": "<?=$kiki_appId?>",
		  "schSel": schSel,
		  "schStr": schStr,
       },
        contentType: 'application/x-www-form-urlencoded;charset=UTF-8', 
        dataType: 'html',
        success: function (data) {
	      $("#"+view_cont).empty();
		  $(data).prependTo($("#"+view_cont));
	    },
        error: function(xhr, status, error) {
		 alert("error : "+error);
	    }
 	});
}

function kiki_list (pg,view_cont) {	// 내 글과 내 토론은 페이지 두 개이므로 별도의 페이징 필요
	view_cont = "history_inc";
    schSel = $("#schSel").val();
 switch (schSel) {
  case "c.regYHS" :
	schStr = $("#beginDate").val();
    break;
  case "UserId" :
	schStr = $("#schStr_userid").val();
    break;
  case "a.mgId" :
	schStr = $("#schSel_mgId").val();
    break;
  case "rwdValue" :
	schStr = $("#schSel_gifti").val();
    break;
   default :
	schStr = "";
    break;
}
    $.ajax({
        url: './kiki/c105_statistics_history_ajaxINC.php?callback=?',
        type: 'POST',
		data: {
		  "cur_page": pg,
		  "appId": "<?=$kiki_appId?>",
		  "schSel": schSel,
		  "schStr": schStr,
       },
        contentType: 'application/x-www-form-urlencoded;charset=UTF-8', 
        dataType: 'html',
        success: function (data) {
	      $("#"+view_cont).empty();
		  $(data).prependTo($("#"+view_cont));
	    },
        error: function(xhr, status, error) {
		 alert("error : "+error);
	    }
 	});
}
</script>



<form name="kiki_frm_sub" method="post">
  <input type="hidden" name="cur_page" value="<?=$cur_page?>">
  <input type="hidden" name="schSel" value="<?=$schSel?>">
  <input type="hidden" name="schStr" value="<?=$schStr?>">
  <input type="hidden" name="appId" value="<?=$kiki_appId?>">
</form>