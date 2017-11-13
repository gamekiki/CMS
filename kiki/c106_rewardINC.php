  <script src="https://code.jquery.com/jquery-2.1.0.min.js"></script>
<?	$sub_menu1 = "";	// 대시보드
	$sub_menu2 = "";	// 회원관리
	$sub_menu3 = "";	// 액티비티 관리
	$sub_menu4 = "";	// 업적관리
	$sub_menu5 = "";	// 뱃지관리
	$sub_menu6 = "";	//통계/분석
	$sub_menu7 = "on";	//리워드 관리
	$sub_menu8 = "";	//레벨설정
	$sub_menu9 = "";	//미니게임
	$sub_menu10 = "";	//상품추천		?> 
<script>
$(function () {	
	tab('#tab',0);
});

function tab(e, num){
    var num = num || 0;
    var menu = $(e).children();
    var con = $(e+'_con').children();
    var select = $(menu).eq(num);
    var i = num;

    select.addClass('on');
    con.eq(num).show();
	load_cont('point_list');	// page load 시 실행

    menu.click(function(){
        if(select!==null){
            select.removeClass("on");
            con.eq(i).hide();
        }

		select = $(this);	
        i = $(this).index();
//console.log("i = "+ i)
  $("#pageNum").val(i);
  if (i == 1) {	// 1: 마일리지
	load_cont('mileage_list');
	$("#mile_layer").val("history").prop("selected", true);
	$("#schSel_1").val("a.userId").prop("selected", true);
	$("#schSel_2").val("a.userId").prop("selected", true);
	$("#schStr").val("");
	$("#schStr_3").val("");
	$("#chk").val("").prop("selected", true);
	$("#sch_layer1").show();
	$("#sch_layer2").hide();
	$("#sch_1").show();	// 검색에 내용 있음
	$("#sch_2").hide();	// 검색에 내용 없음
  } else if (i == 2) {	// 2: 기프티콘
	load_cont('gifticon_list');
	$("#mile_layer").val("history").prop("selected", true);
	$("#schSel_1").val("a.userId").prop("selected", true);
	$("#schSel_2").val("a.userId").prop("selected", true);
	$("#schStr").val("");
	$("#chk").val("").prop("selected", true);
	$("#sch_layer1").hide();
	$("#sch_layer2").hide();
	$("#sch_1").hide();	// 검색에 내용 있음
	$("#sch_2").hide();	// 검색에 내용 없음
	$("#schStr_3").val("");
  } else {	// 0: 포인트
	load_cont('point_list');
  }
        select.addClass('on');
        con.eq(i).show();
    });
} 
</script>
	  <div class="kiki_content">
        <div class="kiki_conwrap">    
            <div class="kiki_box">
               <!-- <div class="tit_top bm20">Bookoa</div> -->
<?	include "./kiki/kiki_header.php";		?>

			   <div class="kiki_row"  style="margin-top:50px">
                 <p class="tit">리워드 관리</p>
                 <div class="con"> 


              <div class="maintab_area">
              <!-- 탭메뉴 -->
              <div class="pro_tabarea">           
                <div class="nav">
                
                <ul class="tab" id="tab">
                  <li class="on"><a href="#location" id="pro_tab01">포인트</a></li>
                  <li class=""><a href="#location" id="pro_tab02">마일리지</a></li>
				  <li class=""><a href="#location" id="pro_tab03">기프티콘</a></li>
                </ul>
                </div> <!-- //nav -->
              </div>
              <!-- 탭컨텐트 -->

			  <div class="tab_con" id="tab_con">
                <!-- pro_con01: 포인트 -->
                  <div id="pro_con01" class="pro_con" style="display: block;">
                    <div class="pro_detail">
						<div id="point_list" class="con board_list">
<!-- table :리워드 20개씩 출력 -->

						</div> <!-- // borad_list -->
                      </div><!-- // pro_detail -->
                   </div> 

                  <div id="pro_con02" class="pro_con" style="display: none;">
                    <div class="pro_detail">
                     
                         <div class="searchtop_area">
                          <select name="mile_layer" id="mile_layer" onchange="javascript:show_hide1(this.value)" class="select_style" style="margin-right:5px">
                             <option value="history" selected="">히스토리</option>
                             <option value="trans">전환신청</option>
                          </select>
    
                          <div class="fl_right">
                            <div class="search">
                            <label></label>
                            <span id="sch_1" style="display:">  <!-- 히스토리일 때는 내용 보임 -->
							  <select name="schSel" id="schSel_1" onchange="javascript:show_hide2(this.value)" class="select_style">
                               <option value="a.userId" selected="">아이디</option>
                               <option value="username">이름</option>
                               <option value="cont">내용</option>
                              </select>
							</span>
                            <span id="sch_2" style="display:none"> <!-- 전환신청일시 내용 안 보임 -->
							  <select name="schSel" id="schSel_2" onchange="javascript:show_hide3(this.value)" class="select_style">
                               <option value="a.userId" selected="">아이디</option>
                               <option value="username">이름</option>
                              </select>
							</span>


                            <span id="sch_layer1" style="display:"><input name="schStr" id="schStr" maxlength="15" class="" value="<?=$schStr?>" type="text"></span>
                            <span id="sch_layer2" style="display:none">
						     <select id="chk" name="chk" class="select_style">
                               <option value="" selected="">전체선택</option>
                               <option value="G">룰렛 당첨</option>
                               <option value="A">관리자 지급/회수</option>
							   <option value="T">마일리지 전환</option>
                             </select>
							</span>
                            <a href="javascript:load_sch();" class="kikibtn gray2"> 검 색 </a>
                            </div>
                        </div>
                       </div> <!-- //searchtop_area -->
  
                        <div id="mileage_list" class="con board_list">
<!-- 마일리지 리스트 -->
                        </div> <!-- // borad_list -->
					<form name='frm_reward' id='frm_reward' method='post'>
					  <input type="hidden" name="flag" value="0" >
						<div id="mileage_trans" class="con board_list" style="display:none">

<!-- 마일리지 전환 요청한 리스트 -->

						</div>
					</form>
                           <!-- 전환신청일 경우 테이블 --> 
                           <div class="con board_list" style="display:none">
                           </div>
                           <!--//  전환신청일 경우 테이블 --> 
  
                    </div><!-- // pro_detail -->
                   </div> 
                   <!--//  pro_con02: 마일리지 -->
                <!-- pro_con01: 포인트 -->
                  <div id="pro_con03" class="pro_con" style="display: none;">
                    <div class="pro_detail">
                         <div class="searchtop_area">
                          <select name="gifti_layer" id="gifti_layer" class="select_style" style="margin-right:5px">
                             <option value="history" selected="">발급신청</option>
                          </select>
    
                          <div class="fl_right">
                            <div class="search">
                            <label></label>
							  <select name="schSel" id="schSel_3" class="select_style">
                               <option value="UserId" selected="">아이디</option>
                               <option value="usedPhone">휴대폰번호</option>
							</span>
                            <input name="schStr" id="schStr_3" maxlength="15" class="" value="<?=$schStr?>" type="text">
                            <a href="javascript:load_sch_gifticon();" class="kikibtn gray2"> 검 색 </a>
                            </div>
                        </div>
                       </div> <!-- //searchtop_area -->

					<form name='frm_reward_gifticon' id='frm_reward_gifticon' method='post'>
					  <input type="hidden" name="flag" value="0" >
						<div id="gifticon_list" class="con board_list">
<!-- table :리워드 20개씩 출력 -->

						</div> <!-- // borad_list -->
					</form>
                      </div><!-- // pro_detail -->
                   </div> 
               </div>  
               <!-- // 탭컨텐트 -->            
            </div>
                
                 </div> <!-- //.con -->
               </div><!-- //.kiki_row -->
               
              
            </div> <!-- //kiki_box -->      
       </div>
      </div>

<input type="hidden" id="cur_page" value="<?=$cur_page?>">
<input type="hidden" id="pageNum" value="0">

<script>
function load_cont(view_cont){
	$("#cur_page").val(1);
  switch (view_cont) {
    case "point_list" :  //  0: 포인트
	 url = "./kiki/c106_reward_pointINC.php";
     break;
    case "mileage_list" : // 1: 내 토론
	 url = "./kiki/c106_reward_mileageINC.php";
	 $("#mileage_list").show();
	 $("#mileage_trans").hide();
     break;
    case "mileage_trans" :
	 url = "./kiki/c106_reward_transINC.php";
	 $("#mileage_list").hide();
	 $("#mileage_trans").show();
     break;
    case "gifticon_list" :
	 url = "./kiki/c106_reward_gifticonINC.php";
     break;
  }
	$.ajax({
        url: url+'?callback=?',
        type: 'POST',
		data: {
		  "cur_page": 1,
		  "appId": "<?=$kiki_appId?>",
       },
        contentType: 'application/x-www-form-urlencoded;charset=UTF-8', 
        dataType: 'html',
        success: function (data) {
//console.log("data = "+data)
	      $("#"+view_cont).empty();
		  $(data).prependTo($("#"+view_cont));
	    },
        error: function(xhr, status, error) {
		 alert("error : "+error);
	    }
 	});
}
function show_hide1(val) {
  switch (val) {
    case "history" :
	  $("#sch_1").show();
	  $("#sch_2").hide();
	  $("#sch_layer1").show();
	  $("#sch_layer2").hide();
	  $("#schSel_1").val("a.userId").prop("selected", true);
	  $("#schSel_2").val("a.userId").prop("selected", true);
	  $("#schStr").val("");
	  $("#chk").val("").prop("selected", true);
	  load_cont("mileage_list");
      break;
    case "trans" :
	  $("#sch_1").hide();
	  $("#sch_2").show();
	  $("#sch_layer1").show();
	  $("#sch_layer2").hide();
	  $("#schSel_1").val("a.userId").prop("selected", true);
	  $("#schSel_2").val("a.userId").prop("selected", true);
	  $("#schStr").val("");
	  $("#chk").val("").prop("selected", true);
	  load_cont("mileage_trans");
      break;
  }
}

function show_hide2(val) {
  switch (val) {
    case "a.userId" :
	  $("#sch_layer1").show();
	  $("#sch_layer2").hide();
	  $("#sch_2").hide();
      break;
    case "username" :
	  $("#sch_layer1").show();
	  $("#sch_layer2").hide();
	  $("#sch_2").hide();
      break;
    case "cont" :
	  $("#sch_layer1").hide();
	  $("#sch_layer2").show();
	  $("#sch_2").hide();
      break;
  }
}

function show_hide3(val) {
  switch (val) {
    case "a.userId" :
	  $("#sch_1").hide();
	  $("#sch_layer1").show();
	  $("#sch_layer2").hide();
      break;
    case "username" :
	  $("#sch_1").hide();
	  $("#sch_layer1").show();
	  $("#sch_layer2").hide();
      break;
  }
}

function load_sch(){
	$("#cur_page").val(1);
    mile_layer = $("#mile_layer").val();
	if (mile_layer == "history") {
		view_cont = "mileage_list";
		schSel = $("#schSel_1").val();
		url = "./kiki/c106_reward_mileageINC.php";
		$("#mileage_list").show();
		$("#mileage_trans").hide();
	} else {
		view_cont = "mileage_trans";
		schSel = $("#schSel_2").val();
		url = "./kiki/c106_reward_transINC.php";
		$("#mileage_list").hide();
		$("#mileage_trans").show();
	}

 switch (schSel) {
  case "a.userId" :
	schStr = $("#schStr").val();
    break;
  case "username" :
	schStr = $("#schStr").val();
    break;
  case "cont" :
	schStr = $("#chk").val();
    break;
}
    $.ajax({
        url: url+'?callback=?',
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

function load_sch_gifticon(){
	$("#cur_page").val(1);
	view_cont = "gifticon_list";
	url = "./kiki/c106_reward_gifticonINC.php";
	schSel = $("#schSel_3").val();
	schStr = $("#schStr_3").val();
 //console.log("sel="+schSel+", str="+schStr+", url="+url)
	$.ajax({
        url: url+'?callback=?',
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
//console.log("data2="+data)
		  $(data).prependTo($("#"+view_cont));
	    },
        error: function(xhr, status, error) {
		 alert("error : "+error);
	    }
 	});
}

function kiki_list (pg,view_cont) {	// 내 글과 내 토론은 페이지 두 개이므로 별도의 페이징 필요
  switch (view_cont) {
    case "mileage_list" :  //  마일리지 리스트
	 url = "./kiki/c106_reward_mileageINC.php";
	 schSel = $("#schSel_1").val();
	 $("#mileage_list").show();
	 $("#mileage_trans").hide();
	 break;
    case "mileage_trans" : // 마일리지 전환신청
	 url = "./kiki/c106_reward_transINC.php";
	 schSel = $("#schSel_2").val();
	 $("#mileage_list").hide();
	 $("#mileage_trans").show();
     break;
    case "point_list" : // 포인트
	 url = "./kiki/c106_reward_pointINC.php";
	 schSel = "";
     break;
    case "gifticon_list" : // 기프티콘 발급 신청
	 url = "./kiki/c106_reward_gifticonINC.php";
	 schSel = $("#schSel_3").val();
	 schStr = $("#schStr_3").val();
     break;
  }

 switch (schSel) {
  case "a.userId" :
	schStr = $("#schStr").val();
    break;
  case "username" :
	schStr = $("#schStr").val();
    break;
  case "cont" :
	schStr = $("#chk").val();
    break;
}
 //console.log("sel="+schSel+", str="+schStr+", url="+url)
    $.ajax({
        url: url+'?callback=?',
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

function go_trans(muLogSerno) {	// 마일리지 전환 승인	
	$.ajax({
        url: './kiki/c106_reward_trans.php?callback=?',
        type: 'POST',
		data: {
			"muLogSerno": muLogSerno,
			"appId": "<?=$kiki_appId?>",
       },
        contentType: 'application/x-www-form-urlencoded;charset=UTF-8', 
        dataType: 'json',
        success: function (data) {
		  if (data.prog == "true") {
			$("#modi_"+muLogSerno).text(data.modiYHS);
			$("#btn_"+muLogSerno).text("전환 완료");
			$("#chk_"+muLogSerno).hide();
			$("#txt_"+muLogSerno).show();
		  } else {
			alert(data.msg);
		  }
        },
       error: function(xhr, status, error) {
		 alert("error : "+error);
	   }
 	});
}

function register()  {
   var submitFlag = 0;
   var chked_val = "";
   var cnt = $('input:checkbox[name="muLogSerno[]"]').is(":checked");

   if(cnt == true) { 
     if(confirm(" 마일리지를 전환하시겠습니까? ")) {
	   var params = jQuery("#frm_reward").serialize(); // serialize() :
	   $.ajax({
        url: './kiki/c106_reward_transAll.php?callback=?',
        type: 'POST',
        data:params,
        contentType: 'application/x-www-form-urlencoded;charset=UTF-8', 
        dataType: 'json',
        success: function (data) {
		  if (data.prog == "true") {
			modiYHS = data.modiYHS;
			$(":checkbox[name='muLogSerno[]']:checked").each(function(pi,po){
//console.log(po.value);	
			  muLogSerno = po.value;
			  $("#modi_"+muLogSerno).text(modiYHS);
			  $("#btn_"+muLogSerno).text("전환 완료");
			  $("#chk_"+muLogSerno).hide();
			  $("#txt_"+muLogSerno).show();
			});
		  } else {
			alert(data.msg);
		  }
        },
       error: function(xhr, status, error) {
		 alert("error : "+error);
	   }
 	   });
     }
   } else {
     alert("마일리지 전환할 항목을 선택해 주세요."); 
   } 
}

function go_gifticon(mgStSerno) {	// 마일리지 전환 승인	
	$.ajax({
        url: './kiki/c106_reward_gifticon.php?callback=?',
        type: 'POST',
		data: {
			"mgStSerno": mgStSerno,
			"appId": "<?=$kiki_appId?>",
       },
        contentType: 'application/x-www-form-urlencoded;charset=UTF-8', 
        dataType: 'json',
        success: function (data) {
		  if (data.prog == "true") {
			$("#gmodi_"+mgStSerno).text(data.compYHS);
			$("#gbtn_"+mgStSerno).text("발급 완료");
			$("#gchk_"+mgStSerno).hide();
			$("#gtxt_"+mgStSerno).show();
		  } else {
			alert(data.msg);
		  }
        },
       error: function(xhr, status, error) {
		 alert("error : "+error);
	   }
 	});
}

function gifticon_register()  {
   var submitFlag = 0;
   var chked_val = "";
   var cnt = $('input:checkbox[name="mgStSerno[]"]').is(":checked");

   if(cnt == true) { 
     if(confirm("키프티콘을 발급하시겠습니까? ")) {
	   var params = jQuery("#frm_reward_gifticon").serialize(); // serialize() :
	   $.ajax({
        url: './kiki/c106_reward_gifticonAll.php?callback=?',
        type: 'POST',
        data:params,
        contentType: 'application/x-www-form-urlencoded;charset=UTF-8', 
        dataType: 'json',
        success: function (data) {
		  if (data.prog == "true") {
			compYHS = data.compYHS;
			$(":checkbox[name='mgStSerno[]']:checked").each(function(pi,po){
//console.log(po.value);	
			  mgStSerno = po.value;
			  $("#gmodi_"+mgStSerno).text(compYHS);
			  $("#gbtn_"+mgStSerno).text("발급 완료");
			  $("#gchk_"+mgStSerno).hide();
			  $("#gtxt_"+mgStSerno).show();
			});
		  } else {
			alert(data.msg);
		  }
        },
       error: function(xhr, status, error) {
		 alert("error : "+error);
	   }
 	   });
     }
   } else {
     alert("마일리지 전환할 항목을 선택해 주세요."); 
   } 
}

function SetChecked_mile(f) {
	var CheckBox = document.getElementsByName("muLogSerno[]"); 
	if( !CheckBox ) return;
	var Flag = document.frm_reward.flag;
//	var Flag = f;
	if( Flag.value == 1 ){
		Flag.value = 0;
	} else {
		Flag.value = 1;
   }
	if( CheckBox.name == 'muLogSerno[]' ){
		if( Flag.value == 1 )
			CheckBox.checked=true;
		else
			CheckBox.checked=false;
	} else {
		for( i = 0; i < CheckBox.length; i++ ){
		 if( Flag.value == 1 )
			 CheckBox[i].checked=true;
		 else
			 CheckBox[i].checked=false;
		}
	}
}

function SetChecked_gift(f) {
	var CheckBox = document.getElementsByName("mgStSerno[]"); 
	if( !CheckBox ) return;
	var Flag = document.frm_reward_gifticon.flag;
//	var Flag = f;
	if( Flag.value == 1 ){
		Flag.value = 0;
	} else {
		Flag.value = 1;
   }
	if( CheckBox.name == 'mgStSerno[]' ){
		if( Flag.value == 1 )
			CheckBox.checked=true;
		else
			CheckBox.checked=false;
	} else {
		for( i = 0; i < CheckBox.length; i++ ){
		 if( Flag.value == 1 )
			 CheckBox[i].checked=true;
		 else
			 CheckBox[i].checked=false;
		}
	}
}
</script>


<form name="kiki_frm_sub" method="post">
  <input type="hidden" name="cur_page" value="<?=$cur_page?>">
  <input type="hidden" name="appId" value="<?=$kiki_appId?>">
</form>