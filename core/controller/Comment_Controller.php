<?php
class Comment_Controller extends Base{
	protected $foto;	
	
	protected function input($param = array()){
	
		parent::input();
		
		$this->title .= "Комментарии";
		
		if(isset($param['id'])){
			$id = $this->clear_int($param['id']);
			$this->foto = $this->ob_m->new_name_foto_po_id($id);
		}

	}
	
	protected function output(){
		
		$this->content = $this->render(VIEW.'comment',array(
				'name_foto'=>$this->foto
		));
		
		$this->page = parent::output();

		return $this->page;
	}
}
?>