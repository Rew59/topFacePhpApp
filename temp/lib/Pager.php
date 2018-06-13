<?php
class Pager{
	protected $page;
	protected $tablename;
	protected $where;
	protected $order;
	protected $napr;
	protected $operand;
	protected $post_number;
	protected $number_link;
	protected $db;
	protected $total_count;
	protected $fields;
	
	public function __construct($page,$tablename,$fields=array(),$where=array(),$order='',$napr='',$post_number,$number_link,$operand='='){
		
		$this->page = $page;
		$this->tablename = $tablename;
		$this->where = $where;
		$this->order = $order;
		$this->napr = $napr;
		$this->post_number = $post_number;
		$this->number_link = $number_link;
		$this->operand = $operand;
		$this->fields = $fields;
		
		$this->db = Model_Driver::get_instance();
	}
	
	public function get_total(){	
		if(!$this->total_count){
			$result = $this->db->select(
							array("COUNT(*) as count"),
							$this->tablename,
							$this->where,
							$this->order,
							$this->napr,
							FALSE,
							$this->operand
			);
			
			$this->total_count = $result[0]['count'];
		}
		return $this->total_count;	
	}
	
	public function get_posts(){
		$total_post = $this->get_total();
		
		$number_pages = (int)($total_post/$this->post_number);
		
		if(($total_post%$this->post_number) != 0){
			$number_pages++;
		}
		
		if($this->page <= 0 || $this->page > $number_pages){
			return FALSE;
		}
		
		$start = ($this->page-1)*$this->post_number;
		
		//Делаем вывод лучших 100 фотографий
		if($start > 95){
			$start = 95;
			$this->post_number = 0;
		}
		//
		$result = $this->db->select(
						$this->fields,
						$this->tablename,
						$this->where,
						$this->order,
						$this->napr,
						$start.','.$this->post_number,
						$this->operand
		);
		
		return $result;
		
	}
	
	public function get_navigation(){
		$total_post = $this->get_total();
		
		//Делаем вывод лучших 100 фотографий
		if($total_post > 100){
			$total_post = 100;
		}
		//
		$number_pages = (int)($total_post/$this->post_number);
		
		if(($total_post%$this->post_number) != 0){
			$number_pages++;
		}
		
		if($total_post < $this->post_number || $this->page > $number_pages){
			return FALSE;
		}
		
		$result = array();
		
		if($this->page != 1){
			$result['last_page'] = $this->page-1;
		}
		
		if($this->page > $this->number_link+1){
			for($i= $this->page-$this->number_link; $i < $this->page; $i++){
				$result['previous'][] = $i;
			}
		}else{
			for($i=1; $i < $this->page; $i++){
				$result['previous'][] = $i;
			}
		}
		
		$result['current'] = $this->page;
		
		if($this->page+$this->number_link < $number_pages){
			for($i= $this->page+1; $i <= $this->page+$this->number_link; $i++){
				$result['next'][] = $i;
			}
		}else{
			for($i=$this->page+1; $i <= $number_pages; $i++){
				$result['next'][] = $i;
			}
		}
		
		if($this->page != $number_pages){
			$result['next_pages'] = $this->page+1;
		}
		
		return $result;
		
	}
	
}

?>