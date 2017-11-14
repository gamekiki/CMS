	 <!-- content -->
<script src="https://code.jquery.com/jquery-2.1.0.min.js"></script>
<script src="./kiki/js/jui.js"></script>
<?	$sub_menu1 = "on";	// 대시보드
	$sub_menu2 = "";	// 회원관리
	$sub_menu3 = "";	// 액티비티 관리
	$sub_menu4 = "";	// 업적관리
	$sub_menu5 = "";	// 뱃지관리
	$sub_menu6 = "";	//통계/분석
	$sub_menu7 = "";	//리워드 관리
	$sub_menu8 = "";	//레벨설정	?>
      <div class="kiki_content">
        <div class="kiki_conwrap">    
            <div class="kiki_box">
               <!-- <div class="tit_top bm20">Bookoa</div> -->
<?	include "./kiki/kiki_header.php";	

	$SQL = "Select appSecret from application where appId = '$kiki_appId' ";
	$result = mysqli_query($kiki_conn, $SQL);
	if( $result === false) {
		 die( print_r( mysqli_connect_error(), true) );
	} else {
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		$appSecret = $row["appSecret"];
		$appSecret = stripslashes($appSecret);
		mysqli_free_result( $result);
	}

// 금일 액티비티 호출 현황	
	$nowDate = date("Y-m-d");
	$nexDate = date('Y-m-d',strtotime('1 days', time()));
	$SQL = "SELECT list.actName, list.actId, COUNT(list.actId) count ";
	$SQL .= " FROM (SELECT a.appId, actName, a.actId FROM user_record a INNER ";
	$SQL .= " JOIN activity b On a.actId = b.actId and a.appId = b.appId ";
	$SQL .= " WHERE a.regiYHS between '$nowDate' and '$nexDate' and a.appId "; // 오늘
	$SQL .= " = '$kiki_appId' GROUP BY a.regiYHS, actName ) list WHERE appId = ";
	$SQL .= " '$kiki_appId' GROUP BY list.actName order by count desc, actName limit 0,5  ";
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
	}
//echo "arr = $arr_num_chart <br>";	
// 금일 가입자 현황	
	$SQL = "SELECT JoinRoute, COUNT(userSerno) count FROM user ";
	$SQL .= " WHERE regiYHS between '$nowDate' and '$nexDate' and appId = '$kiki_appId' ";
	$SQL .= " GROUP BY JoinRoute order by count desc  ";
//echo $SQL;
	$result = mysqli_query($kiki_conn, $SQL);
	if( $result === false) {
		 die( print_r( mysqli_connect_error(), true) );
	} else {
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			$JoinRoute = $row["JoinRoute"];
			$count = $row["count"];
		if(!$count) {
			$count = 0;
		}
	switch ($JoinRoute) {
		case "P" :
			$arrU_cnt[0] = $count;
			break;
		case "I" : 
			$arrU_cnt[1] = $count;
			break;
		default : 
			$arrU_cnt[2] = $count;
			break;
	}
		}
		mysqli_free_result( $result);
	}
	mysqli_close($kiki_conn);

if(!$arrU_cnt[0]) {
	$arrU_cnt[0] = 0;
}
if(!$arrU_cnt[1]) {
	$arrU_cnt[1] = 0;
}
if(!$arrU_cnt[2]) {
	$arrU_cnt[2] = 0;
}	?>
               <div class="kiki_row" style="margin-top:50px">
                 <p class="tit">대시보드</p>
                 
                 <div class="con">
                   <div class="bookoa_inp">
                     <div class="fl_left one-half">
                       <span><label for="app">Application</label>&nbsp; <input id="app" value="<?=$kiki_appId?>" readonly class="width_at" size="42" type="text"></span>
                     </div>  
                     <div class="one-half">
                       <span><label for="apps">Application Secret</label>&nbsp; <input id="apps" value="<?=$appSecret?>" readonly class="width_at" size="42" type="text"> </span>
                      </div>
                   </div>                  
                 </div> <!-- //.con -->
               </div> <!-- //.kiki_row -->
               <div class="kiki_row tm20">
                 <p class="tit">금일 액티비티 호출 현황</p>
                 <a href="./c105_statistics_view.php" class="btn_more">more</a>
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
// 금일 가입자 pie
        chart("#chart2", {
            padding: 50,
            width: 540,
            height : 297,
            theme : "jennifer",
            axis : {
                data : [
                    { "PC" : <?=$arrU_cnt[0]?>, "Android" : <?=$arrU_cnt[2]?>, "iOS" : <?=$arrU_cnt[1]?>}
                ]
            },
            brush : [{
                type : "pie",
<?	if ($arrU_cnt[0] > 0 || $arrU_cnt[2] > 0 || $arrU_cnt[1] > 0 ) { ?>
                showText : true,
<?  } else { // 자료가 없다면 ?>
                showText : false,	
<? } ?>
        /*  */       format : function(k, v, max) {
//    return this.icon("check") + k + ": " + v + "(" + ((v/max)*100).toFixed(2) + "%)";
//    return this.icon("check") + k + ": " + ((v/max)*100).toFixed(1) + "%";
		  return ((v/max)*100).toFixed(1) + "%";
                },
                active : [ "yellow", "red" ],
          //      activeEvent : "click"
            }],
            widget : [{
                type : "legend",
                orient : "bottom"
            }, {
                type : "tooltip"
            }]
        });
// 금일 가입자 column
        chart("#chart3", {
            width: 540,
            height : 297,
            axis : [
                {
                    data : [
                        { list : "PC", list_cnt : "<?=$arrU_cnt[0]?>" },
                        { list : "Android", list_cnt : "<?=$arrU_cnt[2]?>" },
                        { list : "iOS", list_cnt : "<?=$arrU_cnt[1]?>" }
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
                 <div class="con clearfix"> 
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
                            <td><a href="javascript:kiki_go_sub3('<?=$actId?>')"><?=$actName?></td>
                            <td><?=$count?></td>
                            <td><?=$now_per?> %</td>
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
                 <p class="tit">금일 가입자 현황<a href="./c105_statistics_join.php" class="btn_more">more</a></p>
                 <div class="con clearfix">
                   <div class="one-half">
                     <p id="chart2"></p>
                   </div>
                   <div class="one-half">
                     <p id="chart3"></p>
                   </div>
                 </div>
               </div> <!-- //.kiki_row -->
            </div> <!-- //.box_bg -->      
       </div>
      </div>
      <!-- //content -->

<form name="kiki_frm_sub" method="post">
  <input type="hidden" name="kind" value="">
  <input type="hidden" name="yar1" value="<?=$yar1?>">
  <input type="hidden" name="mon1" value="<?=$mon1?>">
  <input type="hidden" name="day1" value="<?=$day1?>">
  <input type="hidden" name="yar2" value="<?=$yar2?>">
  <input type="hidden" name="mon2" value="<?=$mon2?>">
  <input type="hidden" name="day2" value="<?=$day2?>">
  <input type="hidden" name="actId" value="<?=$actId?>">
</form>
<script>
function kiki_go_sub3(actId) {
	document.kiki_frm_sub.actId.value = actId;
	document.kiki_frm_sub.action = "./c105_statistics_view.php";
	document.kiki_frm_sub.submit();
}
</script>