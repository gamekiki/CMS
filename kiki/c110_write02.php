    <?php header('X-UA-Compatible: IE=edge'); ?>
    <?php header('X-UA-Compatible: IE=8'); ?>
<?php
header('Content-Type: text/html; charset=UTF-8');

	include "./kiki_user.php";
	include "./file_library.php";

	$cur_page = kiki_isnumb($_POST["cur_page"]);

	$mgType = kiki_ischar($_POST["mgType"]);				// 게임타입 R : 룰렛, B : 보물상자
	$mgRestrict = kiki_ischar($_POST["mgRestrict"]);		// 참여제한 1 : 하루 1회, A : 단회
	$beginDate = kiki_ischar($_POST["beginDate"]);		// 기간 시작일
	$EndDate = kiki_ischar($_POST["EndDate"]);			// 기간 종료일
	$title = kiki_ischar($_POST["title"]);				// 제목
	$description = kiki_ischar($_POST["description"]);	// 설명
	$chk_info = kiki_ischar($_POST["chk_info"]);			// 대표 이미지 

$fileSize = 0;
if ($_FILES['file1']['name']) {
	$exp = explode(".",$_FILES['file1']['name']); 
	$explower = strtolower($exp[1]) ; 
	$exp1 = preg_match("/gif/",$explower); 
	$exp2 = preg_match("/jpg/",$explower); 
	$exp3 = preg_match("/jpeg/",$explower); 
	$exp4 = preg_match("/png/",$explower); 
	if($exp1 || $exp2 || $exp3 || $exp4) { 
	//이미지크기 체크 
	  $size = getimagesize($_FILES['file1']['tmp_name']); 
	  $fileWidth = $size[0];
	  $fileHeight = $size[1];
	}
	 $filename = upload($_FILES[file1],50*1024*1024,'game'); 
//	 $fileSize=$_FILES[file1][size];
}

	if ($chk_info == "4") {
		$chk_info = "../data/game/thumb_".$filename;
	}

$string = (string)time();
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
$mgId = "MGMAI_". $code2 ;

if($title and $beginDate and $EndDate and $mgType and $mgRestrict) {
	$SQL = "INSERT INTO mg_main (mgId, title, description  ";
	$SQL .= ", startYHS, endYHS, actYN, img, mgRestrict, mgType, appId )";
	$SQL .= "  values ('$mgId'";
	$SQL .= ", '$title'";
	$SQL .= ", '$description'";
	$SQL .= ", '$beginDate'";
	$SQL .= ", '$EndDate'";
	$SQL .= ", 'N'";
	$SQL .= ", '$chk_info'";
	$SQL .= ", '$mgRestrict'";
	$SQL .= ", '$mgType', '$kiki_appId' )" ;
//echo $SQL . "<BR>";
/**/ 	$result = mysqli_query($kiki_conn, $SQL);
	if ( $result === false ) {
	   die( print_r( mysqli_connect_error(), true));
	}

// 미니 게임 sub 자료 등록
$size = 7;
$code2 = "";
for ($i=0; $i < $size; $i++) {
	$chk2 = substr($feed, rand(0, strlen($feed)-1), 1);
	if ($i % 2) {
		$code2 .= $string{$i}; 
	} else {
		$code2 .= $chk2;
	}
}

$rwd_ori = "MGSUB_". $code2 ;
$numb = 1;	
	$SQL = "Select rwdTitle, rwdType, rwdValue ";
	$SQL .= ", rwdProb, rwdRestrict, rwdPrice ";
	$SQL .= " from mg_sub_default order by mgSubSerno  ";
	$result = mysqli_query($kiki_conn, $SQL);
	if( $result === false) {
		 die( print_r( mysqli_connect_error(), true) );
	} else {
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {	
		  $rwdId = $rwd_ori . $numb;
		  $rwdTitle = $row["rwdTitle"];
		  $rwdTitle = stripslashes($rwdTitle);
		  $rwdType = $row["rwdType"];
		  $rwdValue = $row["rwdValue"];
		  $rwdProb = $row["rwdProb"];
		  $rwdRestrict = $row["rwdRestrict"];
		  $rwdPrice = $row["rwdPrice"];

			$SQL2 = "INSERT INTO mg_sub (rwdId, rwdTitle, mgId, rwdType  ";
			$SQL2 .= ", rwdValue, rwdProb, rwdRestrict, rwdPrice )";
			$SQL2 .= "  values ('$rwdId'";
			$SQL2 .= ", '$rwdTitle'";
			$SQL2 .= ", '$mgId'";
			$SQL2 .= ", '$rwdType'";
			$SQL2 .= ", '$rwdValue'";
			$SQL2 .= ", '$rwdProb'";
			$SQL2 .= ", '$rwdRestrict'";
			$SQL2 .= ", '$rwdPrice')" ;
		//echo $SQL . "<BR>";
		/**/ 	$result2 = mysqli_query($kiki_conn, $SQL2);
			if ( $result2 === false ) {
			   die( print_r( mysqli_connect_error(), true));
			}
	$numb = $numb + 1;
		}  // while
	}
}

mysqli_close($kiki_conn);

//exit;?>
<form name="list" method="post" action="../c110_write03.php">
  <input type="hidden" name="cur_page" value="<?=$cur_page?>">
  <input type="hidden" name="mgId" value="<?=$mgId?>">
  <input type="hidden" name="appId" value="<?=$kiki_appId?>">
</form>

<Script language="JavaScript">
	document.list.submit();
</Script> 