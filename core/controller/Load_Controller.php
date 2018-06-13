<?php
class Load_Controller extends Base{
	protected $message;
	protected $topFoto;
	protected $type_img;
	protected $tegi;
	
	protected function input(){
		parent::input();
		
		if($this->is_post()){

			$foto = $_FILES['foto']['name'];

			$sex = $this->clear_str($_POST['sex']);
			
			$teg = $this->clear_str($_POST['teg']);
			
			$new_teg = $this->clear_str($_POST['new_teg']);
			
			//Проверка тега
			if(strlen($new_teg) <= 40){
				$new_teg = trim($new_teg);
			}else{
				//$new_teg = substr($new_teg, 0, strpos($new_teg, ' ' ));
				$_SESSION['message'] = "Слишком длинный тег, тег должен содержать не более 40 символов";
				header("Location:".SITE_URL."load");
				exit();
			}
			
			if(!empty($foto) && !empty($sex)){

				$img_types = array('jpg' => 'image/jpeg','png' => 'image/png');
				
				$this->type_img = array_search($_FILES['foto']['type'],$img_types);

				if(!$this->type_img){
					$_SESSION['message'] = "Не правильный формат изображения, загружаемая фотография должна быть формата jpg или png";
					header("Location:".SITE_URL."load");
					exit();
				}
			
				if(!empty($_FILES['foto']['error'])){
					$_SESSION['message'] = "Слишком большое изображение";
					header("Location:".SITE_URL."load");
					exit();
				}else{
					if($_FILES['foto']['size'] > (5 * 1024 * 1024)){
						$_SESSION['message'] = "Слишком большое изображение, оно должно весить меньше 5mb";
						header("Location:".SITE_URL."load");
						exit();
					}
					
					if(!move_uploaded_file($_FILES['foto']['tmp_name'],OLD_UPLOAD_DIR.$_FILES['foto']['name'])){
						$_SESSION['message'] = "Ошибка копирования изображения, пожалуйста попробуйте снова";
						header("Location:".SITE_URL."load");
						exit();
					}
					
					$res_img = $this->img_resize(OLD_UPLOAD_DIR.$_FILES['foto']['name'],$this->type_img);
					
					if($res_img !== FALSE){
						$img = $res_img;
						unlink(OLD_UPLOAD_DIR.$_FILES['foto']['name']);
					}else{
						$_SESSION['message'] = "Ошибка изменения размера изображения, пожалуйста попробуйте снова загрузить фотографию";
						header("Location:".SITE_URL."load");
						exit();
					}
					
					if(empty($_POST['add'])){
						$result = $this->ob_m->add_old_foto($img,$sex);
						
						if($result === TRUE){
							if(empty($teg)){
								if(!empty($new_teg)){
									$isset_zapis_v_bd = $this->ob_m->isset_zapis_v_bd('id_teg','tegi','name_teg',$new_teg);
									
									if(empty($isset_zapis_v_bd)){
										$result_new_teg = $this->ob_m->add_new_teg($new_teg);
									}
									$id_foto = $this->ob_m->id_foto_po_name($img);
									$id_tega = $this->ob_m->id_tega_po_name_tega($new_teg);
										
									$result_teg_old_foto = $this->ob_m->add_teg_old_foto($id_foto['id'],$id_tega['id_teg']);
									if($result_teg_old_foto === TRUE){
										$_SESSION['message'] = "Поздравляем, вы успешно загрузили свою фотографию";
									}
								}
							}else{
								foreach($teg as $val){
									$id_foto = $this->ob_m->id_foto_po_name($img);
									$id_tega = $this->ob_m->id_tega_po_name_tega($val);
										
									$result_teg_old_foto = $this->ob_m->add_teg_old_foto($id_foto['id'],$id_tega['id_teg']);
									
									if(!$result_teg_old_foto){
										$_SESSION['message'] = "Пожалуйста попробуйте снова, так как произошла ошибка";
										header("Location:".SITE_URL."load");
										exit();
									}
								}
								$_SESSION['message'] = "Поздравляем, вы успешно загрузили свою фотографию";
							}
							
						}else{
							$_SESSION['message'] = "Пожалуйста попробуйте снова, так как произошла ошибка";
						}
						
						header("Location:".SITE_URL."load");
						exit();
						
					}else{
						$_SESSION['message'] = "Пожалуйста попробуйте снова, так как произошла ошибка";
						header("Location:".SITE_URL."load");
						exit();
					}
					
				}
				
				//print_r($_FILES);
			}else{
				$_SESSION['message'] = "Пожалуйста, заполните все поля (выберите фотографию и укажите ваш пол)";
				header("Location:".SITE_URL."load");
				exit();
			}
			//print_r($_POST);
		}
		
		$this->title .= "Загрузка фотографии";
		
		$this->topFoto = $this->ob_m->get_top_foto();
		
		$this->tegi = $this->ob_m->get_tegi();
		
		$this->message = $_SESSION['message'];
	}
	
	protected function output(){
		
		$this->left_bar = $this->render(VIEW.'leftBar',array(
				'topFoto'=>$this->topFoto
		));
		
		$this->content = $this->render(VIEW.'load',array(
				'mes'=>$this->message,
				'tegi'=>$this->tegi
		));
		
		$this->page = parent::output();
		unset($_SESSION['message']);

		return $this->page;
	}
}
?>