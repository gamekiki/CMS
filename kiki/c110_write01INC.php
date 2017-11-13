 <script src="https://code.jquery.com/jquery-2.1.0.min.js"></script>
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
	 <div class="kiki_content">
        <div class="kiki_conwrap">    
            <div class="kiki_box">
               <!-- <div class="tit_top bm20">Bookoa</div> -->
<?	include "./kiki/kiki_header.php";
	$cur_page = kiki_isnumb($_POST["cur_page"]);	
	mysqli_close($kiki_conn);	?>
              
               <div class="kiki_row" style="margin-top:50px">
                 <p class="tit">미니게임 등록</p>
                 
                 <div class="con">
                   <p class="nv_img"><img src="./kiki/img/nv_img01.png"></p>
                   <div class="imgbox_area">
                     <div id="bg_R" class="box_st on">
                        <img src="./kiki/img/test_img.png" alt="룰렛이미지" onclick="javascript:mg_type('R')">
                        <p class="tit_s">룰렛형</p>
                        <p>사용자가 경품 내용을<br> 알 수 있습니다.</p>
                     </div>
                     <!--<div id="bg_B" class="box_st">
                        <img src="./kiki/img/test_img2.png" alt="박스이미지" onclick="javascript:mg_type('B')">
                        <p class="tit_s">보물상자형</p>
                        <p>사용자가 경품 내용을<br> 알 수 없습니다.</p>
                     </div> -->
                   </div>
                   <!-- btnarea -->
                     <div class="kikibtnarea text_right">
                       <a href="javascript:history.go(-1)" class="kikibtn gray2 fl_left">&lt; &nbsp;취소 </a> <a href="javascript:go_write()" class="kikibtn"> 다음&nbsp; &gt; </a>
                     </div>
                     <!-- // btnarea -->
                
                 </div> <!-- //.con -->
               </div>
            </div> <!-- //kiki_box -->      
       </div>
      </div>
<script>
function go_write(){ // 도서 서평등록
	document.list.method = "post";
	document.list.action = "./c110_write02.php";
	document.list.submit();
}

function mg_type(typ) {
   $('input:hidden[name="mgType"]').val(typ);
   $(".imgbox_area > div").removeClass("on");
   $("#bg_"+typ).attr('class','box_st on');
}
</script>

<form name="list" method="post" action="./c002_write.php">
  <input type="hidden" name="cur_page" value="<?=$cur_page?>">
  <input type="hidden" name="mgType" value="R">
  <input type="hidden" name="appId" value="<?=$kiki_appId?>">
</form>