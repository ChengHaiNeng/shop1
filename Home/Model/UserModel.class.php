<?php 
namespace Home\Model;
use Think\Model;

class UserModel extends Model{
	protected $_validate = array(
		array('password','2,12','密碼長度不對',1,'length',3),
		array('re_password','password','兩次密碼不一致',1,'confirm',3),
		array('email','email','郵箱格式不對',1,'regex',3)
		);
}

 ?>