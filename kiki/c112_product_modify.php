    <?php header('X-UA-Compatible: IE=edge'); ?>
    <?php header('X-UA-Compatible: IE=8'); ?>
<?php
header('Content-Type: text/html; charset=UTF-8');

	include "./kiki_user.php";

	$cur_page = kiki_isnumb($_POST["cur_page"]);
	$gdProdSerno = kiki_ischar($_POST["gdProdSerno"]);		// 
	
	$schSel = kiki_ischar($_POST["schSel"]);	
	$schStr = kiki_ischar($_POST["schStr"]);

	$prodId = kiki_ischar($_POST["prodId"]);			// 상품 아이디
	$prodImgUrl = kiki_ischar2($_POST["prodImgUrl"]);	// 이미지 경로
	$prodName = kiki_ischar($_POST["prodName"]);		// 상품명
	$prodPrice = kiki_isnumb($_POST["prodPrice"]);		// 가격
	$prodUrl = kiki_ischar2($_POST["prodUrl"]);			// url
	$kword = kiki_ischar($_POST["kword"]);				// 키워드
	$prodQty = kiki_isnumb($_POST["prodQty"]);			// 수량

if($prodId and $prodImgUrl and $prodName and $prodPrice and $prodUrl and $kword and $prodQty) {
	
	$SQL = "UPDATE gd_prod SET prodId = '$prodId' "; 
	$SQL .= ", prodImgUrl = '$prodImgUrl'";
	$SQL .= ", prodName = '$prodName'";
	$SQL .= ", prodPrice = '$prodPrice'";
	$SQL .= ", prodUrl = '$prodUrl'";
	$SQL .= ", kword = '$kword'";
	$SQL .= ", prodQty = '$prodQty'" ;
	$SQL .= " WHERE gdProdSerno = '$gdProdSerno'" ;
//echo $SQL . "<BR>";
/**/ 	$result = mysqli_query($kiki_conn, $SQL);
	if ( $result === false ) {
	   die( print_r( mysqli_connect_error(), true));
	}
}
mysqli_close($kiki_conn);

//exit;?>
<form name="list" method="post" action="../c112_product.php">
  <input type="hidden" name="cur_page" value="<?=$cur_page?>">
  <input type="hidden" name="schSel" value="<?=$schSel?>">
  <input type="hidden" name="schStr" value="<?=$schStr?>">
  <input type="hidden" name="appId" value="<?=$kiki_appId?>">
</form>

<Script language="JavaScript">
	document.list.submit();
</Script> 