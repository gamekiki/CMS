  <script src="https://code.jquery.com/jquery-2.1.0.min.js"></script>

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
	  <div class="kiki_content">
        <div class="kiki_conwrap">    
            <div class="kiki_box">
               <!-- <div class="tit_top bm20">Bookoa</div> -->
<?	include "./kiki/kiki_header.php";
	$cur_page = kiki_isnumb($_POST["cur_page"]);
	$schSel = kiki_ischar($_POST["schSel"]);	
	$schStr = kiki_ischar($_POST["schStr"]);	

	mysqli_close($kiki_conn);	?>

               <div class="kiki_row" style="margin-top:50px">
                 <p class="tit">저장된 상품추천</p>
                 <div class="con">
                  <p class="nv_img"><img src="./kiki/img/nv02_img01.png"></p>
                   <div class="imgbox_area">
                     <div id="bg_R" class="box_st on">
                        <p class="tit_s" onclick="javascript:mg_type('R')">맞춤</p>
                        <p>쇼핑몰 유저의 데이터를 축적하여<br> 맞춤상품을 추천합니다</p>
                     </div>
                   <!--  <div id="bg_B" class="box_st">
                        <p class="tit_s" onclick="javascript:mg_type('B')">공통</p>
                        <p>전체 쇼핑몰 유저, <br>  혹은 특정 레벨 이상의 유저에게 <br> 상품을 추천합니다.</p>
                     </div> -->
                   </div>
                   
                  
                     <!-- btnarea -->
                   <div class="kikibtnarea text_right">
                       <a href="javascript:history.go(-1)" class="kikibtn gray2 fl_left"> &lt; &nbsp;취소 </a> <a href="javascript:go_write()" class="kikibtn"> 다음&nbsp; &gt; </a>
                     </div>
                     <!-- // btnarea -->
                
                 </div> <!-- //.con -->
               </div><!-- //.kiki_row -->
               
              
            </div> <!-- //kiki_box -->      
       </div>
      </div>

<script>
function go_write(){ // 도서 서평등록
	document.list.method = "post";
	document.list.action = "./c112_product_write02.php";
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
  <input type="hidden" name="schSel" value="<?=$schSel?>">
  <input type="hidden" name="schStr" value="<?=$schStr?>">
</form>