<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
    	$goodsModel = D('Admin/goods');
    	$goods = $goodsModel->field("goods_id,goods_name,goods_img,shop_price,market_price")->where('is_hot=1')->order('goods_id desc')->limit(4)->select();
    	//print_r($goods);
    	$this->assign('goods',$goods);
    	$catModel = D('Admin/cat');
    	$cat = $catModel->getCat();
    	$this->assign('cat',$cat);
    	//print_r($cat);
       $this->display();
    }
}