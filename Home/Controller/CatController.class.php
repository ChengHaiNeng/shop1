<?php 
namespace Home\Controller;
use Think\Controller;
class CatController extends Controller{
	public function cat(){
		////查找分類下的商品
		$cat_id = I('cat_id');
		$goodsModel = D('Admin/goods');
		$cat_goods = $goodsModel->where('cat_id='.$cat_id)->select();

		$history = session('history');
		//print_r($history);
		$this->assign('history',array_reverse($history));
		$this->assign('cat_goods',$cat_goods);
		$this->display();
	}
}

 ?>