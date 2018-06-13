<?php
abstract class Base_Admin extends Base_Controller{
	protected $ob_m;
	protected $ob_us;
	protected $title;
	protected $style;
	protected $script;
	protected $content;
	protected $user = TRUE;
	
	protected function input(){
		if($this->user == TRUE){
			$this->check_auth();
		}
		
		$this->title = "trenerka4a.ru | ";
		
		foreach($this->styles as $style){
			$this->style[] = SITE_URL.$style;
		}
		foreach($this->scripts as $script){
			$this->script[] = SITE_URL.$script;
		}
		
		$this->ob_m = Model::get_instance();
		$this->ob_us = Model_User::get_instance();
	}
	
	protected function output(){
		$this->header = $this->render(VIEW.'header',array(
			'title'=>$this->title,
			'styles'=>$this->style
		));
		
		$this->footer = $this->render(VIEW.'footer',array(
			'scripts'=>$this->script
		));
		
		$page = $this->render(VIEW.'index',array(
						'header'=>$this->header,
						'content'=>$this->content,
						'footer'=>$this->footer
		));
		
		return $page;
	}
}
?>