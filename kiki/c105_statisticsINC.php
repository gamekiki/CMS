 <script src="https://code.jquery.com/jquery-2.1.0.min.js"></script>
 <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
 <link rel="stylesheet" href="./kiki/css/jquery-ui.css" />
 <script src="./kiki/js/jui.js"></script>
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
	
	$sub_menu6_01 = "on";		// 액티비티
	$sub_menu6_02 = "";			// 가입자
	$sub_menu6_03 = "";			// 비용
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

if(!$kind) {
	$kind = "d";	// 기간구분 d:일, w:주, m:월
}
if($kind == "g") { // 기간검색일 경우
	$start_date = kiki_ischar($_POST["start_date"]);
}
	$end2_date = kiki_ischar($_POST["end2_date"]);
 
if(!$end2_date) {
	$end2_date = date("Y-m-d");
}

switch ($kind) {
	case "w" :
	  $sub_gigan1 = "";
	  $sub_gigan2 = "on";
	  $sub_gigan3 = "";
	  $sub_gigan4 = "";
	  break;
	case "m" :
	  $sub_gigan1 = "";
	  $sub_gigan2 = "";
	  $sub_gigan3 = "on";
	  $sub_gigan4 = "";
	  break;
	case "g" : 
	  $sub_gigan1 = "";
	  $sub_gigan2 = "";
	  $sub_gigan3 = "";
	  $sub_gigan4 = "on";
	  break;
	default : 
	  $sub_gigan1 = "on";
	  $sub_gigan2 = "";
	  $sub_gigan3 = "";
	  $sub_gigan4 = "";
	  break;
}
	$end_date = date('Y-m-d',  strtotime('1 days', strtotime($end2_date)));

	if (!$start_date) { // 입력받은 날짜 값이 없으면
		switch ($kind) {
			case "w" :
			  $start_date = date('Y-m-d',  strtotime('-6 days', strtotime($end2_date)));
			  break;
			case "m" :
			  $start_date = date('Y-m-d',  strtotime('-1 month', strtotime($end2_date)));
			  break;
		}
	}

	if ($start_date && $end_date ) {
	   $wheStr = "(a.regiYHS between '$start_date' and '$end_date')";
	} elseif ($start_date && !$end_date) {
	   $end_date = date('Y-m-d',  strtotime('1 days', strtotime($start_date)));
	   $wheStr = "(a.regiYHS between '$start_date' and '$end_date')";
	} elseif (!$start_date && $end_date) {
	   $start_date = date('Y-m-d',  strtotime('-1 days', strtotime($end_date)));
	   $wheStr = "(a.regiYHS between '$start_date' and '$end_date')";
	}
	$wheStr = " (a.appId = '$kiki_appId') and " . $wheStr;	?>
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
                <!-- pro_con01: 활동정보 -->
                  <div id="pro_con01" class="pro_con" style="display: block;">
                    <div class="pro_detail">
                      <p class="tit">액티비티 통계</p>
                      <div class="con_top mgt30">
                          <div class="tab_btn">
                           <a href="javascript:kiki_go_sub2('d')" class="<?=$sub_gigan1?>" id="gigan_d"> 일</a><a href="javascript:kiki_go_sub2('w')" class="<?=$sub_gigan2?>" id="gigan_2">주</a><a href="javascript:kiki_go_sub2('m')" class="<?=$sub_gigan3?>" id="gigan_m">월</a><a href="javascript:kiki_go_sub_class()" class="<?=$sub_gigan4?>" id="gigan_g">기간검색</a>
                          </div>
                      </div> <!-- con-top -->
                     
                      <div class="row">
                       <span> 조회기간</span> &nbsp;
                       <input name="beginDate" id="beginDate" class="" value="<?=$start_date?>" style="width:20%;" type="text" readonly> <a href="#"><img id="calendar1" src="./kiki/img/icon_day.png" alt="달력"></a> ~
                       <input name="EndDate" id="EndDate" class="" value="<?=$end2_date?>" style="width:20%;" type="text" readonly> <a href="#"><img id="calendar2" src="./kiki/img/icon_day.png" alt="달력"></a> 
                       &nbsp; <a href="javascript:go_sch();" class="kikibtn red"> 조회</a>
<?// 액티비티 호출 현황
//echo "whe = $wheStr <br>";
//$arr_num_chart = 0;
	$SQL = "SELECT list.actName, list.actId, COUNT(list.actId) count ";
	$SQL .= " FROM (SELECT a.appId, actName, a.actId FROM user_record a INNER ";
	$SQL .= " JOIN activity b On a.actId = b.actId  and a.appId = b.appId ";
	$SQL .= " WHERE $wheStr "; // 기간
	$SQL .= " GROUP BY a.regiYHS, actName ) list WHERE appId = '$kiki_appId' ";
	$SQL .= " GROUP BY list.actName order by count desc, actName limit 0,5  ";
	$result = mysqli_query($kiki_conn, $SQL);
	if( $result === false) {
		 die( print_r( mysqli_connect_error(), true) );
	} else {
		$arr_num = 0;
		$act_sum = 0;
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			$actName = $row["actName"];
			$actName = stripslashes($actName);
     	if (strlen($actName) > 8) {
			$actName2 = kiki_utf8_strcut($actName,8); 
		}
			$arr_actName[$arr_num] = $actName;
			$arr_actName2[$arr_num] = $actName2;
			$actId = $row["actId"];
			$arr_actId[$arr_num] = $actId;
			$count = $row["count"];
			$act_cnt[$arr_num] = $count;
			$act_sum = $act_sum + $count;
			$arr_num = $arr_num + 1;
		}
		$arr_num_chart = $arr_num - 1;
		mysqli_free_result( $result);
	}	?>
<script id="script_code">
    jui.ready([ "chart.builder" ], function(chart) {
        chart("#chart", {
            width: 540,
            height : 242,
            axis : [
                {
                    data : [
<? for ($k=0;$k < $arr_num_chart ;$k++ ) {	?>
                        { list : "<?=$arr_actName2[$k]?>", list_cnt : "<?=$act_cnt[$k]?>" },
<?	} ?>
                        { list : "<?=$arr_actName2[$arr_num_chart]?>", list_cnt : "<?=$act_cnt[$arr_num_chart]?>" }
                    ],
                    y : {
                        type : "range",
                    //    domain : [ 0, 100 ], // 최소, 최대 값
						domain : "list_cnt",
						step : 5,  // Y 축 눈금 수
                        line : true,
//                        orient  : "right"
						orient  : "left"
//						reverse: true
                    },
                    x : {
                        type : "block",
                        domain : "list", // data 처음 값 : X 축
                        line : "rect",
                        orient : "bottom"
                    }
                }
            ],
			brush : [{
                type : "column",
                size : 10,
                target : "list_cnt", // data 두번째 값 : Y 축
                display : "max",
                activeEvent : "mouseover",
                active : 1,
                minSize : 5,
                animate : "bottom",
                colors : function(data, dataKey) {

					if(data.list_cnt > 50) {
                        return "red";
                    }
                    return "blue";
                }
            }],
            event : {
                "axis.click" : function(e) {
                    console.log(e);
                }
            },
            style : {
            }
        });
	})
</script>
                       <div class="con clearfix mgt20">
                         <!--  그래프 영역 -->
                         <div class="one-half">
                            <p id="chart"></p>
                         </div> <!-- // 그래프 영역 -->
                         <!--  테이블 영역 -->
                         <div class="one-half">
                            <table class="kiki_tblT01">
                          <colgroup>
                              <col width="">
                              <col width="20%">
                              <col width="20%">
                          </colgroup>
                          <thead>
                              <tr>
                                  <th scope="col">액티비티.</th>
                                  <th scope="col">호출수</th>
                                  <th scope="col">%</th>
                              </tr>
                          </thead>
                          <tbody>
<?	for ($j = 0;$j<$arr_num;$j++) {
		$actName = $arr_actName[$j];
		$actId = $arr_actId[$j];
		$count = $act_cnt[$j];
		$now_per = round(($count * 100 / $act_sum),2);
	if ($count) {
		$count = number_format($count);
	}		?>
                          <tr>
                              <td><a href="javascript:kiki_go_sub3('<?=$actId?>')"><?=$actName?></a></td>
                              <td><?=$count?></td>
                              <td><?=$now_per?>%</td>
                          </tr>
<?	}
if ($arr_num == 0) { ?>
                          <tr>
                              <td colspan="3"><div class="kiki_nodata">등록된 액티비티가 없습니다.</div></td>
                          </tr>
<? } ?>
                          </tbody>
                          </table>
                         </div> <!-- // 테이블 영역 : one-half-->
                        </div> <!-- // con clearfix -->
   
                      </div> <!-- //row -->
                      
                      <div class="kiki_row tm20">
                         <p class="tit">액티비티 리스트</p>
                         <div class="con clearfix"> 
                             <!-- table :액티비티 -->
                             <table class="kiki_tblT01" border="0" cellspacing="0" cellpadding="0">
                                       <colgroup>
                                         <col width="">
                                         <col width="20%">
                                         <col width="20%">
            
                                        </colgroup>
                                 <thead>
                                  <tr>
                                    <th>주요 액티비티</th>
                                    <th>호출수</th>
                                    <th>%</th>
                                  </tr>
                                 </thead> 
                                 <tbody>
<?	$act_sum = 0;
	$SQL = "SELECT COUNT(list.actId) count ";
	$SQL .= " FROM (SELECT a.appId, a.actId FROM user_record a INNER ";
	$SQL .= " JOIN activity b On a.actId = b.actId  and a.appId = b.appId ";
	$SQL .= " WHERE $wheStr "; // 기간검색
	$SQL .= " GROUP BY a.regiYHS, actName ) list WHERE appId = '$kiki_appId' ";
//echo $SQL . "<BR>";
	$result = mysqli_query($kiki_conn, $SQL);
	if( $result === false) {
		 die( print_r( mysqli_connect_error(), true) );
	} else {
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		$act_sum = $row["count"];
		mysqli_free_result( $result);
	}

if ($act_sum > 0) {
	$SQL = "SELECT list.actName, list.actId, COUNT(list.actId) count ";
	$SQL .= " FROM (SELECT a.appId, actName, a.actId FROM user_record a INNER ";
	$SQL .= " JOIN activity b On a.actId = b.actId  and a.appId = b.appId ";
	$SQL .= " WHERE $wheStr "; // 기간검색
	$SQL .= " GROUP BY a.regiYHS, actName ) list WHERE appId = '$kiki_appId' ";
//	$SQL .= " GROUP BY a.regiYHS, actName ) list ";
	$SQL .= " GROUP BY list.actName order by count desc, actName ";
//echo $SQL;
	$result = mysqli_query($kiki_conn, $SQL);
	if( $result === false) {
		 die( print_r( mysqli_connect_error(), true) );
	} else {
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			$actName = $row["actName"];
			$actName = stripslashes($actName);
			$actId = $row["actId"];
			$count = $row["count"];
			$now_per = round(($count * 100 / $act_sum),2);
	if ($count) {
		$count = number_format($count);
	}	?>
                                   <tr>
                                      <td><a href="javascript:kiki_go_sub3('<?=$actId?>')"><?=$actName?></a></td>
                                      <td><?=$count?></td>
                                      <td><?=$now_per?>%</td>
                                   </tr>
<?		}
		mysqli_free_result( $result);
	}
} else {	?>
                                   <tr>
                                      <td colspan="3"><div class="kiki_nodata">등록된 액티비티가 없습니다.</div>
                                   </tr>
<?}	// if ($act_sum > 0) { 
mysqli_close($kiki_conn);	?>
                                 </tbody>
                              </table>  
                              <!-- // table :액티비티 -->
                           
                         </div>
                       </div> <!-- //row -->

                  </div> <!-- // pro_detail -->
                   </div> 
                   <!--//  pro_con01: 액티비티 -->
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
	document.kiki_frm_sub.action = "./c105_statistics.php";
	document.kiki_frm_sub.submit();
}

function kiki_go_sub3(actId) {
	document.kiki_frm_sub.actId.value = actId;
	document.kiki_frm_sub.action = "./c105_statistics_view.php";
	document.kiki_frm_sub.submit();
}

function go_sch() {
	startdate =  $("#beginDate").val();
	enddate = $("#EndDate").val();
if (startdate > enddate) {
	alert("조회기간을 확인해 주세요");
	return;
}
	firstdate = new Date(startdate);
	seconddate = new Date(enddate);
	diff = Number((seconddate.getTime() - firstdate.getTime()) /1000/60/60/24);
	if (diff <= 30) {
	  document.kiki_frm_sub.kind.value = "g";
	  document.kiki_frm_sub.start_date.value = startdate;
	  document.kiki_frm_sub.end2_date.value = enddate;
	  document.kiki_frm_sub.action = "./c105_statistics.php";
	  document.kiki_frm_sub.submit();
	} else {
	  alert("최대 검색 기간은 30일 입니다.");
	}
}

function kiki_go_sub_class() {
	$("#gigan_d").removeClass("on");
	$("#gigan_w").removeClass("on");
	$("#gigan_m").removeClass("on");
	$("#gigan_g").attr('class', 'on');
}
</script>

<form name="kiki_frm_sub" method="post">
  <input type="hidden" name="kind" value="<?=$kind?>">
  <input type="hidden" name="end2_date" value="<?=$end2_date?>">
  <input type="hidden" name="start_date" value="<?=$start_date?>">
  <input type="hidden" name="actId" value="<?=$actId?>">
  <input type="hidden" name="appId" value="<?=$kiki_appId?>">
</form>