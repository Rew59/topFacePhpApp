<?php
class Login_Controller extends Base{
	protected $ob_us;
	
	protected function input($param=array()){
		parent::input();
		
		$this->ob_us = Model_User::get_instance();
		
		if(isset($param['logout'])){
			$logout = $this->clear_int($param['logout']);
			if($logout){
				$res = $this->ob_us->logout();
				if($res){
					header("Location:".SITE_URL);
					exit();
				}
			}
		}
		
		$this->title .= "Авторизация";
		
		$time_clean = time()-(3600*24*FEALT);
		
		$this->ob_us->clean_fealtures($time_clean);
		
		$ip_u = $_SERVER['REMOTE_ADDR'];
		$fealtures = $this->ob_us->get_fealtures($ip_u);
		
		if($this->is_post()){
			if(isset($_POST['login']) && isset($_POST['password']) && $fealtures < 3){
		
				$name = $this->clear_str($_POST['login']);
				$password = $this->clear_str($_POST['password']);
				
				try{
					$id = $this->ob_us->get_user($name,$password);
					$this->ob_us->check_id_user($id);
					
					$this->ob_us->set();
					
					header("Location:".SITE_URL."admin");
					exit();
					
				}catch(AuthException $e){
					if($fealtures == NULL){
						$this->ob_us->insert_fealt($ip_u);
					}
					elseif($fealtures > 0){
						$this->ob_us->update_fealt($ip_u,$fealtures);
					}
				}
			}
		}
	}
	
	protected function output(){
	
		$this->content = $this->render(VIEW.'login',array(
				'error'=>$_SESSION['auth']
		));
		
		$this->page = parent::output();
		unset($_SESSION['auth']);
		
		return $this->page;
	}
}
?>