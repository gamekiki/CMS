 <script src="https://code.jquery.com/jquery-2.1.0.min.js"></script>
 <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
 <link rel="stylesheet" href="./kiki/css/jquery-ui.css" />
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
$(function() {
	$("#beginDate, #EndDate").datepicker({
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
   		minDate: 0,
   		maxDate: "+1Y +1M +10D",
   		showWeek: false,
		firstDay: 0	// 0 : 주일, 1:월요일
	});
   $('#calendar1').on('click', function() {
      $("#beginDate").datepicker('show');
   });
   $('#calendar2').on('click', function() {
      $("#EndDate").datepicker('show');
   });
});
</script> 
	 <div class="kiki_content">
        <div class="kiki_conwrap">    
            <div class="kiki_box">
               <!-- <div class="tit_top bm20">Bookoa</div> -->
<?	include "./kiki/kiki_header.php";
	$cur_page = kiki_isnumb($_POST["cur_page"]);
	$mgType = kiki_ischar($_POST["mgType"]);	
	
	mysqli_close($kiki_conn);	?>
              
               <div class="kiki_row" style="margin-top:25px">
                 <p class="tit">미니게임 등록</p>
                 
                 <div class="con">
                   <p class="nv_img"><img src="./kiki/img/nv_img02.png"></p>
                   <div class="kiki_tbview">
                     <!-- table :액티비티 20개씩 출력 -->
<form method="post" name="frm" id="frm" enctype="MULTIPART/FORM-DATA">
  <input type="hidden" name="cur_page" value="<?=$cur_page?>">
  <input type="hidden" name="mgType" value="<?=$mgType?>">
  <input type="hidden" name="mgRestrict" value="1">
  <input type="hidden" name="appId" value="<?=$kiki_appId?>">
                     <table class="tblT01_detail" border="0" cellspacing="0" cellpadding="0">
                         <colgroup>
                         <col width="15%">
                         <col width="">
                         </colgroup>
                       <thead>
                       </thead> 
                       <tbody>             
                          <tr>
                            <th>기간 *</th>
                             <td>
                             <input name="beginDate" id="beginDate" class="" value="" style="width:20%;" type="text" readonly>
                             <a href="#"><img id="calendar1" src="./kiki/img/icon_day.png" alt="달력"></a>
                             ~
                             <input name="EndDate" id="EndDate" class="" value="" style="width:20%;" type="text" readonly>
                             <a href="#"><img id="calendar2" src="./kiki/img/icon_day.png" alt="달력"></a>
                             </td>
                          </tr>
                          <tr>
                            <th>제목 *</th>
                             <td><label><input name="title" maxlength="10" placeholder="쇼핑몰에서 위젯 아이콘 상단에 노출됩니다.(최대 10자)" type="text"></label></td>
                          </tr>
                          <tr>
                            <th>내용 </th>
                             <td><label><input name="description" maxlength="20" value="" placeholder="최대20자" type="text"></label></td>
                          </tr>
                          <tr>
                            <th>위젯 아이콘 </th>
                            <td>
                            <input name="chk_info" value="./kiki/img/test_img1.png" id="c1" <? if ($mgType == "R") { ?> checked="checked" <? } ?> type="radio" onclick="chk_showhide('hide')">
                            <label for="c1"><img src="./kiki/img/test_img_s.png" alt="룰렛이미지"></label>
                           &nbsp;
                            <input name="chk_info" value="./kiki/img/test_img2.png" id="c2" <? if ($mgType == "B") { ?> checked="checked" <? } ?> type="radio" onclick="chk_showhide('hide')">
                            <label for="c2"><img src="./kiki/img/test_img2_s.png" alt="룰렛이미지"></label>
                             &nbsp;
                            <input name="chk_info" value="./kiki/img/test_img3.png" id="c3" type="radio" onclick="chk_showhide('hide')">
                            <label for="c3"><img src="./kiki/img/test_img_s.png" alt="룰렛이미지"></label>
                            &nbsp;
                            <input name="chk_info" value="4" id="c4" type="radio" onclick="chk_showhide('show')">
                            <label for="c4">직접등록
                            <div id="chk_info_layer" style=" display:none; margin-top:10px"><input name="file1" value="" placeholder="text" type="file"></div>
                            </label>
                            </td>
                          </tr>
                           <tr>
                            <th>참여제한 * </th>
                             <td id="restrict"> 
                               <a href="#" class="kikibtn_point on" id="ksh_shop_show_1" onclick="javascript:ksh_shop_show('ksh_shop_show_1','1');return false;">하루1회</a> <a href="#" class="kikibtn_point" id="ksh_shop_show_a" onclick="javascript:ksh_shop_show('ksh_shop_show_a','A');return false;">단회</a> 
                             </td>
                          </tr>
                         </tbody>
                      </table>
</form>
                     </div> <!-- kiki_tbview -->
                     <!-- btnarea -->
                     <div class="kikibtnarea text_right">
                       <a href="javascript:history.go(-1)" class="kikibtn gray2 fl_left"> &lt; &nbsp;이전 </a> <a href="javascript:go_write()" class="kikibtn"> 다음&nbsp; &gt; </a>
                     </div>
                     <!-- // btnarea -->
                
                 </div> <!-- //.con -->
               </div> <!-- // kiki_row -->
            </div> <!-- //kiki_box -->      
       </div>
      </div>
<script>
function chk_showhide(chk){ // 위젯 아이콘 직접 등록 레이어
    if (chk == "hide") {
        $("#chk_info_layer").hide();
	} else {
		$("#chk_info_layer").show();
    }
}

function ksh_shop_show(id,val) {
	 $("#restrict > a ").removeClass("on");
	 $("#"+id).attr('class', 'kikibtn_point on');
	 $("input:hidden[name=mgRestrict]").val(val);
}

function go_write(){ // 미니 게임 등록
	if (document.frm.beginDate.value.length < 1) {
        alert("기간을 입력하세요.");
        document.frm.beginDate.focus();
        return;
    }
	if (document.frm.EndDate.value.length < 1) {
        alert("기간을 입력하세요.");
        document.frm.EndDate.focus();
        return;
    }
	if (document.frm.beginDate.value > document.frm.EndDate.value) {
		alert("기간을 확인해 주세요");
		return;
	}
	if (document.frm.title.value.length < 1) {
        alert("제목을 입력하세요.");
        document.frm.title.focus();
        return;
    }
	var chk_radio = document.getElementById('c4').checked;
	if ((chk_radio == true) && (document.frm.file1.value.length < 1) ) {
		alert('위젯 아이콘을 등록해 주세요.');
		document.frm.file1.focus();
		return false;
	}
    document.frm.action = "./kiki/c110_write02.php";
	document.frm.submit();
}
</script>