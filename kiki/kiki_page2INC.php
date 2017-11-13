<?
$result_stmt .= "<div class='kiki_paging'> ";

	$pre_page = $cur_page - 1;
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

/*	// block 만큼 페이지 고정됨
	$first_page = ($block -1 ) * $page_per_block + 1;
	$last_page = $block*$page_per_block; */
// 페이지 이동시 보여지는 리스트 달라짐..
if ($cur_page < 6) {	
	$first_page = ($block -1 ) * $page_per_block + 1;
	$last_page = $block*$page_per_block;
} else {
	$first_page = ($cur_page -4 );
//	$last_page = $cur_page + 2 ;	// 5 페이지씩
	$last_page = $cur_page + 5 ;	// 10 페이지씩
	if ($last_page> $totpage) {
		$last_page = $totpage;
	}
}
/*if ($last_page - $first_page < 4) {  // 5페이지씩
	$first_page = $last_page - 4;
} */
if ($last_page - $first_page < 9) {
	$first_page = $last_page - 9;
}
if ($first_page < 1) {
	$first_page = 1;
}
// 페이지 이동시 보여지는 리스트 달라짐..

	if ($total_block <= $block) {
		$last_page = $totpage;
	}

/*	if ($block > 1) {
		$member_page = $first_page - 1;
		echo ("<a href='Javascript:kiki_list($member_page)'> << </a> &nbsp;");
	} */

	IF ($pre_page >= 1) {
$result_stmt .= " <a href='Javascript:kiki_list($pre_page,\"$page_cont\")'><img src='./kiki/img/icon_paging_prev.gif' alt='이전으로'></a>&nbsp; ";
	}
$result_stmt .= " <span class='page_num'> ";
//$result_stmt .= " first = $first_page / $last_page /  ";
	$direct_page = $first_page;
	  while($direct_page <= $last_page) {
		if ((int)($direct_page) == (int)($cur_page)) {
$result_stmt .= "  &nbsp;<a class='on'>". $direct_page. "</a>&nbsp; ";
    	} else {
$result_stmt .= "  &nbsp;<a href='JavaScript:kiki_list($direct_page,\"$page_cont\")'>". $direct_page ."</a>&nbsp; ";
    	}
		$direct_page = $direct_page + 1;
    };
$result_stmt .= " </span> ";
	IF ($next_page <=	$totpage) {
$result_stmt .= " &nbsp;<a href='Javascript:kiki_list($next_page,\"$page_cont\")'><img src='./kiki/img/icon_paging_next.gif' alt='다음으로' /></a>";
	}

/*	if ($block < $total_block) {
		$member_page = $last_page + 1;
		echo ("&nbsp;<a href='JavaScript:kiki_list($member_page)'> >> </a>");
	} */
$result_stmt .= "</div> ";	
	?>	