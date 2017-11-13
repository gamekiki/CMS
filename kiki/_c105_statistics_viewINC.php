<script src="https://code.jquery.com/jquery-2.1.0.min.js"></script>
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
	$sub_menu10 = "";	//상품추천		?> 
	 <div class="kiki_content">
        <div class="kiki_conwrap">    
            <div class="kiki_box">
               <!-- <div class="tit_top bm20">Bookoa</div> -->
<?	include "./kiki/kiki_header.php";	

$kind = kiki_ischar($_POST["kind"]);
$actId = kiki_ischar($_POST["actId"]);
if(!$kind) {
	$kind = "d";	// 기간구분 d:일, w:주, m:월
}

if($kind == "g") { // 기간검색일 경우
	$yar1 = kiki_ischar($_POST["yar1"]);
	$mon1 = kiki_ischar($_POST["mon1"]);
	$day1 = kiki_ischar($_POST["day1"]);
}

	$yar2 = kiki_ischar($_POST["yar2"]);
  if(!$yar2) {
	$yar2 = date("Y");
  }
	$mon2 = kiki_ischar($_POST["mon2"]);
  if(!$mon2) {
	$mon2 = date("m");
  }
	$day2 = kiki_ischar($_POST["day2"]);
  if(!$day2) {
	$day2 = date("d");
  }	

if($kind == "d") { // 기간검색일 경우
	$yar1 = $yar2;
	$mon1 = $mon2;
	$day1 = $day2;
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
	  $end2_date = $yar2 . "-". $mon2 ."-". $day2 ;
	  $end_date = date('Y-m-d',  strtotime('1 days', strtotime($end2_date)));

	if ($yar1 && $mon1 && $day1 ) {
	   $start_date = $yar1 . "-". $mon1 ."-". $day1 ;
	} else { // 입력받은 날짜 값이 없으면
		switch ($kind) {
			case "w" :
			  $start_date = date('Y-m-d',  strtotime('-6 days', strtotime($end2_date)));
			  $yar1 = substr($start_date, 0,4);
			  $mon1 = substr($start_date, 5,2);
			  $day1 = substr($start_date, 8,2);
			  break;
			case "m" :
			  $start_date = date('Y-m-d',  strtotime('-1 month', strtotime($end2_date)));
			  $yar1 = substr($start_date, 0,4);
			  $mon1 = substr($start_date, 5,2);
			  $day1 = substr($start_date, 8,2);
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
	$wheStr = " (a.actId = '$actId' and a.appId = '$kiki_appId') and " . $wheStr;	?>
               <div class="kiki_row" style="margin-top:50px">




<form method ="POST" name="kiki_find2" action="./c105_statistics_view.php">
  <input type="hidden" name="actId" value="<?=$actId?>">
  <input type="hidden" name="kind" value="<?=$kind?>">
  <input type="hidden" name="appId" value="<?=$kiki_appId?>">
                 <div class="tit bgnone">
                   <select name="actId" onchange="javascript:document.kiki_find2.submit();">
<?	$SQL = "Select actId, actName from activity ";
	$SQL .= " where (developerId = '$developerId' and appId = '$kiki_appId') ";
	$SQL .= " order by actName ";
	$result = mysqli_query($kiki_conn, $SQL);
	if( $result === false) {
		 die( print_r( mysqli_connect_error(), true) );
	} else {
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		$list_actId = $row["actId"];
		$list_actName = $row["actName"];
		$list_actName = stripslashes($list_actName);	?>
                   <option value="<?=$list_actId?>" <? if ($list_actId == $actId) { ?> selected <? } ?>><?=$list_actName?></option>
<?	  } // while
  	mysqli_free_result( $result);
	}	?>
                   </select>
                  <div class="kikitab_menu small">
                      <ul>
                        <li><a href="javascript:kiki_go_sub2('d')" class="<?=$sub_gigan1?>" id="s_btn1"> 일 </a></li>      
                        <li><a href="javascript:kiki_go_sub2('w')" class="<?=$sub_gigan2?>" id="s_btn2">주</a></li>
                        <li><a href="javascript:kiki_go_sub2('m')" class="<?=$sub_gigan3?>" id="s_btn3">월</a></li>
                        <li><a href="javascript:kiki_go_sub2('g')" class="<?=$sub_gigan4?>" id="s_btn4">기간검색</a></li>
                      </ul>
                   </div>
                 </div>
                 <div class="kikisearch_day">
                  <div class="kikisearch_day_in">
                   <select name="yar1" class="width_at" onchange="kiki_go_change()">
<? for($i = 2017;$i<=2027;$i++) { 	?>
					<option value="<?=$i?>" <? if ($yar1 == $i) { ?> selected <? } ?>><?=$i?></option>
<? } ?>
				  <option value="" <? if ($yar1 == "") { ?> selected <? } ?>> </option>
				   </select> 년
                   <select name="mon1" class="width_at" onchange="kiki_go_change()">
<? for($i = 1;$i<=12;$i++) { 
		if(strlen($i) == 1) {
			$i = "0". $i;
		}	?>
				  <option value="<?=$i?>" <? if ($mon1 == $i) { ?> selected <? } ?>><?=$i?></option>
<? } ?>
                   <option value="" <? if ($mon1 == "") { ?> selected <? } ?>> </option>
                   </select> 월
                   <select name="day1" class="width_at" onchange="kiki_go_change()">
<? for($i = 1;$i<=31;$i++) { 
		if(strlen($i) == 1) {
			$i = "0". $i;
		}	?>
				  <option value="<?=$i?>" <? if ($day1 == $i) { ?> selected <? } ?>><?=$i?></option>
<? } ?>
                   <option value="" <? if ($day1 == "") { ?> selected <? } ?>> </option>
                   </select> 일 ~ 
                    
                   <select name="yar2" class="width_at" onchange="kiki_go_change()">
<? for($i = 2017;$i<=2027;$i++) { 	?>
					<option value="<?=$i?>" <? if ($yar2 == $i) { ?> selected <? } ?>><?=$i?></option>
<? } ?>
					<option value="" <? if ($yar2 == "") { ?> selected <? } ?>> </option>
                   </select> 년
                   <select name="mon2" class="width_at" onchange="kiki_go_change()">
<? for($i = 1;$i<=12;$i++) { 
		if(strlen($i) == 1) {
			$i = "0". $i;
		}	?>
				  <option value="<?=$i?>" <? if ($mon2 == $i) { ?> selected <? } ?>><?=$i?></option>
<? } ?>
				  <option value="" <? if ($mon2 == "") { ?> selected <? } ?>> </option>
                   </select> 월 
                   <select name="day2" class="width_at" onchange="kiki_go_change()">
<? for($i = 1;$i<=31;$i++) { 
		if(strlen($i) == 1) {
			$i = "0". $i;
		}	?>
				  <option value="<?=$i?>" <? if ($day2 == $i) { ?> selected <? } ?>><?=$i?></option>
<? } ?>
				  <option value="" <? if ($day2 == "") { ?> selected <? } ?>> </option>
                   </select> 일
                 <a href="javascript:document.kiki_find2.submit();" class="kikibtn_search">조회</a>
                 </div>
               </div>
</form>
<?// 일자별 액티비티 호출 현황
	$SQL = "SELECT date(a.regiYHS) date, count(actSerno) count FROM user_record a ";
	$SQL .= " INNER JOIN activity b On a.actId = b.actId and a.appId = b.appId";
	$SQL .= " WHERE $wheStr "; // 기간
	$SQL .= " GROUP BY date(a.regiYHS), actName order by date  ";
	$result = mysqli_query($kiki_conn, $SQL);
	if( $result === false) {
		 die( print_r( mysqli_connect_error(), true) );
	} else {
		$arr_num = -1;
		$act_sum = 0;
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		  $arr_num = $arr_num + 1;
			$date = $row["date"];
			$arr_date[$arr_num] = $date;
			$count = $row["count"];
			$act_cnt[$arr_num] = $count;
			$act_sum = $act_sum + $count;
		}
		mysqli_free_result( $result);
	}

// 플랫폼별 액티비티 현황
	$SQL = "SELECT deviceType, count(actSerno) count FROM user_record a ";
	$SQL .= " INNER JOIN activity b On a.actId = b.actId and a.appId = b.appId";
	$SQL .= " WHERE $wheStr "; // 기간
	$SQL .= " GROUP BY deviceType, actName order by count  ";
	$result = mysqli_query($kiki_conn, $SQL);
	if( $result === false) {
		 die( print_r( mysqli_connect_error(), true) );
	} else {
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			$deviceType = $row["deviceType"];
			$count = $row["count"];
		if(!$count) {
			$count = 0;
		}
	switch ($deviceType) {
		case "P" :
			$device_cnt[0] = $count;
			break;
		case "I" : 
			$device_cnt[1] = $count;
			break;
		default : 
			$device_cnt[2] = $count;
			break;
	}
		}
		mysqli_free_result( $result);
	}
if(!$device_cnt[0]) {
	$device_cnt[0] = 0;
}
if(!$device_cnt[1]) {
	$device_cnt[1] = 0;
}
if(!$device_cnt[2]) {
	$device_cnt[2] = 0;
}
// 이용시간대별 액티비티 현황
	$SQL = "SELECT hour(a.regiYHS) useHour, count(actSerno) count FROM user_record a ";
	$SQL .= " INNER JOIN activity b On a.actId = b.actId and a.appId = b.appId";
	$SQL .= " WHERE $wheStr "; // 기간
	$SQL .= " GROUP BY hour(a.regiYHS), actName order by useHour  ";
	$result = mysqli_query($kiki_conn, $SQL);
	if( $result === false) {
		 die( print_r( mysqli_connect_error(), true) );
	} else {
		$hour_num = -1;
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			$hour_num = $hour_num + 1;
			$useHour = $row["useHour"];
			$arr_Hour[$hour_num] = $useHour;
			$count = $row["count"];
		if(!$count) {
			$count = 0;
		}
			$act_Hcnt[$hour_num] = $count;
		}
		mysqli_free_result( $result);
	}

mysqli_close($kiki_conn);	// 지역별 호출 현황 빼면서 위로 올림
//echo "arr_ $hour_num";	?>

<script id="script_code">
    jui.ready([ "chart.builder" ], function(chart) {
        chart("#chart", {
            width: 1210,
            height : 324,
            axis : [
                {
                    data : [
<? for ($k=0;$k < $arr_num ;$k++ ) {	?>
                        { list : "<?=$arr_date[$k]?>", list_cnt : "<?=$act_cnt[$k]?>" },
<?	} ?>
                        { list : "<?=$arr_date[$arr_num]?>", list_cnt : "<?=$act_cnt[$arr_num]?>" }
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
// 플랫폼별 pie
        chart("#chart2", {
            padding: 50,
            width: 577,
            height : 297,
            theme : "jennifer",
            axis : {
                data : [
                    { "PC" : <?=$device_cnt[0]?>, "Android" : <?=$device_cnt[2]?>, "iOS" : <?=$device_cnt[1]?>}
                ]
            },
            brush : [{
                type : "pie",
<?	if ($device_cnt[0] > 0 || $device_cnt[2] > 0 || $device_cnt[1] > 0 ) { ?>
                showText : true,
<?  } else { // 자료가 없다면 ?>
                showText : false,	
<? } ?>
        /*  */       format : function(k, v, max) {
//    return this.icon("check") + k + ": " + v + "(" + ((v/max)*100).toFixed(2) + "%)";
//    return this.icon("check") + k + ": " + ((v/max)*100).toFixed(2) + "%";
      return ((v/max)*100).toFixed(1) + "%";
                },
                active : [ "yellow", "red" ],
                activeEvent : "click"
            }],
            widget : [{
                type : "legend",
                orient : "bottom"
            }, {
                type : "tooltip"
            }]
        });
// 이용시간대별 pie
        chart("#chart3", {
            width: 577,
            height : 297,
            theme : "jennifer",
            axis : {
                data : [ {
<? for ($k=0;$k < $hour_num ;$k++ ) {	?>
                        "<?=$arr_Hour[$k]?>" : <?=$act_Hcnt[$k]?>,
<?	}
	if ($hour_num > -1) { ?>
                        "<?=$arr_Hour[$hour_num]?>" : <?=$act_Hcnt[$hour_num]?>
<?	}	?>
			   } ]
            },
            brush : [{
                type : "pie",
                showText : true,
        /*  */       format : function(k, v, max) {
//    return this.icon("check") + k + ": " + v + "(" + ((v/max)*100).toFixed(2) + "%)";
				    return ((v/max)*100).toFixed(1) + "%";
                },
                active : [ "yellow", "red" ],
                activeEvent : "click"
            }],
            widget : [{
                type : "legend",
                orient : "bottom"
            }, {
                type : "tooltip"
            }]
        });
	})
</script>
                 <div class="con clearfix"> 
                   <p id="chart"></p>
                 </div> <!-- //..con -->
               </div> <!-- //.kiki_row -->

               <div class="kiki_row tm20">
                 <div class="tit">플랫폼별/시간대별 액티비티 호출 현황</div>

                 <div class="con clearfix">
                   <div class="one-half">
                     <p id="chart2"></p>
                   </div>
                   <div class="one-half">
                     <p id="chart3"></p>
                   </div>
                 </div>
               </div> <!-- //.kiki_row -->

  <!--             <div class="kiki_row tm20">
                 <div class="tit">지역별 액티비티 현황</div>
                 <div class="con clearfix">
                    <div>
                    <table class="kiki_tblT01" cellspacing="0" cellpadding="0" border="0">
                           <colgroup>
                             <col width="">
                             <col width="">
                             <col width="20%">
                             <col width="20%">
                           </colgroup>
                     <thead>
                      <tr>
                        <th>국가</th>
                        <th>지역</th>
						<th>접속수</th>
                        <th>접속비율</th>
                      </tr>
                     </thead> 
                     <tbody>
<?
if ($act_sum > 0) {
	$ten_cnt = 0 ;
	$SQL = "SELECT list.accCountry, list.accCity, COUNT(list.actId) count ";
	$SQL .= " FROM (SELECT a.appId, accCountry, accCity, a.actId FROM user_record a INNER ";
	$SQL .= " JOIN activity b On a.actId = b.actId  and a.appId = b.appId ";
	$SQL .= " WHERE $wheStr "; // 기간검색
	$SQL .= " GROUP BY a.regiYHS, accCity ) list ";
	$SQL .= " GROUP BY list.accCity order by count desc, accCountry, accCity limit 0,10 ";
	$result = mysqli_query($kiki_conn, $SQL);
	if( $result === false) {
		 die( print_r( mysqli_connect_error(), true) );
	} else {
		$cnt = 0;
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			$cnt++;
			$accCountry = $row["accCountry"];
			$accCountry = stripslashes($accCountry);
			$accCity = $row["accCity"];
			$accCity = stripslashes($accCity);
			$count = $row["count"];
			$now_per = round(($count * 100 / $act_sum),2);
			$ten_cnt = $ten_cnt + $count;	?>
                       <tr>
                        <td><?=$accCountry?></td>
                        <td><?=$accCity?></td>
                        <td><?=$count?></td>
						<td><?=$now_per?>%</td>
                       </tr>
<?		}
		mysqli_free_result( $result);
	}		
	if ($cnt == 10 and $act_sum > $ten_cnt) {  	// 10개 이상이라면 기타로 처리
		$etc_cnt = $act_sum - $ten_cnt ;
		$now_per = round(($etc_cnt * 100 / $act_sum),2);   ?>
                       <tr>
                        <td>기타</td>
                        <td>기타</td>
                        <td><?=$etc_cnt?></td>
						<td><?=$now_per?>%</td>
                       </tr>
<?  }
} else {	?>
                       <tr>
                        <td colspan="4" class="kiki_nodata">액티비티가 없습니다.</td>
                       </tr>
<?}	// if ($act_sum > 0) { 
mysqli_close($kiki_conn);	?>

                     </tbody>
               </table>
                    </div>
                   
                 </div>
               </div> <!-- //.kiki_row -->
            </div> <!-- //.box_bg -->      
       </div>
      </div>

<script>
function kiki_go_sub2(kind) {
	document.kiki_frm_sub.kind.value = kind;
	document.kiki_frm_sub.action = "./c105_statistics_view.php";
	document.kiki_frm_sub.submit();
}

function kiki_go_change() {
	document.kiki_find2.kind.value = "g";
}
</script>


<form name="kiki_frm_sub" method="post">
  <input type="hidden" name="kind" value="<?=$kind?>">
  <input type="hidden" name="yar1" value="<?=$yar1?>">
  <input type="hidden" name="mon1" value="<?=$mon1?>">
  <input type="hidden" name="day1" value="<?=$day1?>">
  <input type="hidden" name="yar2" value="<?=$yar2?>">
  <input type="hidden" name="mon2" value="<?=$mon2?>">
  <input type="hidden" name="day2" value="<?=$day2?>">
  <input type="hidden" name="actId" value="<?=$actId?>">
  <input type="hidden" name="appId" value="<?=$kiki_appId?>">
</form>