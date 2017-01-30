<?php 
namespace Admin\Controller;
use Think\Controller;

class GoodsController extends Controller{
	public function goodsadd(){
		if(!$_POST){
			$this->display();
		}else{
			$goodsModel = D('goods');
			$upload =new \Think\Upload();
			$upload->exts = array('jpg','jpeg','png','gif');
			$upload->rootPath = './Public/Admin/up/';
			$rs = $upload->upload();
			if(!$rs){
				echo $upload->getError();
				exit();
			}else{
				//var_dump($rs);
				$_POST['goods_img'] = '/Public/Admin/up/'.$rs['goods_img']['savepath'].$rs['goods_img']['savename'];
				//echo $_POST['goods_img'];
				$img = new \Think\Image();
				$img->open('.'.$_POST['goods_img']);
				$path = './Public/Admin/thumb/'.$rs['goods_img']['savepath'].$rs['goods_img']['savename'];
				$img->thumb(208,208)->save($path);
				$_POST['thumb_img'] = '/Public/Admin/thumb/'.$rs['goods_img']['savepath'].$rs['goods_img']['savename'];
				//echo $_POST['thumb_img'];
				if(!$goodsModel->create()){
					//echo '123';
					echo $goodsModel->getError();
					/*echo "createerror";*/
					exit();
				}else{
				/*	echo "goodsadd";*/
					$goodsModel->add();
			}

			}



			/*if(!$goodsModel->create()){
				echo '123';
				echo $goodsModel->getError();
				exit();
			}else{
				$goodsModel->add();
			}*/
		}
	}

	public function goodslist(){
		$goodsModel = D('goods');
		
		//分页
		$count = $goodsModel->count();
		$Page = new \Think\Page($count,6);
		$show = $Page->show();
		$goods = $goodsModel->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->assign('show',$show);
		$this->assign('goods',$goods);
		$this->display();
	}

	public function goodsdel(){
		$goodsModel = D('goods');
		$goodsModel->delete(I('get.goods_id'));
		$this->success('删除成功','',5);
	}
}


 ?>