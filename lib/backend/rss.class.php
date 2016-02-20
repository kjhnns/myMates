<?php
class rss{
	var $data;
	var $items;
	var $link;

	/**
	 * @param title
	 * @param link
	 * @param desc
	 */
	function rss($title, $link, $desc) {
		$this->data['title'] = $title;
		$this->data['subtitle'] = $desc;
		$this->link = $link;
	}

	/**
	 * @param title
	 * @param link
	 * @param date
	 */
	function addItem($t,$l,$date) {
		$this->items[] = array("title"=>$t,"id"=>$l,"updated"=>date("Y-m-d",$date)."T".date("H:i:s",$date)."+01:00");
	}

	/**
	 * @return feed
	 */
	function getFeed() {
		$return = 	"<?xml version=\"1.0\" encoding=\"".LANGCHARSET."\"?>" .
				"<feed xmlns=\"http://www.w3.org/2005/Atom\">";

		foreach($this->data as $k=>$v)//$this->data
		$return .= "<".$k.">".$v."</".$k.">";
		$return .="<link href=\"".$this->link."\" />";
		$return .="<link rel=\"self\" href=\"".HTTP_ROOT."\" />";

		foreach($this->items as $item) {
		$return .="<entry>";
			foreach($item as $k=>$v)
			$return .= ($k=='id'?"<link href=\"".$v."\" />":"")."<".$k.">".$v."</".$k.">";
		$return .="</entry>";
		}

		$return .= "</feed>";

		return $return;
	}

	function output() {
		header('Content-Type: application/rss+xml');
		echo $this->getFeed();
	}
}
debugLog("rss Klasse init", "Die rss Klasse zur erstellung von Newsfeeds konnte erfolgreich initialisiert werden", __FILE__,__LINE__);
?>