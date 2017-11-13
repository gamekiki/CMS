<!doctype html>
<html lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>GameKiKi</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=8">
    <meta http-equiv="X-UA-Compatible" content="IE=9">
    <meta http-equiv="X-UA-Compatible" content="IE=10">
<link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
<link href="http://fonts.googleapis.com/earlyaccess/nanumgothic.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="../css/reset.css" type="text/css" >
<link rel="stylesheet" href="../css/style.css" type="text/css" >
<link rel="stylesheet" type="text/css" href="./kiki/css/kiki_style.css">

</head>

<body>
<div id="body-wrapper">
  <!-- #header -->
   <div id="header" class="sub">
<? include "../inc/header.php";		?>

   </div>
   <input type="hidden" id="app" value="Y">
   <!-- // #header --> 
   <!-- #content -->
   <div id="content">
   <div class="contet_wrapper"> 
    <div class="inner_sub">   
	  <div class="box_bg"> 
 <?	include "./kiki/c105_statistics_activityINC.php";	?>
	  </div>
    </div> <!-- //.inner_con -->
   </div> <!-- //.contetn_wrap -->
   </div>
   <!-- // #content -->
   <!-- #footer -->
<? include "../inc/footer.php";
	mysqli_close($conn);	?>
   <!-- // #footer -->
  </div> 

</body>
</html>

<form name="kiki_frm_sub2" method="post">
  <input type="hidden" name="appId" value="<?=$kiki_appId?>">
</form>