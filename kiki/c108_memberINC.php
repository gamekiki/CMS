<?	$sub_menu1 = "";	// 대시보드
	$sub_menu2 = "on";	// 회원관리
	$sub_menu3 = "";	// 액티비티 관리
	$sub_menu4 = "";	// 업적관리
	$sub_menu5 = "";	// 뱃지관리
	$sub_menu6 = "";	//통계/분석
	$sub_menu7 = "";	//리워드 관리
	$sub_menu8 = "";	//레벨설정	?> 
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
<?	include "./kiki/kiki_header.php";		?>
              
               <div class="kiki_row"  style="margin-top:50px">
                 <p class="tit">회원 관리</p>
                 <div class="con"> 
                   <div class="kiki_boardlist">
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
                   
                            <th>등록일</th>
                          </tr>
                         </thead> 
                         <tbody>
<?	$pagesize = 15 ;

	$cur_page = isset($_POST["cur_page"]) ? kiki_isnumb($_POST["cur_page"]) : 1;
	$board = "user";

	$wheStr = "appId = '$kiki_appId'";
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

	$SQL = "SELECT userSerno, userId, userName, UserPoint, regiYHS, (select levelId from ";
	$SQL .= " appLevel where appId = '$kiki_appId' and a.UserPoint >= minPoint and ";
	$SQL .= " a.Userpoint <  maxPoint ) as levelId, userImg FROM $board a  WHERE $wheStr "; // 기간
	$SQL .= " order by regiYHS desc, UserPoint desc limit $start, $pagesize  ";
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
		}		?>
                           <tr>
                            <td><?=$num?></td>
                            <td><?=$userId?></td>
                            <td><a href="#" onclick="wrapWindowByMask('#kiki_mypoint','<?=$userId?>')"><?=$userName?></a></td>
                            <td id="level_<?=$userId?>"><?=$levelId?></td>
                            <td id="point_<?=$userId?>"><?=$UserPoint?></td>

                            <td> <?=$regiYHS?> </td>
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
                <h3 class="kikipanel-title"> 포인트 지급 / 회수 </h3>
                <a href="#" value="(.kikimodal_pop .close)" class="close"><img src="img/btn_close02.png" alt="닫기"></a>
            </div>
            <div class="kikipanel-body">
                <form>
                    <div class="form-group">
                       <a id="kiki_sign_plus" href="javascript:kiki_chang_sign('+','plus')" class="kikibtn"> + 지급 </a> <a href="javascript:kiki_chang_sign('-','minus')" id="kiki_sign_minus" class="kikibtn white"> - 회수 </a>
                    </div>
                    <div class="form-group">
                        <div class="tit">포인트</div>
                        <label><input class="form-control" id="kiki_point" onblur="kiki_chk_digit(this.value)" maxlength="6" placeholder="" type="text"></label>
                    </div>
                    <div class="form-group">
                        <div class="tit">사유</div>
                        <label><input class="form-control" id="kiki_comments" maxlength="50" placeholder="" type="text"></label>
                    </div> 
                </form>   
            </div>
            <div class="kikipanel-footer"> <a href="#" class="kikibtn btn-cancel">취소</a><a href="javascript:kiki_save_point();" class="kikibtn btn-ok">확인</a> </div>
        </div> <!-- // kikipanel -->
	</div>
    <!--// 수정 -->
<input type="hidden" id="kiki_sign" value="+">
<input type="hidden" id="kiki_userSerno" value="">
<script>
function kiki_chk_digit(val) { // 평점에 따른 graph width 변경...
	var patten = /^[0-9]*$/;
	var chk = patten.test(val); 
  if (chk == true) { // 0.5 ~ 5.0 사이라면
	
  } else {
	alert("숫자만 입력 가능합니다.");
	$("#kiki_point").val('');
	return;
  }
}

function kiki_chang_sign(sign, name) {	// 책 좋아요..
    $("#kiki_sign").val(sign);
  if (name == "plus") {
   $("#kiki_sign_plus").removeClass('white');
   $("#kiki_sign_minus").attr('class','kikibtn white');
  } else {
   $("#kiki_sign_minus").removeClass('white');
   $("#kiki_sign_plus").attr('class','kikibtn white');
  }
}

function kiki_save_point() {	// 책 좋아요..
    if ($("#kiki_point").val() < 1) {
        alert("지금/회수할 포인트를 입력하세요.");
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
		  "kiki_point": $("#kiki_point").val(),
		  "kiki_comments": $("#kiki_comments").val(),
          "userSerno": $("#kiki_userSerno").val(),
          "kiki_sign": $("#kiki_sign").val(),
       },
        contentType: 'application/x-www-form-urlencoded;charset=UTF-8', 
        dataType: 'json',
        success: function (data) {
		 if (data.prog == "true") {
			$("#point_"+$("#kiki_userSerno").val()).text(data.UserPoint);
			$("#level_"+$("#kiki_userSerno").val()).text(data.levelId);
			$("#kiki_point").val('');
			$("#kiki_comments").val('');
			$("#kiki_userSerno").val('');
			$("#kiki_sign").val('');

			$('#mask, .kikimodal_pop').hide(); 
	 	 } else {	
//			console.log("error");
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
</script>


<form name="kiki_frm_sub" method="post">
  <input type="hidden" name="cur_page" value="<?=$cur_page?>">
</form>