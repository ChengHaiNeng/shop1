<?php 
	namespace Admin\Model;
	use Think\Model;
	class CatModel extends Model{
		
		public $cat = array();
		public function __construct(){
			parent::__construct();
			$this->cat = $this->cache(true)->select();
		}


		public function getCat($parent_id=0 ,$level=0){
			//分层目录定义为$catLevel
			$catLevel = array();
			foreach($this->cat as $cat){
				if($cat['parent_id'] == $parent_id){
					$cat['$level'] = $level;
					$catLevel[] = $cat;
					$catLevel = array_merge($catLevel,$this->getCat($cat['cat_id'],$level+1));
				}
			}
			return $catLevel;
		}

		protected   $_validate = array(
			array('cat_name','3,10','长度必须在3到10之间',1,'length',3),			
			);	
	}
 ?>