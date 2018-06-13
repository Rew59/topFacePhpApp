<?php
abstract class Base_Controller{
	protected $request_url;
	protected $controller;
	protected $params;
	protected $styles;
	protected $scripts;
	protected $error;
	protected $page;
	
	public function route(){
		if(class_exists($this->controller)){
			$ref = new ReflectionClass($this->controller);
			
			if($ref->hasMethod('request')){
				if($ref->isInstantiable()){
					$class = $ref->newInstance();
					$method = $ref->getMethod('request');
					$method->invoke($class,$this->get_params());
				}
			}
		}else{
			throw new ContrException('Такой страницы не существует','Контроллер - '.$this->controller);
		}
	}
	
	public function init(){
		global $conf;
		
		if(isset($conf['styles'])){
			foreach($conf['styles'] as $style){
				$this->styles[] = trim($style,'/');
			}
		}
		if(isset($conf['scripts'])){
			foreach($conf['scripts'] as $script){
				$this->scripts[] = trim($script,'/');
			}
		}
	}
	
	protected function get_controller(){
		return $this->controller;
	}
	
	protected function get_params(){
		return $this->params;
	}
	
	protected function input(){
		
	}
	
	protected function output(){
		
	}
	
	public function request($param = array()){
		$this->init();
		$this->input($param);
		$this->output();
		
		if(!empty($this->error)){
			$this->write_error($this->error);
		}
		
		$this->get_page();
	}
	
	public function get_page(){
		echo $this->page;
	}
	
	protected function render($path,$param=array()){
		extract($param);
		ob_start();
		if(!include($path.'.tpl')){
			throw new ContrException('Данного шаблона нет');
		}
		return ob_get_clean();
	}
	
	public function clear_str($var){
		
		if(is_array($var)){
			$row = array();
			foreach($var as $key=>$item){
				$row[$key] = trim(strip_tags($item));
			}
			return $row;
		}
		return trim(strip_tags($var));
	}
	
	public function clear_int($var){
		return (int)$var;
	}
	
	public function is_post(){
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			return TRUE;
		}
		return FALSE;
	}
	
	public function check_auth(){
		try{
			$cookie = Model_User::get_instance();
			$cookie->check_id_user();
			$cookie->validate_cookie();
		}catch(AuthException $e){
			$this->error = "Ошибка авторизации пользователя | ";
			$this->error .= $e->getMessage();
			$this->write_error($this->error);
			header("Location:".SITE_URL."login");
			exit();
		}
	}
	
	public function write_error($err){
		$time = date("d-m-Y G:i:s");
		
		$str = "Ошибка: ".$time." - ".$err."\n\r";
		file_put_contents("log.txt",$str,FILE_APPEND);
	}
	
	public function img_resize($dest,$type_img){
		
		switch($type_img){
			case 'jpg':
				$img_id = imageCreateFromJpeg($dest);
			break;
			case 'png':
				$img_id = imageCreateFromPng($dest);
			break;
		}
		
		$img_width = imageSX($img_id);
		
		$img_height = imageSY($img_id);
		
		$k = round($img_width/IMG_WIDTH,2);
		
		$img_mini_width = round($img_width/$k);
		
		$img_mini_height = round($img_height/$k);
		
		$img_dest_id = imageCreateTrueColor($img_mini_width,$img_mini_height);
		
		$result = imageCopyResampled(
				$img_dest_id,
				$img_id,
				0,
				0,
				0,
				0,
				$img_mini_width,
				$img_mini_height,
				$img_width,
				$img_height);
		
		$name_img = $this->rand_str().'.'.$type_img;
		
		switch($type_img){
			case 'jpg':
				$img = imageJpeg($img_dest_id,OLD_UPLOAD_DIR.$name_img,100);
			break;
			case 'png':
				$img = imagePng($img_dest_id,OLD_UPLOAD_DIR.$name_img);
			break;
		}
		
		imageDestroy($img_id);
		imageDestroy($img_dest_id);
		
		if($img){
			return $name_img;
		}else{
			return FALSE;
		}
	}
	
	public function raiting_elo($team1,$team2){
		$result1 = 1 / (1+pow(10,(($team2-$team1)/400)));
		$result2 = 1 / (1+pow(10,(($team1-$team2)/400)));
		
		$team1 = round($team1+1.0 - $result1,4);
		$team2 = round($team2+0.0 - $result2,4);
		
		$raiting[] = $team1;
		$raiting[] = $team2;
		return $raiting;
	}
	
	protected function rand_str(){
		$rand = rand(0,10000);
		$str = md5(microtime().$rand);
		
		return $str;
	}
}
?>