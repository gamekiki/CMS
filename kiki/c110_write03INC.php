 <script src="https://code.jquery.com/jquery-2.1.0.min.js"></script>

 <script src="../wheel/js/kiki_wheel.js"></script>
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
function wrapWindowByMask(elemId){
	//화면의 높이와 너비를 구한다.
	var maskHeight = $(document).height();  
	var maskWidth = $(window).width();  

	//마스크의 높이와 너비를 화면 것으로 만들어 전체 화면을 채운다.
	$('#mask').css({'width':maskWidth,'height':maskHeight});  

	//애니메이션 효과 - 일단 1초동안 까맣게 됐다가 80% 불투명도로 간다.
	// $('#mask').fadeIn(1000);      
	$('#mask').fadeTo("slow",0.6);    

	$(".kikimodal_pop").each(function(){
		$(this).hide();
	});
		
	var d = document.querySelector(elemId);
//	console.debug("d tesT", d, elemId);
	//modal_pop 같은 거 띄운다.
	$(elemId).show();
}

$(document).ready(function(){
	//검은 막 띄우기
	$('.openMask').click(function(e){
		e.preventDefault();
		//wrapWindowByMask();  다중창을 띄울때 가려준다.
	});

	//닫기 버튼을 눌렀을 때
	$('.kikimodal_pop .close').click(function (e) {  
	    //링크 기본동작은 작동하지 않도록 한다.
	    e.preventDefault();
//	    $('input:radio[name="rwdType_G"]').prop('checked', false);
	    $('#mask, .kikimodal_pop').hide();  
	});       

	//취소 버튼을 눌렀을 때
	$('.kikimodal_pop .btn-cancel').click(function (e) {  
	    //링크 기본동작은 작동하지 않도록 한다.
	    e.preventDefault();  
	//    $('input:radio[name="rwdType_G"]').prop('checked', false);
	    $('#mask, .kikimodal_pop').hide();
	}); 
/*	//검은 막을 눌렀을 때
	$('#mask').click(function () {  
	    $(this).hide();  
	    $('.modal_pop').hide();  
	});   */
});
</script>
	  <div class="kiki_content">
        <div class="kiki_conwrap">    
            <div class="kiki_box">
               <!-- <div class="tit_top bm20">Bookoa</div> -->
<?	include "./kiki/kiki_header.php";
	$cur_page = kiki_isnumb($_POST["cur_page"]);
	$mgId = kiki_ischar($_POST["mgId"]);
//$mgId = "MGMAI_y588M4x6";	?>
              
               <div class="kiki_row" style="margin-top:25px">
                 <p class="tit">미니게임 등록</p>
                 <div class="con">
                    <p class="nv_img"><img src="./kiki/img/nv_img03.png"></p>
                   <p>* 당첨된 확률이 10% 이하인 혜택은 당첨 제한수를 설정하는 것을 권장합니다.</p>
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
                            <td id="line_rwdValue_<?=$mgSubSerno?>"><a href="javascript:go_modify('<?=$mgSubSerno?>')"><?=$rwdValue?></a></td>
                            <td id="line_rwdTitle_<?=$mgSubSerno?>"><?=$rwdTitle?> </td>
                            <td id="line_rwdProb_<?=$mgSubSerno?>"><?=$rwdProb?>%</td>
                            <td id="line_rwdRestrict_<?=$mgSubSerno?>"><?=$rwdRestrict?></td>
                            <td id="line_onePrice_<?=$mgSubSerno?>"><? if ($onePrice) { ?> <?=number_format($onePrice)?>원 <? } ?></td>
                           </tr>
<?		} // while
  		mysqli_free_result( $result);
		}			?>
                         </tbody>
                     </table>  
                      <!-- // table :액티비티 -->   
                      <p id="totPrice">- 비용 총합 : <?=number_format($totPrice)?>원</p>              
                 </div>
<input type="hidden" id="mgSubSerno">
<input type="hidden" id="rwdPrice">
<input type="hidden" id="rwdType">
                   <div id="modify_layer" style="display:none" class="kiki_tbview mgt20">
                     <!-- table :액티비티 20개씩 출력 -->
                     <table class="tblT01_detail" border="0" cellspacing="0" cellpadding="0">
                         <colgroup>
                         <col width="20%">
                         <col width="">
                         </colgroup>
                       <thead>
                       </thead> 
                       <tbody>             
                        <tr>
                         <th id="rwdValue_txt"></th>
                         <td>
                          <a onclick="wrapWindowByMask('#goods_sel')" class="kikibtn red"> 경품 선택 </a> &nbsp;
                          <input id="rwdTitle" value="" maxlength="20" placeholder="" style="width:30%" type="text">
                          <input id="rwdProb" maxlength="5" onblur="chk_digit(this.value,'rwdProb',1)" placeholder="" style="width:20%" type="text">
                          <input id="rwdRestrict" maxlength="5" onblur="chk_digit(this.value,'rwdRestrict',2)" placeholder="숫자만 입력하세요." style="width:20%" type="text">
                          &nbsp; <span id="onePrice"> </span> &nbsp; &nbsp;<a href="javascript:rwd_modify();" class="kikibtn red"> 경품수정 </a>
                         </td>
                        </tr>
                       </tbody>
                      </table>
                     </div> <!-- kiki_tbview -->
                     <!-- btnarea -->
                     <div class="kikibtnarea text_right">
                       <a href="javascript:go_back();" class="kikibtn gray2 fl_left">&lt; &nbsp;이전 </a> <a href="javascript:open_priview();" class="kikibtn gray2"> 미리보기</a>&nbsp; <a href="javascript:go_list();" class="kikibtn"> 완료 </a>
                     </div>
                     <!-- // btnarea -->
                
                 </div> <!-- //.con -->
               </div> <!-- // kiki_row -->
            </div> <!-- //kiki_box -->      
       </div>
      </div>

<!-- 모달팝업 영역 -->   
    <div id="mask"></div>
   
     <!-- 경품선택 -->
    <div id="goods_sel" class="kikimodal_pop" style="display:none">
     <div class="kikipanel">
      <div class="kikipanel-heading">
       <h3 class="kikipanel-title"> 경품선택 </h3>
       <!-- <a href="#" value="(.modal_pop .close)" class="close"><img src="./kiki/img/btn_close02.png" alt="닫기"></a> -->
      </div>
      <div class="kikipanel-body">
       <div id="rwdType_btn" class="form-group">
        <a href="#" class="kikibtn" id="rwdType_P" onclick="javascript:ksh_show('rwdType_P','P')"> 마일리지 </a>
        <a href="#" class="kikibtn" id="rwdType_G" onclick="javascript:ksh_show('rwdType_G','G')"> 기프티콘 </a>
       </div>
       <div id="rwdType_layerP" class="form-group">
        <input class="form-control" id="rwdValue" maxlength="10" placeholder="" type="text" style="width:90%"> P
       </div>
       <div id="rwdType_layerG" class="form-group">
        <ul>
<?	$SQL = "Select giftText from mg_gifticon where appId = '$kiki_appId' and useFlag = 'Y' order by giftSerno  ";
//echo $SQL;
	$result = mysqli_query($kiki_conn, $SQL);
	if( $result === false) {
		 die( print_r( mysqli_connect_error(), true) );
	} else {
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		  $giftText = $row["giftText"];
		  $giftText = stripslashes($giftText);			?>
         <li><input name="rwdType_G" value="<?=$giftText?>" type="radio"><span><?=$giftText?></span></li>
<?		} // while
  		mysqli_free_result( $result);
	}
	mysqli_close($kiki_conn);	?>		 
        </ul>
       </div>
      </div>
       <div class="kikipanel-footer"> <a href="#" class="kikibtn btn-cancel">취소</a><a href="javascript:rwdType_modify();" class="kikibtn btn-ok">선택</a> </div>
     </div> <!-- // panel -->
    </div>
    <!--// 경품선택 -->

 <!-- //모달팝업 영역 --> 
 <form name="list" method="post">
  <input type="hidden" name="mgId" id="mgId" value="<?=$mgId?>">
  <input type="hidden" name="cur_page" value="<?=$cur_page?>">
  <input type="hidden" name="appId" id="appId" value="<?=$kiki_appId?>">
</form>

<script>
function go_list () {
	document.list.action='./c109_minigame.php';
    document.list.submit();
}

function go_back () {
	document.list.action='./c110_modify02.php';
    document.list.submit();
}

function go_modify(mgSubSerno) { //정보 불러오기
	$("#mgSubSerno").val(mgSubSerno);	
	$("#modify_layer").show();
	$.ajax({
	    type: 'POST',
	    dataType: 'json',
	    url: "./kiki/c110_write03Ajax.php?callback=?",
	    data: {
			"mgSubSerno": mgSubSerno,
	    },
	    success: function(data) {
		  if (data.prog == "true") {
	var rwdType = data.rwdType;
	var rwdRestrict = data.rwdRestrict;
	var rwdValue = data.rwdValue;
		if (rwdType == "G") {
			rwdValue_txt = "기프티콘 " + rwdValue;
		} else {
			rwdValue_txt = "마일리지  " + rwdValue;
		}
			$("#rwdValue_txt").text(rwdValue_txt);
			$("#rwdTitle").val(data.rwdTitle); 
			$("#rwdType").val(rwdType); 			 
			$("#rwdProb").val(data.rwdProb); 
			$("#rwdRestrict").val(rwdRestrict); 
			$("#rwdPrice").val(data.rwdPrice); 
			if (rwdType == "G" && rwdRestrict != "") {
				$("#onePrice").text(data.onePrice + " 원");
			}
			if (rwdType == "G") {
				$("#rwdType_layerP").hide();
				$("#rwdType_layerG").show();

			   $('input:radio[name="rwdType_G"]').prop('checked', false);
			   $('input:radio[name=rwdType_G]:input[value="' + rwdValue + '"]').prop("checked", true);

			  $("#rwdType_G").attr('class', 'kikibtn red');
			  $("#rwdType_P").attr('class', 'kikibtn');
			} else {
				$("#rwdType_layerP").show();
				$("#rwdType_layerG").hide();

				$("#rwdType_P").attr('class', 'kikibtn red');
				$("#rwdType_G").attr('class', 'kikibtn');
				$("#rwdValue").val(rwdValue);
			}
		  }
	    } ,
	    error: function(xhr, status, error) {
		  alert(""+error);
	    }
	});
}

function chk_digit(val, name,gubun) { // 숫자만 가능
	var patten = "";
	if (gubun == "1") {
		patten = /^[0-9.]*$/;
	} else {
		patten = /^[0-9]*$/;
	}
	var chk = patten.test(val); 
  if (chk == true) { // 0.5 ~ 5.0 사이라면
	if (gubun == "2") {		// 당첨 제한에 따른 금액 재 계산
		rwdPrice = parseInt($("#rwdPrice").val());
		onePrice = numberWithCommas(rwdPrice * val);

		$("#onePrice").text(onePrice + " 원");
	}
  } else {
	alert("숫자만 입력 가능합니다.");
	$("#"+name).val('');
	$("#"+name).focus();
  }
}

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function ksh_show(id,val) {
	 $("#rwdType_btn > a ").removeClass("red");
	 $("#"+id).attr('class', 'kikibtn red');
	 $("input:hidden[id=rwdType]").val(val);

	if (val == "G") {
		$("#rwdType_layerP").hide();
		$("#rwdType_layerG").show();
	  $("#rwdType_G").attr('class', 'kikibtn red');
	  $("#rwdType_P").attr('class', 'kikibtn');
	} else {
		$("#rwdType_layerP").show();
		$("#rwdType_layerG").hide();
		$("#rwdType_P").attr('class', 'kikibtn red');
		$("#rwdType_G").attr('class', 'kikibtn');
	}
}

// 경품 선택
function rwdType_modify() {
	var rwdType = $("#rwdType").val();	
	if (rwdType == "P") { // 마일리지라면
      if ($("#rwdValue").val() < 1) {
        alert("마일리지를 입력하세요.");
        $("#rwdValue").focus();
        return;
      }
	  rwdValue_txt = "마일리지 " + $("#rwdValue").val();
	} else {
		var rwdtype_chk = $('input:radio[name=rwdType_G]').is(':checked');
		if (!rwdtype_chk) {
		  alert("기프티콘을 선택하세요.");
          return;
		}
		rwdValue = $(":input:radio[name=rwdType_G]:checked").val();
		rwdValue_txt = "기프티콘 " + rwdValue;
	}
//	console.log("rwdValue = "+rwdValue)
	$("#rwdValue_txt").text(rwdValue_txt);
	$('#mask, .kikimodal_pop').hide();
}

// 경품 수정하기
function rwd_modify() {
	var mgSubSerno = $("#mgSubSerno").val();	
	var rwdType = $("#rwdType").val();	
    if ($("#rwdTitle").val() < 1) {
        alert("표시문구를 입력하세요.");
        $("#rwdTitle").focus();
        return;
    }
    if ($("#rwdProb").val().length < 1) {
        alert("당첨될 확률을 입력하세요.");
        $("#rwdProb").focus();
        return;
    }
	if (rwdType == "P") { // 마일리지라면
	  rwdValue = $("#rwdValue").val();
	  rwdValue_txt = "마일리지 " + rwdValue;
	} else {
	  rwdValue = $(":input:radio[name=rwdType_G]:checked").val();
	  rwdValue_txt = "기프티콘 " + rwdValue;
	}
  $.ajax({
      type: 'post',
      dataType: 'json',
	  url: "./kiki/c110_write03_rwdAjax.php?callback=?",
      data: {
		"mgSubSerno": mgSubSerno,
		"rwdType": rwdType,
		"rwdValue": rwdValue,
		"rwdTitle": $("#rwdTitle").val(),
		"rwdProb": $("#rwdProb").val(),
		"rwdRestrict": $("#rwdRestrict").val(),
		"rwdPrice": $("#rwdPrice").val(),
		"mgId": $("#mgId").val(),
       },
       success: function(data) {
		 txt = "<a href='javascript:go_modify(\""+mgSubSerno+"\")'>"+ rwdValue_txt + "</a>";
		 prob = $("#rwdProb").val();
		 totP = data.totPrice;
		 $("#line_rwdValue_"+mgSubSerno).html(txt);
		 $("#line_rwdTitle_"+mgSubSerno).text($("#rwdTitle").val());
		 $("#line_rwdProb_"+mgSubSerno).text(prob + "%");
		 $("#line_rwdRestrict_"+mgSubSerno).text($("#rwdRestrict").val());
		 $("#line_onePrice_"+mgSubSerno).text(data.onePrice);
		 $("#totPrice").text(data.totPrice);		 
// 수정을 클릭했을 경우 값 취소
		 $("#rwdType").val('');
	 	 $("#rwdValue_txt").text('');
		 $("#rwdTitle").val(''); 
		 $("#rwdProb").val(''); 	
		 $("#rwdRestrict").val(); 
		 $("#rwdPrice").val(''); 
		 $("#onePrice").text('');
		 $("#rwdType_layerP").hide();
		 
		 alert('정상적으로 수정되었습니다.');
		 $("#mgSubSerno").val('');	
		 $("#modify_layer").hide();
	   },
       error: function(xhr, status, error) {
		 alert(error);
	   }
  })
}

function open_priview() {
	var mgId = $("#mgId").val();
	var appId = $("#appId").val();
	URL = "http://gamebin.iptime.org/kshop/wheel/preview.html?mgId="+mgId+"&appId=="+appId
	window.open(URL,'priview',"left=0, top=0, width=417,height=550,scrollbars=yes,resizable=no");
}
</script>