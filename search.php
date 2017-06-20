<?php

require_once('lib/initialize.php');

$tpl = new Template();

if( $session->is_logged_in() )
{
	$member = Member::find($_SESSION['username']);
	$tpl->assign('member',$member);
}

//search
$search = new Search();
$search->fullSearch = false;
$terms = isset($_GET['terms']) ? trim($_GET['terms']) : null;

if(empty($terms)):
 	$results = array();
else:
	//do search
	$search->searchTerms = explode(' ', $terms);

	if($_GET['fullsearch'] == 'on'):
		$search->fullSearch = true;
	endif;
	//init pagination
	//check for page num
	$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
	$per_page = PER_PAGE;
	$total_count = $search->count();
	//create the pagination object
	$pagination = new Pagination($page, $per_page, $total_count);

	$results = $search->search($per_page, $pagination->offset());
	empty($results) ? $results = array() : null;
	$tpl->assign('terms', $search->searchTerms);
	//get the extra get vars
	$extra = "terms=".$terms."&fullsearch=".$_GET['fullsearch']."&";
	if($pagination->has_previous_page())
	{
		$tpl->assign('prevPageQuery', $extra.'page='.$pagination->previous_page());
	}
	if($pagination->has_next_page())
	{	
		$queryData['page'] = $pagination->next_page();

		$tpl->assign('nextPageQuery', $extra.'page='.$pagination->next_page());
	}

	$list = ( $pagination->total_pages() > 1 ) ? $pagination->create_page_list('search.php', $extra) : array();
	if(!empty($list)){
		$tpl->assign('list', $list);
	}
endif;

$tpl->assign('results', $results);
$tpl->assign('total', $total_count);
$tpl->render('search','Αναζήτηση','search');
