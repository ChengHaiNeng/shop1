<?php 
namespace Home\Tool;
abstract class ACartTool {
/**
* 向购物车中添加1个商品
* @param $goods_id int 商品id
* @param $goods_name String 商品名
* @param $shop_price float 价格
* @return boolean
*/
abstract public function add($goods_id,$goods_name,$shop_price);
/**
* 减少购物车中1个商品数量,如果减少到0,则从购物车删除该商品
* @param $goods_id int 商品id
*/
abstract public function decr($goods_id);
/**
* 从购物车删除某商品
* @param $goods_id 商品id
*/
abstract public function del($goods_id);
/**
* 列出购物车所有的商品
* @return Array
*/
abstract public function items();
/**
* 返回购物车有几种商品
* @return int
*/
abstract public function calcType();
/**
* 返回购物车中商品的个数
* @return int
*/
abstract public function calcCnt();
/**
* 返回购物车中商品的总价格
* @return float
*/
abstract public function calcMoney();
/**
* 清空购物车
* @return void
*/
abstract public function clear();
}



class CartTool extends ACartTool {
/**
* 向购物车中添加1个商品
* @param $goods_id int 商品id
* @param $goods_name String 商品名
* @param $shop_price float 价格
* @return boolean
*/
public $cart = array();
protected static $ins = null;
final function __construct(){
	$this->cart = session('?cart')?session('cart'):array();
	/*echo 123;*/
}
public static function getIns(){
	if(self::$ins == null){
		self::$ins = new self();
	}
	return self::$ins;
}

public function add($goods_id,$goods_name,$shop_price){
	/*echo 789;*/
	if(isset($this->cart[$goods_id])){
		$this->cart[$goods_id]['goods_num'] = $this->cart[$goods_id]['goods_num']+1;
	}else{
		$row = array('goods_name'=>$goods_name,'shop_price'=>$shop_price,'goods_num'=>1);
		$this->cart[$goods_id] = $row;
	}

}



/**
* 减少购物车中1个商品数量,如果减少到0,则从购物车删除该商品
* @param $goods_id int 商品id
*/
public function decr($goods_id){
	$this->cart[$goods_id]['goods_num'] = $this->cart[$goods_id]['goods_num']-1;
	if($this->cart[$goods_id]['goods_num']<=0){
		unset($this->cart[$goods_id]);
	}
}


/**
* 从购物车删除某商品
* @param $goods_id 商品id
*/
public function del($goods_id){
	unset($this->cart[$goods_id]);
}



/**
* 列出购物车所有的商品
* @return Array
*/
public function items(){
	return $this->cart;
}


/**
* 返回购物车有几种商品
* @return int
*/
public function calcType(){
	return count($this->cart);
}


/**
* 返回购物车中商品的个数
* @return int
*/
public function calcCnt(){
	$num = 0;
	foreach($this->cart as $k=>$v){
		$num += $v['goods_num'];
	}
	return $num;
}	


/**
* 返回购物车中商品的总价格
* @return float
*/
public function calcMoney(){
	$money = 0;
	foreach($this->cart as $k=>$v){
		$money += $v['goods_num']*$v['shop_price'];
	}
	return $money;
}


/**
* 清空购物车
* @return void
*/
public function clear(){
	$this->cart = array();
}

function __destruct(){
	session('cart',$this->cart);
	/*echo 456;*/
}
}
