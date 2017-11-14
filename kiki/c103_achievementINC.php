 <script src="https://code.jquery.com/jquery-2.1.0.min.js"></script>
<?	$sub_menu1 = "";	// 대시보드
	$sub_menu2 = "";	// 회원관리
	$sub_menu3 = "";	// 액티비티 관리
	$sub_menu4 = "on";	// 업적관리
	$sub_menu5 = "";	// 뱃지관리
	$sub_menu6 = "";	//통계/분석
	$sub_menu7 = "";	//리워드 관리
	$sub_menu8 = "";	//레벨설정	?>
	 <div class="kiki_content">
        <div class="kiki_conwrap">    
            <div class="kiki_box">
               <!-- <div class="tit_top bm20">Bookoa</div> -->
<?	include "./kiki/kiki_header.php";		?>
              
               <div class="kiki_row"  style="margin-top:50px">
                 <p class="tit">업적 관리</p>
                 <div class="con"> 
                   <div class="kiki_boardlist">
                     <!-- table :액티비티 20개씩 출력 -->
                     <table class="kiki_tblT01" cellspacing="0" cellpadding="0" border="0">
                               <colgroup>
                                 <col width="10%">
                                 <col width="">
                                 <col width="20%">
                                 <col width="20%">
                                 <col width="20%">
                                </colgroup>
<?	$pagesize = 20 ;
	$cur_page = isset($_POST["cur_page"]) ? kiki_isnumb($_POST["cur_page"]) : 1;

	$wheStr = "appId = '$kiki_appId' and delFlag = 'N' ";
	$SQL = "Select count(achiId) as totcnt from achievement WHERE $wheStr ";
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
                         <thead>
                          <tr>
                            <th>횟수</th>
                            <th>액티비티 이름</th>
                            <th>포인트</th>
                            <th>뱃지</th>
                            <th>수정/삭제</th>
                          </tr>
                         </thead> 
                         <tbody id='achievement_tr'>
<?	if ($totcnt == 0) {	// 자료가 없다면	?>
                           <tr><td colspan='5' class='kiki_nodata'> 등록된 업적이 없습니다.</td> </tr>
<?	} else {
		$start = ($cur_page-1) * $pagesize;
		$SQL = "select achiSerno, achiId, achiName, point, (select count ";
		$SQL .= " from achievement_sub where a.achiId = achiId) ";
		$SQL .= " as count, (select badgeImg from appbadges b ";
		$SQL .= " where a.badgeId = b.badgeId) as badgeImg from achievement a ";
		$SQL .= " WHERE  $wheStr ORDER BY achiSerno desc limit $start, $pagesize ";
//	echo $SQL;
		$result_Q = mysqli_query($kiki_conn, $SQL);
		if( $result_Q === false) {
			 die( print_r( mysqli_connect_error(), true) );
		} else {
			while($row = mysqli_fetch_array($result_Q, MYSQLI_ASSOC)) {
			   $achiSerno = $row["achiSerno"];		
			   $achiId = $row["achiId"];
			   $achiName = $row["achiName"];
			   $achiName = stripslashes($achiName);
			   $point = $row["point"];
			   $point = stripslashes($point);
			   $count = $row["count"];
			   $count = stripslashes($count);
			   $badgeImg = $row["badgeImg"];
			   $badgeImg = stripslashes($badgeImg);
	   if($badgeImg) {
			$temp_name = explode("||", $badgeImg);
			$save_file_name = $temp_name[0];
			$badgeImg = "../data/badge/".$developerId."/".$kiki_appId."/thumb_".$save_file_name;
		}	?>
                           <tr id="<?=$achiSerno?>">
                            <td><?=$count?></td>
                            <td><a href="javascript:view_achievement('<?=$achiId?>','<?=$achiName?>');"><?=$achiName?></a></td>
                            <td><? if($point) { ?><?=$point?> pts<? } ?></td>
                            <td><? if($badgeImg) { ?><img src="<?=$badgeImg?>" alt="뱃지이미지"/> <? } ?></td>
                            <td><a href="javascript:modify_achievement('<?=$achiSerno?>');" class="kikibtn_modify">수정</a> &nbsp; <a href="javascript:remove_achievement('<?=$achiSerno?>','<?=$achiId?>')" class="kikibtn_del">삭제</a></td>
                           </tr>
<?	  } // row while
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
                       <div class="kikibtnarea text_right">
                          <a href="javascript:write_achievement();" class="kikibtn"> 업적 생성 </a>
                       </div>  
                   </div>

                 </div> <!-- //.con -->
               </div> <!-- //.kiki_row -->
              
            </div> <!-- //kiki_box -->      
       </div>
      </div>

<script>
function remove_achievement(achiSerno,achiId) {
  if(confirm('삭제하시겠습니까?'))	{
	$.ajax({
	    type: 'post',
        dataType: 'json',
	    url: "./kiki/c103_achievement_remove.php?callback=?",
	    data: {
			"achiSerno": achiSerno,
			"achiId": achiId,
	    },
	    success: function(data) {
		  if (data.prog == "true") {
			$("tr#"+achiSerno).remove();
			val = $("tbody#achievement_tr>tr:first").text()
			if ((val.trim() === "") || (val.trim() === "undefined") || (val.trim() === "")) {
				var txt = "<tr><td colspan='5' class='kiki_nodata'>등록된 액티비티가 없습니다.</td></tr>"
			$('.kiki_tblT01> tbody:last').append(txt);
	        }
		  } else {
				console.log("error");
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
	 document.kiki_frm_sub.action="./c103_achievement.php";
     document.kiki_frm_sub.submit();
}

function view_achievement(achiId, achiName){
     document.kiki_frm_sub.achiId.value = achiId;
     document.kiki_frm_sub.achiName.value = achiName;
	 document.kiki_frm_sub.method="post";
	 document.kiki_frm_sub.action="./c103_achievement_view.php";
     document.kiki_frm_sub.submit();
}

function modify_achievement(achiSerno){
     document.kiki_frm_sub.achiSerno.value = achiSerno;
	 document.kiki_frm_sub.method="post";
	 document.kiki_frm_sub.action="./c103_achievement_modify.php";
     document.kiki_frm_sub.submit();
}

function write_achievement(){
	 document.kiki_frm_sub.method="post";
	 document.kiki_frm_sub.action="./c103_achievement_write.php";
     document.kiki_frm_sub.submit();
}
</script>


<form name="kiki_frm_sub" method="post">
  <input type="hidden" name="cur_page" value="<?=$cur_page?>">
  <input type="hidden" name="achiSerno" value="">
  <input type="hidden" name="achiId" value="">
  <input type="hidden" name="achiName" value="">
</form>