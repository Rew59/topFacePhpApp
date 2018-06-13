<?php
class Top_Controller extends Base{
	protected $massiv_dan;
	protected $navigation;
	
	protected function input($param = array()){
		parent::input();
		
		if($param['page']){
			$page = $this->clear_int($param['page']);
			
			if($page == 0){
				$page = 1;
			}
		}else{
			$page = 1;
		}
		
		
		
		$this->title .= "Лучшие фотографии";
		
		$pager = new Pager(
				$page,
				'new_foto',
				array('id','name_foto','raiting'),
				array(),
				'raiting',
				'DESC',
				QUANTITY,
				QUANTITY_LINKS
		);
		
		$this->massiv_dan = $pager->get_posts();

		$this->navigation = $pager->get_navigation();
		
	}
	
	protected function output(){
		
		$this->content = $this->render(VIEW.'top',array(
				'massiv_dan'=>$this->massiv_dan,
				'navigation'=>$this->navigation
		));
		
		$this->page = parent::output();

		return $this->page;
	}
}
?>