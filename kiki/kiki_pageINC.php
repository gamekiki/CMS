                      <div class="kiki_paging">
<?	$pre_page = $cur_page - 1;
	$next_page = $cur_page + 1;
	$page_per_block = 10;
	$member_page = 0;
	$block = 1;

	//' 전체 블럭수를 구한다.
	if ($totpage % $page_per_block == 0 ) {
		$total_block = (int)($totpage / $page_per_block);
	} else { 
		$total_block = (int)($totpage / $page_per_block) + 1;
	}
	
	//' 현재 페이지의 블럭 위치를 구한다.
	if ($cur_page % $page_per_block == 0 ) {
		$block = (int)($cur_page / $page_per_block);
	} else {
		$block = (int)($cur_page / $page_per_block) + 1;
	}
	
	$first_page = ($block -1 ) * $page_per_block + 1;
	$last_page = $block*$page_per_block;

	if ($total_block <= $block) {
		$last_page = $totpage;
	}

/*	if ($block > 1) {
		$member_page = $first_page - 1;
		echo ("<a href='Javascript:kiki_list($member_page)'> << </a> &nbsp;");
	} */

	IF ($pre_page >= 1) {
		echo ("<a href='Javascript:kiki_list($pre_page)'><img src='./kiki/img/icon_paging_prev.gif' alt='이전으로'></a>&nbsp");
	}	?>
<span class='page_num'>
<?	$direct_page = $first_page;
	  while($direct_page <= $last_page) {
		if ((int)($direct_page) == (int)($cur_page)) {
    		echo ("&nbsp;<a class='on'>". $direct_page. "</a>&nbsp;");
    	} else {
    		echo ("&nbsp;<a href='JavaScript:kiki_list($direct_page)'>". $direct_page ."</a>&nbsp;");
    	}
		$direct_page = $direct_page + 1;
    };	?>
</span>
<?	IF ($next_page <=	$totpage) {
		echo ("&nbsp;<a href='Javascript:kiki_list($next_page)'><img src='./kiki/img/icon_paging_next.gif' alt='다음으로' /></a>");
	}

/*	if ($block < $total_block) {
		$member_page = $last_page + 1;
		echo ("&nbsp;<a href='JavaScript:kiki_list($member_page)'> >> </a>");
	} */		?>	
                       </div> 