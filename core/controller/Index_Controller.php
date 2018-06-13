<?php
class Index_Controller extends Base{
	protected $foto = array();
	protected $topFoto;
	
	protected function input(){
		parent::input();
		
		if($this->is_post()){
			if(isset($_POST['click']) && isset($_POST['noClick']) && $_POST['click'] != $_POST['noClick']){
			
				$id_foto_click = $this->clear_int($_POST['click']);
				$id_foto_noClick = $this->clear_int($_POST['noClick']);
				
				$raiting1 = $this->ob_m->get_raiting_foto($id_foto_click);
				$raiting2 = $this->ob_m->get_raiting_foto($id_foto_noClick);
				
				$new_raiting = $this->raiting_elo($raiting1['raiting'],$raiting2['raiting']);
				
				$new_raiting1 = $this->ob_m->add_new_raiting($id_foto_click,$new_raiting[0]);
				$new_raiting2 = $this->ob_m->add_new_raiting($id_foto_noClick,$new_raiting[1]);
				
				if($new_raiting1 == TRUE && $new_raiting2 == TRUE){
					
				}
				
			}
		}
		
		$this->title .= "Главная";

		if(!empty($_SESSION['settings_teg'])){
		$this->topFoto = $this->ob_m->get_top_foto($_SESSION['settings_teg']);
			if(!empty($_SESSION['settings'])){
				$this->foto = $this->ob_m->get_home_foto_teg($_SESSION['settings_teg'],$_SESSION['settings']);
			}else{
				$this->foto = $this->ob_m->get_home_foto_teg($_SESSION['settings_teg']);
			}
		}else{
		$this->topFoto = $this->ob_m->get_top_foto();
			if(empty($_SESSION['settings'])){
				$this->foto = $this->ob_m->get_home_foto();
			}else{
				if($_SESSION['settings'] == "м"){
					$this->foto = $this->ob_m->get_home_foto($_SESSION['settings']);
				}
				if($_SESSION['settings'] == "ж"){
					$this->foto = $this->ob_m->get_home_foto($_SESSION['settings']);
				}
			}
		}
		
		
		
	}
	
	protected function output(){
		
		$this->left_bar = $this->render(VIEW.'leftBar',array(
				'topFoto'=>$this->topFoto
		));
		
		$this->content = $this->render(VIEW.'home',
						array(
							'name_foto'=>$this->foto
						)
		);
		
		$this->page = parent::output();

		return $this->page;
	}
}
?>