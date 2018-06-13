<?php
class Model{
	static $instance;
	public $ins_driver;
	
	static function get_instance(){
		if(self::$instance instanceof self){
			return self::$instance;
		}
		return self::$instance = new self;
	}
	
	private function __construct(){
		try{
			$this->ins_driver = Model_Driver::get_instance();
		}catch(DbException $e){
			exit();
		}	
	}
	
	public function get_home_foto($settings = FALSE){
		
		for($i=0;$i<=1;$i++){
		if($settings == FALSE){
			$rand = $this->count_foto('id','new_foto');
			foreach($rand as $k=>$v){
				$rand = $v;
			}

			$rand = rand(1,$rand);
			
				
				$result[$i] = $this->ins_driver->select(
							array('id','name_foto'),
							'new_foto',
							array(),
							FALSE,
							"ASC",
							($rand-1).",1"
							
				);
		}else{
		
			$rand = $this->count_foto('id','new_foto',$settings);
			foreach($rand as $k=>$v){
				$rand = $v;
			}

			$rand = rand(1,$rand);
		
				$result[$i] = $this->ins_driver->select(
							array('id','name_foto'),
							'new_foto',
							array('sex'=>$settings),
							FALSE,
							"ASC",
							($rand-1).",1"
							
				);
			}
			
		}
		foreach ($result as $v1) {
			foreach ($v1 as $v2) {
				$finish[] = $v2;
			}
		}
		
		return $finish;
	}
	
	public function get_home_foto_teg($teg,$pol){
		for($i=0;$i<=1;$i++){
			
			$rand = $this->ins_driver->select_inner_join(
							$teg,
							FALSE,
							TRUE,
							$pol
							
			);
			foreach($rand as $v){
				foreach($v as $v1){
					$rand = $v1;
				}
			}
			
			$rand = rand(1,$rand);
			
				$result[$i] = $this->ins_driver->select_inner_join(
							$teg,
							($rand-1).",1",
							FALSE,
							$pol
							
				);
			
		}
		foreach ($result as $v1) {
			foreach ($v1 as $v2) {
				$finish[] = $v2;
			}
		}
		
		return $finish;
	}
	
	public function get_top_foto($teg){
		
		$date = time()-(1440*60);
		
		$ogran = 'select new_foto.id from new_foto, teg_foto, tegi where new_foto.id=teg_foto.id_foto and teg_foto.id_teg=tegi.id_teg and tegi.name_teg=';
		
		if(!empty($teg)){
			foreach ($teg as $v1) {
				$sq .= "'".$v1."',";
			}
			$sq = substr($sq, 0, strrpos($sq, ',' ));
			$sql1 = "and tegi.name_teg in(".$sq.")";
			
			$result = $this->ins_driver->select(
							array('MAX(new_foto.raiting)'),
							'tegi,teg_foto,new_foto',
							array('teg_foto.id_teg = tegi.id_teg and teg_foto.id_foto=new_foto.id '.$sql1.' and new_foto.date_foto'=>$date
							),
							FALSE,
							"ASC",
							FALSE,
							array('>')
			);
		}else{
			$result = $this->ins_driver->select(
							array("MAX(raiting)"),
							'new_foto',
							array('date_foto'=>$date,'not id'=>$ogran."'16+'"),
							FALSE,
							"ASC",
							FALSE,
							array('>','IN')
			);
		}
		foreach ($result as $v1) {
			foreach ($v1 as $v2) {
				$finish[] = $v2;
			}
		}
		
		if(!empty($teg)){
			foreach ($teg as $v1) {
				$sql .= "'".$v1."',";
			}
			if(!empty($finish[0])){
				$raiting = " and new_foto.raiting=".$finish[0];
			}
			$sql = substr($sql, 0, strrpos($sql, ',' ));
			$sql1 = " and tegi.name_teg in(".$sql.")";
			$result = $this->ins_driver->select(
						array('distinct new_foto.name_foto'),
						'tegi,teg_foto,new_foto',
						array('teg_foto.id_teg = tegi.id_teg and teg_foto.id_foto=new_foto.id'.$sql1.' and new_foto.date_foto'=>$date
						),
						FALSE,
						"ASC",
						FALSE,
						array('>')
			);
			return $result[0]['name_foto'];
			
		}else{
			$result1 = $this->ins_driver->select(
								array("name_foto"),
								'new_foto',
								array('raiting'=>$finish[0],'date_foto'=>$date),
								FALSE,
								"ASC",
								FALSE,
								array('=','>')
			);
			foreach ($result1 as $v1) {
				foreach ($v1 as $v2) {
					$finish1[] = $v2;
				}
			}
			return $finish1[0];
		}
	}
	
	public function count_foto($str,$tabl,$settings = FALSE){
		
		$sql = 'select new_foto.id from new_foto, teg_foto, tegi where new_foto.id=teg_foto.id_foto and teg_foto.id_teg=tegi.id_teg and tegi.name_teg=';

		if($settings){
			$result = $this->ins_driver->select(
							array("count('".$str."')"),
							$tabl,
							array('sex'=>$settings,'not id'=>$sql."'16+'"),
							FALSE,
							"ASC",
							FALSE,
							array('=','IN')
			);
		}else{
			$result = $this->ins_driver->select(
								array("count('".$str."')"),
								$tabl,
								array('not id'=>$sql."'16+'"),
								FALSE,
								"ASC",
								FALSE,
								array('IN')
			);
		}
		return $result[0];
	}
	
	public function delete_foto($id){
		$result = $this->ins_driver->delete(
					'old_foto',
					array('id'=>$id)
		);
		
		return $result;
	}
	
	public function delete_teg_old_foto($id_foto){
		$result = $this->ins_driver->delete(
					'teg_old_foto',
					array('id_foto'=>$id_foto)
		);
		
		return $result;
	}
	
	public function delete_teg_old_foto_po_id_teg($id_foto,$id_teg){
		$result = $this->ins_driver->delete(
					'teg_old_foto',
					array('id_foto = '.$id_foto.' and id_teg'=>$id_teg)
		);
		
		return $result;
	}
	
	public function name_foto_po_id($id){
		$result = $this->ins_driver->select(
						array('name_foto'),
						'old_foto',
						array('id'=>$id)
		);
		return $result[0];
	}
	
	public function id_foto_po_name($name){
		$result = $this->ins_driver->select(
						array('id'),
						'old_foto',
						array('name_foto'=>$name)
		);
		return $result[0];
	}
	
	public function new_id_foto_po_name($name){
		$result = $this->ins_driver->select(
						array('id'),
						'new_foto',
						array('name_foto'=>$name)
		);
		return $result[0];
	}
	
	public function isset_zapis_v_bd($val,$tabl,$where1,$where2){
		$result = $this->ins_driver->select(
						array($val),
						$tabl,
						array($where1=>$where2)
		);
		return $result[0];
	}
	
	public function id_tega_po_name_tega($name_teg){
		$result = $this->ins_driver->select(
						array('id_teg'),
						'tegi',
						array('name_teg'=>$name_teg)
		);
		return $result[0];
	}
	
	public function info_foto_po_id($id){
		$result = $this->ins_driver->select(
						array('sex'),
						'old_foto',
						array('id'=>$id)
		);
		return $result[0];
	}
	
	public function add_foto($nameFoto,$sex){
		$date = time();
		$result = $this->ins_driver->insert(
				'new_foto',
				array(
					'name_foto',
					'sex',
					'date_foto'
				),
				array(
					$nameFoto,
					$sex,
					$date
				)
		);
		
		return $result;
	}
	
	public function get_raiting_foto($id){
		$result = $this->ins_driver->select(
						array('raiting'),
						'new_foto',
						array('id'=>$id)
		);
		return $result[0];
	}
	
	public function get_tegi($id_teg){
		if(!empty($id_teg)){
			$id_teg= "'id_teg'=>".$id_teg."";
		}
		$result = $this->ins_driver->select(
						array('name_teg'),
						'tegi',
						array($id_teg)
		);
		return $result;
	}
	
	public function info_tegi_po_id_foto($id_foto){
		$result = $this->ins_driver->select(
						array('tegi.name_teg'),
						'tegi,teg_old_foto,old_foto',
						array('teg_old_foto.id_teg = tegi.id_teg and teg_old_foto.id_foto=old_foto.id and old_foto.id'=>$id_foto
						)
		);
		return $result;
	}
	
	public function get_teg_old_foto($id_foto){
		$result = $this->ins_driver->select(
						array('id_teg'),
						'teg_old_foto',
						array('id_foto'=>$id_foto)
		);
		return $result;
	}
	
	public function new_name_foto_po_id($id){
		$result = $this->ins_driver->select(
						array('name_foto'),
						'new_foto',
						array('id'=>$id)
		);
		return $result[0];
	}
	
	public function add_new_raiting($id,$raiting){
		$result = $this->ins_driver->update(
					'new_foto',
					array('raiting'),
					array($raiting),
					array('id'=>$id)
		);
		
		return $result;
	}
	
	public function add_old_foto($img_name,$sex){
		$result = $this->ins_driver->insert(
				'old_foto',
				array(
					'name_foto',
					'sex'
				),
				array(
					$img_name,
					$sex
				)
		);
		
		return $result;
	}
	
	public function add_new_teg($new_teg){
		$result = $this->ins_driver->insert(
				'tegi',
				array(
					'name_teg'
				),
				array(
					$new_teg
				)
		);
		
		return $result;
	}
	
	public function add_teg_old_foto($id_foto,$id_teg){
		$result = $this->ins_driver->insert(
				'teg_old_foto',
				array(
					'id_foto',
					'id_teg'
				),
				array(
					$id_foto,
					$id_teg
				)
		);
		
		return $result;
	}
	
	public function add_teg_foto($id_foto,$id_teg){
		$result = $this->ins_driver->insert(
				'teg_foto',
				array(
					'id_foto',
					'id_teg'
				),
				array(
					$id_foto,
					$id_teg
				)
		);
		return $result;
	}
}
?>