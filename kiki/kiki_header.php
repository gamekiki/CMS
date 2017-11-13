 <? 	include "./kiki/kiki_user.php";
 	if (!$UserID) {	?>
<script>
$(document).ready(function() { 
	gogo_login();
});
function gogo_login() {
	alert("로그인 해 주세요.");
    toggle_login();
}
</script>
<?	}
	if (!$appId) {	?>
<script>
  alert("어플리케리션을 선택해 주세요.");
location.href = "../main/main.php"
</script>
<?	}	?>
			   <div class="kiki_tabmenu">
                  <div class="kiki_line"></div>
                  <ul>
                    <li><a href="javascript:go_sub_kiki('./c101_dashboard.php')" class="<?=$sub_menu1?>"> 대시보드 </a></li>
					<li><a href="javascript:go_sub_kiki('./c108_member.php')" class="<?=$sub_menu2?>">회원</a></li> 
                    <li><a href="javascript:go_sub_kiki('./c102_activities.php')" class="<?=$sub_menu3?>">액티비티</a></li>  
                    <li><a href="javascript:go_sub_kiki('./c103_achievement.php')" class="<?=$sub_menu4?>">업적</a></li>
                    <li><a href="javascript:go_sub_kiki('./c104_badge.php')" class="<?=$sub_menu5?>">뱃지</a></li>
					<li><a href="javascript:go_sub_kiki('./c107_set.php')" class="<?=$sub_menu8?>">레벨</a></li>
					<li><a href="javascript:go_sub_kiki('./c109_minigame.php')" class="<?=$sub_menu9?>">미니게임</a></li>
					<li><a href="javascript:go_sub_kiki('./c112_product.php')" class="<?=$sub_menu10?>">상품추천</a></li>
                    <li><a href="javascript:go_sub_kiki('./c105_statistics.php')" class="<?=$sub_menu6?>">통계/분석</a></li>
                    <li><a href="javascript:go_sub_kiki('./c106_reward.php')" class="<?=$sub_menu7?>">리워드</a></li>
                  </ul>
               </div>
<script>
function go_sub_kiki(filePath) {
	document.kiki_frm_sub2.action = filePath;
	document.kiki_frm_sub2.submit();
}
</script>
