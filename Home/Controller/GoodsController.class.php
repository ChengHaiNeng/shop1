<?php 
namespace Home\Controller;
use Think\Controller;
class GoodsController extends Controller{	
	public function goods(){
		$goodsModel = D('Admin/goods');
		$goods_id = I('goods_id');
		$goods = $goodsModel->find($goods_id);
		if($goods){
			$this->history($goods);
		}
		/*session('history',null);*/

		$cat_id = $goods['cat_id'];

		$catModel = D('Admin/cat');
		$row = $catModel->find($cat_id);	
		$arr = array();	
		$arr[] = $row;
		while($row['parent_id']>0){
			$row = $catModel->find($row['parent_id']);
			$arr[] = $row;
		}
//
		
		
		$this->assign('bread',array_reverse($arr));
		$this->assign('goods',$goods);

		//加载商品评论模块
		$commentModel = D('comment');
		$comment = $commentModel ->where('goods_id='.$goods_id)->select();
		foreach($comment as $k=>$c){
			$comment[$k]['content'] =  html_entity_decode($comment[$k]['content'] ,ENT_HTML5);
		}

		/*$comment['content'] = html_entity_decode($c,ENT_HTML5);*/
		
		$this->assign('comments',$comment);

		$this->display();
	}


	public function history($goods){
		$history = session('?history')?session('history'):array();
		$row = array();
		$row['goods_id'] = $goods['goods_id'];
		$row['goods_name'] = $goods['goods_name'];
		$row['shop_price'] = $goods['shop_price'];

		$history[$goods['goods_id']] = $row;

		if(count($history)>5){
			$key = key($history);
			unset($history[$key]);
		}

		session('history',$history);
		}

	
	public function addCart(){
		$goodsModel = D('Admin/goods');
		$goods_id = I('get.goods_id');
		$goods = $goodsModel->find($goods_id);
		$cartTool = \Home\Tool\CartTool::getIns();
		/*$cartTool2 = \Home\Tool\CartTool::getIns();*/
		/*if($cartTool === $cartTool2){
			echo 'true';
		}else{
			echo 'false';
		}*/
		/*var_dump($cartTool);
		echo '<br>';
			var_dump($cartTool2);*/
	/*	print_r($goods);*/

		$cartTool->add($goods['goods_id'],$goods['goods_name'],$goods['shop_price']);
		//print_r(session('cart'));
		$this->success('加入购物车成功','',0.5);

	}

	public function checkout(){
		$carts = session('cart');
		$this->assign('carts',$carts);
		$this->display();
	}

	public function done(){
		$oi = D('ordinfo');
		$cart = \Home\Tool\CartTool::getIns();
		if($oi->create()){
			$ord_sn = $oi->ord_sn = date('Ymd').rand(1000,9999);
			$oi->ordtime = time();
			$oi->user_id = cookie('user_id')?cookie('user_id'):☺;
			$money = $oi->money = $cart->calcMoney();
			echo '~~~~~'.$money.'~~~~~';
			$ordinfo_id = null;
			if($ordinfo_id = $oi->add()){
				$og = D('ordgoods');
			
				$data = array();
				foreach($cart->items() as $k=>$v){
					$row['goods_id'] =  $k;
					$row['goods_name'] = $v['goods_name'];
					$row['shop_price'] = $v['shop_price'];
					$row['goods_num'] = $v['goods_num'];
					$row['ordinfo_id'] = $ordinfo_id;
					$data[] = $row;
				}
				if($og->addAll($data)){
					$this->assign('ordinfo_id',$ord_sn);
					$this->assign('money',$money);
					$this->display();
				}else{
					echo '添加购物信息失败';
					$oi->where('ordinfo_id= '.$ordinfo_id)->delete();//删除订单信息中对应的字段
					$og->where(array('ordinfo_id'=>$ordinfo_id))->delete;
					$this->show('下单失败','utf-8');
					exit();
				}
			}else{
				$this->show('添加订单信息失败','utf-8');
				exit();
			}
		}
		$cart->clear();
	}


	public function addComment(){
		$commentModel = D('comment');
		/*var_dump($_POST);*/
		if(!$commentModel->create()){
			echo '留言失败';
			exit();
		}else{
			if(!$commentModel->add()){
				echo '留言失败';
				exit();
			}else{
				$this->success('留言成功','','0');
			}
		}
		
		
	}

	
		
	
}
