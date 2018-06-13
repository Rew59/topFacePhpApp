<?php
class Model_User{
	protected $ins_driver_u;
	protected $user_id;
	protected $glue = "|";
	
	private $td;
	private $cyfer = MCRYPT_BLOWFISH;
	private $mode = MCRYPT_MODE_CFB;
	private $created;
	private $version;
	
	static $instance;
	static $cookie_name = 'USERNAME';
	
	static function get_instance(){
		if(self::$instance instanceof self){
			return self::$instance;
		}
		return self::$instance = new self;
	}
	
	private function __construct(){
		$this->ins_driver_u = Model_Driver::get_instance();
		$this->td = mcrypt_module_open($this->cyfer,'',$this->mode,'');
	}
	
	public function get_user($name,$password){

		$result = $this->ins_driver_u->select(
						array('user_id'),
						'users',
						array('login'=>$name,
						'password'=>md5($password)
						)
		);
		if($result == NULL || $result == FALSE){
			throw new AuthException('Данного пользователя не существует');
			return;
		}
		
		if(is_array($result)){
			return $result[0]['user_id'];
		}
	}

	public function get_fealtures($ip){
		$result = $this->ins_driver_u->select(
						array('fealtures'),
						'fealtures',
						array('ip'=>$ip)
		);
		if(count($result) == 0){
			return NULL;
		}
		
		return $result[0]['fealtures'];
	}
	
	public function insert_fealt($ip){
		$this->ins_driver_u->insert('fealtures',array('fealtures','ip','time'),
		array('1',$ip,time())
		);
	}
	
	public function update_fealt($ip,$fealtures){
		$fealtures++;
		$this->ins_driver_u->update('fealtures',
					array('fealtures','time'),
					array($fealtures,time()),
					array('ip'=>$ip)
		);
	}
	
	public function clean_fealtures($time){
		$this->ins_driver_u->delete('fealtures',
					array('time'=>$time),
					array('<=')
		);
	}
	
	public function check_id_user($id = FALSE){
		if($id){
			return $this->user_id = $id;
		}else{
			if(array_key_exists(self::$cookie_name,$_COOKIE)){
				$this->unpackage($_COOKIE[self::$cookie_name]);
			}else{
				throw new AuthException("Доступ запрещен");
			}
		}
	}
	
	public function set(){
		$cookie_text = $this->package();
		if($cookie_text){
			setcookie(self::$cookie_name,$cookie_text,0,SITE_URL);
			
			return TRUE;
		}
	}
	
	private function package(){
		if($this->user_id){
			$arr = array($this->user_id,time(),VERSION);
			$str = implode($this->glue,$arr);
			return $this->encrypt($str);
		}else{
			throw new AuthException("Не найден идентификатор пользователя");
		}
	}
	
	private function encrypt($str){
		$iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($this->td),MCRYPT_RAND);
		
		mcrypt_generic_init($this->td,KEY,$iv);
		$crypt_text = mcrypt_generic($this->td,$str);
		mcrypt_generic_deinit($this->td);
		
		return $iv.$crypt_text;
	}
	
	private function unpackage($str){
		$result = $this->decrypt($str);
		list($this->user_id,$this->created,$this->version) = explode($this->glue,$result);
		true;
	}
	
	private function decrypt($str){
		$iv_size = mcrypt_enc_get_iv_size($this->td);
		$iv = substr($str,0,$iv_size);
		$crypt_text = substr($str,$iv_size);
		
		mcrypt_generic_init($this->td,KEY,$iv);
		
		$text = mdecrypt_generic($this->td,$crypt_text);
		
		mcrypt_generic_deinit($this->td);
		
		return $text;
	}
	
	public function validate_cookie(){
		if(!$this->user_id || !$this->created || !$this->version){
			throw new AuthException("Не правильные данные. Доступ запрещен!");
		}
		
		if($this->version != VERSION){
			throw new AuthException("Доступ запрещен!");
		}
		
		if((time() - $this->created) > EXPIRATION){
			throw new AuthException("Закончилось время сессии");
		}
		if((time() - $this->created) > VARNING_TIME){
			$this->set();
		}
		return TRUE;
	}
	
	public function logout(){
		setcookie(self::$cookie_name,"",(time()-3600),SITE_URL);
		return TRUE;
	}
}
?>