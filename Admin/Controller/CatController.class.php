<?php 
namespace Admin\Controller;
use Think\Controller;

class CatController extends Controller{
	public function  cateadd(){
		if(!$_POST){
			$this->display();
		}else{
			$catModel = D('cat');
			$catModel->add($_POST);
		}
		
	}

	public function  cateedit(){
		$cat_id = I('cat_id');
		if(!$_POST){
			$catModel = D('cat');
			$catinfo = $catModel->find($cat_id);
			$this->assign('info',$catinfo);
			$this->display();
		}else{
			$catModel = D('cat');
			$cat_id = I('cat_id');
			$catModel->where('cat_id='.$cat_id)->save($_POST);
		}
	}

	public function  catelist(){
		$catModel = D('cat');
	/*	$catlist = $catModel ->select();*/
	if(S('catlist')){
		$catlist = S('catlist');
		echo '来自缓存';
	}else{
		$catlist =$catModel->getCat();
		echo '来自数据库';
		S('catlist',$catlist,3);
	}
		
		$this ->assign('catlist',$catlist);
		$this->display();
	}

	public function del(){
		$catModel = D('cat');
		$cat_id = I('cat_id');
		$catlist = $catModel->delete($cat_id);
		$this->success('成功','',5);
	}
}


 ?>