<?	$sub_menu1 = "";	// 대시보드
	$sub_menu2 = "on";	// 회원관리
	$sub_menu3 = "";	// 액티비티 관리
	$sub_menu4 = "";	// 업적관리
	$sub_menu5 = "";	// 뱃지관리
	$sub_menu6 = "";	//통계/분석
	$sub_menu7 = "";	//리워드 관리
	$sub_menu8 = "";	//레벨설정
	$sub_menu9 = "";	//미니게임
	$sub_menu10 = "";	//상품추천		?> 
<script src="https://code.jquery.com/jquery-2.1.0.min.js"></script>
<script>
	function wrapWindowByMask(elemId, userSerno){
		$("#kiki_userSerno").val(userSerno);
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
		console.debug("d tesT", d, elemId);
		//kikimodal_pop 같은 거 띄운다.
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
		    $('#mask, .kikimodal_pop').hide();  
			$("#kiki_point").val('');
			$("#kiki_comments").val('');
			$("#kiki_userSerno").val('');
			$("#kiki_sign").val('');
		}); 
		//닫기 버튼을 눌렀을 때
		$('.kikimodal_pop .btn-cancel').click(function (e) {  
		    //링크 기본동작은 작동하지 않도록 한다.
		    e.preventDefault();  
		    $('#mask, .kikimodal_pop').hide();
			$("#kiki_point").val('');
			$("#kiki_comments").val('');
			$("#kiki_userSerno").val('');
			$("#kiki_sign").val('');
		});       

		//검은 막을 눌렀을 때
/*		$('#mask').click(function () {  
		    $(this).hide();  
		    $('.kikimodal_pop').hide();  
		}); */      
	});
</script>
	  <div class="kiki_content">
        <div class="kiki_conwrap">    
            <div class="kiki_box">
               <!-- <div class="tit_top bm20">Bookoa</div> -->
<?	include "./kiki/kiki_header.php";	
	$cur_page = isset($_POST["cur_page"]) ? kiki_isnumb($_POST["cur_page"]) : 1;
	$schSel = isset($_POST["schSel"]) ? kiki_ischar($_POST["schSel"]) : '';	
	$schStr = isset($_POST["schStr"]) ? kiki_ischar($_POST["schStr"]) : '';	
$wheStr = "appId = '$kiki_appId'";
if ($schSel) {
	$wheStr .= " and ($schSel like '%". trim($schStr). "%')"; 
} else {
	$schStr = "";
}	?>
              
               <div class="kiki_row"  style="margin-top:50px">
                 <p class="tit">회원 관리</p>
                 <div class="con"> 
                   <div class="searchtop_area">
                    <div class="fl_right">
                     <div class="search">
                      <label></label>
                      <select name="schSel" id="schSel" class="select_style">
                       <option value="" <? if ($schSel == "") { ?> selected <? } ?>>전체보기</option>
                       <option value="userId" <? if ($schSel == "userId") { ?> selected <? } ?>>아이디</option>
                       <option value="userName" <? if ($schSel == "userName") { ?> selected <? } ?>>이름</option>
                      </select>
                      <input name="schStr" id="schStr" value="<?=$schStr?>" maxlength="15" class="" type="text">
                      <a href="javascript:load_sch();" class="kikibtn gray2"> 검 색 </a>
                     </div>
                    </div>
                   </div>
                   <div class="con kiki_boardlist">
                     <!-- table :액티비티 20개씩 출력 -->
                     <table class="kiki_tblT01" cellspacing="0" cellpadding="0" border="0">
                        <colgroup>
                          <col width="10%">
                          <col width="20%">
                          <col width="">
                          <col width="10%">
                          <col width="10%">
                          <col width="20%">
                         </colgroup>
                         <thead>
                          <tr>
                            <th>No</th>
                            <th>아이디</th>
                            <th>이름</th>
                            <th>레벨</th>
                            <th>포인트</th>
                            <th>마일리지</th>
                          </tr>
                         </thead> 
                         <tbody>
<?	$pagesize = 15 ;

	$board = "user";
	
	$SQL = "Select count(userSerno) as totcnt from $board WHERE $wheStr ";
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
	}
//echo "tot = $totcnt <BR>";
if($totcnt == 0) {	?>
                           <tr>
                            <td colspan="6" class="kiki_nodata">회원이 없습니다.</td>
                           </tr>
<?}  Else {
		$start = ($cur_page-1) * $pagesize;
		$num = $totcnt - (($cur_page - 1) * $pagesize);
		$nowdate = date("Y-m-d");

	$SQL = "SELECT userSerno, userId, userName, UserPoint, regiYHS, (select ";
	$SQL .= " levelId from appLevel where appId = '$kiki_appId' and a.UserPoint ";
	$SQL .= " >= minPoint and a.Userpoint <  maxPoint ) as levelId, userImg ";
	$SQL .= ", userMileage FROM $board a  WHERE $wheStr "; // 기간
	$SQL .= " order by UserPoint desc, regiYHS desc limit $start, $pagesize  ";
//echo $SQL;
	$result = mysqli_query($kiki_conn, $SQL);
	if( $result === false) {
		 die( print_r( mysqli_connect_error(), true) );
	} else {
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			$userSerno = $row["userSerno"];
			$userId = $row["userId"];
			$userId = stripslashes($userId);			
			$userName = $row["userName"];
			$userName = stripslashes($userName);
			$UserPoint = $row["UserPoint"];
	if ($UserPoint) {
		$UserPoint = number_format($UserPoint);
	}
			$regiYHS = new DateTime($row["regiYHS"]);
			$regiYHS2 = date_format($regiYHS, "Y-m-d");
			if ($nowdate == $regiYHS2) { // 오늘 등록한 글이라면
				$regiYHS = date_format($regiYHS, "H:i");
			} else {
				$regiYHS = date_format($regiYHS, "Y-m-d H:i");
			}
			$levelId = $row["levelId"];
			$levelId = stripslashes($levelId);
			$userImg = $row["userImg"];
			$userImg = stripslashes($userImg);
		if(!$userImg) {
			$userImg = "./kiki/img/myphoto.png";
		}
			$userMileage = $row["userMileage"];	
	if ($userMileage) {
		$userMileage = number_format($userMileage);
	}			?>
                           <tr>
                            <td><?=$num?></td>
                            <td><?=$userId?></td>
                            <td><a href="#" onclick="wrapWindowByMask('#kiki_mypoint','<?=$userId?>')"><?=$userName?></a></td>
                            <td id="level_<?=$userId?>"><?=$levelId?></td>
                            <td id="point_<?=$userId?>"><?=$UserPoint?></td>
                            <td id="mileage_<?=$userId?>"> <?=$userMileage?> </td>
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

<!-- 모달팝업 영역 -->   
    <div id="mask"></div>
     <!-- 포인트 지급 회수 -->
    <div id="kiki_mypoint" class="kikimodal_pop" style="display:none">
        <div class="kikipanel">
            <div class="kikipanel-heading">
                <h3 class="kikipanel-title"> 포인트 마일리지 지급 / 회수 </h3>
                <a href="#" value="(.kikimodal_pop .close)" class="close"></a>
            </div>
            <div class="kikipanel-body">
                <form name="kiki_frm">
                    <div class="form-group">
                       <div class="tit">종류</div>
                       <label> <a id="kiki_sign_point" href="javascript:kiki_change_chk('P','point')" class="kikibtn"> 포인트 </a> <a id="kiki_sign_mileage" href="javascript:kiki_change_chk('M','mileage')" class="kikibtn white"> 마일리지 </a> </label>
                    </div>
                    <div class="form-group">
                       <div class="tit">증감</div>
					   <label> <a id="kiki_sign_plus" href="javascript:kiki_change_sign('+','plus')" class="kikibtn"> + 지급 </a> <a href="javascript:kiki_change_sign('-','minus')" id="kiki_sign_minus" class="kikibtn white"> - 회수 </a> </label>
                    </div>
                    <div class="form-group">
                        <div class="tit">점수</div>
                        <label>
                        <input class="form-control" id="kiki_point" onblur="kiki_chk_digit(this.value)" maxlength="6" placeholder="숫자만 입력하세요" type="text" style="width:90%">
                        <p id='kiki_point_txt' class=" kiki_art"> </p>
                        </label>
                    </div>
                    <div class="form-group">
                        <div class="tit">사유</div>
                        <label>
                        <input class="form-control" id="kiki_comments" maxlength="20" onkeyup="chk_char()" placeholder="관리자 페이지에서만 보여집니다.(최대 15자)" type="text" style="width:90%">
                        <p id='kiki_comments_txt' class=" kiki_art"></p>
                        </label>
                    </div> 
                </form>   
            </div>
            <div class="kikipanel-footer"> <a href="#" class="kikibtn btn-cancel">취소</a><a href="javascript:kiki_save_point();" class="kikibtn btn-ok">확인</a> </div>
        </div> <!-- // kikipanel -->
	</div>
    <!--// 수정 -->
<input type="hidden" id="kiki_sign" value="+">
<input type="hidden" id="kiki_chk" value="P">
<input type="hidden" id="kiki_userSerno" value="">
<script>
function kiki_chk_digit(val) { // 평점에 따른 graph width 변경...
	var patten = /^[0-9]*$/;
	var chk = patten.test(val); 
  if (chk == true) { // 0.5 ~ 5.0 사이라면
	$("#kiki_point_txt").text('');
  } else {
	$("#kiki_point_txt").text('숫자만 입력하세요.');
	//alert("숫자만 입력 가능합니다.");
	$("#kiki_point").val('');
	$("#kiki_point").focus();
	return;
  }
}

function kiki_change_sign(sign, name) {	// 책 좋아요..
    $("#kiki_sign").val(sign);
  if (name == "plus") {
   $("#kiki_sign_plus").removeClass('white');
   $("#kiki_sign_minus").attr('class','kikibtn white');
  } else {
   $("#kiki_sign_minus").removeClass('white');
   $("#kiki_sign_plus").attr('class','kikibtn white');
  }
}

function kiki_change_chk(sign, name) {	// 책 좋아요..
    $("#kiki_chk").val(sign);
  if (name == "point") {
   $("#kiki_sign_point").removeClass('white');
   $("#kiki_sign_mileage").attr('class','kikibtn white');
  } else {
   $("#kiki_sign_mileage").removeClass('white');
   $("#kiki_sign_point").attr('class','kikibtn white');
  }
}

function kiki_save_point() {	// 책 좋아요..
    if ($("#kiki_point").val() < 1) {
        alert("지급/회수할 점수를 입력하세요.");
        $("#kiki_point").focus();
        return;
    }
//console.log($("#kiki_point").val());
//console.log($("#kiki_comments").val());
//console.log($("#kiki_userSerno").val());
//console.log($("#kiki_sign").val());
//console.log("<?=$kiki_appId?>");
	$.ajax({
        url: './kiki/c108_givePoint.php?callback=?',
        type: 'POST',
		data: {
		  "kiki_chk": $("#kiki_chk").val(),
		  "kiki_point": $("#kiki_point").val(),
		  "kiki_comments": $("#kiki_comments").val(),
          "userSerno": $("#kiki_userSerno").val(),
          "kiki_sign": $("#kiki_sign").val(),
		  "appId": "<?=$kiki_appId?>",
       },
        contentType: 'application/x-www-form-urlencoded;charset=UTF-8', 
        dataType: 'json',
        success: function (data) {
		 if (data.prog == "true") {
			$("#point_"+$("#kiki_userSerno").val()).text(data.UserPoint);
			$("#level_"+$("#kiki_userSerno").val()).text(data.levelId);
			$("#mileage_"+$("#kiki_userSerno").val()).text(data.userMileage);
			$("#kiki_point").val('');
			$("#kiki_comments").val('');
			$("#kiki_userSerno").val('');
			$("#kiki_sign").val('+');
			$("#kiki_chk").val('P');
		alert("정상적으로 처리되었습니다.");
   $("#kiki_sign_point").removeClass('white');
   $("#kiki_sign_mileage").attr('class','kikibtn white');
   $("#kiki_sign_plus").removeClass('white');
   $("#kiki_sign_minus").attr('class','kikibtn white');
			$('#mask, .kikimodal_pop').hide(); 
	 	 } else {	
			console.log("error");
			$('#mask, .kikimodal_pop').hide(); 
		 }
			},
       error: function(xhr, status, error) {
		 alert("error : "+error);
	   }
 	});
}

function kiki_list(pg){
     document.kiki_frm_sub.cur_page.value = pg;
	 document.kiki_frm_sub.method="post";
	 document.kiki_frm_sub.action="./c108_member.php";
     document.kiki_frm_sub.submit();
}

function load_sch(){
    schSel = $("#schSel").val();
	schStr = $("#schStr").val();
  if (schSel != ""  && !schStr) {
	alert("검색어를 입력하세요.");
	return;
  }
  document.kiki_frm_sub.schStr.value = schStr;
  document.kiki_frm_sub.schSel.value = schSel;
  document.kiki_frm_sub.submit();
}

function chk_char() {  // 글자수 체크
	var maxLength = 15;
	var $input = $('#kiki_comments');
	var textLength = $('#kiki_comments').val().length;
	var count = maxLength - textLength;

	var before = maxLength * 1;
	var now = maxLength - textLength;
	if (count < 0) {
	   var str = $('#kiki_comments').val();
	   $("#kiki_comments_txt").text('최대 15자까지 입력하세요.');
	//   alert('글자 입력수가 초과하였습니다.');
	   $('#kiki_comments').val(str.substr(0, maxLength));
	   count = 0;
	} else {
		$("#kiki_comments_txt").text('');
	}
}
</script>


<form name="kiki_frm_sub" method="post">
  <input type="hidden" name="cur_page" value="<?=$cur_page?>">
  <input type="hidden" name="appId" value="<?=$kiki_appId?>">
  <input type="hidden" name="schSel" value="<?=$schSel?>">
  <input type="hidden" name="schStr" value="<?=$schStr?>">
</form>