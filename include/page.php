<?php
/**
 * Displays : 分页
 * Author   : phpox
 * Date     : Mon Nov 23 20:35:41 CST 2009
 */

defined('PHPOX') or die(header("HTTP/1.1 403 Not Forbidden"));

class include_page{
	var $infocount;
	var $pagecount;
	var $items;
	var $pageno;
	var $start;
	var $next;
	var $prev;
	var $maxpages;
	var $limit;

	function __construct($infocount,$items,$pageno)
	{
		$this->infocount = $infocount;
		$this->items = $items;
		$this->pageno = $pageno;
		$this->pagecount = $this->getpagecount();
		$this->justpageno();
		$this->start = $this->getstart();
		$this->gotoprev();
		$this->gotonext();
		$this->limit = $this->start.','.$this->items;
	}

	function justpageno()
	{
		if (empty($this->pageno) || $this->pageno < 1){
			$this->pageno = 1;
		}
		if ($this->pageno > $this->pagecount){
			$this->pageno = $this->pagecount;
		}
	}

	function gotonext()
	{
		$next = $this->pageno + 1;
		if ($next > $this->pagecount){
			$this->next = $this->pagecount;
		}else {
			$this->next = $next;
		}
		return $this->next;
	}
	
	function gotoprev()
	{
		$prev = $this->pageno -1;
		if ($prev < 1){
			$this->prev = 1;
		}else {
			$this->prev = $prev;
		}
		return $this->prev;
	}

	function getpagecount()
	{
		$pagecount = ceil($this->infocount / $this->items);
                if($pagecount <1 ) $pagecount = 1;
                return $pagecount;
	}

	function getstart()
	{
		if ($this->pageno <= 1){
			return 0;
		}else {
			return ($this->pageno - 1) * $this->items;
		}
	}
	
	function showpage($ctl,$act,$args=null){
        if($this->pagecount == 1) return;
		if($this->pageno == 1){
			$upimg = '/images_old/up.gif';
		}else {
			$upimg = '/images_old/up1.gif';
		}
		if($this->pageno >= $this->pagecount){
			$downimg = '/images_old/down1.gif';
		}else {
			$downimg = '/images_old/down.gif';
		}
		$args1 = $args;
		$args['p'] = $this->prev;
		$args1['p'] = $this->next;
		$prevurl = url($ctl,$act,$args);
		$nexturl = url($ctl,$act,$args1);
		$code = '<div style="wdith:100%;height:auto;text-align:center;margin-left:auto;margin-right:auto;">';
		$code .= '<a href="'.$prevurl.'"><img src="'.$upimg.'" alt="上页" width="26" height="16" /></a>&nbsp;&nbsp;';
		$code .= '<a href="'.$nexturl.'"><img src="'.$downimg.'" alt="下页" width="26" height="15" /></a></div>';
		return $code;
	}
	
	//显示样式1
	function showpage1($ctl,$act,$args=null){
        if($this->pagecount == 1) return;
		if($this->pageno == 1){
			$upimg = '/images_old/up.gif';
		}else {
			$upimg = '/images_old/up1.gif';
		}
		if($this->pageno >= $this->pagecount){
			$downimg = '/images_old/down1.gif';
		}else {
			$downimg = '/images_old/down.gif';
		}
		$pargs = $args;
		$nargs = $args;
		$pargs['p'] = $this->prev;
		$nargs['p'] = $this->next;
		$prevurl = url($ctl,$act,$pargs);
		$nexturl = url($ctl,$act,$nargs);
		$code = '<div style="wdith:100%;height:auto;text-align:center;margin-left:auto;margin-right:auto;">';
		$code .= '<a href="'.$prevurl.'"><img src="'.$upimg.'" alt="上页" width="26" height="16" /></a>&nbsp;&nbsp;';
		$code .= '<a href="'.$nexturl.'"><img src="'.$downimg.'" alt="下页" width="26" height="15" /></a></div>';
		return $code;
	}

	/**
	 * 显示样式2
	 */
	function multi($mpurl,$page = 10)
	{
		$multipage = '';
		//$mpurl .= strpos($mpurl, '?') !== false ? '&amp;' : '?';
		$realpages = 1;
		$offset = 2;
		$realpages = @ceil($this->infocount / $this->items);
		$pages = $this->maxpages && $this->maxpages < $realpages ? $this->maxpages : $realpages;
		if($page > $pages)
		{
			$from = 1;
			$to = $pages;
		} 
		else
		{
			$from = $this->pageno - $offset;
			$to = $from + $page - 1;
			if($from < 1)
			{
				$to = $this->pageno + 1 - $from;
				$from = 1;
				if($to - $from < $page)
				{
					$to = $page;
				}
			}
			elseif($to > $pages)
			{
				$from = $pages - $page + 1;
				$to = $pages;
			}
		}
		$multipage .= '<li><a href="'.$mpurl.($this->prev).'.html">上一页</a></li>';
		if($this->pageno - $offset > 1 && $pages > $page)
		{
			$multipage .= '<li class="li_3"><a href="'.$mpurl.'1.html">1 ...</a></li>';
		}
		for($i = $from; $i <= $to; $i++)
		{
			$multipage .= $i == $this->pageno ? '<li class="this_li"><a>'.$i.'</a></li>' :'<li><a href="'.$mpurl.$i.'.html">'.$i.'</a></li>';
		}
		if($to < $pages )
		{
			$multipage .= '<li class="li_3"><a href="'.$mpurl.$pages.'.html">... '.$realpages.'</a></li>';
		}
		$multipage .= '<li><a href="'.$mpurl.($this->next).'.html">下一页</a></li>';
		return $multipage;
	}
	
	/*
	 	2013-01-07
	 	施云
		原分页代码逻辑错误，修复错误
		2014-06-20
		施云
		修改分页样式
	 */
	function showpage2($mpurl,$page = 10)
	{
		$page_str = '<ul  class="pagination">';
		$multipage = '';
		$realpages = 1;
		$offset = 10;
		$realpages = @ceil($this->infocount / $this->items);
		$pages = $this->maxpages && $this->maxpages < $realpages ? $this->maxpages : $realpages;
		
		$total_page		= $pages;
		$current_page 	= intval($_GET['page']);
		if($current_page==0)
			$current_page	= 1;
			//添加分支适应移动端分页样式 zht 20160115
		$show = (is_mobile()) ? 3 : 15;
			
		if($current_page>1)
			$page_str 	.= '<li><a href="'.$mpurl.'&page='.($current_page-1).'" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
		
		if ($total_page < $show){
			for($i=1;$i<=$total_page;$i++)
			{
				if($i==$current_page)
					$page_str 	.= '<li><a href="javascript:void(0)" class="cur">'.$i.'</a></li>';
				else
					$page_str 	.= '<li><a href="'.$mpurl.'&page='.$i.'">'.$i.'</a></li>';
			}
		}
		else{
			$n = ceil($show/2);
			$k = $n-1;
			if ($current_page!=1)
				$page_str 	.= '<li><a href="'.$mpurl.'/page1">1</a>'.($current_page-$k>2?' ... ':'').'</li>';
			for($i=max(($current_page-$k),2);$i<$current_page;$i++)
			{
				$page_str 	.= '<li><a href="'.$mpurl.'&page='.$i.'">'.$i.'</a></li>';
			}
			$page_str 	.= '<li><a href="javascript:void(0)" class="cur">'.$current_page.'</a></li>';
			for($i=$current_page+1;$i<=min(($current_page+$k),$total_page-1);$i++)
			{
				$page_str 	.= '<li><a href="'.$mpurl.'&page='.$i.'">'.$i.'</a></li>';
			}
			if ($current_page!=$total_page)
				$page_str 	.= '<li>'.($current_page+$k<$total_page-1?' ... ':'').'<a href="'.$mpurl.'/page'.$total_page.'">'.$total_page.'</a></li>';
		}
		
		if($current_page<$total_page)
			$page_str 	.= '<li><a href="'.$mpurl.'&page='.($current_page+1).'" aria-label="Next"> <span aria-hidden="true">&raquo;</span></a></li>';
		
		$page_str .= '</ul>';
		return $page_str;
	}
	
}