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
	$wheStr = " (a.appId = '$kiki_appId') and " . $wheStr;	?>
               <div class="kiki_row" style="margin-top:50px">
                 <p class="tit">통계/분석</p>
				 
                 <div class="con">
                  <div class="maintab_area">
              <!-- 탭메뉴 -->
              <div class="pro_tabarea">           
                <div class="nav">
                
                <ul class="tab" id="tab">
                  <li class="on"><a href="javascript:go_sub_kiki('./c105_statistics.php')" id="pro_tab01">액티비티</a></li>
                  <li class=""><a href="javascript:go_sub_kiki('./c105_statistics_join.php')" id="pro_tab02">가입자</a></li>
                  <li class=""><a href="#location" id="pro_tab03">비용</a></li>
                  <li class=""><a href="#location" id="pro_tab04">활동</a></li>
                  <li class=""><a href="javascript:go_sub_kiki('./c105_statistics_history.php')" id="pro_tab05">히스토리</a></li>
                </ul>
                </div> <!-- //nav -->
              </div>


				 <div>

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
<form method ="POST" name="kiki_find2" action="./c105_statistics.php">
  <input type="hidden" name="kind" value="<?=$kind?>">
  <input type="hidden" name="appId" value="<?=$kiki_appId?>">
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
</form>
             </div>
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
                 <div class="con clearfix"> 
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
                   <div class="one-half">
                     <p id="chart"></p>
                   </div>
                   <div class="one-half">
                     <!-- table :액티비티 -->
                     <table class="kiki_tblT01" cellspacing="0" cellpadding="0" border="0">
                               <colgroup>
                                 <col width="">
                                 <col width="20%">
                                 <col width="20%">
    
                                </colgroup>
                         <thead>
                          <tr>
                            <th>액티비티</th>
                            <th>호출수</th>
                            <th>%</th>
                          </tr>
                         </thead> 
                         <tbody>
<?	for ($j = 0;$j<$arr_num;$j++) {
		$actName = $arr_actName[$j];
		$actId = $arr_actId[$j];
		$count = $act_cnt[$j];
		$now_per = round(($count * 100 / $act_sum),2); ?>
                           <tr>
                            <td><a href="javascript:kiki_go_sub3('<?=$actId?>')"><?=$actName?></a></td>
                            <td><?=$count?></td>
                            <td><?=$now_per?>%</td>
                           </tr>
<?	}
if ($arr_num == 0) { ?>
                           <tr>
                            <td colspan="3" class="kiki_nodata">등록된 액티비티가 없습니다.</td>
                           </tr>
<? } ?>
                         </tbody>
                      </table>  
                      <!-- // table :액티비티 -->                 
                   </div><!-- //.one-half -->
                 </div> <!-- //..con -->
               </div> <!-- //.kiki_row -->
               <div class="kiki_row tm20">
                 <div class="tit">액티비티 리스트</div>
                 <div class="con clearfix">
                    <div>
                    <table class="kiki_tblT01" cellspacing="0" cellpadding="0" border="0">
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
			$now_per = round(($count * 100 / $act_sum),2);	?>
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
                        <td colspan="3" class="kiki_nodata">등록된 액티비티가 없습니다.</td>
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
	document.kiki_frm_sub.action = "./c105_statistics.php";
	document.kiki_frm_sub.submit();
}

function kiki_go_change() {
	document.kiki_find2.kind.value = "g";
}

function kiki_go_sub3(actId) {
	document.kiki_frm_sub.actId.value = actId;
	document.kiki_frm_sub.action = "./c105_statistics_view.php";
	document.kiki_frm_sub.submit();
}

function kiki_chang_page(path1) {
	document.kiki_frm_sub.action = path1;
//console.log(path1)
	document.kiki_frm_sub.submit();
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