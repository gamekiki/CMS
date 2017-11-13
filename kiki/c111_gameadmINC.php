 <script src="https://code.jquery.com/jquery-2.1.0.min.js"></script>
 <?	$sub_menu1 = "";	// 대시보드
	$sub_menu2 = "";	// 회원관리
	$sub_menu3 = "";	// 액티비티
	$sub_menu4 = "";	// 업적
	$sub_menu5 = "";	// 뱃지
	$sub_menu6 = "";	//통계/분석
	$sub_menu7 = "";	//리워드
	$sub_menu8 = "";	//레벨설정
	$sub_menu9 = "on";	//미니게임
	$sub_menu10 = "";	//상품추천		?>
	  <div class="kiki_content">
        <div class="kiki_conwrap">    
            <div class="kiki_box">
               <!-- <div class="tit_top bm20">Bookoa</div> -->
<?	include "./kiki/kiki_header.php";	?>
              
               <div class="kiki_row" style="margin-top:25px">
                 <p class="tit">미니게임 관리</p>
                 
                 
                 <div class="con">
                  <div class="maintab_area">
              <!-- 탭메뉴 -->
              <div class="pro_tabarea">           
                <div class="nav">
                
                <ul class="tab" id="tab">
                  <li class="on"><a href="#location" id="pro_tab01">비용</a></li>
                  <li class=""><a href="#location" id="pro_tab02">활동 정보</a></li>
                  <li class=""><a href="#location" id="pro_tab03">실시간 정보</a></li>
                </ul>
                </div> <!-- //nav -->
              </div>
              <!-- 탭컨텐트 -->
              <div class="tab_con" id="tab_con">
                <!-- pro_con01: 전체 -->
                <div id="pro_con01" class="pro_con" style="display: block;">
                  <div class="pro_detail">
                      <div class="board_list">
         
                         소요된 총 비용 : 3,104,750원
                         <div class="graph_area">
                         <img src="img/graph02.jpg">
                         </div>


                        </div> <!-- // borad_list -->
                  </div> <!-- // pro_detail -->
                </div>
                <!-- //pro_con01: 전체 -->
                <!-- pro_con02: 공지 -->
                  <div id="pro_con02" class="pro_con" style="display: none;">
                    <div class="pro_detail">
                      <div class="con_top">
                          <div class="tab_btn">
                           <a href="#" class="on"> 시간대별</a><a href="#">일별</a><a href="#">월별</a><a href="#">년별</a> 
                          </div>
                      </div> <!-- con-top -->
                     
                      <div class="row">
                       <span> 조회기간</span> &nbsp;
                       <input name="beginDate" id="" class="" value="2017-04-27" style="width:20%;" type="text"> <a href="#" onclick="Calendar.drawCalendar('beginDate',20, 10);return false"><img src="img/icon_day.png" alt="달력"></a> ~
                       <input name="beginDate" id="" class="" value="2017-04-27" style="width:20%;" type="text"> <a href="#" onclick="Calendar.drawCalendar('beginDate',20, 10);return false"><img src="img/icon_day.png" alt="달력"></a> 
                       &nbsp; <a href="#" class="kikibtn red"> 조회</a>
                       
                       <div class="con">
                         <img src="img/graph01.jpg" alt="그래프 영역">
                        </div> <!-- // borad_list -->
   
                      </div> <!-- //row -->

                  </div> <!-- // pro_detail -->
                   </div> 
                   <!--//  pro_con02: 공지 -->
                   <!-- pro_con03: 잡담 -->
                  <div id="pro_con03" class="pro_con" style="display: none;">
                    <div class="pro_detail">
                   
                       <div class="searchtop_area">
                        <div class="fl_right">
                          <div class="search">
                          <label></label>
                          <select name="schSel" class="select_style">
                             <option value="" selected="">날짜</option>
                             <option value="">당첨 내역</option>
                             <option value="">회원 ID</option>
                          </select>
                          <input name="beginDate" id="" class="" value="2017-04-27" type="text">
                          <a href="#" onclick=""><img src="img/icon_day.png" alt="달력"></a>
                          <a href="" class="kikibtn gray2"> 검 색 </a>
                          </div>
                      </div>
                     </div>

                      <div class="con board_list">
                          <table class="kiki_tblT01">
                          <caption><span class="blind">공지사항 목록</span></caption>
                          <colgroup>
                              <col width="10%">
                              <col width="">
                              <col width="">
                              <col width="">
                          </colgroup>
                          <thead>
                              <tr>
                                  <th scope="col">No.</th>
                                  <th scope="col">회원 ID</th>
                                  <th scope="col">당첨 내역</th>
                                  <th scope="col">당첨 일자</th>
                              </tr>
                          </thead>
                          <tbody>
                                                                  
                          <tr>
                              <td>1234</td>
                              <td>abc@gmail.com</td>
                              <td>스타벅스 기프티콘 </td>
                              <td>2017-09-21 12:00:00</td>
                          </tr>
                          <tr>
                              <td>1234</td>
                              <td>abc@gmail.com</td>
                              <td>스타벅스 기프티콘 </td>
                              <td>2017-09-21 12:00:00</td>
                          </tr>
                          <tr>
                              <td>1234</td>
                              <td>abc@gmail.com</td>
                              <td>스타벅스 기프티콘 </td>
                              <td>2017-09-21 12:00:00</td>
                          </tr>
                          <tr>
                              <td>1234</td>
                              <td>abc@gmail.com</td>
                              <td>스타벅스 기프티콘 </td>
                              <td>2017-09-21 12:00:00</td>
                          </tr>
                          <tr>
                              <td>1234</td>
                              <td>abc@gmail.com</td>
                              <td>스타벅스 기프티콘 </td>
                              <td>2017-09-21 12:00:00</td>
                          </tr>
                               
                          </tbody>
                          </table>
                        </div> <!-- // borad_list -->

                  </div> <!-- // pro_detail -->
                   </div> 
                   <!--//  pro_con03: 잡담 -->
                  
               </div>  
               <!-- // 탭컨텐트 -->            
            </div>
                
                 </div> <!-- //.con -->
               </div> <!-- // kiki_row -->
            </div> <!-- //kiki_box -->      
       </div>
      </div>