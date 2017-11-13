  <script src="https://code.jquery.com/jquery-2.1.0.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <link rel="stylesheet" href="./kiki/css/jquery-ui.css" />
  <script src="./kiki/js/core.js"></script>
  <script src="./kiki/js/chart.js"></script>
<?	$sub_menu1 = "";	// 대시보드
	$sub_menu2 = "";	// 회원관리
	$sub_menu3 = "";	// 액티비티 관리
	$sub_menu4 = "";	// 업적관리
	$sub_menu5 = "";	// 뱃지관리
	$sub_menu6 = "on";	//통계/분석
	$sub_menu7 = "";	//리워드 관리
	$sub_menu8 = "";	//레벨설정	
	$sub_menu9 = "";	//미니게임
	$sub_menu10 = "";	//상품추천	
	
	$sub_menu6_01 = "";		// 액티비티
	$sub_menu6_02 = "";			// 가입자
	$sub_menu6_03 = "on";			// 비용
	$sub_menu6_04 = "";			// 활동
	$sub_menu6_05 = "";			// 히스토리	?> 
<script>
$(function() {
	$("#beginDate, #EndDate").datepicker({
		buttonImageOnly: false,
		showButtonPanel: false,
		// date 포멧
		dateFormat : "yy-mm-dd",
		showAnim : "",
		// 다른 달의 일 보이기, 클릭 가능
		showOtherMonths: true,
	 	selectOtherMonths: false,
	 	// 년도, 달 변경
	 	changeMonth: true,
	 	changeYear: true,
	 // 여러달 보이기
	 	numberOfMonths: 1,
	 	showButtonPanel: true,
 // 달력 선택 제한 주기(min: 현재부터 -20일,max:현재부터 +1달+10일) // 아래주석이면 20년 정보
   		minDate: "-5Y +1M +10D",
   		maxDate: 0,
   		showWeek: false,
		firstDay: 0	// 0 : 주일, 1:월요일
	});
   $('#calendar1').on('click', function() {
      $("#beginDate").datepicker('show');
   });
   $('#calendar2').on('click', function() {
      $("#EndDate").datepicker('show');
   });
});
</script>
	  <div class="kiki_content">
        <div class="kiki_conwrap">    
            <div class="kiki_box">
               <!-- <div class="tit_top bm20">Bookoa</div> -->
<?	include "./kiki/kiki_header.php";	
	$kind = kiki_ischar($_POST["kind"]);
	$mgId = kiki_ischar($_POST["mgId"]);

if(!$kind) {
	$kind = "d";	// 기간구분 d:일, w:주, m:월
}
	$start_date = kiki_ischar($_POST["start_date"]);
	$end2_date = kiki_ischar($_POST["end2_date"]);
 
if(!$end2_date) {
	$end2_date = date("Y-m-d");
}

switch ($kind) {
	case "d" :
	  $sub_gigan1 = "";
	  $sub_gigan2 = "on";
	  $sub_gigan3 = "";
	  break;
	case "m" :
	  $sub_gigan1 = "";
	  $sub_gigan2 = "";
	  $sub_gigan3 = "on";
	  break;
	default : 
	  $sub_gigan1 = "on";
	  $sub_gigan2 = "";
	  $sub_gigan3 = "";
	  break;
}
	$end_date = date('Y-m-d',  strtotime('1 days', strtotime($end2_date)));

	if (!$start_date) { // 입력받은 날짜 값이 없으면
		$start_date = $end2_date;
	}

	if ($start_date && !$end_date) {
	   $end_date = date('Y-m-d',  strtotime('1 days', strtotime($start_date)));
	} elseif (!$start_date && $end_date) {
	   $start_date = date('Y-m-d',  strtotime('-1 days', strtotime($end_date)));
	}

	$wheStr1 = "(b.regYHS between '$start_date' and '$end_date' and rwdType = 'P')";
	$wheStr2 = "(b.compYHS between '$start_date' and '$end_date') AND (b.compYHS IS NOT NULL OR b.compYHS != '') ";
	$wheStr1 = " (delFlag = 'N' and c.appId = '$kiki_appId') and " . $wheStr1;
	$wheStr2 = " (delFlag = 'N' and c.appId = '$kiki_appId') and " . $wheStr2;
if ($mgId) {	// 게임이 있다면
	$wheStr1 = $wheStr1 . " and (a.mgId = '$mgId') " ;
	$wheStr2 = $wheStr2 . " and (a.mgId = '$mgId') " ;	
}	?>
               <div class="kiki_row" style="margin-top:10px">
                 <!-- <p class="tit">통계/분석</p> -->
                 
                 
                 <div class="con">
                  <div class="maintab_area">
              <!-- 탭메뉴 -->
              <div class="pro_tabarea" style="margin-bottom:40px">           
<?	// 통계 header 메뉴 
	include "./kiki/c105_statistics_header.php";		?>
              </div>
              <!-- 탭컨텐트 -->
              <div class="tab_con" id="tab_con">
                   <!-- pro_con03: 비용 -->
                  <div id="pro_con03" class="pro_con" style="display:block;">
                    <div class="pro_detail">
                      <div class="con_top">
                          <div class="tab_btn">
                           <a href="javascript:kiki_go_sub2('t')" class="<?=$sub_gigan1?>" id="gigan_t"> 시간대별</a><a href="javascript:kiki_go_sub2('d')" class="<?=$sub_gigan2?>" id="gigan_d">일별</a><a href="javascript:kiki_go_sub2('m')" class="<?=$sub_gigan3?>" id="gigan_m">월별</a>
                          </div>
                           <div class="fl_right">
                              <div class="search">
                                <select name="schSel" id="schSel" class="select_style" style="margin-right:5px">
<?		$SQL = "Select mgId, title from mg_main where appId = '$kiki_appId' ";
		$SQL .= " and delFlag = 'N' order by mgMainSerno desc ";
		$result = mysqli_query($kiki_conn, $SQL);
		if( $result === false) {
//			 die( print_r( mysqli_connect_error(), true) );
		} else {
		  while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			$list_mgId = $row["mgId"];
			$list_title = $row["title"];
			$list_title = stripslashes($list_title);
			if (strlen($list_title) > 12) {
				$list_title = kiki_utf8_strcut($list_title,12); 
			}	?>
                              <option value="<?=$list_mgId?>" <? if ($mgId == $list_mgId) { ?> selected <? } ?>><?=$list_title?></option>
<?		  } // while
  		mysqli_free_result( $result);
		}	?>
                                  <option value="" <? if ($mgId == "") { ?> selected <? } ?>>전체보기</option>
                                </select>
                              </div>
                            </div> <!-- // fl_right -->
                      </div> <!-- con-top -->
                     
                      <div class="row">
                       <span> 조회기간</span> &nbsp;
                       <input name="start_date" id="beginDate" class="" value="<?=$start_date?>" style="width:20%;" type="text" readonly> <a href="#"><img id="calendar1" src="./kiki/img/icon_day.png" alt="달력"></a> ~
                       <input name="end2_date" id="EndDate" class="" value="<?=$end2_date?>" style="width:20%;" type="text" readonly> <a href="#"><img id="calendar2" src="./kiki/img/icon_day.png" alt="달력"></a> 
                       &nbsp; <a href="javascript:go_sch();" class="kikibtn red"> 조회</a>
<?// 가입 시간대별 현황   ISNULL(count(mgLogSerno),0) AS mile_count
	$startDate = date_create($start_date); // 오늘 날짜입니다.
	$targetDate = date_create($end2_date); // 타겟 날짜를 지정합니다.
	$interval = date_diff($startDate, $targetDate);
if ($kind == "t")	{ // 시간대별  현황
	$tot_num = 24;
	$SQL1 = "SELECT hour(b.regYHS) mile_useHour, count(mgLogSerno) AS mile_count, SUM(rwdValue) as mile_Price ";
	$SQL1 .= " FROM mg_sub a INNER JOIN mg_log b ON a.mgId = b.mgId and a.rwdId  "; 
	$SQL1 .= " = b.rwdId INNER JOIN mg_main c ON a.mgId = c.mgId WHERE $wheStr1 "; // 기간
	$SQL1 .= " GROUP BY hour(b.regYHS) order by mile_useHour  ";

	$SQL2 = "SELECT hour(b.compYHS) gift_useHour, count(mgStSerno) gift_count, SUM(rwdPrice) as gift_Price ";
	$SQL2 .= " FROM mg_sub a INNER JOIN mg_st b ON a.mgId = b.mgId and a.rwdId ";
	$SQL2 .= " = b.rwdId INNER JOIN mg_main c ON a.mgId = c.mgId WHERE $wheStr2 "; // 기간
	$SQL2 .= " GROUP BY hour(b.compYHS) order by gift_useHour  ";
  for ($i = 0 ; $i < $tot_num ; $i++) {
	$mile_Hour[$i] = $i;
	$mile_HPrice[$i] = 0;
	$gift_HPrice[$i] = 0;
  }
  $formin = 0;
  $formax = 23;

} elseif ($kind == "d") {		// 일자별 현황이라면
	$tot_num = $interval->days;
	$tot_num = $tot_num + 1;
	$tot_cnt1 = explode("-",$start_date);
	$end_ = explode("-",$end2_date);
	$mile_txt = $tot_cnt1[1] . "/";
	$chk1 = (int)$tot_cnt1[2];
	$date_diff = $chk1 ;

  $formin = (int)$tot_cnt1[2];
  $formax = (int)$end_[2];
  for ($i = $formin ; $i <= $formax ; $i++) {
	$mile_Hour[$i] = $mile_txt . "/". $i;
	$mile_HPrice[$i] = 0;
	$gift_HPrice[$i] = 0;
  }
	$SQL1 = "SELECT DATE(b.regYHS) mile_useHour, count(mgLogSerno) mile_count, SUM(rwdValue) as mile_Price ";
	$SQL1 .= " FROM mg_sub a INNER JOIN mg_log b ON a.mgId = b.mgId and a.rwdId  "; 
	$SQL1 .= " = b.rwdId INNER JOIN mg_main c ON a.mgId = c.mgId WHERE $wheStr1 "; // 기간
	$SQL1 .= " GROUP BY DATE(b.regYHS) order by mile_useHour  ";
	
	$SQL2 = "SELECT DATE(b.compYHS) gift_useHour, count(mgStSerno) gift_count, SUM(rwdPrice) as gift_Price ";
	$SQL2 .= " FROM mg_sub a INNER JOIN mg_st b ON a.mgId = b.mgId and a.rwdId ";
	$SQL2 .= " = b.rwdId INNER JOIN mg_main c ON a.mgId = c.mgId WHERE $wheStr2 "; // 기간
	$SQL2 .= " GROUP BY DATE(b.compYHS) order by gift_useHour  ";
} elseif ($kind == "m") {		// 월별 현황이라면
	$start_ = explode("-",$start_date);
	$end_ = explode("-",$end2_date);
	$sY = $start_[0];
	$sM = $start_[1];
	$eY = $end_[0];
	$eM = $end_[1];

	$dist = ($eY-$sY)*12 + ($eM-$sM);
	$mile_txt = substr($sY,2,2) . "/";

	$tot_num = $dist + 1;
	$ssY = $sY ."/". $sM ."/01";

 if ($sM > $eM) {  // 년말 ~ 년초일 경우
	 $ssY_1 = $sY ."/". $sM ."/01";
	 $ssY_2 = $sY ."/". $sM ."/01";
    for ($i = 0 ; $i < $tot_num ; $i++) {
	  $chk = substr($ssY,2,5);
	  $mile_Hour[$chk] = substr($ssY,2,5);
	  $mile_HPrice[$chk] = 0;
	  $gift_HPrice[$chk] = 0;
	  $ssY = date("Y/m/d", strtotime($ssY."+1 months"));
    }
    $formin = (int)$start_[1];
    $formax = (int)$end_[1];
 } else {
    $formin = (int)$start_[1];
    $formax = (int)$end_[1];
    for ($i = $formin ; $i <= $formax ; $i++) {
//	echo substr($ssY,5,2) . "<BR>";
	  $chk = substr($ssY,2,5);
//echo "chk = $i <br>";
	  $mile_Hour[$i] = substr($ssY,2,5);
	  $mile_HPrice[$i] = 0;
	  $gift_HPrice[$i] = 0;
	  $ssY = date("Y/m/d", strtotime($ssY."+1 months"));
    }
 }
	$SQL1 = "SELECT MONTH(b.regYHS) mile_useHour, b.regYHS as mile_count, SUM(rwdValue) as mile_Price ";
	$SQL1 .= " FROM mg_sub a INNER JOIN mg_log b ON a.mgId = b.mgId and a.rwdId  "; 
	$SQL1 .= " = b.rwdId INNER JOIN mg_main c ON a.mgId = c.mgId WHERE $wheStr1 "; // 기간
	$SQL1 .= " GROUP BY MONTH(b.regYHS) order by mile_useHour  ";
	
	$SQL2 = "SELECT MONTH(b.compYHS) gift_useHour, b.compYHS as gift_count, SUM(rwdPrice) as gift_Price ";
	$SQL2 .= " FROM mg_sub a INNER JOIN mg_st b ON a.mgId = b.mgId and a.rwdId ";
	$SQL2 .= " = b.rwdId INNER JOIN mg_main c ON a.mgId = c.mgId WHERE $wheStr2 "; // 기간
	$SQL2 .= " GROUP BY MONTH(b.compYHS) order by gift_useHour  ";
}
//echo $SQL1 . "<BR>";
//echo $SQL2 . "<BR><br>";
// 마일리지 비용
	$result = mysqli_query($kiki_conn, $SQL1);
	if( $result === false) {
		 die( print_r( mysqli_connect_error(), true) );
	} else {
		$mile_num = 0;
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			$mile_useHour = $row["mile_useHour"];
			$mile_count = $row["mile_count"];
		if(!$mile_count) {
			$mile_count = 0;
		}
			$mile_Price = $row["mile_Price"];
		if(!$mile_Price) {
			$mile_Price = 0;
		}
	switch ($kind) {
		case ("d") :
			$mile_cnt1 = explode("-",$mile_useHour);
			$chk = (int)$mile_cnt1[2];
			$mile_Hour[$chk] = $mile_txt . (int)$mile_cnt1[2] ;
			$mile_HPrice[$chk] = $mile_Price;
			break;
		case ("m") :
			$mile_cnt1 = explode("-",$mile_count);
     if ($sM > $eM) {  // 년말 ~ 년초일 경우
			$milechk = substr($mile_cnt1[0],2,2) . "/" . (int)$mile_cnt1[1];
			$mile_Hour[$milechk] = $milechk;
			$mile_HPrice[$milechk] = $mile_Price;
	 } else {
			$mile_Hour[$mile_useHour] = substr($mile_cnt1[0],2,2) . "/" . (int)$mile_cnt1[1];
			$mile_HPrice[$mile_useHour] = $mile_Price;
	}
			break;
		default :
			$mile_Hour[$mile_useHour] = $mile_useHour;
			$mile_HPrice[$mile_useHour] = $mile_Price;
			break;
	}
		}
		mysqli_free_result( $result);
	}
// 기프티콘 시작
	$result = mysqli_query($kiki_conn, $SQL2);
	if( $result === false) {
		 die( print_r( mysqli_connect_error(), true) );
	} else {
		$gift_num = 0;
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			$gift_useHour = $row["gift_useHour"];
			$gift_count = $row["gift_count"];
		if(!$mile_count) {
			$mile_count = 0;
		}
			$gift_Price = $row["gift_Price"];
		if(!$gift_Price) {
			$gift_Price = 0;
		}
	switch ($kind) {
		case ("d") :
			$mile_cnt1 = explode("-",$gift_useHour);
			$chk = (int)$mile_cnt1[2];
			$gift_HPrice[$chk] = $gift_Price;
			break;
		case ("m") :
			$mile_cnt1 = explode("-",$gift_count);
     if ($sM > $eM) {  // 년말 ~ 년초일 경우
			$milechk = substr($mile_cnt1[0],2,2) . "/" . (int)$mile_cnt1[1];
			$gift_HPrice[$milechk] = $gift_Price;
	 } else {
			$gift_HPrice[$gift_useHour] = $gift_Price;
	}
			break;
		default :
			$gift_HPrice[$gift_useHour] = $gift_Price;
			break;
	}
		}
		mysqli_free_result( $result);
	}	
mysqli_close($kiki_conn);	?>

<script id="script_code">
	jui.ready([ "chart.builder" ], function(chart) {
         chart("#chart", {
             width: 1200,
            height : 400,
             padding : 50,
            theme : "jennifer",
            axis : {
                x : {
                    domain : [  // x 축
<?	if ($sM > $eM) {
		for ($k=0;$k < $dist ;$k++ ) {	
			$chk = substr($ssY_1,2,5);	?>
  "<?=$mile_Hour[$chk]?>" ,
<?			$ssY_1 = date("Y/m/d", strtotime($ssY_1."+1 months"));
		}
		$chk = substr($ssY_1,2,5);			?>
  "<?=$mile_Hour[$chk]?>"
<?	} else {
		for ($k=$formin;$k < $formax ;$k++ ) {	?>
  "<?=$mile_Hour[$k]?>" ,
<?		}	?>
  "<?=$mile_Hour[$formax]?>"
<?	}	?>
					],
					line : true
                },
                y : {
                    type : 'range',
                    domain : function(data) {
                        return [data.마일리지 + data.기프티콘, 0];
                    },
                    unit : 10000,
                    line : true,
                    reverse : false
                },
                data : [
 <?	if ($sM > $eM) {
		for ($k=0;$k < $dist ;$k++ ) {	
			$chk = substr($ssY_2,2,5);	?>
  { "마일리지" : <?=$mile_HPrice[$chk]?>, "기프티콘" : <?=$gift_HPrice[$chk]?> },
<?			$ssY_2 = date("Y/m/d", strtotime($ssY_2."+1 months"));
		}
		$chk = substr($ssY_2,2,5);	?>
  { "마일리지" : <?=$mile_HPrice[$chk]?>, "기프티콘" : <?=$gift_HPrice[$chk]?> }
<?	} else {
		for ($k=$formin;$k < $formax ;$k++ ) {	?>
  { "마일리지" : <?=$mile_HPrice[$k]?>, "기프티콘" : <?=$gift_HPrice[$k]?> },
<?		}	?>
  { "마일리지" : <?=$mile_HPrice[$formax]?>, "기프티콘" : <?=$gift_HPrice[$formax]?> }
<?	}?>
                ]
            },
             brush : [{
                type : 'stackcolumn',
                display : "all",
                format : function(v) {
                    return v  // + "!!!";
                } ,
                edge : false , // true : 옆의 데이타와 선으로 연결,false : 연결 안 함
				colors : [ 2, "#9228E4"]	// colors : [ 2, 8 ]
            }],
			widget : [
                { type : "legend", filter : false, orient : "bottom", align: "start", colors : [ 2, "#9228E4" ] },	//  아래 주석 부분 
				{ type : "tooltip", all : true}
            ],
            event : {
                click : function(obj, e) {
                    console.log(obj);
                }
            } 
        });
	})
</script>
                       <div class="con">
                         <div id="chart"></div>
                        </div> <!-- // borad_list -->
   
                      </div> <!-- //row -->

                  </div> <!-- // pro_detail -->
                   </div> 
                   <!--//  pro_con03: 비용 -->
                   <!-- pro_con04: 활동 -->
                  
               </div>  
               <!-- // 탭컨텐트 -->            
            </div>
                
                 </div> <!-- //.con -->
               </div><!-- //.kiki_row -->
               
              
            </div> <!-- //kiki_box -->      
       </div>
      </div>

<script>
function kiki_go_sub2(kind) {
	document.kiki_frm_sub.kind.value = kind;
	$("#gigan_d").removeClass("on");
	$("#gigan_m").removeClass("on");
	$("#gigan_t").removeClass("on");
	$("#gigan_"+kind).attr('class', 'on');
//	document.kiki_frm_sub.action = "./c105_statistics_cost.php";
//	document.kiki_frm_sub.submit();
}

function kiki_go_sub3(mgId) {
	document.kiki_frm_sub.mgId.value = mgId;
	document.kiki_frm_sub.action = "./c105_statistics_cost.php";
	document.kiki_frm_sub.submit();
}

function go_sch() {
	document.kiki_frm_sub.mgId.value =  $("#schSel").val();
console.log($("#schSel").val())
	startdate =  $("#beginDate").val();
	enddate = $("#EndDate").val();
if (startdate > enddate) {
	alert("조회기간을 확인해 주세요");
	return;
}	
	kind = document.kiki_frm_sub.kind.value;
	firstdate = new Date(startdate);
	seconddate = new Date(enddate);
  if (kind == "t") {
	diff = Number((seconddate.getTime() - firstdate.getTime()) /1000/60/60/24);
	if (diff <= 180) {
	  document.kiki_frm_sub.start_date.value = startdate;
	  document.kiki_frm_sub.end2_date.value = enddate;
	  document.kiki_frm_sub.action = "./c105_statistics_cost.php";
	  document.kiki_frm_sub.submit();
	} else {
	  alert("기간은 6개월 이내로 선택하세요.");
	}
  } else if (kind == "d") {
	first1 = startdate.substring(0,7);
	end1 = enddate.substring(0,7);
	if (first1 == end1) {
	  document.kiki_frm_sub.start_date.value = startdate;
	  document.kiki_frm_sub.end2_date.value = enddate;
	  document.kiki_frm_sub.action = "./c105_statistics_cost.php";
	  document.kiki_frm_sub.submit();
	} else {
	  alert("일별 검색은 같은 달 내에서만 가능합니다.");
	}
  } else {  // 월이라면
	if(enddate.substring(0,4) == startdate.substring(0,4)) {
       diff = enddate.substring(5,7) * 1 - startdate.substring(5,7) * 1;
    } else {
       diff = Math.round((seconddate.getTime()-firstdate.getTime())/(1000*60*60*24*365/12));
    }	
	if (diff <= 6) {
	  document.kiki_frm_sub.start_date.value = startdate;
	  document.kiki_frm_sub.end2_date.value = enddate;
	  document.kiki_frm_sub.action = "./c105_statistics_cost.php";
	  document.kiki_frm_sub.submit();
	} else {
	  alert("기간은 6개월 이내로 선택하세요.");
//console.log("first = "+first1 + ", end = "+end1)
	}
  }
}
</script>

<form name="kiki_frm_sub" method="post">
  <input type="hidden" name="kind" value="<?=$kind?>">
  <input type="hidden" name="end2_date" value="<?=$end2_date?>">
  <input type="hidden" name="start_date" value="<?=$start_date?>">
  <input type="hidden" name="mgId" value="<?=$mgId?>">
  <input type="hidden" name="appId" value="<?=$kiki_appId?>">
</form>