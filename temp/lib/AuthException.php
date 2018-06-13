<?php
class AuthException extends Exception{
	
	public function __construct($text){
		$this->message = $text;
		$_SESSION['auth'] = $text;
	}
}
?>