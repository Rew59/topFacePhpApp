<?php
abstract class Base_Error extends Base_Controller{
	protected $message_err;
	protected $title;
	protected $style;
	protected $script;
	
	protected function input(){
		$this->title = 'Страница показа ошибок';
		
		foreach($this->styles as $style){
			$this->style[] = SITE_URL.$style;
		}
		foreach($this->scripts as $script){
			$this->script[] = SITE_URL.$script;
		}
	}
	
	protected function output(){
		$page = $this->render(VIEW.'error_page',
				array(
					'title' => $this->title,
					'error' => $this->message_err,
					'styles'=>$this->style,
					'scripts'=>$this->script
				)
		);
		
		return $page;
	}
}
?>