<?php
class Admin_Controller extends Base_Admin{
	protected $message;
	protected $massiv_dan;
	protected $navigation;
	protected $tegi=array();
	
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
		
		if($this->is_post()){
			if($_POST['add']){

				$id = $_POST['add'];
				$nameFoto = $this->ob_m->name_foto_po_id($id);
				$infoFoto = $this->ob_m->info_foto_po_id($id);
				
				if (copy(OLD_UPLOAD_DIR.$nameFoto['name_foto'],UPLOAD_DIR.$nameFoto['name_foto'])) {
					unlink(OLD_UPLOAD_DIR.$nameFoto['name_foto']);
					$result1 = $this->ob_m->add_foto($nameFoto['name_foto'],$_POST['sex']);
				
					$result = $this->ob_m->delete_foto($id);
					
					if($result === TRUE && $result1 == TRUE){
						$id_foto = $this->ob_m->new_id_foto_po_name($nameFoto['name_foto']);
						$tegi_old_foto = $this->ob_m->get_teg_old_foto($id);
						
						if(!empty($tegi_old_foto)){
							foreach($tegi_old_foto as $val){
								foreach($val as $val2){
								
									$result_teg_foto = $this->ob_m->add_teg_foto($id_foto['id'],$val2['id_teg']);
									if(!$result_teg_foto){
										$_SESSION['message'] = "Ошибка при добавлении фотографии";
										header("Location:".SITE_URL."admin");
										exit();
									}
								}
							}
						
							$result2 = $this->ob_m->delete_teg_old_foto($id);
							
							if($result2 === TRUE){
								$_SESSION['message'] = "Фотография успешно добавлена";
							}
						}else{
							$_SESSION['message'] = "Фотография успешно добавлена";
						}
					}else{
						$_SESSION['message'] = "Ошибка при добавлении фотографии";
					}
					
					header("Location:".SITE_URL."admin");
					exit();
				 }else{
					$_SESSION['message'] = "Ошибка копирования изображения";
						header("Location:".SITE_URL."admin");
						exit();
				 }
				
			}
			if($_POST['del']){
				$id = $_POST['del'];
				$nameFoto = $this->ob_m->name_foto_po_id($id);
				
				$result = $this->ob_m->delete_foto($id);
				$result2 = $this->ob_m->delete_teg_old_foto($id);
				if($result === TRUE && $result2 === TRUE){
					unlink(OLD_UPLOAD_DIR.$nameFoto['name_foto']);
					$_SESSION['message'] = "Фотография успешно удалена";
				}else{
					$_SESSION['message'] = "Ошибка при удалении фотографии";
				}
				
				header("Location:".SITE_URL."admin");
				exit();
			}
			
			if($_POST['del_teg']){
				$id_and_name_teg = explode(",", $_POST['del_teg']);
				
				$id_foto = $id_and_name_teg[0];
				$name_teg = $id_and_name_teg[1];
				
				$id_teg = $this->ob_m->id_tega_po_name_tega($name_teg);
				
				$result = $this->ob_m->delete_teg_old_foto_po_id_teg($id_foto,$id_teg['id_teg']);
				if($result === TRUE){
					$_SESSION['message'] = "Тег успешно удален";
				}else{
					$_SESSION['message'] = "Ошибка при удалении тега";
				}
				header("Location:".SITE_URL."admin");
				exit();
			}
		}
		
		$this->title .= "Админка";
		
		$pager = new Pager(
				$page,
				'old_foto',
				array('id','name_foto','sex'),
				array(),
				'id',
				'DESC',
				QUANTITY,
				QUANTITY_LINKS
		);
		
		$this->massiv_dan = $pager->get_posts();
		
		foreach($this->massiv_dan as $v){
			$this->tegi[] = $this->ob_m->info_tegi_po_id_foto($v['id']);
		}

		$this->navigation = $pager->get_navigation();
		
		$this->message = $_SESSION['message'];
	}
	
	protected function output(){
		
		$this->content = $this->render(VIEW.'home_admin',array(
				'mes'=>$this->message,
				'massiv_dan'=>$this->massiv_dan,
				'navigation'=>$this->navigation,
				'tegi'=>$this->tegi
		));
		
		$this->page = parent::output();
		unset($_SESSION['message']);
		return $this->page;
	}
}
?>