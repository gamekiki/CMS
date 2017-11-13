    <?php header('X-UA-Compatible: IE=edge'); ?>
    <?php header('X-UA-Compatible: IE=8'); ?>
<?php
header("Content-Type: text/html; charset=UTF-8");
	include "./kiki_user.php";	
	$eventTyp =  kiki_ischar($_POST["eventTyp"]);

if ($eventTyp == "P") {  // 상품이라면
	$SQL = "select prodId as eventId, prodName as eventName ";
	$SQL .= " from gd_prod a where appId = '$kiki_appId' ";
	$SQL .= " order by prodName, a.prodId desc ";
} else {
	$SQL = "select mgId as eventId, title as eventName ";
	$SQL .= " from mg_main a where appId = '$kiki_appId' ";
	$SQL .= " and delFlag = 'N' order by mgMainSerno desc ";
}
	$result = mysqli_query($kiki_conn, $SQL);
	if( $result === false) {
		 die( print_r( mysqli_connect_error(), true) );
	} else {
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {	
			$list_eventId = $row["eventId"];	
			$eventName = $row["eventName"];
			$eventName = stripslashes($eventName);
			if (strlen($eventName) > 12) {
				$eventName = utf8_strcut($eventName,12); 
			}

$result2 .= " <option value='$list_eventId' ";
  if ($list_eventId == $eventId) {
$result2 .= " 	selected ";
  }
$result2 .= "> $eventName  ";
$result2 .= "</option> ";
		} // while
$result2 .= " <option value='' ";
  if ($eventId == "") {
$result2 .= " 	selected ";
  }
$result2 .= ">전체보기</option> ";
	 mysqli_free_result( $result);
	}
	mysqli_close($kiki_conn);	
	echo $result2;			?>