 <script src="https://code.jquery.com/jquery-2.1.0.min.js"></script>
<?	$sub_menu1 = "";	// 대시보드
	$sub_menu2 = "";	// 회원관리
	$sub_menu3 = "on";	// 액티비티 관리
	$sub_menu4 = "";	// 업적관리
	$sub_menu5 = "";	// 뱃지관리
	$sub_menu6 = "";	//통계/분석
	$sub_menu7 = "";	//리워드 관리
	$sub_menu8 = "";	//레벨설정
	$sub_menu9 = "";	//미니게임
	$sub_menu10 = "";	//상품추천		?>
	  <div class="kiki_content">
        <div class="kiki_conwrap">    
            <div class="kiki_box">
               <!-- <div class="tit_top bm20">Bookoa</div> -->
<?	include "./kiki/kiki_header.php";		?>
              
               <div class="kiki_row"  style="margin-top:50px">
                 <p class="tit">액티비티 관리</p>
                 <div class="con"> 
                 
                   <div class="kiki_boardlist">
                     <!-- table :액티비티 20개씩 출력 -->
                     <table class="kiki_tblT01" cellspacing="0" cellpadding="0" border="0">
                               <colgroup>
                                 <col width="20%">
                                 <col width="">
                                 <col width="20%">
                                 <col width="20%">
                                 <col width="20%">
                                </colgroup>
                         <thead>
<?	$pagesize = 20 ;
	$cur_page = isset($_POST["cur_page"]) ? kiki_isnumb($_POST["cur_page"]) : 1;

	$wheStr = "appId = '$kiki_appId' and developerId = '$developerId'";
	$SQL = "Select count(actId) as totcnt from activity WHERE $wheStr ";
	$result_count = mysqli_query($kiki_conn, $SQL);
	if ( $result_count === false ) {
		die( print_r( mysqli_connect_error(), true));
		mysqli_close($kiki_conn);
	} else {
	  $row = mysqli_fetch_array($result_count, MYSQLI_ASSOC);
 	  $totcnt = $row["totcnt"];	
	  $totpage = ceil((($totcnt / $pagesize) * -1) * -1);
	  mysqli_free_result($result_count);
	}	?>
            
                          <tr>
                            <th>액티비티 Id</th>
                            <th>액티비티 이름</th>
                            <th>포인트</th>
                            <th>뱃지</th>
                            <th>수정/삭제</th>
                          </tr>
                         </thead> 
                         <tbody id='activity_tr'>
<?	if ($totcnt == 0) {	// 자료가 없다면	?>
                           <tr><td colspan='5' class='kiki_nodata'> 등록된 액티비티가 없습니다.</td> </tr>
<?	} else {
		$start = ($cur_page-1) * $pagesize;
		$num = $totcnt ;
//echo "<br> star = $start , cur_page = $cur_page / ";
		$SQL = "select actSerno, actId, actName, (select rewardValue ";
		$SQL .= " from activity_reward where a.actId = actId and rewkind='P') ";
		$SQL .= " as rewardValue, (select badgeImg from activity_reward b ";
		$SQL .= " inner join appbadges  c on b.rewardValue = c.badgeId ";
		$SQL .= " where a.actId = b.actId and rewkind='B' and ";
		$SQL .= " rewardValue = badgeId) as badgeImg from activity a ";
		$SQL .= " WHERE  $wheStr ORDER BY actSerno desc limit $start, $pagesize ";
//	echo $SQL;
		$result_Q = mysqli_query($kiki_conn, $SQL);
		if( $result_Q === false) {
			 die( print_r( mysqli_connect_error(), true) );
		} else {
			while($row = mysqli_fetch_array($result_Q, MYSQLI_ASSOC)) {
			   $actSerno = $row["actSerno"];		
			   $actId = $row["actId"];
			   $actName = $row["actName"];
			   $actName = stripslashes($actName);
			   $rewardValue = $row["rewardValue"];
			   $rewardValue = stripslashes($rewardValue);
			   $badgeImg = $row["badgeImg"];
			   $badgeImg = stripslashes($badgeImg);
	   if($badgeImg) {
			$temp_name = explode("||", $badgeImg);
			$save_file_name = $temp_name[0];
			$badgeImg = "../data/badge/".$developerId."/".$kiki_appId."/thumb_".$save_file_name;
		}	?>
                           <tr id="<?=$actSerno?>">
                            <td><?=$actId?></td>
                            <td id="actname_<?=$actSerno?>"><?=$actName?> </td>
                            <td><? if($rewardValue <> "") { ?> <?=$rewardValue?> pts<? } ?></td>
                            <td><? if($badgeImg) { ?><img src="<?=$badgeImg?>" alt="뱃지이미지"/> <? } ?></td>
                            <td><a href="javascript:modify_activity('<?=$actSerno?>');" class="kikibtn_modify">수정</a> &nbsp; <a href="javascript:remove_activity('<?=$actSerno?>','<?=$actId?>')" class="kikibtn_del">삭제</a></td>
                           </tr>
<?		$num = $num - 1;
	  } // row while
  	mysqli_free_result( $result_Q);
		$rewSerno = "";
	}
}  // if($totcnt == 0) {
	mysqli_close($kiki_conn);	?>                    
                         </tbody>
                      </table>  
                      <!-- // table :액티비티 --> 
<?  if ($totcnt != 0) {	
		include "./kiki/kiki_pageINC.php";
	}	?>
                       <!-- btnarea -->
                       <div class="kikibtnarea text_right">
                          <a href="javascript:write_activity();" class="kikibtn"> 새 액티비티 생성 </a>
                       </div>  
                       <!-- // btnarea -->             
                   </div><!-- //kiki_boradlist-->
                 </div> <!-- //..con -->
               </div> <!-- //.kiki_row -->
              
            </div> <!-- //.box_bg -->      
       </div>
      </div>

<script>
function remove_activity(actSerno,actId) {
  if(confirm('삭제하시겠습니까?'))	{
	$.ajax({
	    type: 'post',
        dataType: 'json',
	    url: "./kiki/c102_activity_remove.php?callback=?",
	    data: {
			"actSerno": actSerno,
			"actId": actId,
			"appId": "<?=$kiki_appId?>",
	    },
	    success: function(data) {
		  if (data.prog == "true") {
			$("tr#"+actSerno).remove();
			val = $("tbody#activity_tr>tr:first").text()
			if ((val.trim() === "") || (val.trim() === "undefined") || (val.trim() === "")) {
				var txt = "<tr><td colspan='5' class='kiki_nodata'>등록된 액티비티가 없습니다.</td></tr>"
			$('.kiki_tblT01> tbody:last').append(txt);
	        }
		  }
	    },
	    error: function(xhr, status, error) {
		  alert(error);
	    }
	});
  }
}

function kiki_list(pg){
     document.kiki_frm_sub.cur_page.value = pg;
	 document.kiki_frm_sub.method="post";
	 document.kiki_frm_sub.action="./c102_activities.php";
     document.kiki_frm_sub.submit();
}

function modify_activity(actSerno){
     document.kiki_frm_sub.actSerno.value = actSerno;
	 document.kiki_frm_sub.method="post";
	 document.kiki_frm_sub.action="./c102_activities_modify.php";
     document.kiki_frm_sub.submit();
}

function write_activity(){
	 document.kiki_frm_sub.method="post";
	 document.kiki_frm_sub.action="./c102_activities_write.php";
     document.kiki_frm_sub.submit();
}
</script>


<form name="kiki_frm_sub" method="post">
  <input type="hidden" name="cur_page" value="<?=$cur_page?>">
  <input type="hidden" name="actSerno" value="">
  <input type="hidden" name="appId" value="<?=$kiki_appId?>">
</form>