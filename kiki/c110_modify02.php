    <?php header('X-UA-Compatible: IE=edge'); ?>
    <?php header('X-UA-Compatible: IE=8'); ?>
<?php
header('Content-Type: text/html; charset=UTF-8');

	include "./kiki_user.php";
	include "./file_library.php";

	$cur_page = kiki_isnumb($_POST["cur_page"]);

	$mgId = kiki_ischar($_POST["mgId"]);					// 

	$mgRestrict = kiki_ischar($_POST["mgRestrict"]);		// 참여제한 1 : 하루 1회, A : 단회
	$beginDate = kiki_ischar($_POST["beginDate"]);		// 기간 시작일
	$EndDate = kiki_ischar($_POST["EndDate"]);			// 기간 종료일
	$title = kiki_ischar($_POST["title"]);				// 제목
	$description = kiki_ischar($_POST["description"]);	// 설명
	$chk_info = kiki_ischar($_POST["chk_info"]);			// 대표 이미지 

	$old_img = kiki_ischar($_POST["old_img"]);
	$imgname = kiki_ischar($_POST["imgname"]);		// 4 : 기존에 직접 등록

$fileSize = 0;
if ($_FILES['file1']['name']) {
	$exp = explode(".",$_FILES['file1']['name']); 
	$explower = strtolower($exp[1]) ; 
	$exp1 = preg_match("/gif/",$explower); 
	$exp2 = preg_match("/jpg/",$explower); 
	$exp3 = preg_match("/jpeg/",$explower); 
	$exp4 = preg_match("/png/",$explower); 

	 $filename = upload($_FILES[file1],50*1024*1024,'game'); 
//	 $fileSize=$_FILES[file1][size];
}

	if($imgname == "4" and ($filename or $chk_info <> "4" )) {
	  $firstchk = substr($old_img,0,7);
	  if ($old_img != "" AND $firstchk == "../data") { //회원 업로드
		$old_img = str_replace("../data/game/" , "" , $old_img);
		del_file($old_img,'game');
		$old_img2 = str_replace("thumb_" , "" , $old_img);
		del_file($old_img2,'game');
	  }
	}	
	if ($chk_info == "4") {
		$chk_info2 = "../data/game/thumb_".$filename;
	}
//echo $chk_info." / $filename / <BR>";
//echo "old_img = $old_img / imgname = $imgname /chk = $chk_info  / $filename<BR>" ;
if($mgId and $title and $beginDate and $EndDate and $mgRestrict) {
	$SQL = "UPDATE mg_main SET title = '$title' ";
	$SQL .= ", description = '$description' ";
	$SQL .= ", startYHS = '$beginDate' ";
	$SQL .= ", endYHS = '$EndDate'";
  if ($imgname == "4" and $chk_info == "4" and $filename <> "") {
	$SQL .= ", img = '$chk_info2'";
  } elseif ($chk_info != "4") {
	$SQL .= ", img = '$chk_info'";
  } elseif ($imgname <> "4" and $chk_info == "4" and $filename <> "") {
	$SQL .= ", img = '$chk_info2'";
  }
	$SQL .= ", mgRestrict = '$mgRestrict'";
	$SQL .= " WHERE mgId = '$mgId' " ;
//echo $SQL . "<BR>";
//exit;
/**/ 	$result = mysqli_query($kiki_conn, $SQL);
	if ( $result === false ) {
	   die( print_r( mysqli_connect_error(), true));
	}
}
//exit;
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