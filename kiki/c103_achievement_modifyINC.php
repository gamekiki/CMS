<script src="https://code.jquery.com/jquery-2.1.0.min.js"></script>
<script>
function wrapWindowByMask(elemId) {
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
	$(elemId).show();
}

$(document).ready(function(){
	$('.openMask').click(function(e){
	   e.preventDefault();
	});

	$('.kikimodal_pop .close').click(function (e) {
	  e.preventDefault();
	  $('#mask, .kikimodal_pop').hide();
	  $("#kiki_actId").val('');
	  $("#kiki_actiname").text('');
	});

	//닫기 버튼을 눌렀을 때
	$('.kikimodal_pop .btn-cancel').click(function (e) {    //링크 기본동작은 작동하지 않도록 한다.  
	  e.preventDefault();  
	  $('#mask, .kikimodal_pop').hide(); 
	  $("#kiki_actId").val('');
	  $("#kiki_actiname").text('');
	});       
});
</script>
<?	$sub_menu1 = "";	// 대시보드
	$sub_menu2 = "";	// 회원관리
	$sub_menu3 = "";	// 액티비티 관리
	$sub_menu4 = "on";	// 업적관리
	$sub_menu5 = "";	// 뱃지관리
	$sub_menu6 = "";	//통계/분석
	$sub_menu7 = "";	//리워드 관리
	$sub_menu8 = "";	//레벨설정		?>
	  <div class="kiki_content">
        <div class="kiki_conwrap">    
            <div class="kiki_box">
               <!-- <div class="tit_top bm20">Bookoa</div> -->
<?	include "./kiki/kiki_header.php";
	$cur_page = kiki_ischar($_POST["cur_page"]);
	$achiSerno = kiki_ischar($_POST["achiSerno"]);
	
	$SQL = "select a.achiId, achiName, point, badgeId, b.actId, count, actName ";
	$SQL .= " from achievement a INNER JOIN achievement_Sub b ON ";
	$SQL .= " a.achiId = b.achiId INNER JOIN activity c ON b.actId = c.actId ";
	$SQL .= " WHERE  achiSerno = '$achiSerno'  ";
//echo $SQL;
//exit;
	$result_Q = mysqli_query($kiki_conn, $SQL);
	if( $result_Q === false) {
		 die( print_r( mysqli_connect_error(), true) );
	} else {
		$row = mysqli_fetch_array($result_Q, MYSQLI_ASSOC);
		$achiId = $row["achiId"];
		$achiName = $row["achiName"];
		$kiki_point = $row["point"];
		$kiki_badgeId = $row["badgeId"];
		$kiki_actId = $row["actId"];
		$kiki_count = $row["count"];
		$kiki_actName = $row["actName"];
		mysqli_free_result( $result_Q);
	}	?>
              
               <div class="kiki_row"  style="margin-top:50px">
                 <p class="tit">업적 생성</p>
                 <div class="con"> 
<form action="./kiki/c103_achievement_modify.php" method="POST" name="kiki_frm">
                   <div class="kiki_tbview">
                     <!-- table :액티비티 20개씩 출력 -->
                     <table class="tblT01_detail" cellspacing="0" cellpadding="0" border="0">
                         <colgroup>
                         <col width="15%">
                         <col width="">
                         </colgroup>
                       <thead>
                       </thead> 
                       <tbody>             
                          <tr>
                            <th>업적 이름</th>
                             <td><label><input name="achiName" value="<?=$achiName?>" maxlength="15" placeholder="" type="text"></label></td>
                          </tr>
                          <tr>
                            <th>액티비티 선택</th>
                             <td><a href="#" onclick="wrapWindowByMask('#kiki_storage')" class="kikibtn white" style="padding:8px 10px; font-size:11px">액티비티 선택</a> &nbsp; <span id="kiki_actiname"><?=$kiki_actName?></span></td>
                          </tr>
                          <tr>
                            <th>횟수</th>
                             <td>
                             <input name="kiki_count" id="kiki_count" value="<?=$kiki_count?>" maxlength="3" value="<?=$kiki_count?>" placeholder="" onblur="kiki_chk_digit(this.value,'kiki_count')" type="text" style="width:30%"> &nbsp; 회 </label>
                             </td>
                          </tr>
                       </tbody>
                      </table>
                   </div> <!-- // kiki_tbview -->
                     
                     <p class="tit02" style="margin-top:30px">- 리워드  &nbsp;&nbsp; </p>
                     <div class="kiki_tbview">
                     <!-- table :액티비티 20개씩 출력 -->
                     <table class="tblT01_detail" cellspacing="0" cellpadding="0" border="0">
                         <colgroup>
                         <col width="15%">
                         <col width="">
                         </colgroup>
                       <thead>
                       </thead> 
                       <tbody>           
                          <tr class="kikipoint">
                            <th>포인트</th>
                             <td><label><input name="kiki_point" id="kiki_point" onblur="kiki_chk_digit(this.value,'kiki_point')" value="<?=$kiki_point?>" maxlength="5" placeholder="" style=" width:70%" type="text"></label>&nbsp; point</td>
                          </tr>
                          <tr class="kikibadge">
                            <th>뱃지 </th>
                             <td>
                             <div class="kikibadge_wrap">
                               <ul class="badge">
<?	$SQL = "Select badgeId, badgeImg from appbadges where developerId ";
	$SQL .= " = '$developerId' and appId = '$kiki_appId' order by badgeSerno ";
//echo $SQL;
	$result = mysqli_query($kiki_conn, $SQL);
	if( $resul2 === false) {
		 die( print_r( mysqli_connect_error(), true) );
	} else {
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		$list_badgeId = $row["badgeId"];		
		$list_badgeImg = $row["badgeImg"];
		$list_badgeImg = stripslashes($list_badgeImg);
			   if($list_badgeImg) {
				 $temp_name = explode("||", $list_badgeImg);
				 $save_file_name = $temp_name[0];
				 $list_badgeImg = "../data/badge/".$developerId."/".$kiki_appId."/thumb_".$save_file_name;
			   } else {
				   $list_badgeImg = "../img/badge01.png";
			   }	?>
             <li id="bg_<?=$list_badgeId?>" <? if ($kiki_badgeId == $list_badgeId) { ?>class="on" <? } ?>><img src="<?=$list_badgeImg?>" onclick="javascript:kiki_reward_badgeId('<?=$list_badgeId?>')"/></li>
<?		} // row while
  	mysqli_free_result( $result);
	}		?> <? if ($kiki_badgeId) { ?> &nbsp; <input name="badgeDel" value="Y" type="checkbox"> 뱃지 삭제 <? } ?>
                               </ul>
                             </div>
                             </td>
                          </tr>
                         </tbody>
                      </table> 
                     </div> 
                     <!-- // kiki_tbview -->
    <input type="hidden" name="kiki_actId" id="kiki_actId" value="<?=$kiki_actId?>">
    <input type="hidden" name="rewardBadge" value="<?=$kiki_badgeId?>">
    <input type="hidden" name="cur_page" value="<?=$cur_page?>">
	<input type="hidden" name="achiId" value="<?=$achiId?>"> 
</form>
                   <!-- btnarea -->
                   <div class="kikibtnarea text_right">
                     <a href="javascript:history.go(-1);" class="kikibtn"> 취 소 </a> <a href="javascript:kiki_checkForm();" class="kikibtn"> 업적 수정 </a>
                   </div>  
                   <!-- // btnarea -->             

                 </div> <!-- //.con -->
               </div> <!-- //.kiki_row -->
              
            </div> <!-- //kiki_box -->      
       </div>
      </div>
<script>
function kiki_chk_digit(val, name) { // 평점에 따른 graph width 변경...
	var patten = /^[0-9]*$/;
	var chk = patten.test(val); 
  if (chk == true) { // 0.5 ~ 5.0 사이라면
	
  } else {
	alert("숫자만 입력 가능합니다.");
	$("#"+name).val('');
  }
}

function kiki_reward_badgeId(badgeId) {
   $('input:hidden[name="rewardBadge"]').val(badgeId);
   $(".badge > li").removeClass("on");
   $("#bg_"+badgeId).attr('class','on');
}

function kiki_checkForm() {
	if (document.kiki_frm.achiName.value.length < 1) {
        alert("업적 이름 입력하세요.");
        document.kiki_frm.achiName.focus();
        return;
    }
	if (document.kiki_frm.kiki_actId.value.length < 1) {
        alert("액티비티를 선택하세요.");
        return;
    }
	if (document.kiki_frm.kiki_count.value.length < 1) {
        alert("횟수를 입력하세요.");
        document.kiki_frm.kiki_count.focus();
        return;
    }
	var kiki_point = document.kiki_frm.kiki_point.value ;
	var rewardBadge = document.kiki_frm.rewardBadge.value  ;
	if (kiki_point == "" && rewardBadge == "" ) {
        alert("리워드를 등록해 주세요.");
        return;
   }
	if ($("input:checkbox[name=badgeDel]").is(":checked") == true) {
		badgeDel = "Y";
	} else {
		badgeDel = "N";
	}
   if (kiki_point == "" && badgeDel == "Y" ) {
        alert("리워드를 등록해 주세요.");
        return;
   }
    document.kiki_frm.submit();
}

function select_activity(actId, actname) {
   $("input:hidden[name=kiki_actId]").val(actId);
   $("#kiki_actiname").text(actname);

   $("td > a").attr('class',"kikibtn white");
   $("#acti_btn_"+actId).attr('class','kikibtn');
}


function chk_select_activity() {
   var actId = $("input:hidden[name=kiki_actId]").val();
   if (!actId) {
	   alert("액티비티를 선택해 주세요.");
	   return;
   } else {
	   $('#mask, .kikimodal_pop').hide(); 
   }
}
</script>
<!-- 모달팝업 영역 -->   
    <div id="mask"></div>
      <!-- 액티비티선택 -->
    <div id="kiki_storage" class="kikimodal_pop" style="display:none">
        <div class="kikipanel">
            <div class="kikipanel-heading">
                <h3 class="kikipanel-title"> 액티비티 선택 </h3>
                <a href="#" value="(.kikimodal_pop .close)" class="close"><img src="img/btn_close02.png" alt="닫기"></a>
            </div>
            <div class="kikipanel-body">
                <div class="kiki_boardlist hfix">
                     <!-- table :액티비티 20개씩 출력 -->
                     <table class="kiki_tblT01" cellspacing="0" cellpadding="0" border="0">
                               <colgroup>
                                 <col width="40%">
                                 <col width="25%">
                                 <col width="">
                                </colgroup>
                         <thead>
                          <tr>
                            <th>액티비티 이름</th>
                            <th>포인트</th>
                            <th>선택</th>
                          </tr>
                         </thead> 
                         <tbody>
<?	$wheStr = "appId = '$kiki_appId' and developerId = '$developerId'";
	$SQL = "Select count(actId) as totcnt from activity WHERE $wheStr ";
	$result_count = mysqli_query($kiki_conn, $SQL);
	if ( $result_count === false ) {
		die( print_r( mysqli_connect_error(), true));
		mysqli_close($kiki_conn);
	} else {
	  $row = mysqli_fetch_array($result_count, MYSQLI_ASSOC);
 	  $totcnt = $row["totcnt"];	
	  mysqli_free_result($result_count);
	}
	if ($totcnt == 0) {	// 자료가 없다면	?>	
                           <tr>
                            <td colspan='3' class='kiki_nodata'> 등록된 액티비티가 없습니다.</td>
                           </tr>
<?	} else {
		$start = ($cur_page-1) * $pagesize;
		$num = $totcnt ;

		$SQL = "select actId, actName, (select rewardValue ";
		$SQL .= " from activity_reward where a.actId = actId and rewkind='P') ";
		$SQL .= " as rewardValue from activity a ";
		$SQL .= " WHERE  $wheStr ORDER BY actSerno desc ";
		$result_Q = mysqli_query($kiki_conn, $SQL);
		if( $result_Q === false) {
			 die( print_r( mysqli_connect_error(), true) );
		} else {
			while($row = mysqli_fetch_array($result_Q, MYSQLI_ASSOC)) {
			   $actId = $row["actId"];
			   $actName = $row["actName"];
			   $actName = stripslashes($actName);
			   $rewardValue = $row["rewardValue"];
			   $rewardValue = stripslashes($rewardValue);
			  if ($kiki_actId == $actId) { 
				  $this_class = "kikibtn";
			  } else {
				  $this_class = "kikibtn white";
			  }			   ?>
                           <tr>
                            <td><?=$actName?></td>
                            <td><? if($rewardValue) { ?> <?=$rewardValue?> pts<? } ?></td>
                            <td><a id="acti_btn_<?=$actId?>" href="javascript:select_activity('<?=$actId?>','<?=$actName?>');" class="<?=$this_class?>" style="padding: 8px 10px 8px 10px; font-size:11px"> 선택 </a></td>
                           </tr>
<?	  } // row while
  	mysqli_free_result( $result_Q);
	}
}  // if($totcnt == 0) {
	mysqli_close($kiki_conn);	?>  
                         </tbody>
                      </table>  
                      <!-- // table :액티비티 --> 
                  </div>  
                   
            </div>
            <div class="kikipanel-footer"> <a href="#" class="kikibtn btn-cancel">취소</a><a href="javascript:chk_select_activity()" class="kikibtn btn-ok">확인</a> </div>
            
        </div> <!-- // kikipanel -->
		
	</div>
    <!--// 액티비티선택 -->