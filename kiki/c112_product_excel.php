<?php  header('Access-Control-Allow-Origin:http://gamebin.iptime.org'); ?>
<?php header('Access-Control-Allow-Credentials: true'); ?>
<?php header('charset=UTF-8');

	$UserID = $_COOKIE["UserID"];

	include "./kiki_user.php";
	require_once "./reader.php";
	$data = new Spreadsheet_Excel_Reader();
	$data->setOutputEncoding("UTF-8//IGNORE");
	$UserIP = $_SERVER["REMOTE_ADDR"];

function upload(&$file,$limit_file_size, $folder1)    {
   $save_dir="../../data/product";
   //금지된 확장자 설정 - 금지할 확장자를 추가해서 사용
   $ban_ext = array('php','php3','html','htm','cgi','pl','asp','jsp','exe','com');

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
        MsgBox("업로드가 불가능한 확장자입니다.");
    }
     
    //같은 파일명이 있지 않게 하기위해 파일명을 절대 중복이 불가능하게 만든다.
    mt_srand((double)microtime()*1000000);
    $new_file_name = time() . mt_rand(10000,99999);

    $file_name = $new_file_name . '.' . $ext; //파일 이름뒤에 확장자를 붙인다.
	$re_ext = strtolower($ext);

    //화일을 지정된 폴더로 이동시킨다.
   if(move_uploaded_file($file['tmp_name'],$save_dir.'/'.$file_name)) {
     @unlink($file['tmp_name']);
     return $file_name;
   } else {
     @unlink($file['tmp_name']);
	 $filename = "";
   }
}
	$msg = "";
	$prog = "";

	if ($_FILES['file1']['name']) {
		$exp = explode(".",$_FILES['file1']['name']); 
		$exp1 = preg_match("/xls/",$exp[1]); 
		if(!$exp1) { 
		   $msg =  "xls 파일만 등록 가능합니다."; 
		   $prog = "false";
		} else {
			$filename1 = upload($_FILES['file1'],50*1024*1024,'product'); 

			$data->read("/home/kshop/docs/data/product/".$filename1);
			for ($i = 2; $i <= $data->sheets[0]["numRows"]; $i++) {
			   $prodId = $data->sheets[0]["cells"][$i][1];
			   $prodImgUrl = $data->sheets[0]["cells"][$i][2];
			   $prodName = $data->sheets[0]["cells"][$i][3];
			   $prodPrice = $data->sheets[0]["cells"][$i][4];
			   $prodUrl = $data->sheets[0]["cells"][$i][5];
			   $kword = $data->sheets[0]["cells"][$i][6];
			   $prodQty = $data->sheets[0]["cells"][$i][7];
//			   $prodQty = $data->sheets[0]["cells"][$i][8];
//echo "id = $prodId /ig = $prodImgUrl / name= $prodName / price = $prodPrice / url = $prodUrl / kw = $kword / qty = $prodQty <BR>";
		
		if($prodId and $prodImgUrl and $prodName and $prodPrice and $prodUrl and $kword and $prodQty) {
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
	//		echo $SQL . "<BR>";
			/**/ 	$result = mysqli_query($kiki_conn, $SQL);
				if ( $result === false ) {
				   die( print_r( mysqli_connect_error(), true));
				}
		} else {
			$msg .= $prodId . ",";
			$prog = "false";
		}
			} // for

	if (!$prog) {
		$msg = "";
		$prog = "true";
	} else {
		$strlen = strlen($msg) - 1;
		$msg = substr($msg, 0, $strlen);
		$msg .= " 상품이 등록되지 않았습니다.";
	}
		} // xls 파일이라면
	mysqli_close($kiki_conn);
	echo  '{"prog":"'. $prog .'","filename":"'. $filename1 .'","msg":"'. $msg .'"}';
//		echo  '{"prog":"'. $prog .'","filename":"'. $filename1 .'","msg":"'. $msg .'","prodId":"'. $prodId .'","prodImgUrl":"'. $prodImgUrl .'","prodName":"'. $prodName .'","prodPrice":"'. $prodPrice .'","prodUrl":"'. $prodUrl .'","kword":"'. $kword .'","prodQty":"'. $prodQty .'"}';
	} else { /* */ // if file ()
	mysqli_close($kiki_conn);
		echo '{"prog":"'. $_FILES['filename1']['name'] .'"}';
	}
	  ?>