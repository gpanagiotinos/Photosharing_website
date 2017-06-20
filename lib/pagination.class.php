<?php

class Pagination{
	
	public $current_page;
	public $per_page;
	public $total_count;
	
	public function __construct($page=1,$per_page=3,$total_count=0)
	{
		$this->current_page = (int)$page;
		$this->per_page = (int)$per_page;
		$this->total_count = (int)$total_count;
	}
	
	public function offset()
	{
		return ($this->current_page - 1)*$this->per_page;
	}
	public function create_page_list()
	{
		$max = 4;$list='';
		for($i = ($this->current_page - $max); $i < ($this->current_page + $max); $i++)
		{
			if($i < 1 ) continue;
			//create the list
			if($i == $this->current_page){
				$list .= "<a class='current' href='photos.php?page=".$this->current_page."'>".$this->current_page."</a>";
			}else{
				$list .= "<a href='photos.php?page=".$i."'>".$i."</a>";
			}
			if($i == $this->total_pages()) break;
		}
		//insert the current
		return $list;
	}
	public function total_pages()
	{
		return ceil($this->total_count/$this->per_page);
	}
	
	public function previous_page()
	{
		return $this->current_page - 1;
	}
	
	public function next_page()
	{
		return $this->current_page + 1;
	}
	
	public function has_previous_page()
	{
		return $this->previous_page() >= 1 ? true : false;
	}
	
	public function has_next_page()
	{
		return $this->next_page() <= $this->total_pages() ? true : false;
	}
}