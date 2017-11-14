 <script src="https://code.jquery.com/jquery-2.1.0.min.js"></script>
<?	$sub_menu1 = "";	// 대시보드
	$sub_menu2 = "";	// 회원관리
	$sub_menu3 = "on";	// 액티비티 관리
	$sub_menu4 = "";	// 업적관리
	$sub_menu5 = "";	// 뱃지관리
	$sub_menu6 = "";	//통계/분석
	$sub_menu7 = "";	//리워드 관리
	$sub_menu8 = "";	//레벨설정	?>
	  <div class="kiki_content">
        <div class="kiki_conwrap">    
            <div class="kiki_box">
               <!-- <div class="tit_top bm20">Bookoa</div> -->
<?	include "./kiki/kiki_header.php";
	$cur_page = kiki_isnumb($_POST["cur_page"]);
//echo "cur_ = $cur_page; ";	?>
              
               <div class="kiki_row"  style="margin-top:50px">
                 <p class="tit">새 액티비티 생성</p>
                 <div class="con"> 
                   <div class="kiki_tbview">
                     <!-- table :액티비티 20개씩 출력 -->
<form action="./kiki/c102_activities_write.php" method="POST" name="kiki_frm">
                     <table class="tblT01_detail" cellspacing="0" cellpadding="0" border="0">
                         <colgroup>
                         <col width="15%">
                         <col width="">
                         </colgroup>
                       <thead>
                       </thead> 
                       <tbody>             
                          <tr>
                            <th>이름</th>
                             <td><label><input name="actName" value="<?=$actName?>" placeholder="" maxlength="40" type="text"></label></td>
                          </tr>
                          <tr>
                            <th>설명</th>
                             <td><label><input name="actDesc" value="<?=$actDesc?>" maxlength="140" placeholder="액티비티 설명을 입력하세요" type="text"></label></td>
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
                          <tr>
                          <th> 필수 선택</th>
                            <td colspan="">
                            <span class="kiki_sel"> <input name="rewardP" value="P" type="checkbox" onclick="kiki_showhideP();"> 포인트 &nbsp; <input name="rewardB" value="B" type="checkbox" onclick="kiki_showhideB();">뱃지</span> &nbsp;  &nbsp; (포인트, 뱃지를 선택해 주세요) </td>
                          </tr>           
                          <tr class="kikipoint" style="display:none">
                            <th>포인트</th>
                             <td><label><input name="rewardPoint" id="rewardPoint" value="" onblur="kiki_chk_digit(this.value,'rewardPoint')" maxlength="3" placeholder="" type="text" style=" width:70%"></label>&nbsp; point</td>
                          </tr>
                          <tr class="kikipoint" style="display:none">
                            <th>포인트 제약조건</th>
                             <td>
                             <div class="kikipoint_wrap">
                                 <div class="inp_set">
                                    <p><a href="#" class="kikibtn_point on" id="kiki_reward_pointshow_1" onclick="javascript:kiki_reward_pointshow('kiki_reward_pointshow_1','1')">하루1회</a> <a href="#" class="kikibtn_point" id="kiki_reward_pointshow_2" onclick="javascript:kiki_reward_pointshow('kiki_reward_pointshow_2','2')">하루2회</a> <a href="#" class="kikibtn_point" id="kiki_reward_pointshow_3" onclick="javascript:kiki_reward_pointshow('kiki_reward_pointshow_3','3')">하루3회</a>
                                    </p>
                                    <p>
                                    <a href="#" class="kikibtn_point" id="kiki_reward_pointshow_a" onclick="javascript:kiki_reward_pointshow('kiki_reward_pointshow_a','a')">단 회</a> <a href="#" class="kikibtn_point" id="kiki_reward_pointshow_n" onclick="javascript:kiki_reward_pointshow('kiki_reward_pointshow_n','N')">무한제공</a> <a href="#" class="kikibtn_point" id="kiki_reward_pointshow_p" onclick="javascript:kiki_reward_pointshow('kiki_reward_pointshow_p','P')">직접입력</a>
                                    </p>
                                 </div> 
                                 <p class="bm20" id="rewardKindP" style="display:none">
                                  <span class="bold">하루</span> &nbsp;<input class="width_at" id="restrictP" name="restrictP" maxlength="3" onblur="kiki_chk_digit(this.value,'restrictP')" size="44%" type="text"> <span class="bold"> &nbsp;회</span>
                                </p>
                              </div> <!-- // kikipoint_wrap -->
                            </td>
                          </tr>
                          <tr  class="kikibadge" style="display:none">
                            <th>뱃지 선택</th>
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
             <li id="bg_<?=$list_badgeId?>" class=""><img src="<?=$list_badgeImg?>" onclick="javascript:kiki_reward_badgeId('<?=$list_badgeId?>')"/></li>
<?		} // row while
  	mysqli_free_result( $result);
	}	
mysqli_close($kiki_conn);	?> 
                               </ul>
                             </div>
                             </td>
                          </tr>
                         </tbody>
                      </table> 
  <input type="hidden" name="rew_point_restrict" value="1">
  <input type="hidden" name="rewardBadge">
  <input type="hidden" name="cur_page" value="<?=$cur_page?>">
</form>
                     </div> 
                     <!-- // kiki_tbview -->
                   <!-- btnarea -->
                   <div class="kikibtnarea text_right">
                     <a href="javascript:history.back();" class="kikibtn"> 취 소 </a> <a href="javascript:kiki_checkForm();" class="kikibtn"> 새 액티비티 생성 </a>
                   </div>  
                   <!-- // btnarea -->             

                 </div> <!-- //..con -->
               </div> <!-- //.kiki_row -->
              
            </div> <!-- //.box_bg -->      
       </div>
      </div>

<script>
function kiki_showhideP() {
	showhide = $(".kikipoint").css("display");
  if(showhide === "none"){
   $(".kikipoint").show();
  } else { // 보
	$(".kikipoint").hide();
  }
}
function kiki_showhideB() {
	showhide = $(".kikibadge").css("display");
  if(showhide === "none"){
     $(".kikibadge").show();
  } else { // 보
	 $(".kikibadge").hide();
  }
}

function kiki_chk_digit(val, name) { // 평점에 따른 graph width 변경...
	var patten = /^[0-9]*$/;
	var chk = patten.test(val); 
  if (chk == true) { // 0.5 ~ 5.0 사이라면
	
  } else {
	alert("숫자만 입력 가능합니다.");
	$("#"+name).val('');
  }
}

function kiki_reward_pointshow(id,val) {
//   $(".on").attr('class', 'kikibtn_point');
	 $("p > a ").removeClass("on");
     $(".kikipoint_wrap > li").removeClass("on");
//	 $(".btn-midorange").attr('class', 'btn-lightgray');
	 $("#"+id).attr('class', 'kikibtn_point on');
  if(val == "P") { // 포인트
	 $("#rewardKindP").show();
	 $("input:hidden[name=rew_point_restrict]").val('P');
  } else {
     $("#rewardKindP").hide();
	 $("input:hidden[name=rew_point_restrict]").val(val);
  }
}

function kiki_reward_badgeId(badgeId) {
   $('input:hidden[name="rewardBadge"]').val(badgeId);
   $(".badge > li").removeClass("on");
   $("#bg_"+badgeId).attr('class','on');
}

function kiki_checkForm() {
	if (document.kiki_frm.actName.value.length < 1) {
        alert("이름을 입력하세요.");
        document.kiki_frm.actName.focus();
        return;
    }
	var rewardP = $("input:checkbox[name='rewardP']").is(":checked") ;
	var rewardB = $("input:checkbox[name='rewardB']").is(":checked") ;
	var rewardPoint = $("#rewardPoint").val();

	if (rewardP === false && rewardB === false ) {
        alert("리워드를 등록해 주세요.");
        return;
   }
   if (rewardP === true && (rewardPoint == 0)   ) {
        alert("리워드 포인트를 등록해 주세요.");
        return;
   }
   if (rewardB === true && (document.kiki_frm.rewardBadge.value.length < 1)) {
        alert("리워드 뱃지를 등록해 주세요.");
        return;
   }
    document.kiki_frm.submit();
}
</script>