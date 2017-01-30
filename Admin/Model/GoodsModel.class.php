<?php 
namespace  Admin\Model;
use Think\Model\RelationModel;

class GoodsModel extends RelationModel{

	protected $_link = array(
		'comment'=>self::HAS_MANY,
		);
	/*protected $_validate = array(
		array('goods_name','3,10','输入的必须在3到10之间',1,'length',3),
		array('goods_sn','','id已经存在',1,'unique',3),
		);*/
	protected $_auto = array(
		array('add_time','time',1,'function'),
		array('last_update','time',2,'function'),
		);
	/*protected $insertFields="goods_id,goods_sn,cat_id,shop_price"; */
}

 ?>