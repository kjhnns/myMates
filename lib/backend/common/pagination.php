<?php
/*
 * function pagination
 *
 * gibt eine blaetterseiten zurueck
 * @param str url
 * @param int count
 * @param int actpage
 * @param int perpage
 * @param str pageparam
 * @return str
 */
function pagination($url, $count, $act_page, $per_page, $page="page")
{
	if(strpos($url,"?") === false) {
		$z = "?";
	} else {
		$z = "&";
	}
	$r= '';
	if (ceil($count / $per_page) > 10)
	{
		if ($act_page > 1)
			$r .= '<a href="' . $url . $z . $page . '=' . intval($act_page -1) . '">&#xAB;</a> ';

		if ($act_page-5 > 0) {
			$r .='<a href="' . $url . $z . $page . '=1">1</a> ';
			$r .='<a href="' . $url . $z . $page . '=2">2</a> ... ';
			for ($i= $act_page-2; $i < $act_page; $i++)
				$r .= '<a href="' . $url . $z . $page . '=' . intval($i) . '">' . intval($i) . '</a> ';
		} else {
			for ($i= 1; $i < $act_page; $i++)
				$r .= '<a href="' . $url . $z . $page . '=' . intval($i) . '">' . intval($i) . '</a> ';
		}

		$r .= "<b>".$act_page."</b>";

		if ($act_page+4 >= ceil($count / $per_page))
			for ($i= $act_page +1; $i <= ceil($count / $per_page); $i++)
				$r .= ' <a href="' . $url . $z . $page . '=' . intval($i) . '">' . intval($i) . '</a>';
		else {
			for ($i= $act_page +1; $i <= $act_page+2; $i++)
				$r .= ' <a href="' . $url . $z . $page . '=' . intval($i) . '">' . intval($i) . '</a>';
			$r .=' ... <a href="' . $url . $z . $page . '='.ceil($count / $per_page -1).'">'.ceil($count / $per_page -1).'</a> ';
			$r .='<a href="' . $url . $z . $page . '='.ceil($count / $per_page).'">'.ceil($count / $per_page).'</a> ';
		}

		if ($act_page < ceil($count / $per_page))
			$r .= ' <a href="' . $url . $z . $page . '=' . intval($act_page +1) . '">&#xBB;</a>';

	}
	else if (ceil($count / $per_page) == 1)
	{
		$r= '1';
	} else {
		if ($act_page > 1)
		{
			$r .= '<a href="' . $url . $z . $page . '=' . intval($act_page -1) . '">&#xAB;</a> ';
		}
		for ($i= 1; $i < $act_page; $i++)
		{
			$r .= '<a href="' . $url . $z . $page . '=' . intval($i) . '">' . intval($i) . '</a> ';
		}

		$r .= "<b>$act_page</b>";

		for ($i= $act_page +1; $i <= ceil($count / $per_page); $i++)
		{
			$r .= ' <a href="' . $url . $z . $page . '=' . intval($i) . '">' . intval($i) . '</a> ';
		}

		if ($act_page < ceil($count / $per_page))
		{
			$r .= ' <a href="' . $url . $z . $page . '=' . intval($act_page +1) . '">&#xBB;</a> ';
		}
	}
	return $r;
}
?>
