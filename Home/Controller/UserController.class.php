<?php 
namespace Home\Controller;
use Think\Controller;
class UserController extends Controller{
	public function login(){
		if(!$_POST){
			$this->display();
		}else{
			$verify = I('verify');
			/*echo $verify;
			echo '<br>';
			var_dump($this->checkVerify($verify));
			exit();*/
			if(!$this->checkVerify($verify)){
				echo '验证码错误';
				exit();
			}else{
				$userModel = D('user');
				$username = I('username');
				$user = $userModel->where('username='.'"'.$username.'"')->find();
				/*print_r($user);*/
				$salt = $user['salt'];
				/*echo '<br>',$salt;*/
				$password = I('password');
				/*echo '<br>',$password;*/
				//从数据库取得的密码
				$realpwd = $user['password'];
				/*echo '<br>';
				echo  md5(md5($password).md5($salt));*/
				if($realpwd == md5(md5($password).md5($salt))){
					//set cookie
					cookie('username',$username);
					cookie('code',md5($username.C('cookie_salt')));
					$this->redirect('/');

				}else{
					echo '密码错误';
				}
		}
		}
	}

	public function logout(){
		cookie('username',null);
		cookie('code',null);
		$this->redirect('/');
	}

	public function verify(){
		$verify = new \Think\Verify();
		/*$verify->useNoise=false;
		$verify->length = 4;
		$verify->useZh=true;*/
		$verify->useNoise=false;

		$verify->entry();
	}

	public function checkVerify($verify){
		$Verify = new \Think\Verify();
		return($Verify->check($verify));
		
		
	}

	public function msg(){
		$this->display();
	}
	public function reg(){
		if(!$_POST){
			$this->display();
		}else{
			$userModel= D('user');	

			if(!$userModel->create()){
				echo $userModel->getError();
				exit();
			}else{
				$password = I('password');			
				$userModel->salt = mt_rand(1000,99999);
				$userModel->password = md5(md5($password).md5($userModel->salt));	
				if(!$userModel->add()){
					echo $userModel->getError();
					exit();
				}else{
							
					$this->redirect('Home/User/login');
				}
			}
		}
		
	}
}


 ?>