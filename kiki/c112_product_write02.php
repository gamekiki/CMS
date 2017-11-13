    <?php header('X-UA-Compatible: IE=edge'); ?>
    <?php header('X-UA-Compatible: IE=8'); ?>
<?php
header('Content-Type: text/html; charset=UTF-8');

	include "./kiki_user.php";

	$cur_page = kiki_isnumb($_POST["cur_page"]);
	$mgType = kiki_ischar($_POST["mgType"]);				// 맞춤 : R
	
	$schSel = kiki_ischar($_POST["schSel"]);	
	$schStr = kiki_ischar($_POST["schStr"]);

	$prodId = kiki_ischar($_POST["prodId"]);			// 상품 아이디
	$prodImgUrl = kiki_ischar2($_POST["prodImgUrl"]);	// 이미지 경로
	$prodName = kiki_ischar($_POST["prodName"]);		// 상품명
	$prodPrice = kiki_isnumb($_POST["prodPrice"]);		// 가격
	$prodUrl = kiki_ischar2($_POST["prodUrl"]);			// url
	$kword = kiki_ischar($_POST["kword"]);				// 키워드
	$prodQty = kiki_isnumb($_POST["prodQty"]);			// 수량

/*$string = (string)time();
$feed = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"; 
$size = 8;

for ($i=0; $i < $size; $i++) {
	$chk2 = substr($feed, rand(0, strlen($feed)-1), 1);
	if ($i % 2) {
		$code2 .= $string{$i}; 
	} else {
		$code2 .= $chk2;
	}
}
$prodId = "GD_". $code2 ;	*/

if($prodId and $prodImgUrl and $prodName and $prodPrice and $prodUrl and $kword and $prodQty) {
	$UserIP = $_SERVER["REMOTE_ADDR"];
	
	$SQL = "INSERT INTO gd_prod (prodId, prodImgUrl, prodName, prodPrice ";
	$SQL .= ", prodUrl, kword, listFlag, regYHS, IP, appId, prodQty )";
	$SQL .= "  values ('$prodId'";
	$SQL .= ", '$prodImgUrl'";
	$SQL .= ", '$prodName'";
	$SQL .= ", '$prodPrice'";
	$SQL .= ", '$prodUrl'";
	$SQL .= ", '$kword'";
	$SQL .= ", 'Y'";
	$SQL .= ", now() ";
	$SQL .= ", '$UserIP'";
	$SQL .= ", '$kiki_appId' ";
	$SQL .= ", '$prodQty' )" ;
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