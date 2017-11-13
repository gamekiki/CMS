<html>
<head>
<title>  </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body>
<?	$UserID = $_COOKIE["UserID"];
	include "./kiki_user.php";

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
	$board = kiki_ischar($_POST["board"]);
$UserIP =  $_SERVER["REMOTE_ADDR"];

foreach ($_POST['LevelSerno'] as $k=>$chkb) { 
    $LevelSerno = kiki_ischar($_POST['LevelSerno'][$k]);
    $minPoint = kiki_ischar($_POST['minPoint'][$k]);
	if (!$minPoint) {
		$minPoint = 0;
	}
    $maxPoint = kiki_ischar($_POST['maxPoint'][$k]);
//echo "min  $minPoint, max = $maxPoint <BR>";
	$levelId = kiki_ischar($_POST['levelId'][$k]);
	$levelName = kiki_ischar($_POST["levelName"][$k]);
  if ($maxPoint <> "" && $UserID) { //값이 등록되었다면
//echo "min  $minPoint, max = $maxPoint <BR>";
//  if ($minPoint && $maxPoint && $levelId && $levelName) { //값이 등록되었다면
	if ($LevelSerno) { // 수정이라면
		$SQL = "UPDATE $board SET minPoint = '$minPoint'";
		$SQL .= ", maxPoint = '$maxPoint'";
//		$SQL .= ", levelId = '$levelId'";
//		$SQL .= ", levelName = '$levelName'";
		$SQL .= " WHERE LevelSerno = '$LevelSerno'";
//echo $SQL . "<BR>";	
//exit;
		$result = mysqli_query($kiki_conn, $SQL);
		if ( $result === false ) {
		   die( print_r( mysqli_connect_error(), true));
		}
	} else { // 새로 등록이라면
		$SQL = "INSERT INTO $board (levelId, minPoint, maxPoint ";
		$SQL .= ", levelName, appId, developerId, UserIP )";
		$SQL .= "  values ('$levelId'";
		$SQL .= ", '$minPoint'";
		$SQL .= ", '$maxPoint'";
		$SQL .= ", '$levelName'";
		$SQL .= ", '$kiki_appId'";
		$SQL .= ", '$developerId'";
		$SQL .= ", '$UserIP')" ;
		$result = mysqli_query($kiki_conn, $SQL);
		if ( $result === false ) {
		   die( print_r( mysqli_connect_error(), true));
		}
	}
  }
} // foreach

	mysqli_close($kiki_conn); ?>

<form name="list" method="post" action="../c107_set.php">
  <input type="hidden" name="appId" value="<?=$kiki_appId?>">
</form>

<Script language="JavaScript">
	document.list.submit();
</Script> 
</body>
</html>	
