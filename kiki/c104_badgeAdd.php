<?php  header('Access-Control-Allow-Origin:http://gamebin.iptime.org'); ?>
<?php header('Access-Control-Allow-Credentials: true'); ?>
<?php header('charset=UTF-8');
	include "./kiki_user.php";
	$badgeName = kiki_ischar($_REQUEST["badgeName"]);

if ($_FILES['badge_file']['name']) {
	$badge_file = upload($_FILES['badge_file'],50*1024*1024,$developerId,$kiki_appId);
}

function upload(&$file,$limit_file_size, $path1, $path2)    {
   $save_dir="../../data";
   //금지된 확장자 설정 - 금지할 확장자를 추가해서 사용
   $ban_ext = array('php','php3','html','htm','cgi','pl','asp','jsp','exe','com','inc','bat');

   //업로드 파일 제한 크기를 초과하였는지 확인
   if ($file[size] > $limit_file_size) {    
     //파일의 크기를 아래의 단위로 표시합니다.
     $unit=Array("Bytes", "KB", "MB", "GB");
     for ($i=0; $limit_file_size>=1024; $limit_file_size>>=10, $i++);
       $file_size = sprintf("%d $unit[$i]", $limit_file_size);
       //  MsgBox("업로드 파일 크기 제한 : $file_size");
	   $filename = "";
     }
     //확장자를 이용하여 업로드 가능한 파일인지 체크한다.
     $temp_name = explode(".",$file['name']);
//	 $temp_name = str_replace(" ","",$temp_name);
     $ext = strtolower($temp_name[sizeof($temp_name)-1]);
     $temp_name2 = str_replace("&","",$file['name']);
//	 $temp_name2 = str_replace(" ","",$temp_name2);
	if (in_array($ext,$ban_ext)) {
   //     MsgBox("업로드가 불가능한 확장자입니다.");
		$filename = "";
    }

    //같은 파일명이 있지 않게 하기위해 파일명을 절대 중복이 불가능하게 만든다.
    mt_srand((double)microtime()*1000000);
    $new_file_name = time() . mt_rand(10000,99999);

    $file_name = $new_file_name . '.' . $ext; //파일 이름뒤에 확장자를 붙인다.
    $file_name_db = $file_name . '||' . $temp_name2; //db에 저장될 화일명 예) 새파일명||원래파일명
/**/	$re_ext = strtolower($ext);
	$sumFile = '../../data/badge/'.$path1.'/'.$path2.'/thumb_'.$file_name;

/* */	if ($re_ext == "gif") {  // thumb 처리
		thumbnail(1,$file['tmp_name'],$sumFile,"31","30");
	} elseif ($re_ext == "jpg" || $re_ext == "jpeg") {
		thumbnail(2,$file['tmp_name'],$sumFile,"31","30");
	} elseif ($re_ext == "png") {
		thumbnail(3,$file['tmp_name'],$sumFile,"31","30");
	} elseif ($re_ext == "bmp") {
		thumbnail(4,$file['tmp_name'],$sumFile,"31","30");
	}
	//화일을 지정된 폴더로 이동시킨다.
   if(move_uploaded_file($file['tmp_name'],'../../data/badge/'.$path1.'/'.$path2.'/'.$file_name)) {
     @unlink($file['tmp_name']);
     return $file_name_db;
   } else {
     @unlink($file['tmp_name']);
	 $filename = "";
   } 
}

// 원본 이미지 -> 썸네일로 만드는 함수
function thumbnail($mime, $file, $save_filename, $max_width, $max_height) {
    if(function_exists('imagecreatefromgif') && ($mime === 1)) {  
        $src_img =    imagecreatefromgif($file);  
    } elseif(function_exists('imagecreatefromjpeg') && ($mime === 2)) { 
        $src_img = ImageCreateFromJPEG($file); //JPG파일로부터 이미지를 읽어옵니다
    } elseif(function_exists('imagecreatefrompng') && ($mime === 3)) {  
        $src_img =    imagecreatefrompng($file);  
    } elseif(function_exists('imagecreatefromwbmp') && ($mime === 4)) { 
        $src_img =    imagecreatefromwbmp($file);  
    }  
        $img_info = getImageSize($file);//원본이미지의 정보를 얻어옵니다
        $img_width = $img_info[0];
        $img_height = $img_info[1];
 
        if(($img_width/$max_width) == ($img_height/$max_height))
        {//원본과 썸네일의 가로세로비율이 같은경우
            $dst_width=$max_width;
            $dst_height=$max_height;
        } elseif(($img_width/$max_width) < ($img_height/$max_height)) {//세로기준
            $dst_width=$max_height*($img_width/$img_height);
            $dst_height=$max_height;
        } else {//가로에 기준을 둔경우
            $dst_width=$max_width;
            $dst_height=$max_width*($img_height/$img_width);
        }

		$dst_img = imagecreatetruecolor($dst_width, $dst_height); //타겟img 생성
   
        ImageCopyResized($dst_img, $src_img, 0, 0, 0, 0, $dst_width, $dst_height, $img_width, $img_height); //타겟이미지에 원하는 사이즈의 이미지를 저장
        ImageInterlace($dst_img);

    if($mime === 1) {  
        imagegif($dst_img,  $save_filename);  
    } elseif($mime === 2) { 
        ImageJPEG($dst_img,  $save_filename);
    } elseif($mime === 3) {  
       imagepng($dst_img,  $save_filename);  
    } elseif($mime === 4) { 
       imagewbmp($dst_img,  $save_filename);  
    }  
        ImageDestroy($dst_img);
        ImageDestroy($src_img);
}

if ($badgeName) {
	$UserIP =  $_SERVER["REMOTE_ADDR"];

	$code1 = "bag_";
	$board = "appbadges";
/* 랜덤 문자 */
$feed = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"; 
$size = 8;
for ($i=0; $i < $size; $i++) {
    $code1 .= substr($feed, rand(0, strlen($feed)-1), 1);  
}

function makeZeroNumeric ($str, $num) {
	If (strlen($str) < $num) {
		$no = $num - strlen($str);
		for ($i = 1; $i <= $no; $i++) {
			$zero = $zero . "0";
		}
		return $zero . $str;
	} Else {
		return $str;
	}
}
	$SQL = "Select MAX(badgeId) as badgeId from $board Where left(badgeId,12) = '$code1'";
	$result = mysqli_query($kiki_conn, $SQL);
	if( $result === false) {
		 die( print_r( mysqli_connect_error(), true) );
	} else {
	  $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
 	  $badgeId = $row["badgeId"];	
	  $badgeId = trim($badgeId);
	  mysqli_free_result($result);
	}
	if($badgeId != NULL) {
		$badgeId_ = substr($badgeId,12,5);
		$badgeId_2 = substr($badgeId,0,12);
		$badgeId_ = $badgeId_ + 1;
		$badgeId_ =  sprintf("%.0f",$badgeId_);
		$badgeId_ = makeZeroNumeric($badgeId_,5) ;
		$badgeId = $badgeId_2 . $badgeId_;
	} else {
		$badgeId = makeZeroNumeric($badgeId,5) ;
		$badgeId = $code1 . $badgeId;
	}

$UserIP =  $_SERVER["REMOTE_ADDR"];
	$SQL = "INSERT INTO $board (badgeId, badgeName ";
	$SQL .= ", badgeImg, badgeDate, appId, developerId, UserIP )";
	$SQL .= "  values ('$badgeId'";
	$SQL .= ", '$badgeName'";
	$SQL .= ", '$badge_file'";
	$SQL .= ", now() ";
	$SQL .= ", '$kiki_appId'";
	$SQL .= ", '$developerId'";
	$SQL .= ", '$UserIP' )" ;
/* */	$result = mysqli_query($kiki_conn, $SQL);
	if ( $result === false ) {
	   die( print_r( mysqli_connect_error(), true));
	}

	if($badge_file) {
	   $temp_name = explode("||", $badge_file);
	   $save_file_name = $temp_name[0];
	   $badgeImg = "../data/badge/".$developerId."/".$kiki_appId."/thumb_".$save_file_name;
	} else {
	   $badgeImg = "../img/badge01.png";
	}
 $regiYHS = date("Y-m-d");
$result1 .= "  <tr id='$badgeId'> ";
$result1 .= "    <td> $badgeId </td> ";
$result1 .= "    <td id='img_$badgeId'> <img src='$badgeImg'/> </td> ";
$result1 .= "    <td id='name_$badgeId'>$badgeName </td>  ";
$result1 .= "    <td> $regiYHS </td> ";
$result1 .= "    <td> <a href='javascript:kiki_badge_show(\"$badgeId\")' class='kikibtn_modify'>수정</a> &nbsp; <a href='javascript:kiki_remove_badge(\"$badgeId\")' class='kikibtn_del'>삭제</a> </td> ";
$result1 .= "  </tr> ";

	echo  $result1;
} else {
	echo "false";
}
mysqli_close($kiki_conn);	 ?>