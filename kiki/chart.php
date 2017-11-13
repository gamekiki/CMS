<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="charset=utf-8;"/>
    <script src="https://code.jquery.com/jquery-2.1.0.min.js"></script>
	<script src="./js/core.js"></script>
    <script src="./js/chart.js"></script>
</head>
<body >

<div id="chart"></div>
<?	$arr_num = 4;
	$title[0] = "Will";
	$title[1] = "James";
	$title[2] = "David";
    $title[3] = "Sam";
	$title[4] = "louis";
	
	$mile[0] = "5";
	$mile[1] = "15";
	$mile[2] = "8";
    $mile[3] = "20";
	$mile[4] = "18";
	
	$gif[0] = "15";
	$gif[1] = "6";
	$gif[2] = "10";
    $gif[3] = "35";
	$gif[4] = "4";		?>
<script id="script_code">
	jui.ready([ "chart.builder" ], function(chart) {
         chart("#chart", {
             width: 600,
            height : 400,
             padding : 100,
            theme : "jennifer",
            axis : {
                x : {
//                    domain : [ "week1", "week2", "week3", "week4" ],
                    domain : [
<?	for ($k=0;$k < $arr_num ;$k++ ) {	?>
  "<?=$title[$k]?>" ,
<?	}	?>
  "<?=$title[$arr_num]?>"
					],
					line : true
                },
                y : {
                    type : 'range',
                    domain : function(data) {
                        return [data.마일리지 + data.기프티콘, 0];
                    },
                    unit : 10,
                    line : true,
                    reverse : false
                },
                data : [
            /*       { "마일리지" : 5, "기프티콘" : 15 },
                   { "마일리지" : 15, "기프티콘" : 6 },
                   { "마일리지" : 8, "기프티콘" : 10 },
				   { "마일리지" : 20, "기프티콘" : 35 },
                   { "마일리지" : 18, "기프티콘" : 4 }  */
 <?	for ($k=0;$k < $arr_num ;$k++ ) {	?>
  { "마일리지" : <?=$mile[$k]?>, "기프티콘" : <?=$gif[$k]?> },
<?	}	?>
  { "마일리지" : <?=$mile[$arr_num]?>, "기프티콘" : <?=$gif[$arr_num]?> }
                ]
            },
             brush : [{
                type : 'stackcolumn',
                //active : 1,
                //activeEvent : "click",
             //   minSize : 13,
                display : "all",
                format : function(v) {
                    return v  // + "!!!";
                } ,
                edge : false , // true : 옆의 데이타와 선으로 연결,false : 연결 안 함
				colors : [ 2, "#9228E4"]	// colors : [ 2, 8 ]
            }],
			widget : [
         //       { type : "title", text : "Column Sample" },  // 차트 타이틀 표시
       //         { type : "legend", filter : true, orient : "bottom", align: "end", colors : [ 3, 4, 5 ] },	//  아래 주석 부분 
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


</body>
</html>