<!doctype html>
<html lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<title>게임키키 쇼핑몰</title>
</head>
<body>
<?	include "./kiki_user.php";

$sRef = $_SERVER['HTTP_REFERER'];
if (strlen($sRef) > 0 ) {
	$iStrPos = explode("//", $sRef);
	$sRef = $iStrPos[1];
	$iStrPos = explode("/", $sRef);
	$sRef = $iStrPos[0];
}

$SERVER_NAME = $_SERVER["SERVER_NAME"];
If ($SERVER_NAME <> $sRef) {
	echo "<script>";
	echo "alert(" . chr(34) ."이페이지는 직접 엑세스 할수 없습니다. 다시 정상적인 절차로 접속하시길 바랍니다." . Chr(34). ");";
	echo "history.go(-1);";
	echo "</script>";
	exit;
}
	$cur_page = kiki_isnumb($_POST["cur_page"]);
	$gdProdSerno = kiki_isnumb($_POST["gdProdSerno"]);
	$schSel = kiki_ischar($_POST["schSel"]);
	$schStr = kiki_ischar($_POST["schStr"]);
	$UserID = $_COOKIE["UserID"];

	$SQL  = "delete from gd_prod  ";
	$SQL .= " where gdProdSerno = '$gdProdSerno'  " ;
	$result = mysqli_query($kiki_conn, $SQL);
	if ( $result === false ) {
	   die( print_r( mysqli_connect_error(), true));
	}
	mysqli_close($kiki_conn);		?>

<form name="list" method="POST" action="../c112_product.php">
  <input type="hidden" name="cur_page" value="<?=$cur_page?>">
  <input type="hidden" name="appId" value="<?=$kiki_appId?>">
  <input type="hidden" name="schSel" value="<?=$schSel?>">
  <input type="hidden" name="schStr" value="<?=$schStr?>">
</form>

<Script language=JavaScript>
  document.list.submit();
</Script>

</body>
</html>