<?php
abstract class Base extends Base_Controller{
	protected $ob_m;
	protected $title;
	protected $style;
	protected $script;
	protected $header;
	protected $left_bar;
	protected $content;
	protected $footer;
	
	protected function input(){
		$this->title = "Site.ru | ";
		
		foreach($this->styles as $style){
			$this->style[] = SITE_URL.$style;
		}
		foreach($this->scripts as $script){
			$this->script[] = SITE_URL.$script;
		}
		
		$this->ob_m = Model::get_instance();
		
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
						'left_bar'=>$this->left_bar,
						'content'=>$this->content,
						'footer'=>$this->footer
		));
		
		return $page;
	}
}
?>