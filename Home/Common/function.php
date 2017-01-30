<?php 
	 function check_cookie(){
		if(md5(cookie('username').C('cookie_salt')) == cookie('code')){
			return 1;
		}else{
			return 0;
		}



	}


 ?>