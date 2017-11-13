    <?php header('X-UA-Compatible: IE=edge'); ?>
    <?php header('X-UA-Compatible: IE=8'); ?>
<?php
header("Content-Type: text/html; charset=UTF-8");
	include "./kiki_user.php";	
	$eventTyp =  kiki_ischar($_POST["eventTyp"]);
	$eventId =  kiki_ischar($_POST["eventId"]);
//$eventTyp = "P";
//$kiki_appId = "app_paNiDM1f00000";
if ($eventTyp == "P") {  // 상품이라면
	$SQL = "select prodId as eventId, prodName as eventName ";
	$SQL .= " from gd_prod a where appId = '$kiki_appId' ";
	$SQL .= " order by prodName, a.prodId desc ";
} else {
	$SQL = "select mgId as eventId, title as eventName ";
	$SQL .= " from mg_main a where appId = '$kiki_appId' ";
	$SQL .= " and delFlag = 'N' order by mgMainSerno desc ";
}
//echo $SQL;
	$result = mysqli_query($kiki_conn, $SQL);
	if( $result === false) {
		 die( print_r( mysqli_connect_error(), true) );
	} else {
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			$list_eventId = $row["eventId"];	
			$eventName = $row["eventName"];
			$eventName = stripslashes($eventName);
			if (strlen($eventName) > 12) {
				$eventName = kiki_utf8_strcut($eventName,12); 
			}
$result_stmt .= " <option value='$list_eventId' ";
  if ($list_eventId == $eventId) {
$result_stmt .= " selected ";
  }
$result_stmt .= "> $eventName  ";
$result_stmt .= "</option> ";
		} // while

$result_stmt .= " <option value='' ";
  if ($eventId == "") {
$result_stmt .= " selected ";
  }
$result_stmt .= ">전체보기</option> ";
	 mysqli_free_result( $result);
	}
	mysqli_close($kiki_conn);	
	echo $result_stmt;			?>