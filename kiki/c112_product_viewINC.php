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
	$gdProdSerno = kiki_isnumb($_POST["gdProdSerno"]);

	$SQL = "Select prodId, prodImgUrl, prodName, prodPrice ";
	$SQL .= ", prodUrl, kword, prodQty from gd_prod ";
	$SQL .= " where gdProdSerno = '$gdProdSerno'";
//echo $SQL;
	$result = mysqli_query($kiki_conn, $SQL);
	if( $result === false) {
//		 die( print_r( mysqli_connect_error(), true) );
	} else {
	  $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		$prodId = $row["prodId"];
		$prodId = stripslashes($prodId);
		$prodImgUrl = $row["prodImgUrl"];
		$prodImgUrl = stripslashes($prodImgUrl);
		$prodName = $row["prodName"];
		$prodName = stripslashes($prodName);
		$prodPrice = $row["prodPrice"];
	if ($prodPrice) {
		$prodPrice = number_format($prodPrice);
	}
		$prodUrl = $row["prodUrl"];
		$kword = $row["kword"];
		$kword = stripslashes($kword);
		$prodQty = $row["prodQty"];
		 mysqli_free_result($result);
	}
	mysqli_close($kiki_conn);	?>
              
               <div class="kiki_row" style="margin-top:50px">
                 <p class="tit">상품추천</p>
                 <div class="con"> 
                   <div class="kiki_tbview">
                     <!-- table :액티비티 20개씩 출력 -->
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
                             <td><label><?=$prodId?></label></td>
                          </tr>
                          <tr>
                            <th>상품 이미지 *</th>
                             <td>
                             <!-- <p class="p_txt">[권장사이즈] 가로 해상도 548px 이상</p> -->
                             <label><img src="<?=$prodImgUrl?>" class="icon_img" alt="상품이미지"></label>
                             </td>
                          </tr>
                          <tr>
                            <th>상품명 *</th>
                             <td><label><?=$prodName?></label></td>
                          </tr>
                          <tr>
                            <th>가격 *</th>
                             <td><label><?=$prodPrice?>원</label></td>
                          </tr>
                          <tr>
                            <th>URL *</th>
                             <td><label><?=$prodUrl?> &nbsp;<a href="<?=$prodUrl?>" target="_blank"> <img src="./kiki/img/ico_view.png" alt="url보기"></a></label></td>
                          </tr>
                          <tr>
                            <th>키워드 *</th>
                             <td><label><?=$kword?></label></td>
                          </tr>
                          <tr>
                            <th>수량 *</th>
                             <td><label><?=$prodQty?></label></td>
                          </tr>
                         </tbody>
                      </table>
                     </div>
                     <!-- btnarea -->
                     <div class="kikibtnarea text_right">
                       <a href="javascript:GoList();" class="kikibtn fl_left"> 목록 </a>  <a href="javascript:prod_preview();" class="kikibtn gray2"> 미리보기</a>&nbsp; <a href="javascript:GoModify();" class="kikibtn"> 수정 </a>&nbsp; <a href="javascript:cdelete();" class="kikibtn gray2">&nbsp;삭제 </a>
                     </div>
                     <!-- // btnarea -->
                     <!-- 상품 미리보기 레이어 -->
                     <div id="layer_view" class="layer_view" style="display:none">
                       <div class="pro_txt">
                         <p id="name_layer"> <?=$prodName?> </p> 
                         <p id="price_layer"> <?=$prodPrice?>원 </p>
                       </div>
                       <div class="pro_photo">
                         <a href="javascript:close_preview();" class="pro_close"><img src="./kiki/img/btn_close03.png" alt="닫기"/></a>
                         <img id="img_layer" src="<?=$prodImgUrl?>" alt="상품이미지"/>
                       </div>
                     </div>
                     <!-- // 상품 미리보기 레이어 -->
                 </div> <!-- //.con -->
               </div><!-- //.kiki_row -->
               
              
            </div> <!-- //kiki_box -->      
       </div>
      </div>

<script>
function cdelete(){
  if(confirm('정말 삭제하시겠습니까?'))	{
	document.list.action='./kiki/c112_product_delete.php';
    document.list.submit();
  }
}

function GoList(){
	document.list.action='./c112_product.php';
    document.list.submit();
}

function GoModify(){
	document.list.action='./c112_product_modify.php';
    document.list.submit();
}

function open_priview(gdProdSerno) {
	URL = "http://gamebin.iptime.org/kshop/wheel/preview.html?gdProdSerno="+gdProdSerno
	window.open(URL,'priview',"left=0, top=0, width=817,height=900,scrollbars=yes,resizable=no");
}

function prod_preview() { // 상품 미리보기
	$("#layer_view").show();
}

function numberWithCommas(x) { // 3자리 콤마 표시
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function close_preview() { // 상품 미리보기
	$("#layer_view").hide();
}
</script>

<form name="list" method="post" action="./c109_minigame.php">
  <input type="hidden" name="cur_page" value="<?=$cur_page?>">
  <input type="hidden" name="schSel" value="<?=$schSel?>">
  <input type="hidden" name="schStr" value="<?=$schStr?>">
  <input type="hidden" name="gdProdSerno" value="<?=$gdProdSerno?>">
  <input type="hidden" name="appId" value="<?=$kiki_appId?>">
</form>