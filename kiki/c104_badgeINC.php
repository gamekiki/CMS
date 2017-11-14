 <script src="https://code.jquery.com/jquery-2.1.0.min.js"></script>
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
		console.debug("d tesT", d, elemId);
		//kikimodal_pop 같은 거 띄운다.
		$(elemId).show();
	}

	$(document).ready(function(){
		//닫기 버튼을 눌렀을 때
		$('.kikimodal_pop .close').click(function (e) {  
		    //링크 기본동작은 작동하지 않도록 한다.
		    e.preventDefault();  
		    $('#mask, .kikimodal_pop').hide();  
		});       
		$('.kikimodal_pop .btn-cancel').click(function (e) {  
		    //링크 기본동작은 작동하지 않도록 한다.
		    e.preventDefault();  
		    $('#mask, .kikimodal_pop').hide();  
		});  
		//검은 막을 눌렀을 때
	/*	$('#mask').click(function () {  
		    $(this).hide();  
		    $('.kikimodal_pop').hide();  
		});    */   
	});
</script>

<?	$sub_menu1 = "";	// 대시보드
	$sub_menu2 = "";	// 회원관리
	$sub_menu3 = "";	// 액티비티 관리
	$sub_menu4 = "";	// 업적관리
	$sub_menu5 = "on";	// 뱃지관리
	$sub_menu6 = "";	//통계/분석
	$sub_menu7 = "";	//리워드 관리
	$sub_menu8 = "";	//레벨설정	?>
	  <div class="kiki_content">
        <div class="kiki_conwrap">    
            <div class="kiki_box">
               <!-- <div class="tit_top bm20">Bookoa</div> -->
<?	include "./kiki/kiki_header.php";	?>
              
               <div class="kiki_row"  style="margin-top:50px">
                 <p class="tit">뱃지 관리</p>
                 <div class="con"> 
                   <div class="kiki_boardlist">
                     <!-- table :액티비티 20개씩 출력 -->
                     <table class="kiki_tblT01" cellspacing="0" cellpadding="0" border="0">
                               <colgroup>
                                 <col width="20%">
                                 <col width="15%">
                                 <col width="">
                                 <col width="20%">
                                 <col width="15%">
                                </colgroup>
                         <thead>
<?
	$board = "appbadges";
	$pagesize = 20 ;
	$cur_page = isset($_POST["cur_page"]) ? kiki_isnumb($_POST["cur_page"]) : 1;

	$wheStr = "appId = '$kiki_appId' and developerId = '$developerId'";
	$SQL = "Select count(badgeId) as totcnt from $board WHERE $wheStr ";
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
                            <th>아이디</th>
                            <th>등록뱃지</th>
                            <th>뱃지이름</th>
                            <th>등록일</th>
                            <th>수정 / 삭제</th>
                          </tr>
                         </thead> 
                         <tbody id='badge_tr'>
<?	if ($totcnt == 0) {	// 자료가 없다면	?>
                          <tr><td colspan='5' class='kiki_nodata'> 등록된 뱃지가 없습니다.</td> </tr>
<?	} else {
		$start = ($cur_page-1) * $pagesize;
		$SQL = "select badgeSerno, badgeId, badgeName, badgeImg, badgeDate from $board";
		$SQL .= " WHERE  $wheStr ORDER BY badgeSerno desc limit $start, $pagesize  ";
		$result_Q = mysqli_query($kiki_conn, $SQL);
		if( $result_Q === false) {
			 die( print_r( mysqli_connect_error(), true) );
		} else {
			$num = $totcnt ;
			while($row = mysqli_fetch_array($result_Q, MYSQLI_ASSOC)) {
			   $badgeSerno = $row["badgeSerno"];		
			   $badgeId = $row["badgeId"];
			   $badgeName = $row["badgeName"];
			   $badgeName = stripslashes($badgeName);
			   $badgeImg = $row["badgeImg"];
			   $badgeImg = stripslashes($badgeImg);
			   if($badgeImg) {
				 $temp_name = explode("||", $badgeImg);
				 $save_file_name = $temp_name[0];
				 $badgeImg = "../data/badge/".$developerId."/".$kiki_appId."/thumb_".$save_file_name;
			   } else {
				   $badgeImg = "../img/badge01.png";
			   }
			   $badgeDate = new DateTime($row["badgeDate"]);
			   $badgeDate = date_format($badgeDate, "Y-m-d");	?>
                          <tr id='<?=$badgeId?>'> 
							<td><?=$badgeId?></td>
                            <td id='img_<?=$badgeId?>'><img src='<?=$badgeImg?>'/></td>
							<td id='name_<?=$badgeId?>'><?=$badgeName?></td>
							<td><?=$badgeDate?></td>
							<td><a href="javascript:kiki_badge_show('<?=$badgeId?>')" class="kikibtn_modify">수정</a> &nbsp; <a href="javascript:kiki_remove_badge('<?=$badgeId?>')" class="kikibtn_del">삭제</a></td>
                          </tr>
<?		$num = $num - 1;
		  } // while
		  mysqli_free_result( $result_Q);
		}  // if $result != false
	}  // if($totcnt == 0) {			?>
                         </tbody>
                      </table>  
                      <!-- // table :액티비티 --> 
<?  if ($totcnt != 0) {	
		include "./kiki/kiki_pageINC.php";
	}	?>
                       <!-- btnarea -->
                       <div class="kikibtnarea" style="margin-top:50px">
                  <form id="kiki_badge_frm" method="post" enctype="multipart/form-data" name="kiki_badge_frm">               
                              <span class="tit_s"> ※ 새 뱃지 등록 </span> &nbsp;
                              <input type="text" id="badgeName" name="badgeName" maxlength="50" placeholder="생성할 뱃지 이름을 입력하세요" style="width:300px; height:32px">&nbsp;
                               
                             <a href="#" class="kikibtn imgfp">이미지선택
                               <input type="file" id="badge_file" name="badge_file" class="input_filepath">
                             </a> 
                             <a href="#" id="badge_btn" class="kikibtn">생 성</a>
                             <a href="#" onclick="wrapWindowByMask('#kiki_storage')" class="kikibtn">뱃지 창고</a>
                 </form>
                       </div>  
                       <!-- // btnarea -->             
                   </div><!-- //kiki_boradlist-->

                 </div> <!-- //.con -->
               </div> <!-- //.kiki_row -->
              
            </div> <!-- //kiki_box -->      
       </div>
      </div>


<!-- 모달팝업 영역 -->   
    <div id="mask"></div>
   
    <!-- 뱃지창고 -->
    <div id="kiki_storage" class="kikimodal_pop" style="display:none">
        <div class="kikipanel">
            <div class="kikipanel-heading">
                <h3 class="kikipanel-title"> 뱃지 창고 </h3>
                <a href="#" value="(.kikimodal_pop .close)" class="close"><img src="img/btn_close02.png" alt="닫기"></a>
            </div>
            <div class="kikipanel-body">
                <div class="kiki_boardlist hfix">
                     <!-- table :액티비티 20개씩 출력 -->
                     <table class="kiki_tblT01" cellspacing="0" cellpadding="0" border="0">
                               <colgroup>
                                 <col width="20%">
                                 <col width="25%">
                                 <col width="">
                                </colgroup>
                         <thead>
                          <tr>
                            <th>선택</th>
                            <th>뱃지 이미지</th>
                            <th>뱃지이름</th>
                          </tr>
                         </thead> 
                         <tbody>
<form name="kiki_checked_form" method="post">
  <input type="hidden" name="appId" value="<?=$kiki_appId?>">
<?	$SQL = "Select count(badgesSerno) as totcnt from default_badges ";
	$result_count = mysqli_query($kiki_conn, $SQL);
	if ( $result_count === false ) {
		die( print_r( mysqli_connect_error(), true));
		mysqli_close($kiki_conn);
	} else {
	  $row = mysqli_fetch_array($result_count, MYSQLI_ASSOC);
 	  $totcnt = $row["totcnt"];	
	  mysqli_free_result($result_count);
	}
	if($totcnt == 0) { ?>
                           <tr>
                            <td colspan="3" class="kiki_nodata">등록된 뱃지가 없습니다.</td>
                           </tr>
<? }  Else {	
	$SQL = "Select badgesSerno, badgesImg, badgesName from default_badges  ";
	$SQL .= " order by badgesSerno ";
	$result = mysqli_query($kiki_conn, $SQL);
	if( $result === false) {
		 die( print_r( mysqli_connect_error(), true) );
	} else {
$i = 1;
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		$badgesSerno = $row["badgesSerno"];		
		$badgeImg = $row["badgesImg"];
		if($badgeImg) {
		   $temp_name = explode("||", $badgeImg);
 		   $save_file_name = $temp_name[0];
		   $badgeImg = "../data/defbadge/thumb_".$save_file_name;
		} else {
		   $badgeImg = "../img/badge01.png";
		}
		$badgesName = $row["badgesName"];
		$badgesName = stripslashes($badgesName);	?>
                           <tr>
                            <td><input name="badgesSerno[]" value="<?=$badgesSerno?>" type="checkbox"></td>
                            <td><img src="<?=$badgeImg?>" alt="뱃지이미지"></td>
                            <td><?=$badgesName?></td>
                           </tr>
<?		$num = $num - 1;
$i = $i +1;
	  } // while
  	mysqli_free_result( $result);
	}
}  //  if($totcnt == 0) {	
mysqli_close($kiki_conn);	?>
</form>
                         </tbody>
                      </table>  
                      <!-- // table :액티비티 --> 
                     
                      
                   </div>  
            </div>
            <div class="kikipanel-footer"> <a href="#" class="kikibtn btn-cancel">취소</a><?if($totcnt == 0) { ?><a href="javascript:alert('등록된 뱃지가 없습니다.')" class="kikibtn btn-ok">선택뱃지 사용</a><? } else { ?><a href="javascript:kiki_badge_Add(document.kiki_checked_form)" class="kikibtn btn-ok">선택뱃지 사용</a><? } ?> </div>
        </div> <!-- // kikipanel -->
	</div>
    <!--// 수정 -->

<script language="javascript">
$('#badge_file').change(
	function(){
	   $(this).closest('form').trigger('submit');
}); 

/**/$("#badge_btn").click(function() {
  $(this).closest('form').trigger('submit');
}); 

function kiki_badge_show(badgeId) {
  $("#badgeId").val(badgeId);
  showhide = $("#kiki_modify").css("display");
  if(showhide == "block"){

  } else { // 보여주기라면
	$.ajax({
	    type: 'POST',
	    dataType: 'json',
	    url: "./kiki/c104_badge_Load.php?callback=?",
	    data: {
			"badgeId": $("#badgeId").val(),
	    },
	    success: function(data) {
		  if (data.prog == "true") {
			$("#badge_name").val(data.badgeName); 
			$("#badgefile").val(data.badgeImg);
			$("#kiki_storage").hide();
			wrapWindowByMask('#kiki_modify');
		  }
	    } ,
	    error: function(xhr, status, error) {
		  alert(""+error);
	    }
	});
  }
}

function kiki_badge_Add(f) { //// 작업 해야 함...
   var submitFlag = 0;
   for(i = 0; i < f.elements.length; ++i) {
     if(f.elements[i].name == 'badgesSerno[]') {
       if(f.elements[i].checked == true) {
         submitFlag = 1;
         break;
       }
     }
   }
   if(submitFlag) { // 저장
    setQueryString(f);
	$.post("./kiki/c104_badge_defaultAdd.php?"+queryString,
  function(data){ 
	if (data != "") { 
			$("#badge_tr").empty();
			badge_tr.innerHTML = data;
			$("#kiki_storage").hide();
			$('#mask, .kikimodal_pop').hide();  
	} 
  }); // 여기까지 막아 주세요....
   } else {
       alert("사용할 뱃지를 선택하세요."); 
   }
}

function setQueryString(frm) {
  queryString = "";
  var numberElements = frm.elements.length;
  for(var i = 0; i < numberElements; i++) {
    input = frm.elements[i];
    if(i < numberElements - 1) {
      if(input.type=="checkbox") {
	    if(input.checked == true) {
		  queryString += input.name + "=" + encodeURIComponent(input.value) + "&";
	    }
      }
    } else {
      if(input.type=="checkbox") {
	    if(input.checked == true) {
		    queryString += input.name + "=" + encodeURIComponent(input.value);
	    }
      }
    }
  }
}

function kiki_remove_badge(badgeId) {
  if(confirm('삭제하시겠습니까?'))	{
	$.ajax({
	    type: 'post',
        dataType: 'json',
	    url: "./kiki/c104_badge_remove.php?callback=?",
	    data: {
			"badgeId": badgeId,
	    },
	    success: function(data) {
		  if (data.prog == "true") {
			$("tr#"+badgeId).remove();
			val = $("tbody#badge_tr>tr:first").text()
//console.log ("val = "+data.sql)
			if ((val.trim() === "") || (val.trim() === "undefined") || (val.trim() === "")) {
			   var txt = "<tr><td colspan='5' class='kiki_nodata'>등록된 뱃지가 없습니다.</td></tr>"
			   $('tbody#badge_tr:last').append(txt);
			}
		  }
	    },
	    error: function(xhr, status, error) {
		  alert(error);
	    }
	});
  }
}

$("form#kiki_badge_frm").submit(function(event){      
   event.preventDefault();
   if (document.kiki_badge_frm.badgeName.value.length < 1) {
      alert("뱃지 이름을 입력하세요.");
      document.kiki_badge_frm.badgeName.focus();
      return;
   }
   var fdd = new FormData($(this)[0]); 
// console.log ("a = "+$(this)[0])
// console.debug ("file = "+fdd)
/**/   $.ajax({
     url: "./kiki/c104_badgeAdd.php",
     type: "POST",
     data: fdd,
     async: false,
     cache: false,
     contentType: false,
     processData: false,
     success:  function(data){
 //console.log(data)
 if (data != "false") {
	  val = $("tbody#badge_tr>tr:first").text()
//console.log(val)
	  if ((val.trim() == "등록된 뱃지가 없습니다.") || (val.trim() === "undefined") || (val.trim() === "")) {
			$("tbody#badge_tr>tr").empty();
	  }
		$("tbody#badge_tr>tr:first").before(data);
		document.kiki_badge_frm.badgeName.value = "";
		document.kiki_badge_frm.badge_file.value = "";
 }  //  if (obj.prog == "true") {
     } // success
   });  
	return false;
});

function kiki_list(pg){
     document.kiki_frm_sub.cur_page.value = pg;
	 document.kiki_frm_sub.method="post";
	 document.kiki_frm_sub.action="./c104_badge.php";
     document.kiki_frm_sub.submit();
}
</script>

     <!-- 수정 -->
    <div id="kiki_modify" class="kikimodal_pop" style="display:none">
        <div class="kikipanel">
            <div class="kikipanel-heading">
                <h3 class="kikipanel-title"> 뱃지 수정 </h3>
                <a href="#" value="(.kikimodal_pop .close)" class="close"><img src="img/btn_close02.png" alt="닫기"></a>
            </div>
<form id="kiki_badge_frm2" method="post" enctype="multipart/form-data" name="kiki_badge_frm2">
  <input type="hidden" id="badgeId" name="badgeId" value="">
  <input type="hidden" id="badgefile" name="badgefile" value=""> 
			<div class="kikipanel-body">
             <div class="form-group">
              <div class="tit">뱃지이름</div>
              <label><input class="form-control" id="badge_name" name="badge_name" placeholder="" maxlength="30" type="text"></label>
             </div>
             <div class="form-group">
              <div class="tit">뱃지이미지</div>
              <label> 
               <input id="add2" class="form-control" name="file_path2" accept="image/jpg, image/gif, image/jpeg, image/bmp, image/png" type="text" style="width: 71%;">
               <a href="#" class="kikibtn imgfp">이미지선택
                 <input id="badge_file2" name="badge_file2" class="input_filepath" onchange="file_path2.value=this.value" type="file">
               </a>
              </label>
             </div> 
            </div>
            <div class="kikipanel-footer"> <a href="#" class="kikibtn btn-cancel">취소</a><a href="#" id="badge_btn2" class="kikibtn btn-ok">수정하기</a> </div>
</form>             
        </div> <!-- // kikipanel -->
		
	</div>
    <!--// 수정 -->
<script>
$("#badge_btn2").click(function() {
  $(this).closest('form').trigger('submit');
});

$("form#kiki_badge_frm2").submit(function(event){      
   event.preventDefault();
//console.log("aaa="+$("#badge_name").val())
//console.log("bbb="+$("#badgeId").val())
//console.log("ccc="+$("#badgefile").val())
	if (!$("#badge_name").val()) {
       alert("뱃지 이름을 입력하세요.");
       $("#badge_name").focus();
       return;
    }

//	var form = $('#kiki_badge_frm2')[0];
//	var fdd = new FormData(form);
	var fdd = new FormData($(this)[0]); 

//console.debug("fdd="+fdd)
/**/   $.ajax({
     url: "./kiki/c104_badgeMod.php",
     type: "POST",
    data: fdd,
/* 	 data : {
		"badge_name": $("#badge_name").val(),
		"badgeId": $("#badgeId").val(),
		"badgefile": $("#badgefile").val(),
		"badge_file2": $("#badge_file2").val(),
	 }, */
     async: true,
     cache: false,
     contentType: false,
     processData: false,
     success:  function(data){
// console.log("mod = "+data)
 if (data != "false") {
 var txt = $("#badge_name").val() ;
//console.log("val = "+txt + " / data = "+data)
		    $("td#name_"+$("#badgeId").val()).text('');
			$("td#name_"+$("#badgeId").val()).append(txt);
		if (data) {
		    $("td#img_"+$("#badgeId").val()).text('');
			$("td#img_"+$("#badgeId").val()).append(data);
		}
		$("#badge_name").val('');
		$("#badgeId").val('');
		$("#badgefile").val('');
		$("#add2").val('')
		$("#kiki_storage").hide();
		$('#mask, .kikimodal_pop').hide(); 
 }  //  if (obj.success == "true") {
	  else {
//console.log("false");	 
	  }
     } // success
   });  
	return false;
});
</script>


<form name="kiki_frm_sub" method="post">
  <input type="hidden" name="cur_page" value="<?=$cur_page?>">
  <input type="hidden" name="appId" value="<?=$kiki_appId?>">
</form>