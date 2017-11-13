  <script src="https://code.jquery.com/jquery-2.1.0.min.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
  <link rel="stylesheet" href="./kiki/css/jquery.switchButton.css">
  <script src="./kiki/js/jquery.switchButton.js"></script>

<?	$sub_menu1 = "";	// 대시보드
	$sub_menu2 = "";	// 회원관리
	$sub_menu3 = "";	// 액티비티
	$sub_menu4 = "";	// 업적
	$sub_menu5 = "";	// 뱃지
	$sub_menu6 = "";	//통계/분석
	$sub_menu7 = "";	//리워드
	$sub_menu8 = "";	//레벨설정
	$sub_menu9 = "";	//미니게임
	$sub_menu10 = "on";	//상품추천		?>
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
	    $("#bookSerno").val('');
	    $('#mask, .kikimodal_pop').hide();  
	});       

	//취소 버튼을 눌렀을 때
	$('.kikimodal_pop .btn-cancel').click(function (e) {  
	    //링크 기본동작은 작동하지 않도록 한다.
	    e.preventDefault();  
	    $("#bookSerno").val('');
	    $('#mask, .kikimodal_pop').hide();
	}); 
/*	//검은 막을 눌렀을 때
	$('#mask').click(function () {  
	    $(this).hide();  
	    $('.modal_pop').hide();  
	});   */
});
/*$(function() {
  $(".booky_sw input").switchButton({
	width: 68,
	height: 30,
	button_width: 34
  });
}) */
	var listedDone = false;

$(function() {
  $(".booky_sw input").each(function(){
	var checked = ($(this).attr("listFlag")=="Y")? true : false;
	  $(this).switchButton({
		checked : checked,
		width: 68,
		height: 30,
		button_width: 34,
		checkCallback : function(){
	if(listedDone){
		  check = $(this).prop("checked");
		if (check == true) {
		  if(confirm('정말 중단하시겠습니까?'))	{
			return true;
		  } else {
			return false;
		  }
		} else {
			return true;
		}
	} else {
		return true;
	}
			},	
		off_callback : function(){modifylistFlag(this.element[0], "N", this.element[0].getAttribute("gdProdSerno"))},
		on_callback : function(){modifylistFlag(this.element[0], "Y", this.element[0].getAttribute("gdProdSerno"))},		
	  });
  }).promise().done(function(){
	listedDone= true;  
  });
}) 

function modifylistFlag(elem,listFlag,gdProdSerno){
//console.log("el="+elem + ", act = "+listFlag + ", gdProdSerno = "+gdProdSerno+ ", listedDone = "+listedDone);
	if(!listedDone){
		return
	}
//console.log ("abc")
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: "./kiki/c112_listFlagAjax.php?callback=?",
		data: {
			"listFlag" : listFlag,
			"gdProdSerno" : gdProdSerno
		},
		success: function (data) {
//console.log("data="+data);
			if(data.prog == "true"){
				//listHotTag();
			}
		},
		error: function (request, status, error) {
			console.log('code: '+request.status+"\n"+'message: '+request.responseText+"\n"+'error: '+error);
		}
	});		
}
</script>
	  <div class="kiki_content">
        <div class="kiki_conwrap">    
            <div class="kiki_box">
               <!-- <div class="tit_top bm20">Bookoa</div> -->
<?	include "./kiki/kiki_header.php";

	$cur_page = isset($_POST["cur_page"]) ? kiki_isnumb($_POST["cur_page"]) : 1;
	$schSel = isset($_POST["schSel"]) ? kiki_ischar($_POST["schSel"]) : 'prodName';	
	$schStr = isset($_POST["schStr"]) ? kiki_ischar($_POST["schStr"]) : '';	

	$wheStr = "appId = '$kiki_appId'";

if ($schSel == "prodName") {  // 상품검색이라면
	$wheStr .= " and (prodName like '%". trim($schStr). "%')"; 
	$display = "";
} else {
	$wheStr .= " and (listFlag = '". trim($schSel). "')"; 
	$display = "none";
}
	$SQL = "Select count(gdProdSerno) as totcnt from gd_prod ";
	$SQL .= " where appId = '$kiki_appId'  ";
	$result = mysqli_query($kiki_conn, $SQL);
	if( $result === false) {
		 die( print_r( mysqli_connect_error(), true) );
	} else {
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		$totcnt = $row["totcnt"];
		mysqli_free_result( $result);
	}
	if ($totcnt) {
		$totcnt = number_format($totcnt);
	}	?>
               <div class="kiki_row" style="margin-top:50px">
                 <p class="tit">저장된 상품추천</p>
                 
                 <div class="con">
                   <p class="info"> 
                    - 상품 등록 개수 : <?=$totcnt?>개
                   <div class="searchtop_area">
                        <div class="fl_right">
                          <div class="search">
                          <label></label>
                          <select id="schSel" name="schSel" onchange="javascript:show_hide(this.value)" class="select_style">
                             <option value="prodName" <? if ($schSel == "prodName") { ?> selected <? } ?>>상품명</option>
                             <option value="Y" <? if ($schSel == "Y") { ?> selected <? } ?>>on</option>
                             <option value="N" <? if ($schSel == "N") { ?> selected <? } ?>>off</option>
                          </select>
                         <span id="prodName_span" style="display:<?=$display?>"> <input name="schStr" id="schStr" value="<?=$schStr?>" maxlength="15" class="" type="text"> </span>
                          <a href="javascript:load_sch();" class="kikibtn gray2"> 검 색 </a>
                          </div>
                      </div>
                   </div>
                   <div class="con clearfix"> 
                     <!-- table :액티비티 -->
                     <table class="kiki_tblT01" cellspacing="0" cellpadding="0" border="0">
                       <colgroup>
                        <col width="">
                        <col width="20%">
                        <col width="20%">
                       </colgroup>
                         <thead>
                          <tr>
                            <th>이미지</th>
                            <th>상품명</th>
                            <th>가격</th>
                            <th>키워드</th>
                            <th>수량</th>
                            <th>on/off</th>
                            <th>수정/삭제</th>
                          </tr>
                         </thead> 
                         <tbody>
<?	$pagesize = 10 ;

	$SQL = "Select count(gdProdSerno) as totcnt from gd_prod where $wheStr ";
	$result = mysqli_query($kiki_conn, $SQL);
	if( $result === false) {
		 die( print_r( mysqli_connect_error(), true) );
	} else {
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		$totcnt = $row["totcnt"];
		$totpage = ceil((($totcnt / $pagesize) * -1) * -1);
		mysqli_free_result( $result);
	}
	if (!$totcnt) {
		$totpage=1;
	}
	if($totcnt == 0) {	?>
						   <tr>
						     <td colspan="7"><div class='no_data'>등록된 추천상품이 없습니다.</div></td>
						  </tr>
<?	}  Else {
		$start = ($cur_page-1) * $pagesize;
		$nowdate = date("Y-m-d");

		$SQL = "Select gdProdSerno, prodId, prodImgUrl, prodName, prodQty  ";
		$SQL .= ", prodPrice, kword, listFlag from gd_prod where $wheStr ";
		$SQL .= " order by gdProdSerno desc ";
		$SQL .= " limit $start, $pagesize ";
		$result = mysqli_query($kiki_conn, $SQL);
		if( $result === false) {
//			 die( print_r( mysqli_connect_error(), true) );
		} else {
		  while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			$gdProdSerno = $row["gdProdSerno"];
			$prodId = $row["prodId"];
			$prodId = stripslashes($prodId);
			$prodImgUrl = $row["prodImgUrl"];
			$prodImgUrl = stripslashes($prodImgUrl);
			$prodName = $row["prodName"];
			$prodName = stripslashes($prodName);
			if (strlen($prodName) > 12) {
				$prodName = utf8_strcut($prodName,12); 
			}
			$prodQty = $row["prodQty"];
	if ($prodQty) {
		$prodQty = number_format($prodQty);
	}
			$prodPrice = $row["prodPrice"];
	if ($prodPrice) {
		$prodPrice = number_format($prodPrice);
	}
			$kword = $row["kword"];
			$kword = strip_tags($kword);
			if (strlen($kword) > 12) {
				$kword = utf8_strcut($kword,12); 
			}
			$listFlag = $row["listFlag"];
	if ($prodQty == 0 and $listFlag = "Y") { // 품절이면서 on 이라면 off 로 상태변경
		$SQL2  = "UPDATE gd_prod SET listFlag = 'N'";
		$SQL2 .= " where gdProdSerno = '$gdProdSerno'  " ;
		$result2 = mysqli_query($kiki_conn, $SQL2);
		if ( $result2 === false ) {
		   die( print_r( mysqli_connect_error(), true));
		}
	}			?>
                           <tr>
                            <td><? if ($prodImgUrl) { ?><img src="<?=$prodImgUrl?>" class="icon_img"><? } ?></td>
                            <td><a href="javascript:GoView('<?=$gdProdSerno?>','./c112_product_view.php');"><?=$prodName?></a></td>
                            <td><?=$prodPrice?></td>
                            <td><?=$kword?></td>
							<td><?=$prodQty?></td>
                            <td>
                           <!-- switch btn -->
                              <div class="swbtn_wrapper">
                                <div class="booky_sw slider demo ">
                                  <input type="checkbox" value="<?=$listFlag?>" <? if ($listFlag == "Y") { ?>checked <? } ?> gdProdSerno="<?=$gdProdSerno?>" listFlag="<?=$listFlag?>">
                                </div>
                              </div>
                             <!-- // switch btn -->
                           </td>
                            <td><a href="javascript:GoView('<?=$gdProdSerno?>','./c112_product_modify.php');" class="kikibtn_modify">수정</a> &nbsp; <a href="javascript:cdelete('<?=$gdProdSerno?>');" class="kikibtn_del">삭제</a></td>
                           </tr>
<?		  } // while
  		mysqli_free_result( $result);
		}	
	}	
	mysqli_close($kiki_conn);	?>
                         </tbody>
                     </table>
                      <!-- // table :액티비티 --> 
<?	include "./kiki/kiki_pageINC.php";		?>     
                 </div><!-- kiki_tbview -->
                     <!-- btnarea -->
                     <div class="kikibtnarea text_right">
                       <a onclick="wrapWindowByMask('#kiki_Excel')" class="kikibtn gray2 fl_left"> 엑셀등록 </a> <a href="javascript:go_write()" class="kikibtn"> 신규등록 </a>
                     </div>
                     <!-- // btnarea -->
                
                 </div> <!-- //.con -->
               </div><!-- //.kiki_row -->
               
              
            </div> <!-- //kiki_box -->      
       </div>
      </div>

 <!-- 모달팝업 영역 -->   
    <div id="mask"></div>
     <!-- 포인트 지급 회수 -->
    <div id="kiki_Excel" class="kikimodal_pop" style="display:none">
        <div class="kikipanel">
            <div class="kikipanel-heading">
                <h3 class="kikipanel-title"> 엑셀등록 </h3>
              <!--  <a href="#" value="(.kikimodal_pop .close)" class="close"><img src="./kiki/img/btn_close02.png" alt="닫기"></a> -->
            </div>
<form id="excel_frm" method="post" enctype="multipart/form-data" name="excel_frm">
  <input type="hidden" name="appId" value="<?=$kiki_appId?>">
            <div class="kikipanel-body">
                    <div class="form-group">
                        <div class="tit">엑셀파일</div>
                        <label><input name="file1" id="excelfile" class="form-control" value="" placeholder="text" type="file" style="width:100%"></label>
                    </div>
                    <div class="form-group">
                        <ul><li>* 아래의 엑셀 템플릿을 다운로드하신 후, 내용을 입력하여 첨부해 주세요</li></ul>
                    </div> 
                    <div class="form-group text_center">
                       <a href="../data/prodTemplate.xls" class="kikibtn" style="font-size:14px"> 엑셀템플릿 다운로드 </a>
                    </div>
            </div>
            <div class="kikipanel-footer"> <a href="#" class="kikibtn btn-cancel">취소</a><a href="#" id="excel_btn" class="kikibtn btn-ok">확인</a> </div>
</form>
        </div> <!-- // kikipanel -->
		
	</div>
    <!--// 수정 -->

<script>
function show_hide(val) {
  switch (val) {
    case "prodName" :
	  $("#prodName_span").show();
      break;
    case "Y" :
	  $("#prodName_span").hide();
      break;
    case "N" :
	  $("#prodName_span").hide();
      break;
  }
}

function load_sch(){
    schSel = $("#schSel").val();
	schStr = $("#schStr").val();
  if (schSel == "prodName"  && !schStr) {
	alert("검색어를 입력하세요.");
	return;
  }
  if (schSel != "prodName") {
	  $("#schStr").val('');
	  document.list.schStr.value = '';
  } else {
	  document.list.schStr.value = schStr;
  }
  document.list.schSel.value = schSel;
  document.list.submit();
}

function kiki_list(pg){
    document.list.cur_page.value = pg;
    document.list.submit();
}

function go_write(){ // 도서 서평등록
	document.list.method = "post";
	document.list.action = "./c112_product_write01.php";
	document.list.submit();
}

function cdelete(gdProdSerno){
  if(confirm('정말 삭제하시겠습니까?'))	{
	document.list.gdProdSerno.value = gdProdSerno;
	document.list.action='./kiki/c112_product_delete.php';
    document.list.submit();
  }
}

function GoView(gdProdSerno, url){
	document.list.gdProdSerno.value = gdProdSerno;
	document.list.action= url;
    document.list.submit();
}

$("#excel_btn").click(function() {
  $(this).closest('form').trigger('submit');
});

$("form#excel_frm").submit(function(event){      
   event.preventDefault();
   if (document.excel_frm.file1.value.length < 1) {
      alert("엑셀 파일을 등록하세요.");
      document.excel_frm.file1.focus();
      return;
   }
   if(document.excel_frm.file1.value.length > 1){
	   var temp; 
	   temp = document.excel_frm.file1.value; //텍스트상자의 값
	   file = temp.slice(temp.indexOf("\\") + 1);
	   ext = file.substring(file.lastIndexOf(".") + 1, file.length).toLowerCase(); // 파일의 확장자 구함.
	   if((ext.indexOf("xls")!= 0) ) {  // - 가 포함되었다면,
	      alert("xls 파일만 업로드 가능합니다.");  //경고문 출력
	      document.excel_frm.file1.value = "";
	      document.excel_frm.file1.focus(); 
	      return;
	   }
   }
//	document.excel_frm.action = "./kiki/c112_product_excel.php";
//	document.excel_frm.submit();
/* */ 
 var fdd = new FormData($(this)[0]); 
   $.ajax({
     url: "./kiki/c112_product_excel.php",
     type: "POST",
     data: fdd,
     async: true,
     cache: false,
     contentType: false,
     processData: false,
     success:  function(data){
 console.log("mod = "+data)
   var obj = $.parseJSON(data)
   if (obj.prog == "true") {
		$("#excelfile").val('');
		$('#mask, .kikimodal_pop').hide(); 
//console.log("$prodId="+obj.prodId +" $prodImgUrl="+obj.prodImgUrl+" and $prodName="+obj.prodName+" and $prodPrice="+obj.prodPrice+" and $prodUrl="+obj.prodUrl+" and $kword="+obj.kword+" and $prodQty="+obj.prodQty)
	alert("정상적으로 등록되었습니다.")	
		location.reload();
   }  //  if (obj.prog == "true") {
	  else {
		  $("#excelfile").val('');
		  $('#mask, .kikimodal_pop').hide();  
		  alert(obj.msg);
	  }
     } , // success,
       error: function(xhr, status, error) {
		 alert("error : "+error);
	   }
   });  
	return false; 
});
</script>

<form name="list" method="post" action="./c112_product.php">
  <input type="hidden" name="cur_page" value="<?=$cur_page?>">
  <input type="hidden" name="gdProdSerno" value="">
  <input type="hidden" name="appId" value="<?=$kiki_appId?>">
  <input type="hidden" name="schSel" value="<?=$schSel?>">
  <input type="hidden" name="schStr" value="<?=$schStr?>">
</form>