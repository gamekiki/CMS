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
	$mgType = kiki_ischar($_POST["mgType"]);	// R : 맞춤

	mysqli_close($kiki_conn);	?>
              
               <div class="kiki_row" style="margin-top:50px">
                 <p class="tit">상품추천 등록</p>
                 <div class="con">
                   <p class="nv_img"><img src="./kiki/img/nv02_img02.png"></p>
                   <div class="kiki_tbview">
                     <!-- table :액티비티 20개씩 출력 -->
<form method="post" name="frm" id="frm">
  <input type="hidden" name="cur_page" value="<?=$cur_page?>">
  <input type="hidden" name="mgType" value="<?=$mgType?>">
  <input type="hidden" name="schSel" value="<?=$schSel?>">
  <input type="hidden" name="schStr" value="<?=$schStr?>">
  <input type="hidden" name="appId" value="<?=$kiki_appId?>">
                     <table class="tblT01_detail" border="0" cellspacing="0" cellpadding="0">
                         <colgroup>
                         <col width="15%">
                         <col width="">
                         </colgroup>
                       <thead>
                       </thead> 
                       <tbody>             
                          <tr>
                            <th>상품 아이디 *</th>
                             <td><label><input name="prodId" maxlength="20" value="" placeholder="" type="text"></label></td>
                          </tr>
                          <tr>
                            <th>상품 이미지 *</th>
                             <td>
                             <!-- <p class="p_txt">[권장사이즈] 가로 해상도 548px 이상</p> -->
                             <label><input name="prodImgUrl" maxlength="300" value="http://" placeholder="이미지 파일 경로를 입력하세요." type="text"></label>
                             </td>
                          </tr>
                          <tr>
                            <th>상품명 *</th>
                             <td><label><input name="prodName" maxlength="10" value="" placeholder="쇼핑몰에서 상품이미지 상단에 노출됩니다.(최대 10자)" type="text"></label></td>
                          </tr>
                          <tr>
                            <th>가격 *</th>
                             <td><label><input name="prodPrice" id="prodPrice" maxlength="7" value="" onblur="chk_digit(this.value,'prodPrice','가격은')" placeholder="쇼핑몰에서 상품이미지 상단에 노출됩니다" type="text"></label></td>
                          </tr>
                          <tr>
                            <th>URL *</th>
                             <td><label><input name="prodUrl" maxlength="300" value="http://" placeholder="" type="text"></label></td>
                          </tr>
                          <tr>
                            <th>키워드 *</th>
                             <td><label><input name="kword" maxlength="50" value="" placeholder="카테고리 명을 입력하세요" type="text"></label></td>
                          </tr>
                          <tr>
                            <th>수량 *</th>
                             <td><label><input name="prodQty" id="prodQty" maxlength="5" value="" onblur="chk_digit(this.value,'prodQty','수량은')" placeholder="수량을 입력하세요" type="text"></label></td>
                          </tr>
                         </tbody>
                      </table>
</form>
                     </div>
                     <!-- btnarea -->
                     <div class="kikibtnarea text_right">
                       <a href="javascript:history.go(-1)" class="kikibtn gray2 fl_left">&lt; &nbsp;이전 </a> <a href="javascript:prod_preview();" class="kikibtn gray2"> 미리보기</a>&nbsp; <a href="javascript:go_write()" class="kikibtn"> 완료 </a>
                     </div>
                     <!-- // btnarea -->
                     <!-- 상품 미리보기 레이어 -->
                     <div id="layer_view" class="layer_view" style="display:none">
                       <div class="pro_txt">
                         <p id="name_layer"> </p> 
                         <p id="price_layer"> </p>
                       </div>
                       <div class="pro_photo">
                         <a href="javascript:close_preview();" class="pro_close"><img src="./kiki/img/btn_close03.png" alt="닫기"/></a>
                         <img id="img_layer" src="" alt="상품이미지"/>
                       </div>
                     </div>
                     <!-- // 상품 미리보기 레이어 -->
                 </div> <!-- //.con -->
               </div><!-- //.kiki_row -->
            </div> <!-- //kiki_box -->      
       </div>
      </div>
<script>
function go_write(){ // 미니 게임 등록
	if (document.frm.prodId.value.length < 1) {
        alert("상품아이디를 입력하세요.");
        document.frm.prodId.focus();
        return;
    }
	if (document.frm.prodImgUrl.value.length < 10) {
        alert("상품 이미지 경로를 입력하세요.");
        document.frm.prodImgUrl.focus();
        return;
    }	
	if (document.frm.prodName.value.length < 1) {
        alert("상품명을 입력하세요.");
        document.frm.prodName.focus();
        return;
    }
	if (document.frm.prodPrice.value.length < 1) {
        alert("가격을 입력하세요.");
        document.frm.prodPrice.focus();
        return;
    }
	if (document.frm.prodUrl.value.length < 10) {
        alert("URL을 입력하세요.");
        document.frm.prodUrl.focus();
        return;
    }
	if (document.frm.kword.value.length < 1) {
        alert("키워드를 입력하세요.");
        document.frm.kword.focus();
        return;
    }
	if (document.frm.prodQty.value.length < 1) {
        alert("수량을 입력하세요.");
        document.frm.prodQty.focus();
        return;
    }
    document.frm.action = "./kiki/c112_product_write02.php";
	document.frm.submit();
}

function chk_digit(val, name, txt) { // 평점에 따른 graph width 변경...
	var patten = /^[0-9]*$/;
	var chk = patten.test(val); 
  if (chk == false) {
	alert(txt+" 숫자만 입력 가능합니다.");
	$("#"+name).val('');
	$("#"+name).focus();
  }
}

function prod_preview() { // 상품 미리보기
	$("#layer_view").show();
	img = document.frm.prodImgUrl.value;
	name = document.frm.prodName.value;
	price = document.frm.prodPrice.value;
	price =  numberWithCommas(price)
	if (price) {
		price = price + "원";
	}
	$("#name_layer").text(name);
	$("#price_layer").text(price);
	$("#img_layer").attr("src",img);
}

function numberWithCommas(x) { // 3자리 콤마 표시
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function close_preview() { // 상품 미리보기
	$("#layer_view").hide();
}
</script>