<?php
class Settings_Controller extends Base{
	protected $message;
	protected $topFoto;
	protected $tegi;
	
	protected function input(){
		parent::input();
		
		if($this->is_post()){
			
			$sex = $this->clear_str($_POST['sex']);
			
			$teg = $this->clear_str($_POST['teg']);
			
			if(!empty($sex)){
				$_SESSION['settings'] = $sex;
				
				if($_SESSION['settings'] === "м" || $_SESSION['settings'] === "ж"){
					$_SESSION['message'] = "Настройки успешно сохранены";
					
				}
			}else{
				$_SESSION['message'] = "Вы не указали предпочитаемый пол, для показа фотографий";
				
			}
			
			if(!empty($teg)){
				
				$_SESSION['settings_teg'] = $teg;
				
				$_SESSION['message'] = "Настройки успешно сохранены";
				
			}else{
				unset($_SESSION['settings_teg']);
			}
			
			header("Location:".SITE_URL."settings");
			exit();
		}
		
		$this->title .= "Настройки показа фотографий";
		
		$this->topFoto = $this->ob_m->get_top_foto();
		
		$this->tegi = $this->ob_m->get_tegi();
		
		$this->message = $_SESSION['message'];
	}
	
	protected function output(){
		
		$this->left_bar = $this->render(VIEW.'leftBar',array(
				'topFoto'=>$this->topFoto
		));
		
		$this->content = $this->render(VIEW.'settings',array(
				'mes'=>$this->message,
				'tegi'=>$this->tegi
		));
		
		$this->page = parent::output();
		unset($_SESSION['message']);

		return $this->page;
	}
}